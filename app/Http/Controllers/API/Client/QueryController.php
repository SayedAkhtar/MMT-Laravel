<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\CreateQueryAPIRequest;
use App\Http\Requests\Client\UpdateQueryAPIRequest;
use App\Http\Resources\Client\ActiveQueryResource;
use App\Http\Resources\Client\ConfirmedQueryResource;
use App\Http\Resources\Client\QueryCollection;
use App\Http\Resources\Client\QueryResource;
use App\Models\ActiveQuery;
use App\Models\ConfirmedQuery;
use App\Models\Payment;
use App\Models\Query;
use App\Models\QueryResponse;
use App\Repositories\QueryRepository;
use App\Services\QueryResponseService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

class QueryController extends AppBaseController
{
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
    }

    /**
     * Query's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return QueryCollection
     */
    public function index(Request $request): JsonResponse
    {
        $queries = Query::with('specialization')->where('patient_id', Auth::id())->orderByDesc('id')->get();
        $activeQueries = ActiveQueryResource::collection($queries)->resolve();
        $activeQueries = array_values(array_filter($activeQueries, function ($el) {
            if (count($el) > 0) return $el;
        }));
        $data['active_query'] = $activeQueries;
//        $data['all_query'] = QueryResource::collection($queries)->resolve();
        return $this->successResponse($data);
    }

    /**
     * Create Query with given payload.
     *
     * @param CreateQueryAPIRequest $request
     *
     */
    public function store(CreateQueryAPIRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            $data = [];
            if ($input['current_step'] == QueryResponse::generateQuery && $input['type'] == Query::TYPE_QUERY) {
                $query = Query::create($input);
                $data = (new QueryResponseService($query->id, 1, $input['response']))->execute();
            } elseif ($input['current_step'] == QueryResponse::documentForVisa && $input['type'] == Query::TYPE_MEDICAL_VISA) {
                $query = Query::create($input);
                $data = (new QueryResponseService($query->id, 3, $input['response']))->execute();
            } else {
                if (empty($input['query_id'])) {
                    return $this->errorResponse('query_id is required', 422);
                }
                $query = Query::find($input['query_id']);
                $query->current_step = $input['current_step'];
                $query->save();
                $data = (new QueryResponseService($input['query_id'], $input['current_step'], $input['response']))->execute();
            }
            DB::commit();
            return $this->successResponse($data);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return $this->errorResponse('Steps must be unique', 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Get single Query record.
     *
     * @param int $id
     *
     * @return QueryResource
     */
    public function show(int $id, int $step)
    {
        $query = Query::query()->where('patient_id', Auth::id());
        if ($step == QueryResponse::queryConfirmed && $id == 0) {
            $query = $query->where('is_confirmed', true)->select('confirmed_details')->latest()->first();
            if (!empty($query->confirmed_details)) {
                $data = json_decode($query->confirmed_details, true);
            } else {
                $data = [];
            }
        } else if ($step == QueryResponse::queryConfirmed) {
            $query = $query->select('confirmed_details')->findOrFail($id);
            $data = json_decode($query->confirmed_details, true);
        } else {
            $query = $query->select('id', 'type', 'current_step', 'payment_required')->findOrFail($id);
            $data = $query->toArray();
            if (!$query->payment_required && $step == 4) {
                $step = 5;
            }
            $data['step_data'] = $query->getStepResponse($step);
            if (!$query->payment_required && $step == 3) {
                $data['next_step'] = 5;
            } else {
                $data['next_step'] = $step + 1;
            }
        }
        return $this->successResponse($data);
    }

    /**
     * Update Query with given payload.
     *
     * @param UpdateQueryAPIRequest $request
     * @param int $id
     *
     * @return QueryResource
     * @throws ValidatorException
     *
     */
    public function update(UpdateQueryAPIRequest $request, int $id): QueryResource
    {
        $input = $request->all();
        $query = $this->queryRepository->update($input, $id);

        return new QueryResource($query);
    }

    public function confirmedQueryDetail()
    {
        $confirmedQuery = ConfirmedQuery::query()->with([
            'queries' => function ($q) {
                return $q->where('patient_id', '=', Auth::id());
            },
            'accommodation',
            'coordinator'
        ])->orderByDesc('updated_at')->first();

        return $this->successResponse(ConfirmedQueryResource::make($confirmedQuery));
    }

    public function uploadVisa(Request $request)
    {
        $request->validate([
            'files' => ['required'],
            'files.*' => ['mimes:png,jpeg,jpg,pdf', 'max:10240'],
            'model_id' => ['required'],
            'name' => ['required']
        ]);
        try {
            $query = Query::findOrFail($request->input('model_id'));
            $query->updateImage('files', $request->input('name'), false);
            return $this->successResponse("File uploaded");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return $this->errorResponse("File not uploaded", 500);
        }

    }

    public function updatePatientResponse(Request $request)
    {
        $request->validate([
            'query_id' => 'required| exists:queries,id'
        ]);
        if ($request->has('document')) {
            $path = $request->file('document')->store('public');
            $activeQuery = ActiveQuery::where('query_id', $request->input('query_id'))->first();
            $activeQuery->patient_response = $path;
            $activeQuery->save();
            return $this->successResponse("Upload successful");
        }
    }

    public function transactionSuccess(Request $request)
    {
        $request->validate([
            'query_id' => 'required',
            'r_payment_id' => 'required',
            'amount' => 'required',
        ]);
        try {
            $payment = Payment::create([
                'r_payment_id' => $request->input('r_payment_id'),
                'method' => $request->input('method') ?? 'razorpay',
                'currency' => $request->input('currency') ?? 'inr',
                'phone' => \auth()->user()->phone,
                'amount' => $request->input('amount'),
                'json_response' => $request->input('response'),
            ]);
            $query = ActiveQuery::where('query_id', $request->input('query_id'))->first();
            $query->is_payment_done = true;
            $query->is_payment_id = $payment->id;
        } catch (\Exception $e) {
            return $this->errorResponse("Opps! Something went wrong. If the amount was deducted then the payment will get reversed in 3-5 business days.", 500);
        }
        return $this->successResponse('Your payment is verified');
    }
}
