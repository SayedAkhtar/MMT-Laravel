<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreatePatientFamilyAPIRequest;
use App\Http\Requests\Client\BulkUpdatePatientFamilyAPIRequest;
use App\Http\Requests\Client\CreatePatientFamilyAPIRequest;
use App\Http\Requests\Client\UpdatePatientFamilyAPIRequest;
use App\Http\Resources\Client\PatientFamilyCollection;
use App\Http\Resources\Client\PatientFamilyResource;
use App\Repositories\PatientFamilyRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
    public function index(Request $request): PatientFamilyCollection
    {
        $patientFamilies = $this->patientFamilyRepository->fetch($request);

        return new PatientFamilyCollection($patientFamilies);
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
        $patientFamily = $this->patientFamilyRepository->create($input);
//
//        return new PatientFamilyResource($patientFamily);
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
    public function delete(int $id): JsonResponse
    {
        $this->patientFamilyRepository->delete($id);

        return $this->successResponse('PatientFamily deleted successfully.');
    }

    /**
     * Bulk create PatientFamily's.
     *
     * @param BulkCreatePatientFamilyAPIRequest $request
     *
     * @return PatientFamilyCollection
     * @throws ValidatorException
     *
     */
    public function bulkStore(BulkCreatePatientFamilyAPIRequest $request): PatientFamilyCollection
    {
        $patientFamilies = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientFamilyInput) {
            $patientFamilies[$key] = $this->patientFamilyRepository->create($patientFamilyInput);
        }

        return new PatientFamilyCollection($patientFamilies);
    }

    /**
     * Bulk update PatientFamily's data.
     *
     * @param BulkUpdatePatientFamilyAPIRequest $request
     *
     * @return PatientFamilyCollection
     * @throws ValidatorException
     *
     */
    public function bulkUpdate(BulkUpdatePatientFamilyAPIRequest $request): PatientFamilyCollection
    {
        $patientFamilies = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientFamilyInput) {
            $patientFamilies[$key] = $this->patientFamilyRepository->update($patientFamilyInput, $patientFamilyInput['id']);
        }

        return new PatientFamilyCollection($patientFamilies);
    }
}
