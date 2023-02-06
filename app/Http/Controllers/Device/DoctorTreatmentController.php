<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateDoctorTreatmentAPIRequest;
use App\Http\Requests\Device\BulkUpdateDoctorTreatmentAPIRequest;
use App\Http\Requests\Device\CreateDoctorTreatmentAPIRequest;
use App\Http\Requests\Device\UpdateDoctorTreatmentAPIRequest;
use App\Http\Resources\Device\DoctorTreatmentCollection;
use App\Http\Resources\Device\DoctorTreatmentResource;
use App\Repositories\DoctorTreatmentRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class DoctorTreatmentController extends AppBaseController
{
    /**
     * @var DoctorTreatmentRepository
     */
    private DoctorTreatmentRepository $doctorTreatmentRepository;

    /**
     * @param DoctorTreatmentRepository $doctorTreatmentRepository
     */
    public function __construct(DoctorTreatmentRepository $doctorTreatmentRepository)
    {
        $this->doctorTreatmentRepository = $doctorTreatmentRepository;
    }

    /**
     * DoctorTreatment's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return DoctorTreatmentCollection
     */
    public function index(Request $request): DoctorTreatmentCollection
    {
        $doctorTreatments = $this->doctorTreatmentRepository->fetch($request);

        return new DoctorTreatmentCollection($doctorTreatments);
    }

    /**
     * Create DoctorTreatment with given payload.
     *
     * @param CreateDoctorTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorTreatmentResource
     */
    public function store(CreateDoctorTreatmentAPIRequest $request): DoctorTreatmentResource
    {
        $input = $request->all();
        $doctorTreatment = $this->doctorTreatmentRepository->create($input);

        return new DoctorTreatmentResource($doctorTreatment);
    }

    /**
     * Get single DoctorTreatment record.
     *
     * @param int $id
     *
     * @return DoctorTreatmentResource
     */
    public function show(int $id): DoctorTreatmentResource
    {
        $doctorTreatment = $this->doctorTreatmentRepository->findOrFail($id);

        return new DoctorTreatmentResource($doctorTreatment);
    }

    /**
     * Update DoctorTreatment with given payload.
     *
     * @param UpdateDoctorTreatmentAPIRequest $request
     * @param int                             $id
     *
     * @throws ValidatorException
     *
     * @return DoctorTreatmentResource
     */
    public function update(UpdateDoctorTreatmentAPIRequest $request, int $id): DoctorTreatmentResource
    {
        $input = $request->all();
        $doctorTreatment = $this->doctorTreatmentRepository->update($input, $id);

        return new DoctorTreatmentResource($doctorTreatment);
    }

    /**
     * Delete given DoctorTreatment.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->doctorTreatmentRepository->delete($id);

        return $this->successResponse('DoctorTreatment deleted successfully.');
    }

    /**
     * Bulk create DoctorTreatment's.
     *
     * @param BulkCreateDoctorTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorTreatmentCollection
     */
    public function bulkStore(BulkCreateDoctorTreatmentAPIRequest $request): DoctorTreatmentCollection
    {
        $doctorTreatments = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorTreatmentInput) {
            $doctorTreatments[$key] = $this->doctorTreatmentRepository->create($doctorTreatmentInput);
        }

        return new DoctorTreatmentCollection($doctorTreatments);
    }

    /**
     * Bulk update DoctorTreatment's data.
     *
     * @param BulkUpdateDoctorTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorTreatmentCollection
     */
    public function bulkUpdate(BulkUpdateDoctorTreatmentAPIRequest $request): DoctorTreatmentCollection
    {
        $doctorTreatments = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorTreatmentInput) {
            $doctorTreatments[$key] = $this->doctorTreatmentRepository->update($doctorTreatmentInput, $doctorTreatmentInput['id']);
        }

        return new DoctorTreatmentCollection($doctorTreatments);
    }
}