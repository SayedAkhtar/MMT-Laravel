<?php

namespace App\Http\Controllers\API\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateDegisnationAPIRequest;
use App\Http\Requests\Device\BulkUpdateDegisnationAPIRequest;
use App\Http\Requests\Device\CreateDegisnationAPIRequest;
use App\Http\Requests\Device\UpdateDegisnationAPIRequest;
use App\Http\Resources\Device\DegisnationCollection;
use App\Http\Resources\Device\DegisnationResource;
use App\Repositories\DegisnationRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class DegisnationController extends AppBaseController
{
    /**
     * @var DegisnationRepository
     */
    private DegisnationRepository $degisnationRepository;

    /**
     * @param DegisnationRepository $degisnationRepository
     */
    public function __construct(DegisnationRepository $degisnationRepository)
    {
        $this->degisnationRepository = $degisnationRepository;
    }

    /**
     * Degisnation's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return DegisnationCollection
     */
    public function index(Request $request): DegisnationCollection
    {
        $degisnations = $this->degisnationRepository->fetch($request);

        return new DegisnationCollection($degisnations);
    }

    /**
     * Create Degisnation with given payload.
     *
     * @param CreateDegisnationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DegisnationResource
     */
    public function store(CreateDegisnationAPIRequest $request): DegisnationResource
    {
        $input = $request->all();
        $degisnation = $this->degisnationRepository->create($input);

        return new DegisnationResource($degisnation);
    }

    /**
     * Get single Degisnation record.
     *
     * @param int $id
     *
     * @return DegisnationResource
     */
    public function show(int $id): DegisnationResource
    {
        $degisnation = $this->degisnationRepository->findOrFail($id);

        return new DegisnationResource($degisnation);
    }

    /**
     * Update Degisnation with given payload.
     *
     * @param UpdateDegisnationAPIRequest $request
     * @param int                         $id
     *
     * @throws ValidatorException
     *
     * @return DegisnationResource
     */
    public function update(UpdateDegisnationAPIRequest $request, int $id): DegisnationResource
    {
        $input = $request->all();
        $degisnation = $this->degisnationRepository->update($input, $id);

        return new DegisnationResource($degisnation);
    }

    /**
     * Delete given Degisnation.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->degisnationRepository->delete($id);

        return $this->successResponse('Degisnation deleted successfully.');
    }

    /**
     * Bulk create Degisnation's.
     *
     * @param BulkCreateDegisnationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DegisnationCollection
     */
    public function bulkStore(BulkCreateDegisnationAPIRequest $request): DegisnationCollection
    {
        $degisnations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $degisnationInput) {
            $degisnations[$key] = $this->degisnationRepository->create($degisnationInput);
        }

        return new DegisnationCollection($degisnations);
    }

    /**
     * Bulk update Degisnation's data.
     *
     * @param BulkUpdateDegisnationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DegisnationCollection
     */
    public function bulkUpdate(BulkUpdateDegisnationAPIRequest $request): DegisnationCollection
    {
        $degisnations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $degisnationInput) {
            $degisnations[$key] = $this->degisnationRepository->update($degisnationInput, $degisnationInput['id']);
        }

        return new DegisnationCollection($degisnations);
    }
}
