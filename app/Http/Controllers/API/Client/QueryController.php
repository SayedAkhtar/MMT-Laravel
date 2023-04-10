<?php

namespace App\Http\Controllers\API\Client;

use App\Constants\QueryStatus;
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
use App\Repositories\QueryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $queries = Query::with('specialization', 'activeQuery')->orderByDesc('id')->get();
        $activeQueries = ActiveQueryResource::collection($queries)->resolve();
        $activeQueries = array_values(array_filter($activeQueries, function ($el) {
            if (count($el) > 0) return $el;
        }));
        $data['active_query'] = $activeQueries;
        $data['all_query'] = QueryResource::collection($queries)->resolve();
        return $this->successResponse($data);
    }

    /**
     * Create Query with given payload.
     *
     * @param CreateQueryAPIRequest $request
     *
     * @return QueryResource
     * @throws ValidatorException
     *
     */
    public function store(CreateQueryAPIRequest $request): QueryResource
    {
        $input = $request->all();
        try {
            unset($input['medical_visa']);
            unset($input['passport_image']);
            if ($request->hasFile('medical_visa')) {
                $input['medical_visa'] = $request->file('medical_visa')->store('public');
            }
            if ($request->hasFile('passport_image')) {
                $input['passport_image'] = $request->file('passport_image')->store('public');
            }
            $input['status'] = QueryStatus::QUERY_OPEN;
            $input['patient_id'] = Auth::id();
            $query = $this->queryRepository->create($input);
        } catch (\Exception $e) {

        }

        return new QueryResource($query);
    }

    /**
     * Get single Query record.
     *
     * @param int $id
     *
     * @return QueryResource
     */
    public function show(int $id): QueryResource
    {
        $query = $this->queryRepository->findOrFail($id);

        return new QueryResource($query);
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
