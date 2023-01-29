<?php

namespace App\Http\Controllers\API\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateDoctorSpecializationAPIRequest;
use App\Http\Requests\Device\BulkUpdateDoctorSpecializationAPIRequest;
use App\Http\Requests\Device\CreateDoctorSpecializationAPIRequest;
use App\Http\Requests\Device\UpdateDoctorSpecializationAPIRequest;
use App\Http\Resources\Device\DoctorSpecializationCollection;
use App\Http\Resources\Device\DoctorSpecializationResource;
use App\Repositories\DoctorSpecializationRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class DoctorSpecializationController extends AppBaseController
{
    /**
     * @var DoctorSpecializationRepository
     */
    private DoctorSpecializationRepository $doctorSpecializationRepository;

    /**
     * @param DoctorSpecializationRepository $doctorSpecializationRepository
     */
    public function __construct(DoctorSpecializationRepository $doctorSpecializationRepository)
    {
        $this->doctorSpecializationRepository = $doctorSpecializationRepository;
    }

    /**
     * DoctorSpecialization's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return DoctorSpecializationCollection
     */
    public function index(Request $request): DoctorSpecializationCollection
    {
        $doctorSpecializations = $this->doctorSpecializationRepository->fetch($request);

        return new DoctorSpecializationCollection($doctorSpecializations);
    }

    /**
     * Create DoctorSpecialization with given payload.
     *
     * @param CreateDoctorSpecializationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorSpecializationResource
     */
    public function store(CreateDoctorSpecializationAPIRequest $request): DoctorSpecializationResource
    {
        $input = $request->all();
        $doctorSpecialization = $this->doctorSpecializationRepository->create($input);

        return new DoctorSpecializationResource($doctorSpecialization);
    }

    /**
     * Get single DoctorSpecialization record.
     *
     * @param int $id
     *
     * @return DoctorSpecializationResource
     */
    public function show(int $id): DoctorSpecializationResource
    {
        $doctorSpecialization = $this->doctorSpecializationRepository->findOrFail($id);

        return new DoctorSpecializationResource($doctorSpecialization);
    }

    /**
     * Update DoctorSpecialization with given payload.
     *
     * @param UpdateDoctorSpecializationAPIRequest $request
     * @param int                                  $id
     *
     * @throws ValidatorException
     *
     * @return DoctorSpecializationResource
     */
    public function update(UpdateDoctorSpecializationAPIRequest $request, int $id): DoctorSpecializationResource
    {
        $input = $request->all();
        $doctorSpecialization = $this->doctorSpecializationRepository->update($input, $id);

        return new DoctorSpecializationResource($doctorSpecialization);
    }

    /**
     * Delete given DoctorSpecialization.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->doctorSpecializationRepository->delete($id);

        return $this->successResponse('DoctorSpecialization deleted successfully.');
    }

    /**
     * Bulk create DoctorSpecialization's.
     *
     * @param BulkCreateDoctorSpecializationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorSpecializationCollection
     */
    public function bulkStore(BulkCreateDoctorSpecializationAPIRequest $request): DoctorSpecializationCollection
    {
        $doctorSpecializations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorSpecializationInput) {
            $doctorSpecializations[$key] = $this->doctorSpecializationRepository->create($doctorSpecializationInput);
        }

        return new DoctorSpecializationCollection($doctorSpecializations);
    }

    /**
     * Bulk update DoctorSpecialization's data.
     *
     * @param BulkUpdateDoctorSpecializationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorSpecializationCollection
     */
    public function bulkUpdate(BulkUpdateDoctorSpecializationAPIRequest $request): DoctorSpecializationCollection
    {
        $doctorSpecializations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorSpecializationInput) {
            $doctorSpecializations[$key] = $this->doctorSpecializationRepository->update($doctorSpecializationInput, $doctorSpecializationInput['id']);
        }

        return new DoctorSpecializationCollection($doctorSpecializations);
    }
}
