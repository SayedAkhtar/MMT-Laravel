<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreatePatientFamilyDetailsAPIRequest;
use App\Http\Requests\Client\BulkUpdatePatientFamilyDetailsAPIRequest;
use App\Http\Requests\Client\CreatePatientFamilyDetailsAPIRequest;
use App\Http\Requests\Client\UpdatePatientFamilyDetailsAPIRequest;
use App\Http\Resources\Client\PatientFamilyDetailsCollection;
use App\Http\Resources\Client\PatientFamilyDetailsResource;
use App\Models\User;
use App\Repositories\PatientFamilyDetailsRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $patientFamilyDetails = User::find(Auth::id())->patientFamilyDetails;

        return new PatientFamilyDetailsCollection($patientFamilyDetails);
    }

    /**
     * Create PatientFamilyDetails with given payload.
     *
     * @param CreatePatientFamilyDetailsAPIRequest $request
     *
     * @return PatientFamilyDetailsResource
     * @throws ValidatorException
     *
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
     * @param int $id
     *
     * @return PatientFamilyDetailsResource
     * @throws ValidatorException
     *
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
     * @return JsonResponse
     * @throws Exception
     *
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
     * @return PatientFamilyDetailsCollection
     * @throws ValidatorException
     *
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
     * @return PatientFamilyDetailsCollection
     * @throws ValidatorException
     *
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
