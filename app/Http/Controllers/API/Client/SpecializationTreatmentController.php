<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateSpecializationTreatmentAPIRequest;
use App\Http\Requests\Client\BulkUpdateSpecializationTreatmentAPIRequest;
use App\Http\Requests\Client\CreateSpecializationTreatmentAPIRequest;
use App\Http\Requests\Client\UpdateSpecializationTreatmentAPIRequest;
use App\Http\Resources\Client\SpecializationTreatmentCollection;
use App\Http\Resources\Client\SpecializationTreatmentResource;
use App\Repositories\SpecializationTreatmentRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class SpecializationTreatmentController extends AppBaseController
{
    /**
     * @var SpecializationTreatmentRepository
     */
    private SpecializationTreatmentRepository $specializationTreatmentRepository;

    /**
     * @param SpecializationTreatmentRepository $specializationTreatmentRepository
     */
    public function __construct(SpecializationTreatmentRepository $specializationTreatmentRepository)
    {
        $this->specializationTreatmentRepository = $specializationTreatmentRepository;
    }

    /**
     * SpecializationTreatment's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return SpecializationTreatmentCollection
     */
    public function index(Request $request): SpecializationTreatmentCollection
    {
        $specializationTreatments = $this->specializationTreatmentRepository->fetch($request);

        return new SpecializationTreatmentCollection($specializationTreatments);
    }

    /**
     * Create SpecializationTreatment with given payload.
     *
     * @param CreateSpecializationTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return SpecializationTreatmentResource
     */
    public function store(CreateSpecializationTreatmentAPIRequest $request): SpecializationTreatmentResource
    {
        $input = $request->all();
        $specializationTreatment = $this->specializationTreatmentRepository->create($input);

        return new SpecializationTreatmentResource($specializationTreatment);
    }

    /**
     * Get single SpecializationTreatment record.
     *
     * @param int $id
     *
     * @return SpecializationTreatmentResource
     */
    public function show(int $id): SpecializationTreatmentResource
    {
        $specializationTreatment = $this->specializationTreatmentRepository->findOrFail($id);

        return new SpecializationTreatmentResource($specializationTreatment);
    }

    /**
     * Update SpecializationTreatment with given payload.
     *
     * @param UpdateSpecializationTreatmentAPIRequest $request
     * @param int                                     $id
     *
     * @throws ValidatorException
     *
     * @return SpecializationTreatmentResource
     */
    public function update(UpdateSpecializationTreatmentAPIRequest $request, int $id): SpecializationTreatmentResource
    {
        $input = $request->all();
        $specializationTreatment = $this->specializationTreatmentRepository->update($input, $id);

        return new SpecializationTreatmentResource($specializationTreatment);
    }

    /**
     * Delete given SpecializationTreatment.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->specializationTreatmentRepository->delete($id);

        return $this->successResponse('SpecializationTreatment deleted successfully.');
    }

    /**
     * Bulk create SpecializationTreatment's.
     *
     * @param BulkCreateSpecializationTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return SpecializationTreatmentCollection
     */
    public function bulkStore(BulkCreateSpecializationTreatmentAPIRequest $request): SpecializationTreatmentCollection
    {
        $specializationTreatments = collect();

        $input = $request->get('data');
        foreach ($input as $key => $specializationTreatmentInput) {
            $specializationTreatments[$key] = $this->specializationTreatmentRepository->create($specializationTreatmentInput);
        }

        return new SpecializationTreatmentCollection($specializationTreatments);
    }

    /**
     * Bulk update SpecializationTreatment's data.
     *
     * @param BulkUpdateSpecializationTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return SpecializationTreatmentCollection
     */
    public function bulkUpdate(BulkUpdateSpecializationTreatmentAPIRequest $request): SpecializationTreatmentCollection
    {
        $specializationTreatments = collect();

        $input = $request->get('data');
        foreach ($input as $key => $specializationTreatmentInput) {
            $specializationTreatments[$key] = $this->specializationTreatmentRepository->update($specializationTreatmentInput, $specializationTreatmentInput['id']);
        }

        return new SpecializationTreatmentCollection($specializationTreatments);
    }
}
