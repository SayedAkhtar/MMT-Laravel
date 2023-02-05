<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateSpecializationAPIRequest;
use App\Http\Requests\Client\BulkUpdateSpecializationAPIRequest;
use App\Http\Requests\Client\CreateSpecializationAPIRequest;
use App\Http\Requests\Client\UpdateSpecializationAPIRequest;
use App\Http\Resources\Client\SpecializationCollection;
use App\Http\Resources\Client\SpecializationResource;
use App\Repositories\SpecializationRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class SpecializationController extends AppBaseController
{
    /**
     * @var SpecializationRepository
     */
    private SpecializationRepository $specializationRepository;

    /**
     * @param SpecializationRepository $specializationRepository
     */
    public function __construct(SpecializationRepository $specializationRepository)
    {
        $this->specializationRepository = $specializationRepository;
    }

    /**
     * Specialization's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return SpecializationCollection
     */
    public function index(Request $request): SpecializationCollection
    {
        $specializations = $this->specializationRepository->fetch($request);

        return new SpecializationCollection($specializations);
    }

    /**
     * Create Specialization with given payload.
     *
     * @param CreateSpecializationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return SpecializationResource
     */
    public function store(CreateSpecializationAPIRequest $request): SpecializationResource
    {
        $input = $request->all();
        $specialization = $this->specializationRepository->create($input);

        return new SpecializationResource($specialization);
    }

    /**
     * Get single Specialization record.
     *
     * @param int $id
     *
     * @return SpecializationResource
     */
    public function show(int $id): SpecializationResource
    {
        $specialization = $this->specializationRepository->findOrFail($id);

        return new SpecializationResource($specialization);
    }

    /**
     * Update Specialization with given payload.
     *
     * @param UpdateSpecializationAPIRequest $request
     * @param int                            $id
     *
     * @throws ValidatorException
     *
     * @return SpecializationResource
     */
    public function update(UpdateSpecializationAPIRequest $request, int $id): SpecializationResource
    {
        $input = $request->all();
        $specialization = $this->specializationRepository->update($input, $id);

        return new SpecializationResource($specialization);
    }

    /**
     * Delete given Specialization.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->specializationRepository->delete($id);

        return $this->successResponse('Specialization deleted successfully.');
    }

    /**
     * Bulk create Specialization's.
     *
     * @param BulkCreateSpecializationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return SpecializationCollection
     */
    public function bulkStore(BulkCreateSpecializationAPIRequest $request): SpecializationCollection
    {
        $specializations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $specializationInput) {
            $specializations[$key] = $this->specializationRepository->create($specializationInput);
        }

        return new SpecializationCollection($specializations);
    }

    /**
     * Bulk update Specialization's data.
     *
     * @param BulkUpdateSpecializationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return SpecializationCollection
     */
    public function bulkUpdate(BulkUpdateSpecializationAPIRequest $request): SpecializationCollection
    {
        $specializations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $specializationInput) {
            $specializations[$key] = $this->specializationRepository->update($specializationInput, $specializationInput['id']);
        }

        return new SpecializationCollection($specializations);
    }
}
