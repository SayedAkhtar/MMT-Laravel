<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreatePatientFamilyAPIRequest;
use App\Http\Requests\Client\BulkUpdatePatientFamilyAPIRequest;
use App\Http\Requests\Client\CreatePatientFamilyAPIRequest;
use App\Http\Requests\Client\UpdatePatientFamilyAPIRequest;
use App\Http\Resources\Client\PatientDetailsResource;
use App\Http\Resources\Client\PatientFamilyCollection;
use App\Http\Resources\Client\PatientFamilyResource;
use App\Models\PatientFamilyDetails;
use App\Models\User;
use App\Repositories\PatientFamilyRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

class PatientFamilyController extends AppBaseController
{
    /**
     * @var PatientFamilyRepository
     */
    private PatientFamilyRepository $patientFamilyRepository;

    /**
     * @param PatientFamilyRepository $patientFamilyRepository
     */
    public function __construct(PatientFamilyRepository $patientFamilyRepository)
    {
        $this->patientFamilyRepository = $patientFamilyRepository;
    }

    /**
     * PatientFamily's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return PatientFamilyCollection
     */
    public function index(Request $request)
    {
        $user = User::with(['patientFamilyDetails' => function ($q) {
            $q->leftJoin('users as u', function ($join) {
                $join->on(DB::raw("CONCAT(u.country_code, '', u.phone)"), '=', 'patient_family_details.phone')->where('u.is_active', true);
            })
            ->select([DB::raw('u.id as family_user_id'), 'patient_family_details.*', 'q.*']);
        }])->find(Auth::id());
        $patientFamilies = $user->patientFamilyDetails;
        return $this->successResponse(PatientFamilyResource::collection($patientFamilies));
    }

    /**
     * Create PatientFamily with given payload.
     *
     * @param CreatePatientFamilyAPIRequest $request
     *
     * @throws ValidatorException
     *
     */
    public function store(CreatePatientFamilyAPIRequest $request)
    {
        $input = $request->all();
        $input['patient_id'] = Auth::id();
        $family = PatientFamilyDetails::create($input);
        return $this->successResponse($family);
    }

    /**
     * Get single PatientFamily record.
     *
     * @param int $id
     *
     * @return PatientFamilyResource
     */
    public function show(int $id): PatientFamilyResource
    {
        $patientFamily = $this->patientFamilyRepository->findOrFail($id);

        return new PatientFamilyResource($patientFamily);
    }

    /**
     * Update PatientFamily with given payload.
     *
     * @param UpdatePatientFamilyAPIRequest $request
     * @param int $id
     *
     * @return PatientFamilyResource
     * @throws ValidatorException
     *
     */
    public function update(UpdatePatientFamilyAPIRequest $request, int $id): PatientFamilyResource
    {
        $input = $request->all();
        $patientFamily = $this->patientFamilyRepository->update($input, $id);

        return new PatientFamilyResource($patientFamily);
    }

    /**
     * Delete given PatientFamily.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     *
     */
    public function destroy(int $id): JsonResponse
    {
        PatientFamilyDetails::find($id)->delete();
        return $this->successResponse('PatientFamily deleted successfully.');
    }
}
