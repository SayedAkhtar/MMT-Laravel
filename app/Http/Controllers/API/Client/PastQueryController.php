<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreatePastQueryAPIRequest;
use App\Http\Requests\Client\BulkUpdatePastQueryAPIRequest;
use App\Http\Requests\Client\CreatePastQueryAPIRequest;
use App\Http\Requests\Client\UpdatePastQueryAPIRequest;
use App\Http\Resources\Client\PastQueryCollection;
use App\Http\Resources\Client\PastQueryResource;
use App\Repositories\PastQueryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class PastQueryController extends AppBaseController
{
    /**
     * @var PastQueryRepository
     */
    private PastQueryRepository $pastQueryRepository;

    /**
     * @param PastQueryRepository $pastQueryRepository
     */
    public function __construct(PastQueryRepository $pastQueryRepository)
    {
        $this->pastQueryRepository = $pastQueryRepository;
    }

    /**
     * PastQuery's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return PastQueryCollection
     */
    public function index(Request $request): PastQueryCollection
    {
        $pastQueries = $this->pastQueryRepository->fetch($request);

        return new PastQueryCollection($pastQueries);
    }

    /**
     * Create PastQuery with given payload.
     *
     * @param CreatePastQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PastQueryResource
     */
    public function store(CreatePastQueryAPIRequest $request): PastQueryResource
    {
        $input = $request->all();
        $pastQuery = $this->pastQueryRepository->create($input);

        return new PastQueryResource($pastQuery);
    }

    /**
     * Get single PastQuery record.
     *
     * @param int $id
     *
     * @return PastQueryResource
     */
    public function show(int $id): PastQueryResource
    {
        $pastQuery = $this->pastQueryRepository->findOrFail($id);

        return new PastQueryResource($pastQuery);
    }

    /**
     * Update PastQuery with given payload.
     *
     * @param UpdatePastQueryAPIRequest $request
     * @param int                       $id
     *
     * @throws ValidatorException
     *
     * @return PastQueryResource
     */
    public function update(UpdatePastQueryAPIRequest $request, int $id): PastQueryResource
    {
        $input = $request->all();
        $pastQuery = $this->pastQueryRepository->update($input, $id);

        return new PastQueryResource($pastQuery);
    }

    /**
     * Delete given PastQuery.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->pastQueryRepository->delete($id);

        return $this->successResponse('PastQuery deleted successfully.');
    }

    /**
     * Bulk create PastQuery's.
     *
     * @param BulkCreatePastQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PastQueryCollection
     */
    public function bulkStore(BulkCreatePastQueryAPIRequest $request): PastQueryCollection
    {
        $pastQueries = collect();

        $input = $request->get('data');
        foreach ($input as $key => $pastQueryInput) {
            $pastQueries[$key] = $this->pastQueryRepository->create($pastQueryInput);
        }

        return new PastQueryCollection($pastQueries);
    }

    /**
     * Bulk update PastQuery's data.
     *
     * @param BulkUpdatePastQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PastQueryCollection
     */
    public function bulkUpdate(BulkUpdatePastQueryAPIRequest $request): PastQueryCollection
    {
        $pastQueries = collect();

        $input = $request->get('data');
        foreach ($input as $key => $pastQueryInput) {
            $pastQueries[$key] = $this->pastQueryRepository->update($pastQueryInput, $pastQueryInput['id']);
        }

        return new PastQueryCollection($pastQueries);
    }
}
