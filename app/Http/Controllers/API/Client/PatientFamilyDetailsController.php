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
    public function index(Request $request)
    {
        $patientFamilyDetails = User::find(Auth::id())->patientFamilyDetails;

        return $this->successResponse(PatientFamilyDetailsResource::collection($patientFamilyDetails)) ;
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
    public function store(CreatePatientFamilyDetailsAPIRequest $request)
    {
        $input = $request->all();
        $patientFamilyDetails = $this->patientFamilyDetailsRepository->create($input);

        return $this->successResponse(new PatientFamilyDetailsResource($patientFamilyDetails)) ;
    }

    /**
     * Get single PatientFamilyDetails record.
     *
     * @param int $id
     *
     * @return PatientFamilyDetailsResource
     */
    public function show(int $id)
    {
        $patientFamilyDetails = $this->patientFamilyDetailsRepository->findOrFail($id);

        return $this->successResponse(PatientFamilyDetailsResource::collection($patientFamilyDetails));
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
    public function update(UpdatePatientFamilyDetailsAPIRequest $request, int $id)
    {
        $input = $request->all();
        $patientFamilyDetails = $this->patientFamilyDetailsRepository->update($input, $id);

        return $this->successResponse(PatientFamilyDetailsResource::collection($patientFamilyDetails));
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
    public function destroy(int $id)
    {
        $this->patientFamilyDetailsRepository->delete($id);

        return $this->successResponse('Patient Family Details deleted successfully.');
    }

}
