<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreatePatientTestimonyAPIRequest;
use App\Http\Requests\Device\BulkUpdatePatientTestimonyAPIRequest;
use App\Http\Requests\Device\CreatePatientTestimonyAPIRequest;
use App\Http\Requests\Device\UpdatePatientTestimonyAPIRequest;
use App\Http\Resources\Device\PatientTestimonyCollection;
use App\Http\Resources\Device\PatientTestimonyResource;
use App\Repositories\PatientTestimonyRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class PatientTestimonyController extends AppBaseController
{
    /**
     * @var PatientTestimonyRepository
     */
    private PatientTestimonyRepository $patientTestimonyRepository;

    /**
     * @param PatientTestimonyRepository $patientTestimonyRepository
     */
    public function __construct(PatientTestimonyRepository $patientTestimonyRepository)
    {
        $this->patientTestimonyRepository = $patientTestimonyRepository;
    }

    /**
     * PatientTestimony's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return PatientTestimonyCollection
     */
    public function index(Request $request): PatientTestimonyCollection
    {
        $patientTestimonies = $this->patientTestimonyRepository->fetch($request);

        return new PatientTestimonyCollection($patientTestimonies);
    }

    /**
     * Create PatientTestimony with given payload.
     *
     * @param CreatePatientTestimonyAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientTestimonyResource
     */
    public function store(CreatePatientTestimonyAPIRequest $request): PatientTestimonyResource
    {
        $input = $request->all();
        $patientTestimony = $this->patientTestimonyRepository->create($input);

        return new PatientTestimonyResource($patientTestimony);
    }

    /**
     * Get single PatientTestimony record.
     *
     * @param int $id
     *
     * @return PatientTestimonyResource
     */
    public function show(int $id): PatientTestimonyResource
    {
        $patientTestimony = $this->patientTestimonyRepository->findOrFail($id);

        return new PatientTestimonyResource($patientTestimony);
    }

    /**
     * Update PatientTestimony with given payload.
     *
     * @param UpdatePatientTestimonyAPIRequest $request
     * @param int                              $id
     *
     * @throws ValidatorException
     *
     * @return PatientTestimonyResource
     */
    public function update(UpdatePatientTestimonyAPIRequest $request, int $id): PatientTestimonyResource
    {
        $input = $request->all();
        $patientTestimony = $this->patientTestimonyRepository->update($input, $id);

        return new PatientTestimonyResource($patientTestimony);
    }

    /**
     * Delete given PatientTestimony.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->patientTestimonyRepository->delete($id);

        return $this->successResponse('PatientTestimony deleted successfully.');
    }

    /**
     * Bulk create PatientTestimony's.
     *
     * @param BulkCreatePatientTestimonyAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientTestimonyCollection
     */
    public function bulkStore(BulkCreatePatientTestimonyAPIRequest $request): PatientTestimonyCollection
    {
        $patientTestimonies = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientTestimonyInput) {
            $patientTestimonies[$key] = $this->patientTestimonyRepository->create($patientTestimonyInput);
        }

        return new PatientTestimonyCollection($patientTestimonies);
    }

    /**
     * Bulk update PatientTestimony's data.
     *
     * @param BulkUpdatePatientTestimonyAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return PatientTestimonyCollection
     */
    public function bulkUpdate(BulkUpdatePatientTestimonyAPIRequest $request): PatientTestimonyCollection
    {
        $patientTestimonies = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientTestimonyInput) {
            $patientTestimonies[$key] = $this->patientTestimonyRepository->update($patientTestimonyInput, $patientTestimonyInput['id']);
        }

        return new PatientTestimonyCollection($patientTestimonies);
    }
}