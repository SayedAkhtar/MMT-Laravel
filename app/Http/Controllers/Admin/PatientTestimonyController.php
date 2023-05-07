<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreatePatientTestimonyAPIRequest;
use App\Http\Requests\Device\BulkUpdatePatientTestimonyAPIRequest;
use App\Http\Requests\Device\CreatePatientTestimonyAPIRequest;
use App\Http\Requests\Device\UpdatePatientTestimonyAPIRequest;
use App\Http\Resources\Device\PatientTestimonyCollection;
use App\Http\Resources\Device\PatientTestimonyResource;
use App\Repositories\PatientTestimonyRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class PatientTestimonyController extends AppBaseController
{
    use IsViewModule;

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
        $this->module = "module/patient-testimonials";
    }

    /**
     * PatientTestimony's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $testimonials = $this->patientTestimonyRepository->fetch($request);

        return $this->module_view('list', compact('testimonials'));
    }

    public function create()
    {
        return $this->module_view('add');
    }

    public function store(CreatePatientTestimonyAPIRequest $request)
    {
        $input = $request->all();
        $patientTestimony = $this->patientTestimonyRepository->create($input);

    }

    /**
     * Get single PatientTestimony record.
     *
     * @param int $id
     *
     * @return PatientTestimonyResource
     */
    public function show(int $id)
    {
        $patientTestimony = $this->patientTestimonyRepository->findOrFail($id);

    }

    /**
     * Update PatientTestimony with given payload.
     *
     * @param UpdatePatientTestimonyAPIRequest $request
     * @param int $id
     *
     * @return PatientTestimonyResource
     * @throws ValidatorException
     *
     */
    public function update(UpdatePatientTestimonyAPIRequest $request, int $id)
    {
        $input = $request->all();
        $patientTestimony = $this->patientTestimonyRepository->update($input, $id);

    }

    /**
     * Delete given PatientTestimony.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     *
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
     * @return PatientTestimonyCollection
     * @throws ValidatorException
     *
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
     * @return PatientTestimonyCollection
     * @throws ValidatorException
     *
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
