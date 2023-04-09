<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\CreateQueryAPIRequest;
use App\Http\Requests\Client\UpdateQueryAPIRequest;
use App\Http\Resources\Client\ActiveQueryResource;
use App\Http\Resources\Client\ConfirmedQueryResource;
use App\Http\Resources\Client\QueryCollection;
use App\Http\Resources\Client\QueryResource;
use App\Models\ConfirmedQuery;
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
        $queries = $this->queryRepository->fetch($request);
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
        $query = $this->queryRepository->create($input);

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
}
