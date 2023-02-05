<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateConfirmedQueryAPIRequest;
use App\Http\Requests\Client\BulkUpdateConfirmedQueryAPIRequest;
use App\Http\Requests\Client\CreateConfirmedQueryAPIRequest;
use App\Http\Requests\Client\UpdateConfirmedQueryAPIRequest;
use App\Http\Resources\Client\ConfirmedQueryCollection;
use App\Http\Resources\Client\ConfirmedQueryResource;
use App\Repositories\ConfirmedQueryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class ConfirmedQueryController extends AppBaseController
{
    /**
     * @var ConfirmedQueryRepository
     */
    private ConfirmedQueryRepository $confirmedQueryRepository;

    /**
     * @param ConfirmedQueryRepository $confirmedQueryRepository
     */
    public function __construct(ConfirmedQueryRepository $confirmedQueryRepository)
    {
        $this->confirmedQueryRepository = $confirmedQueryRepository;
    }

    /**
     * ConfirmedQuery's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return ConfirmedQueryCollection
     */
    public function index(Request $request): ConfirmedQueryCollection
    {
        $confirmedQueries = $this->confirmedQueryRepository->fetch($request);

        return new ConfirmedQueryCollection($confirmedQueries);
    }

    /**
     * Create ConfirmedQuery with given payload.
     *
     * @param CreateConfirmedQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return ConfirmedQueryResource
     */
    public function store(CreateConfirmedQueryAPIRequest $request): ConfirmedQueryResource
    {
        $input = $request->all();
        $confirmedQuery = $this->confirmedQueryRepository->create($input);

        return new ConfirmedQueryResource($confirmedQuery);
    }

    /**
     * Get single ConfirmedQuery record.
     *
     * @param int $id
     *
     * @return ConfirmedQueryResource
     */
    public function show(int $id): ConfirmedQueryResource
    {
        $confirmedQuery = $this->confirmedQueryRepository->findOrFail($id);

        return new ConfirmedQueryResource($confirmedQuery);
    }

    /**
     * Update ConfirmedQuery with given payload.
     *
     * @param UpdateConfirmedQueryAPIRequest $request
     * @param int                            $id
     *
     * @throws ValidatorException
     *
     * @return ConfirmedQueryResource
     */
    public function update(UpdateConfirmedQueryAPIRequest $request, int $id): ConfirmedQueryResource
    {
        $input = $request->all();
        $confirmedQuery = $this->confirmedQueryRepository->update($input, $id);

        return new ConfirmedQueryResource($confirmedQuery);
    }

    /**
     * Delete given ConfirmedQuery.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->confirmedQueryRepository->delete($id);

        return $this->successResponse('ConfirmedQuery deleted successfully.');
    }

    /**
     * Bulk create ConfirmedQuery's.
     *
     * @param BulkCreateConfirmedQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return ConfirmedQueryCollection
     */
    public function bulkStore(BulkCreateConfirmedQueryAPIRequest $request): ConfirmedQueryCollection
    {
        $confirmedQueries = collect();

        $input = $request->get('data');
        foreach ($input as $key => $confirmedQueryInput) {
            $confirmedQueries[$key] = $this->confirmedQueryRepository->create($confirmedQueryInput);
        }

        return new ConfirmedQueryCollection($confirmedQueries);
    }

    /**
     * Bulk update ConfirmedQuery's data.
     *
     * @param BulkUpdateConfirmedQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return ConfirmedQueryCollection
     */
    public function bulkUpdate(BulkUpdateConfirmedQueryAPIRequest $request): ConfirmedQueryCollection
    {
        $confirmedQueries = collect();

        $input = $request->get('data');
        foreach ($input as $key => $confirmedQueryInput) {
            $confirmedQueries[$key] = $this->confirmedQueryRepository->update($confirmedQueryInput, $confirmedQueryInput['id']);
        }

        return new ConfirmedQueryCollection($confirmedQueries);
    }
}
