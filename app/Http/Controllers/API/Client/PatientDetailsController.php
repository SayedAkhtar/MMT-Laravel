<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreatePatientDetailsAPIRequest;
use App\Http\Requests\Client\BulkUpdatePatientDetailsAPIRequest;
use App\Http\Requests\Client\CreatePatientDetailsAPIRequest;
use App\Http\Requests\Client\UpdatePatientDetailsAPIRequest;
use App\Http\Resources\Client\PatientDetailsCollection;
use App\Http\Resources\Client\PatientDetailsResource;
use App\Repositories\PatientDetailsRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class PatientDetailsController extends AppBaseController
{
    /**
     * @var PatientDetailsRepository
     */
    private PatientDetailsRepository $patientDetailsRepository;

    /**
     * @param PatientDetailsRepository $patientDetailsRepository
     */
    public function __construct(PatientDetailsRepository $patientDetailsRepository)
    {
        $this->patientDetailsRepository = $patientDetailsRepository;
    }

    /**
     * PatientDetails's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return PatientDetailsCollection
     */
    public function index(Request $request): PatientDetailsCollection
    {
        $patientDetails = $this->patientDetailsRepository->fetch($request);

        return new PatientDetailsCollection($patientDetails);
    }

    /**
     * Create PatientDetails with given payload.
     *
     * @param CreatePatientDetailsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientDetailsResource
     */
    public function store(CreatePatientDetailsAPIRequest $request): PatientDetailsResource
    {
        $input = $request->all();
        $patientDetails = $this->patientDetailsRepository->create($input);

        return new PatientDetailsResource($patientDetails);
    }

    /**
     * Get single PatientDetails record.
     *
     * @param int $id
     *
     * @return PatientDetailsResource
     */
    public function show(int $id): PatientDetailsResource
    {
        $patientDetails = $this->patientDetailsRepository->findOrFail($id);

        return new PatientDetailsResource($patientDetails);
    }

    /**
     * Update PatientDetails with given payload.
     *
     * @param UpdatePatientDetailsAPIRequest $request
     * @param int                            $id
     *
     * @throws ValidatorException
     *
     * @return PatientDetailsResource
     */
    public function update(UpdatePatientDetailsAPIRequest $request, int $id): PatientDetailsResource
    {
        $input = $request->all();
        $patientDetails = $this->patientDetailsRepository->update($input, $id);

        return new PatientDetailsResource($patientDetails);
    }

    /**
     * Delete given PatientDetails.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->patientDetailsRepository->delete($id);

        return $this->successResponse('PatientDetails deleted successfully.');
    }

    /**
     * Bulk create PatientDetails's.
     *
     * @param BulkCreatePatientDetailsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientDetailsCollection
     */
    public function bulkStore(BulkCreatePatientDetailsAPIRequest $request): PatientDetailsCollection
    {
        $patientDetails = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientDetailsInput) {
            $patientDetails[$key] = $this->patientDetailsRepository->create($patientDetailsInput);
        }

        return new PatientDetailsCollection($patientDetails);
    }

    /**
     * Bulk update PatientDetails's data.
     *
     * @param BulkUpdatePatientDetailsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientDetailsCollection
     */
    public function bulkUpdate(BulkUpdatePatientDetailsAPIRequest $request): PatientDetailsCollection
    {
        $patientDetails = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientDetailsInput) {
            $patientDetails[$key] = $this->patientDetailsRepository->update($patientDetailsInput, $patientDetailsInput['id']);
        }

        return new PatientDetailsCollection($patientDetails);
    }
}
