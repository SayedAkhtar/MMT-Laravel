<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateDoctorAPIRequest;
use App\Http\Requests\Client\BulkUpdateDoctorAPIRequest;
use App\Http\Requests\Client\CreateDoctorAPIRequest;
use App\Http\Requests\Client\UpdateDoctorAPIRequest;
use App\Http\Resources\Client\DoctorCollection;
use App\Http\Resources\Client\DoctorResource;
use App\Models\Doctor;
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
     */
    public function index(Request $request)
    {
        if ($request->has('hospital_id')) {
            $doctors = Doctor::with('hospitals', function ($q) use ($request) {
                $q->where('hospitals.id', $request->input('hospital_id'));
            })->get();
        } else if ($request->has('specialization_id')) {
            $doctors = Doctor::whereHas('specializations', function ($q) use ($request) {
                return $q->where('specializations.id', $request->input('specialization_id'));
            })->get();
        } else {
            $doctors = $this->doctorRepository->fetch($request);
        }
        if (!empty($doctors)) {
            return $this->successResponse((DoctorResource::collection($doctors))->resolve()) ;
        } else {
            return $this->errorResponse("No doctors found", 404);
        }
    }

    /**
     * Create Doctor with given payload.
     *
     * @param CreateDoctorAPIRequest $request
     *
     * @return DoctorResource
     * @throws ValidatorException
     *
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
    public function show(int $id)
    {
        $doctor = $this->doctorRepository->findOrFail($id);

        return $this->successResponse(DoctorResource::make($doctor)->resolve())  ;
    }

    /**
     * Update Doctor with given payload.
     *
     * @param UpdateDoctorAPIRequest $request
     * @param int $id
     *
     * @return DoctorResource
     * @throws ValidatorException
     *
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
     * @return JsonResponse
     * @throws Exception
     *
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
     * @return DoctorCollection
     * @throws ValidatorException
     *
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
     * @return DoctorCollection
     * @throws ValidatorException
     *
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
