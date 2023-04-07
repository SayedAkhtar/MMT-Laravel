<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateDoctorAPIRequest;
use App\Http\Requests\Device\BulkUpdateDoctorAPIRequest;
use App\Http\Requests\Device\CreateDoctorAPIRequest;
use App\Http\Requests\Device\UpdateDoctorAPIRequest;
use App\Http\Resources\Device\DoctorCollection;
use App\Http\Resources\Device\DoctorResource;
use App\Models\User;
use App\Repositories\DoctorRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class DoctorController extends AppBaseController
{
    use IsViewModule;

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

    public function index(Request $request)
    {
        $doctors = $this->doctorRepository->fetch($request);
        if ($request->isXmlHttpRequest()) {
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
     * @return DoctorResource
     * @throws ValidatorException
     *
     */
    public function store(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('module.doctor.add');
        }
        $rules = (new CreateDoctorAPIRequest)->rules();
        $request->validate($rules);
        $input = $request->all();
        $input['user_type'] = User::TYPE_DOCTOR;
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
        return view($this->module . '/edit', compact('doctor'));
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
