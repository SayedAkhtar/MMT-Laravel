<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin\BulkCreateDoctorAPIRequest;
use App\Http\Requests\Admin\BulkUpdateDoctorAPIRequest;
use App\Http\Requests\Admin\CreateDoctorAPIRequest;
use App\Http\Requests\Admin\UpdateDoctorAPIRequest;
use App\Http\Resources\Admin\DoctorCollection;
use App\Http\Resources\Admin\DoctorResource;
use App\Repositories\DoctorRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class DoctorController extends AppBaseController
{
    /**
     * @var DoctorRepository
     */
    private DoctorRepository $doctorRepository;

    /**
     * @param DoctorRepository $doctorRepository
     */
    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    /**
     * Doctor's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return DoctorCollection
     */
    public function index(Request $request): DoctorCollection
    {
        $doctors = $this->doctorRepository->fetch($request);

        return new DoctorCollection($doctors);
    }

    /**
     * Create Doctor with given payload.
     *
     * @param CreateDoctorAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorResource
     */
    public function store(CreateDoctorAPIRequest $request): DoctorResource
    {
        $input = $request->all();
        $doctor = $this->doctorRepository->create($input);

        return new DoctorResource($doctor);
    }

    /**
     * Get single Doctor record.
     *
     * @param int $id
     *
     * @return DoctorResource
     */
    public function show(int $id): DoctorResource
    {
        $doctor = $this->doctorRepository->findOrFail($id);

        return new DoctorResource($doctor);
    }

    /**
     * Update Doctor with given payload.
     *
     * @param UpdateDoctorAPIRequest $request
     * @param int                    $id
     *
     * @throws ValidatorException
     *
     * @return DoctorResource
     */
    public function update(UpdateDoctorAPIRequest $request, int $id): DoctorResource
    {
        $input = $request->all();
        $doctor = $this->doctorRepository->update($input, $id);

        return new DoctorResource($doctor);
    }

    /**
     * Delete given Doctor.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->doctorRepository->delete($id);

        return $this->successResponse('Doctor deleted successfully.');
    }

    /**
     * Bulk create Doctor's.
     *
     * @param BulkCreateDoctorAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorCollection
     */
    public function bulkStore(BulkCreateDoctorAPIRequest $request): DoctorCollection
    {
        $doctors = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorInput) {
            $doctors[$key] = $this->doctorRepository->create($doctorInput);
        }

        return new DoctorCollection($doctors);
    }

    /**
     * Bulk update Doctor's data.
     *
     * @param BulkUpdateDoctorAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorCollection
     */
    public function bulkUpdate(BulkUpdateDoctorAPIRequest $request): DoctorCollection
    {
        $doctors = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorInput) {
            $doctors[$key] = $this->doctorRepository->update($doctorInput, $doctorInput['id']);
        }

        return new DoctorCollection($doctors);
    }
}
