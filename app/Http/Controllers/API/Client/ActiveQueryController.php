<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateActiveQueryAPIRequest;
use App\Http\Requests\Client\BulkUpdateActiveQueryAPIRequest;
use App\Http\Requests\Client\CreateActiveQueryAPIRequest;
use App\Http\Requests\Client\UpdateActiveQueryAPIRequest;
use App\Http\Resources\Client\ActiveQueryCollection;
use App\Http\Resources\Client\ActiveQueryResource;
use App\Repositories\ActiveQueryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class ActiveQueryController extends AppBaseController
{
    /**
     * @var ActiveQueryRepository
     */
    private ActiveQueryRepository $activeQueryRepository;

    /**
     * @param ActiveQueryRepository $activeQueryRepository
     */
    public function __construct(ActiveQueryRepository $activeQueryRepository)
    {
        $this->activeQueryRepository = $activeQueryRepository;
    }

    /**
     * ActiveQuery's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return ActiveQueryCollection
     */
    public function index(Request $request): ActiveQueryCollection
    {
        $activeQueries = $this->activeQueryRepository->fetch($request);

        return new ActiveQueryCollection($activeQueries);
    }

    /**
     * Create ActiveQuery with given payload.
     *
     * @param CreateActiveQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return ActiveQueryResource
     */
    public function store(CreateActiveQueryAPIRequest $request): ActiveQueryResource
    {
        $input = $request->all();
        $activeQuery = $this->activeQueryRepository->create($input);

        return new ActiveQueryResource($activeQuery);
    }

    /**
     * Get single ActiveQuery record.
     *
     * @param int $id
     *
     * @return ActiveQueryResource
     */
    public function show(int $id): ActiveQueryResource
    {
        $activeQuery = $this->activeQueryRepository->findOrFail($id);

        return new ActiveQueryResource($activeQuery);
    }

    /**
     * Update ActiveQuery with given payload.
     *
     * @param UpdateActiveQueryAPIRequest $request
     * @param int                         $id
     *
     * @throws ValidatorException
     *
     * @return ActiveQueryResource
     */
    public function update(UpdateActiveQueryAPIRequest $request, int $id): ActiveQueryResource
    {
        $input = $request->all();
        $activeQuery = $this->activeQueryRepository->update($input, $id);

        return new ActiveQueryResource($activeQuery);
    }

    /**
     * Delete given ActiveQuery.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->activeQueryRepository->delete($id);

        return $this->successResponse('ActiveQuery deleted successfully.');
    }

    /**
     * Bulk create ActiveQuery's.
     *
     * @param BulkCreateActiveQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return ActiveQueryCollection
     */
    public function bulkStore(BulkCreateActiveQueryAPIRequest $request): ActiveQueryCollection
    {
        $activeQueries = collect();

        $input = $request->get('data');
        foreach ($input as $key => $activeQueryInput) {
            $activeQueries[$key] = $this->activeQueryRepository->create($activeQueryInput);
        }

        return new ActiveQueryCollection($activeQueries);
    }

    /**
     * Bulk update ActiveQuery's data.
     *
     * @param BulkUpdateActiveQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return ActiveQueryCollection
     */
    public function bulkUpdate(BulkUpdateActiveQueryAPIRequest $request): ActiveQueryCollection
    {
        $activeQueries = collect();

        $input = $request->get('data');
        foreach ($input as $key => $activeQueryInput) {
            $activeQueries[$key] = $this->activeQueryRepository->update($activeQueryInput, $activeQueryInput['id']);
        }

        return new ActiveQueryCollection($activeQueries);
    }
}
