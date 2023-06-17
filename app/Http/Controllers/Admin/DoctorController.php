<?php

namespace App\Http\Controllers\Admin;

//use App\Constants\CountryCodes;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateDoctorAPIRequest;
use App\Http\Requests\Device\UpdateDoctorAPIRequest;
use App\Http\Resources\Device\DoctorCollection;
use App\Models\City;
use App\Models\Designation;
use App\Models\Doctor;
use App\Models\Qualification;
use App\Models\Specialization;
use App\Models\State;
use App\Models\User;
use App\Repositories\DoctorRepository;
use App\Traits\IsViewModule;
use Illiminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as FacadesValidator;
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
       
        $validator =  FacadesValidator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        $request->validate($rules);
        $input = $request->all();
        $input['user_type'] = User::TYPE_DOCTOR;
        // dd($input);
        DB::beginTransaction();
        
        $this->findOrCreate($input);
        try {
            $input['password'] = Hash::make('no-password');
            $user = User::create($input);
            if ($user) {
                $input['user_id'] = $user->id;
                $doctor = $this->doctorRepository->create($input);
                if (!empty($input['hospital_id'])) {
                    $result = $doctor->hospitals()->sync($input['hospital_id']);
                }
                if (!empty($input['specialization_id'])) {
                    $result = $doctor->specializations()->sync($input['specialization_id']);
                }
                if (!empty($input['designation_id'])) {
                    $result = $doctor->designations()->sync($input['designation_id']);
                }
                if (!empty($input['qualification_id'])) {
                    $result = $doctor->qualifications()->sync($input['qualification_id']);
                }
                if ($request->hasFile('image')) {
                    $doctor->updateImage('image', 'avatar', false);
                }
                DB::commit();
                return redirect(route('doctors.index'))->with('success', "Doctor created successfully");
            }
            throw new Exception("Not able to create doctor at this moment");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage(), $e->getCode(), $e, $e->getLine());
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
        $doctor = Doctor::with('hospitals', 'qualification', 'designation', 'user')->findOrFail($id);
        return $this->module_view('edit', compact('doctor'));
    }

    /**
     * Update Doctor with given payload.
     *
     * @param UpdateDoctorAPIRequest $request
     * @param int $id
     *
     * @throws ValidatorException
     *
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'nullable | email',
            'phone' => 'nullable',
            'image' => ['nullable', 'file'],
            'start_of_service' => ['required'],
            'awards' => ['nullable'],
            'description' => ['nullable'],
            'designation_id.*' => ['required'],
            'qualification_id.*' => ['required'],
            'faq' => ['nullable'],
            'time_slots' => ['nullable', "string"],
            'is_active' => ['boolean'],
        ]);
        $input = $request->except('image');
        DB::beginTransaction();
        $this->findOrCreate($input);
        try {
            $doctor = $this->doctorRepository->update($input, $id);
            $doctor->user->update(['name' => $validated['name'], 'email' => $validated['email'], 'phone' => $validated['phone']]);
            if (!empty($input['hospital_id'])) {
                $result = $doctor->hospitals()->sync($input['hospital_id']);
            }
            if (!empty($input['specialization_id'])) {
                $result = $doctor->specializations()->sync($input['specialization_id']);
            }
            if (!empty($input['designation_id'])) {
                $result = $doctor->designations()->sync($input['designation_id']);
            }
            if (!empty($input['qualification_id'])) {
                $result = $doctor->qualifications()->sync($input['qualification_id']);
            }
            if ($request->hasFile('image')) {
                $doctor->updateImage('image', 'avatar', false);
            }
            DB::commit();
            return back()->with('success', "Doctor updated successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
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
            $doctor->specializations()->detach();
            $doctor->user()->delete();
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return $this->errorResponse("Something went wrong");
        }
        return $this->successResponse('Doctor deleted successfully.');
    }

    private function findOrCreate(&$input){
        if(!empty($input['state_id']) && intval($input['state_id']) == 0){
            $data = State::create(['name' => $input['state_id'], 'country_id' => $input['country_id']]);
            $input['state_id'] = $data->id; 
        }
        if(!empty($input['city_id']) && intval($input['city_id']) == 0){
            $data = City::create(['name' => $input['city_id'], 
                                    'country_id' => $input['country_id'], 
                                    'state_id' => $input['state_id']]);
            $input['city_id'] = $data->id; 
        }
        foreach($input['designation_id'] as $key => $designation){
            if(intval($designation) == 0){
                $data = Designation::create(['name' => $designation]);
                $input['designation_id'][$key] = $data->id; 
            }
        }
        foreach($input['qualification_id'] as $key => $qualification){
            if(intval($qualification) == 0){
                $data = Qualification::create(['name' => $qualification]);
                $input['qualification_id'][$key] = $data->id; 
            }
        }
        foreach($input['specialization_id'] as $key => $specialization){
            if(intval($specialization) == 0){
                $data = Specialization::create(['name' => $specialization]);
                $input['specialization_id'][$key] = $data->id; 
            }
        }
        return $input;
    }

}
