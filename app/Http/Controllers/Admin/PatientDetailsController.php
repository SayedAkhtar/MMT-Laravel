<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreatePatientDetailsAPIRequest;
use App\Http\Requests\Device\BulkUpdatePatientDetailsAPIRequest;
use App\Http\Requests\Device\CreatePatientDetailsAPIRequest;
use App\Http\Requests\Device\UpdatePatientDetailsAPIRequest;
use App\Http\Resources\Device\PatientDetailsCollection;
use App\Http\Resources\Device\PatientDetailsResource;
use App\Repositories\PatientDetailsRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class PatientDetailsController extends AppBaseController
{
    use IsViewModule;

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
        $this->module = "module/patient-details";
    }

    /**
     * PatientDetails's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     */
    public function index(Request $request)
    {
        $patientDetails = $this->patientDetailsRepository->fetch($request);
    }

    /**
     * Create PatientDetails with given payload.
     *
     * @param CreatePatientDetailsAPIRequest $request
     *
     * @return PatientDetailsResource
     * @throws ValidatorException
     *
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
     * @param int $id
     *
     * @return PatientDetailsResource
     * @throws ValidatorException
     *
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
     * @return JsonResponse
     * @throws Exception
     *
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
     * @return PatientDetailsCollection
     * @throws ValidatorException
     *
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
     * @return PatientDetailsCollection
     * @throws ValidatorException
     *
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
