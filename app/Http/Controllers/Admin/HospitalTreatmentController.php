<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateHospitalTreatmentAPIRequest;
use App\Http\Requests\Device\BulkUpdateHospitalTreatmentAPIRequest;
use App\Http\Requests\Device\CreateHospitalTreatmentAPIRequest;
use App\Http\Requests\Device\UpdateHospitalTreatmentAPIRequest;
use App\Http\Resources\Device\HospitalTreatmentCollection;
use App\Http\Resources\Device\HospitalTreatmentResource;
use App\Repositories\HospitalTreatmentRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class HospitalTreatmentController extends AppBaseController
{
    /**
     * @var HospitalTreatmentRepository
     */
    private HospitalTreatmentRepository $hospitalTreatmentRepository;

    /**
     * @param HospitalTreatmentRepository $hospitalTreatmentRepository
     */
    public function __construct(HospitalTreatmentRepository $hospitalTreatmentRepository)
    {
        $this->hospitalTreatmentRepository = $hospitalTreatmentRepository;
    }

    /**
     * HospitalTreatment's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return HospitalTreatmentCollection
     */
    public function index(Request $request): HospitalTreatmentCollection
    {
        $hospitalTreatments = $this->hospitalTreatmentRepository->fetch($request);

        return new HospitalTreatmentCollection($hospitalTreatments);
    }

    /**
     * Create HospitalTreatment with given payload.
     *
     * @param CreateHospitalTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return HospitalTreatmentResource
     */
    public function store(CreateHospitalTreatmentAPIRequest $request): HospitalTreatmentResource
    {
        $input = $request->all();
        $hospitalTreatment = $this->hospitalTreatmentRepository->create($input);

        return new HospitalTreatmentResource($hospitalTreatment);
    }

    /**
     * Get single HospitalTreatment record.
     *
     * @param int $id
     *
     * @return HospitalTreatmentResource
     */
    public function show(int $id): HospitalTreatmentResource
    {
        $hospitalTreatment = $this->hospitalTreatmentRepository->findOrFail($id);

        return new HospitalTreatmentResource($hospitalTreatment);
    }

    /**
     * Update HospitalTreatment with given payload.
     *
     * @param UpdateHospitalTreatmentAPIRequest $request
     * @param int                               $id
     *
     * @throws ValidatorException
     *
     * @return HospitalTreatmentResource
     */
    public function update(UpdateHospitalTreatmentAPIRequest $request, int $id): HospitalTreatmentResource
    {
        $input = $request->all();
        $hospitalTreatment = $this->hospitalTreatmentRepository->update($input, $id);

        return new HospitalTreatmentResource($hospitalTreatment);
    }

    /**
     * Delete given HospitalTreatment.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->hospitalTreatmentRepository->delete($id);

        return $this->successResponse('HospitalTreatment deleted successfully.');
    }

    /**
     * Bulk create HospitalTreatment's.
     *
     * @param BulkCreateHospitalTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return HospitalTreatmentCollection
     */
    public function bulkStore(BulkCreateHospitalTreatmentAPIRequest $request): HospitalTreatmentCollection
    {
        $hospitalTreatments = collect();

        $input = $request->get('data');
        foreach ($input as $key => $hospitalTreatmentInput) {
            $hospitalTreatments[$key] = $this->hospitalTreatmentRepository->create($hospitalTreatmentInput);
        }

        return new HospitalTreatmentCollection($hospitalTreatments);
    }

    /**
     * Bulk update HospitalTreatment's data.
     *
     * @param BulkUpdateHospitalTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return HospitalTreatmentCollection
     */
    public function bulkUpdate(BulkUpdateHospitalTreatmentAPIRequest $request): HospitalTreatmentCollection
    {
        $hospitalTreatments = collect();

        $input = $request->get('data');
        foreach ($input as $key => $hospitalTreatmentInput) {
            $hospitalTreatments[$key] = $this->hospitalTreatmentRepository->update($hospitalTreatmentInput, $hospitalTreatmentInput['id']);
        }

        return new HospitalTreatmentCollection($hospitalTreatments);
    }
}