<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateDoctorAPIRequest;
use App\Http\Requests\Device\BulkUpdateDoctorAPIRequest;
use App\Http\Requests\Device\CreateDoctorAPIRequest;
use App\Http\Requests\Device\CreateUserAPIRequest;
use App\Http\Requests\Device\UpdateDoctorAPIRequest;
use App\Http\Resources\Device\DoctorCollection;
use App\Http\Resources\Device\DoctorResource;
use App\Repositories\DoctorRepository;
use App\Traits\isViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

class DoctorController extends AppBaseController
{
    use isViewModule;
    protected $module;
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
        $this->module = 'module/doctor';
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
    public function index(Request $request)
    {
        $doctors = $this->doctorRepository->fetch($request);
        if($request->isXmlHttpRequest()){
            $data = new DoctorCollection($doctors);
            return $data;
        }
        return $this->module_view('list', compact('doctors'));
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
    public function store(Request $request)
    {
        if($request->isMethod('get')){
            return  view('module.doctor.add');
        }
        $rules = array_merge((new CreateUserAPIRequest)->rules(), (new CreateDoctorAPIRequest)->rules());
        $request->validate($rules);
        $input = $request->all();
        $doctor = $this->doctorRepository->create($input);
//        CreateDoctorAPIRequest
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
        return view($this->module.'/edit', compact('doctor'));
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