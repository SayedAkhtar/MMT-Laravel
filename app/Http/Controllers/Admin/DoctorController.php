<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateDoctorAPIRequest;
use App\Http\Requests\Device\UpdateDoctorAPIRequest;
use App\Http\Resources\Device\DoctorCollection;
use App\Http\Resources\Device\DoctorResource;
use App\Models\Doctor;
use App\Models\User;
use App\Repositories\DoctorRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        DB::beginTransaction();
        try {
            $user = User::create($input);
            if ($user) {
                $input['user_id'] = $user->id;
                $doctor = $this->doctorRepository->create($input);
                if (!empty($input['hospital_id'])) {
                    $result = $doctor->hospitals()->sync($input['hospital_id']);
                }
                DB::commit();
                return redirect(route('doctors.index'))->with('success', "Doctor created successfully");
            }
            throw new Exception("Not able to create doctor at this moment");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Get single Doctor record.
     *
     * @param int $id
     *
     */
    public function show(int $id)
    {
        $doctor = Doctor::with('hospitals', 'qualification', 'designation')->findOrFail($id);
        return $this->module_view('edit', compact('doctor'));
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
        DB::beginTransaction();
        try {
            $doctor = Doctor::findOrFail($id);
            $doctor->hospitals()->detach();
            $doctor->user()->delete();
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return $this->errorResponse("Something went wrong");
        }
        return $this->successResponse('Doctor deleted successfully.');
    }

}
