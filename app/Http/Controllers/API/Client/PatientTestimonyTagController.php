<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreatePatientTestimonyTagAPIRequest;
use App\Http\Requests\Client\BulkUpdatePatientTestimonyTagAPIRequest;
use App\Http\Requests\Client\CreatePatientTestimonyTagAPIRequest;
use App\Http\Requests\Client\UpdatePatientTestimonyTagAPIRequest;
use App\Http\Resources\Client\PatientTestimonyTagCollection;
use App\Http\Resources\Client\PatientTestimonyTagResource;
use App\Repositories\PatientTestimonyTagRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class PatientTestimonyTagController extends AppBaseController
{
    /**
     * @var PatientTestimonyTagRepository
     */
    private PatientTestimonyTagRepository $patientTestimonyTagRepository;

    /**
     * @param PatientTestimonyTagRepository $patientTestimonyTagRepository
     */
    public function __construct(PatientTestimonyTagRepository $patientTestimonyTagRepository)
    {
        $this->patientTestimonyTagRepository = $patientTestimonyTagRepository;
    }

    /**
     * PatientTestimonyTag's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return PatientTestimonyTagCollection
     */
    public function index(Request $request): PatientTestimonyTagCollection
    {
        $patientTestimonyTags = $this->patientTestimonyTagRepository->fetch($request);

        return new PatientTestimonyTagCollection($patientTestimonyTags);
    }

    /**
     * Create PatientTestimonyTag with given payload.
     *
     * @param CreatePatientTestimonyTagAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientTestimonyTagResource
     */
    public function store(CreatePatientTestimonyTagAPIRequest $request): PatientTestimonyTagResource
    {
        $input = $request->all();
        $patientTestimonyTag = $this->patientTestimonyTagRepository->create($input);

        return new PatientTestimonyTagResource($patientTestimonyTag);
    }

    /**
     * Get single PatientTestimonyTag record.
     *
     * @param int $id
     *
     * @return PatientTestimonyTagResource
     */
    public function show(int $id): PatientTestimonyTagResource
    {
        $patientTestimonyTag = $this->patientTestimonyTagRepository->findOrFail($id);

        return new PatientTestimonyTagResource($patientTestimonyTag);
    }

    /**
     * Update PatientTestimonyTag with given payload.
     *
     * @param UpdatePatientTestimonyTagAPIRequest $request
     * @param int                                 $id
     *
     * @throws ValidatorException
     *
     * @return PatientTestimonyTagResource
     */
    public function update(UpdatePatientTestimonyTagAPIRequest $request, int $id): PatientTestimonyTagResource
    {
        $input = $request->all();
        $patientTestimonyTag = $this->patientTestimonyTagRepository->update($input, $id);

        return new PatientTestimonyTagResource($patientTestimonyTag);
    }

    /**
     * Delete given PatientTestimonyTag.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->patientTestimonyTagRepository->delete($id);

        return $this->successResponse('PatientTestimonyTag deleted successfully.');
    }

    /**
     * Bulk create PatientTestimonyTag's.
     *
     * @param BulkCreatePatientTestimonyTagAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientTestimonyTagCollection
     */
    public function bulkStore(BulkCreatePatientTestimonyTagAPIRequest $request): PatientTestimonyTagCollection
    {
        $patientTestimonyTags = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientTestimonyTagInput) {
            $patientTestimonyTags[$key] = $this->patientTestimonyTagRepository->create($patientTestimonyTagInput);
        }

        return new PatientTestimonyTagCollection($patientTestimonyTags);
    }

    /**
     * Bulk update PatientTestimonyTag's data.
     *
     * @param BulkUpdatePatientTestimonyTagAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientTestimonyTagCollection
     */
    public function bulkUpdate(BulkUpdatePatientTestimonyTagAPIRequest $request): PatientTestimonyTagCollection
    {
        $patientTestimonyTags = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientTestimonyTagInput) {
            $patientTestimonyTags[$key] = $this->patientTestimonyTagRepository->update($patientTestimonyTagInput, $patientTestimonyTagInput['id']);
        }

        return new PatientTestimonyTagCollection($patientTestimonyTags);
    }
}
