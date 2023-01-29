<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateDoctorHospitalAPIRequest;
use App\Http\Requests\Client\BulkUpdateDoctorHospitalAPIRequest;
use App\Http\Requests\Client\CreateDoctorHospitalAPIRequest;
use App\Http\Requests\Client\UpdateDoctorHospitalAPIRequest;
use App\Http\Resources\Client\DoctorHospitalCollection;
use App\Http\Resources\Client\DoctorHospitalResource;
use App\Repositories\DoctorHospitalRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class DoctorHospitalController extends AppBaseController
{
    /**
     * @var DoctorHospitalRepository
     */
    private DoctorHospitalRepository $doctorHospitalRepository;

    /**
     * @param DoctorHospitalRepository $doctorHospitalRepository
     */
    public function __construct(DoctorHospitalRepository $doctorHospitalRepository)
    {
        $this->doctorHospitalRepository = $doctorHospitalRepository;
    }

    /**
     * DoctorHospital's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return DoctorHospitalCollection
     */
    public function index(Request $request): DoctorHospitalCollection
    {
        $doctorHospitals = $this->doctorHospitalRepository->fetch($request);

        return new DoctorHospitalCollection($doctorHospitals);
    }

    /**
     * Create DoctorHospital with given payload.
     *
     * @param CreateDoctorHospitalAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorHospitalResource
     */
    public function store(CreateDoctorHospitalAPIRequest $request): DoctorHospitalResource
    {
        $input = $request->all();
        $doctorHospital = $this->doctorHospitalRepository->create($input);

        return new DoctorHospitalResource($doctorHospital);
    }

    /**
     * Get single DoctorHospital record.
     *
     * @param int $id
     *
     * @return DoctorHospitalResource
     */
    public function show(int $id): DoctorHospitalResource
    {
        $doctorHospital = $this->doctorHospitalRepository->findOrFail($id);

        return new DoctorHospitalResource($doctorHospital);
    }

    /**
     * Update DoctorHospital with given payload.
     *
     * @param UpdateDoctorHospitalAPIRequest $request
     * @param int                            $id
     *
     * @throws ValidatorException
     *
     * @return DoctorHospitalResource
     */
    public function update(UpdateDoctorHospitalAPIRequest $request, int $id): DoctorHospitalResource
    {
        $input = $request->all();
        $doctorHospital = $this->doctorHospitalRepository->update($input, $id);

        return new DoctorHospitalResource($doctorHospital);
    }

    /**
     * Delete given DoctorHospital.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->doctorHospitalRepository->delete($id);

        return $this->successResponse('DoctorHospital deleted successfully.');
    }

    /**
     * Bulk create DoctorHospital's.
     *
     * @param BulkCreateDoctorHospitalAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorHospitalCollection
     */
    public function bulkStore(BulkCreateDoctorHospitalAPIRequest $request): DoctorHospitalCollection
    {
        $doctorHospitals = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorHospitalInput) {
            $doctorHospitals[$key] = $this->doctorHospitalRepository->create($doctorHospitalInput);
        }

        return new DoctorHospitalCollection($doctorHospitals);
    }

    /**
     * Bulk update DoctorHospital's data.
     *
     * @param BulkUpdateDoctorHospitalAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorHospitalCollection
     */
    public function bulkUpdate(BulkUpdateDoctorHospitalAPIRequest $request): DoctorHospitalCollection
    {
        $doctorHospitals = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorHospitalInput) {
            $doctorHospitals[$key] = $this->doctorHospitalRepository->update($doctorHospitalInput, $doctorHospitalInput['id']);
        }

        return new DoctorHospitalCollection($doctorHospitals);
    }
}
