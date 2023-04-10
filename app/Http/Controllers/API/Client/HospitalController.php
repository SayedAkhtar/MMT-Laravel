<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\CreateHospitalAPIRequest;
use App\Http\Requests\Client\UpdateHospitalAPIRequest;
use App\Http\Resources\Client\DoctorResource;
use App\Http\Resources\Client\HospitalCollection;
use App\Http\Resources\Client\HospitalResource;
use App\Models\Hospital;
use App\Repositories\HospitalRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class HospitalController extends AppBaseController
{
    /**
     * @var HospitalRepository
     */
    private HospitalRepository $hospitalRepository;

    /**
     * @param HospitalRepository $hospitalRepository
     */
    public function __construct(HospitalRepository $hospitalRepository)
    {
        $this->hospitalRepository = $hospitalRepository;
    }

    /**
     * Hospital's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return HospitalCollection
     */
    public function index(Request $request): HospitalCollection
    {
        $hospitals = $this->hospitalRepository->fetch($request);

        return new HospitalCollection($hospitals);
    }

    /**
     * Create Hospital with given payload.
     *
     * @param CreateHospitalAPIRequest $request
     *
     * @return HospitalResource
     * @throws ValidatorException
     *
     */
    public function store(CreateHospitalAPIRequest $request): HospitalResource
    {
        $input = $request->all();
        $hospital = $this->hospitalRepository->create($input);

        return new HospitalResource($hospital);
    }

    /**
     * Get single Hospital record.
     *
     * @param int $id
     *
     * @return HospitalResource
     */
    public function show(int $id): JsonResponse
    {
        $hospital = Hospital::findOrFail($id);

        return $this->successResponse(new HospitalResource($hospital));
    }

    /**
     * Update Hospital with given payload.
     *
     * @param UpdateHospitalAPIRequest $request
     * @param int $id
     *
     * @return HospitalResource
     * @throws ValidatorException
     *
     */
    public function update(UpdateHospitalAPIRequest $request, int $id): HospitalResource
    {
        $input = $request->all();
        $hospital = $this->hospitalRepository->update($input, $id);

        return new HospitalResource($hospital);
    }

    /**
     * Delete given Hospital.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     *
     */
    public function delete(int $id): JsonResponse
    {
        $this->hospitalRepository->delete($id);

        return $this->successResponse('Hospital deleted successfully.');
    }

    public function doctors($id)
    {
        $doctors = Hospital::find($id)->doctors;
        return $this->successResponse(DoctorResource::collection($doctors)->resolve());
    }
}
