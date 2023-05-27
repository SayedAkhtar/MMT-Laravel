<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateQueryAPIRequest;
use App\Http\Requests\Device\UpdateQueryAPIRequest;
use App\Models\Accommodation;
use App\Models\Query;
use App\Models\QueryResponse;
use App\Models\User;
use App\Repositories\QueryRepository;
use App\Services\QueryResponseService;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

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
        $queries = Query::with('hospital', 'specialization', 'patient')->whereHas('patient')->get();
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
    public function store(CreateQueryAPIRequest $request)
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
                return redirect(route('query.show', ['query' => $query->id, 'tab' => $tab]));
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
        $query = Query::findOrFail($id);
        $first_tab = $query->type == Query::TYPE_MEDICAL_VISA ? 'upload-medical-visa' : 'details';
        $tab = $request->get('tab') ?? $first_tab;

//        if ($query->type == Query::TYPE_MEDICAL_VISA && !empty($tab)) {
//            $tab = 'upload-medical-visa';
//        }
        $afterOpenQuery = ['upload-medical-visa', 'upload-ticket', 'coordinator'];
//        if (in_array($tab, $afterOpenQuery) && (empty($query->activeQuery) && empty($query->activeQuery->doctor_response) && ($query->type != Query::TYPE_MEDICAL_VISA))) {
//            return back()->with('error', "Please upload doctor's review before proceeding");
//        }
        return $this->module_view('queries-layout', compact('query', 'tab'));
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
                ->join('language_user', 'users.id', '=', 'language_user.user_id')
                ->join('language', 'language.id', '=', 'language_user.language_id')
                ->first();
            $data['coordinator'] = $user->toArray();
            $acc = Accommodation::where('id', $validated['accommodation_id'])
                ->with('category')
                ->first();
            $data['accommodation'] = $acc->select('name', 'address', 'geo_location', 'images')->first()->toArray();
            $data['accommodation']['category'] = $acc->category->pluck('name')->toArray();
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

}
