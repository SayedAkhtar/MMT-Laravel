<?php

namespace App\Http\Controllers\API\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreatePatientFamilyDetailsAPIRequest;
use App\Http\Requests\Device\BulkUpdatePatientFamilyDetailsAPIRequest;
use App\Http\Requests\Device\CreatePatientFamilyDetailsAPIRequest;
use App\Http\Requests\Device\UpdatePatientFamilyDetailsAPIRequest;
use App\Http\Resources\Device\PatientFamilyDetailsCollection;
use App\Http\Resources\Device\PatientFamilyDetailsResource;
use App\Repositories\PatientFamilyDetailsRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class PatientFamilyDetailsController extends AppBaseController
{
    /**
     * @var PatientFamilyDetailsRepository
     */
    private PatientFamilyDetailsRepository $patientFamilyDetailsRepository;

    /**
     * @param PatientFamilyDetailsRepository $patientFamilyDetailsRepository
     */
    public function __construct(PatientFamilyDetailsRepository $patientFamilyDetailsRepository)
    {
        $this->patientFamilyDetailsRepository = $patientFamilyDetailsRepository;
    }

    /**
     * PatientFamilyDetails's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return PatientFamilyDetailsCollection
     */
    public function index(Request $request): PatientFamilyDetailsCollection
    {
        $patientFamilyDetails = $this->patientFamilyDetailsRepository->fetch($request);

        return new PatientFamilyDetailsCollection($patientFamilyDetails);
    }

    /**
     * Create PatientFamilyDetails with given payload.
     *
     * @param CreatePatientFamilyDetailsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientFamilyDetailsResource
     */
    public function store(CreatePatientFamilyDetailsAPIRequest $request): PatientFamilyDetailsResource
    {
        $input = $request->all();
        $patientFamilyDetails = $this->patientFamilyDetailsRepository->create($input);

        return new PatientFamilyDetailsResource($patientFamilyDetails);
    }

    /**
     * Get single PatientFamilyDetails record.
     *
     * @param int $id
     *
     * @return PatientFamilyDetailsResource
     */
    public function show(int $id): PatientFamilyDetailsResource
    {
        $patientFamilyDetails = $this->patientFamilyDetailsRepository->findOrFail($id);

        return new PatientFamilyDetailsResource($patientFamilyDetails);
    }

    /**
     * Update PatientFamilyDetails with given payload.
     *
     * @param UpdatePatientFamilyDetailsAPIRequest $request
     * @param int                                  $id
     *
     * @throws ValidatorException
     *
     * @return PatientFamilyDetailsResource
     */
    public function update(UpdatePatientFamilyDetailsAPIRequest $request, int $id): PatientFamilyDetailsResource
    {
        $input = $request->all();
        $patientFamilyDetails = $this->patientFamilyDetailsRepository->update($input, $id);

        return new PatientFamilyDetailsResource($patientFamilyDetails);
    }

    /**
     * Delete given PatientFamilyDetails.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->patientFamilyDetailsRepository->delete($id);

        return $this->successResponse('PatientFamilyDetails deleted successfully.');
    }

    /**
     * Bulk create PatientFamilyDetails's.
     *
     * @param BulkCreatePatientFamilyDetailsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientFamilyDetailsCollection
     */
    public function bulkStore(BulkCreatePatientFamilyDetailsAPIRequest $request): PatientFamilyDetailsCollection
    {
        $patientFamilyDetails = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientFamilyDetailsInput) {
            $patientFamilyDetails[$key] = $this->patientFamilyDetailsRepository->create($patientFamilyDetailsInput);
        }

        return new PatientFamilyDetailsCollection($patientFamilyDetails);
    }

    /**
     * Bulk update PatientFamilyDetails's data.
     *
     * @param BulkUpdatePatientFamilyDetailsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientFamilyDetailsCollection
     */
    public function bulkUpdate(BulkUpdatePatientFamilyDetailsAPIRequest $request): PatientFamilyDetailsCollection
    {
        $patientFamilyDetails = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientFamilyDetailsInput) {
            $patientFamilyDetails[$key] = $this->patientFamilyDetailsRepository->update($patientFamilyDetailsInput, $patientFamilyDetailsInput['id']);
        }

        return new PatientFamilyDetailsCollection($patientFamilyDetails);
    }
}
