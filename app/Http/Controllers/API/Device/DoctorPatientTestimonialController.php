<?php

namespace App\Http\Controllers\API\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateDoctorPatientTestimonialAPIRequest;
use App\Http\Requests\Device\BulkUpdateDoctorPatientTestimonialAPIRequest;
use App\Http\Requests\Device\CreateDoctorPatientTestimonialAPIRequest;
use App\Http\Requests\Device\UpdateDoctorPatientTestimonialAPIRequest;
use App\Http\Resources\Device\DoctorPatientTestimonialCollection;
use App\Http\Resources\Device\DoctorPatientTestimonialResource;
use App\Repositories\DoctorPatientTestimonialRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class DoctorPatientTestimonialController extends AppBaseController
{
    /**
     * @var DoctorPatientTestimonialRepository
     */
    private DoctorPatientTestimonialRepository $doctorPatientTestimonialRepository;

    /**
     * @param DoctorPatientTestimonialRepository $doctorPatientTestimonialRepository
     */
    public function __construct(DoctorPatientTestimonialRepository $doctorPatientTestimonialRepository)
    {
        $this->doctorPatientTestimonialRepository = $doctorPatientTestimonialRepository;
    }

    /**
     * DoctorPatientTestimonial's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return DoctorPatientTestimonialCollection
     */
    public function index(Request $request): DoctorPatientTestimonialCollection
    {
        $doctorPatientTestimonials = $this->doctorPatientTestimonialRepository->fetch($request);

        return new DoctorPatientTestimonialCollection($doctorPatientTestimonials);
    }

    /**
     * Create DoctorPatientTestimonial with given payload.
     *
     * @param CreateDoctorPatientTestimonialAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorPatientTestimonialResource
     */
    public function store(CreateDoctorPatientTestimonialAPIRequest $request): DoctorPatientTestimonialResource
    {
        $input = $request->all();
        $doctorPatientTestimonial = $this->doctorPatientTestimonialRepository->create($input);

        return new DoctorPatientTestimonialResource($doctorPatientTestimonial);
    }

    /**
     * Get single DoctorPatientTestimonial record.
     *
     * @param int $id
     *
     * @return DoctorPatientTestimonialResource
     */
    public function show(int $id): DoctorPatientTestimonialResource
    {
        $doctorPatientTestimonial = $this->doctorPatientTestimonialRepository->findOrFail($id);

        return new DoctorPatientTestimonialResource($doctorPatientTestimonial);
    }

    /**
     * Update DoctorPatientTestimonial with given payload.
     *
     * @param UpdateDoctorPatientTestimonialAPIRequest $request
     * @param int                                      $id
     *
     * @throws ValidatorException
     *
     * @return DoctorPatientTestimonialResource
     */
    public function update(UpdateDoctorPatientTestimonialAPIRequest $request, int $id): DoctorPatientTestimonialResource
    {
        $input = $request->all();
        $doctorPatientTestimonial = $this->doctorPatientTestimonialRepository->update($input, $id);

        return new DoctorPatientTestimonialResource($doctorPatientTestimonial);
    }

    /**
     * Delete given DoctorPatientTestimonial.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->doctorPatientTestimonialRepository->delete($id);

        return $this->successResponse('DoctorPatientTestimonial deleted successfully.');
    }

    /**
     * Bulk create DoctorPatientTestimonial's.
     *
     * @param BulkCreateDoctorPatientTestimonialAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorPatientTestimonialCollection
     */
    public function bulkStore(BulkCreateDoctorPatientTestimonialAPIRequest $request): DoctorPatientTestimonialCollection
    {
        $doctorPatientTestimonials = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorPatientTestimonialInput) {
            $doctorPatientTestimonials[$key] = $this->doctorPatientTestimonialRepository->create($doctorPatientTestimonialInput);
        }

        return new DoctorPatientTestimonialCollection($doctorPatientTestimonials);
    }

    /**
     * Bulk update DoctorPatientTestimonial's data.
     *
     * @param BulkUpdateDoctorPatientTestimonialAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorPatientTestimonialCollection
     */
    public function bulkUpdate(BulkUpdateDoctorPatientTestimonialAPIRequest $request): DoctorPatientTestimonialCollection
    {
        $doctorPatientTestimonials = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorPatientTestimonialInput) {
            $doctorPatientTestimonials[$key] = $this->doctorPatientTestimonialRepository->update($doctorPatientTestimonialInput, $doctorPatientTestimonialInput['id']);
        }

        return new DoctorPatientTestimonialCollection($doctorPatientTestimonials);
    }
}
