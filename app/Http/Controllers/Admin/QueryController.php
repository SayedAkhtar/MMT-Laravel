<?php

namespace App\Http\Controllers\Admin;

use App\Constants\NotificationStrings;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateQueryAPIRequest;
use App\Http\Requests\Device\UpdateQueryAPIRequest;
use App\Models\Accommodation;
use App\Models\Query;
use App\Models\QueryResponse;
use App\Models\User;
use App\Notifications\FirebaseNotification;
use App\Repositories\QueryRepository;
use App\Services\QueryResponseService;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\InputBag;

class QueryController extends AppBaseController
{
    use IsViewModule;

    protected $module;
    /**
     * @var QueryRepository
     */
    private QueryRepository $queryRepository;

    /**
     * @param QueryRepository $queryRepository
     */
    public function __construct(QueryRepository $queryRepository)
    {
        $this->queryRepository = $queryRepository;
        $this->module = 'module/queries';
    }

    /**
     * Query's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $newQueries = new Collection();
        $queries = Query::with('hospital', 'specialization', 'patient')->whereHas('patient')->orderByDesc('updated_at')->get();
        foreach ($queries as $index => $q) {
            if ($q->current_step == 1) {
                $newQueries->add($q);
                unset($queries[$index]);
            }
        }
        $queries = $newQueries->merge($queries);

        return $this->module_view('/list', compact('queries'));
    }

    /**
     * Create Query with given payload.
     *
     * @param CreateQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $query = Query::findOrFail($request->query_id);
            $result = (new QueryResponseService($request->query_id, $request->current_step, $request->response))->execute();
            if ($result) {
                $query->current_step = $request->current_step;
                $query->save();
                $tab = QueryResponse::getNextTab($request->current_step);
                DB::commit();
                return back()->with('success', "Status updated and notified");
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            dd($e->getMessage());
        }

        return back()->withErrors('Something wrong occurred');
    }

    /**
     * Get single Query record.
     *
     * @param int $id
     *
     */
    public function show(Request $request, int $id)
    {
        $query = Query::with(['patient', 'patientFamily', 'specialization', 'doctor'])->findOrFail($id);
        $first_tab = $query->type == Query::TYPE_MEDICAL_VISA ? 'upload-medical-visa' : 'details';
        $tab = $request->get('tab') ?? $first_tab;
        $data = [];
        if ($tab == "coordinator" && !empty($query->confirmed_details)) {
            $confirmed_values = json_decode($query->confirmed_details, true);
            $data['selected_coordinator'] = !empty($confirmed_values['coordinator']) ? $confirmed_values['coordinator'] : [];
            $data['selected_hotel'] = !empty($confirmed_values['accommodation']) ? $confirmed_values['accommodation'] : [];
            $data['selected_cab'] = !empty($confirmed_values['cab']) ? $confirmed_values['cab'] : [];
        }
        //        if ($query->type == Query::TYPE_MEDICAL_VISA && !empty($tab)) {
        //            $tab = 'upload-medical-visa';
        //        }
        $afterOpenQuery = ['upload-medical-visa', 'upload-ticket', 'coordinator'];
        //        if (in_array($tab, $afterOpenQuery) && (empty($query->activeQuery) && empty($query->activeQuery->doctor_response) && ($query->type != Query::TYPE_MEDICAL_VISA))) {
        //            return back()->with('error', "Please upload doctor's review before proceeding");
        //        } 
        return $this->module_view('queries-layout', compact('query', 'tab', 'data'));
    }

    /**
     * Update Query with given payload.
     *
     * @param UpdateQueryAPIRequest $request
     * @param int $id
     * @throws ValidatorException
     *
     */
    public function update(Request $request, int $id)
    {
        $input = $request->all();
        if (!empty($input['set_payment_type'])) {
            $query = Query::findOrFail($id);
            $query->payment_required = $request->has('payment_required');
            $query->save();
            return back()->with('success', 'Payment term updated');
        }
        $query = $this->queryRepository->update($input, $id);

        return back()->with('success', 'Query updated');
    }

    public function confirmQuery(Request $request)
    {
        $validated = $request->validate([
            'query_id' => 'required',
            'coordinator_id' => 'required',
            'accommodation_id' => 'required',
        ]);
        $query = Query::findOrFail($validated['query_id']);

        DB::beginTransaction();
        try {
            $user = User::where('users.id', $validated['coordinator_id'])
                ->select('users.name', 'phone', 'email', 'image', 'gender', 'language.name as language')
                ->leftjoin('language_user', 'users.id', '=', 'language_user.user_id')
                ->leftjoin('language', 'language.id', '=', 'language_user.language_id')
                ->first();
            $data['coordinator'] = $user->toArray();
            if (!empty($user['image'])) {
                $data['coordinator']['image'] = URL::to(Storage::url($user['image']));
            }
            $acc = Accommodation::where('id', $validated['accommodation_id'])
                ->with('category')
                ->first();
            $data['accommodation'] = $acc->select('name', 'address', 'geo_location', 'images')->first()->toArray();
            $data['accommodation']['category'] = $acc->category->pluck('name')->toArray();
            $data['cab'] = $request->has('cab') ? $request->input('cab') : [];
            $query->confirmed_details = json_encode($data);
            $query->save();

            DB::commit();
            return back()->with('success', "Query Updated Success");
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    /**
     * Delete given Query.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     *
     */
    public function delete(int $id): JsonResponse
    {
        $this->queryRepository->delete($id);

        return $this->successResponse('Query deleted successfully.');
    }

    public function updateStep(Request $request, int $id)
    {
        $query = Query::findOrFail($id);
        $q = QueryResponse::where(['query_id' => $id])->first();
        $ns = (new NotificationStrings('en'))->get('TICKETS_AND_VISA_VERIFIED');
        if ($query->current_step == QueryResponse::doctorResponse) {
            $query->current_step = QueryResponse::documentForVisa;
            $ns = (new NotificationStrings('en'))->get('PROCEED_TO_NEXT_STEP');
        } elseif ($query->current_step == QueryResponse::documentForVisa && $query->payment_required) {
            $query->current_step = QueryResponse::payment;
            $ns = (new NotificationStrings('en'))->get('PAYMENT_REQUIRED');
        } elseif ($query->current_step == QueryResponse::documentForVisa && !$query->payment_required) {
            $query->current_step = QueryResponse::ticketsAndVisa;
            $ns = (new NotificationStrings('en'))->get('PROCEED_TO_NEXT_STEP');
        } elseif ($query->current_step == QueryResponse::payment) {
            $query->current_step = QueryResponse::ticketsAndVisa;
            $ns = (new NotificationStrings('en'))->get('PROCEED_TO_NEXT_STEP');
        } elseif ($query->current_step == QueryResponse::ticketsAndVisa) {
            $query->current_step = QueryResponse::queryConfirmed;
            $ns = (new NotificationStrings('en'))->get('TICKETS_AND_VISA_VERIFIED');
        }
        try {
            $query->notify(new FirebaseNotification($ns['title'], $ns['body']));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        $query->save();
        return back();
    }

    public function updateVil(Request $request, int $id)
    {
        $folderPath = 'query_docs/';
        $request->validate(['vil.*' => 'required| file| mimes:jpeg,png,pdf|max:5130']);
        
            try {
                $query = Query::findOrFail($id);
                $files = $request->file('vil');
                $url = [];
                foreach($files as $file){
                    $fileName = uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    $storage = Firebase::storage();
                    $storageClient = $storage->getStorageClient();
                    $bucket = $storage->getBucket();
                    $object = $bucket->upload(
                        fopen($file->getPathname(), 'r'),
                        ['name' => $folderPath . $fileName, 'predefinedAcl' => 'publicRead',], // Upload to the specified folder
                    );
                    $url[] = "https://storage.googleapis.com/{$bucket->name()}/{$folderPath}{$fileName}";
                }

                $res = $query->update(['vil' => json_encode($url)]);
                $query->notify(new FirebaseNotification("Visa Invitation Letter Updated", "Your Visa Invitation letter has been uploaded. You can check it in your all query section"));
                return back()->with('success', ' Visa Invitation Letter Updated');
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return back()->withErrors($e->getMessage());
            }
    }
}
