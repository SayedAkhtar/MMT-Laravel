<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateHospitalAPIRequest;
use App\Http\Requests\Device\UpdateHospitalAPIRequest;
use App\Http\Resources\Device\HospitalCollection;
use App\Models\Accreditation;
use App\Models\Hospital;
use App\Models\User;
use App\Repositories\AccreditationRepository;
use App\Repositories\HospitalRepository;
use App\Repositories\TreatmentRepository;
use App\Traits\IsViewModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

class HospitalController extends AppBaseController
{
    use IsViewModule;

    protected $module;
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
        $this->module = 'module/hospital';
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
    public function index(Request $request): View
    {
        $hospitals = Hospital::query()->where('is_active', true)->get();
        return $this->module_view('list', compact('hospitals'));
    }

    public function create(Request $request)
    {
        $accreditations = app(AccreditationRepository::class)->fetch($request);
        $doctors = User::query()->whereHas('doctor')->get();
        $treatments = app(TreatmentRepository::class)->fetch($request);
        return $this->module_view('add', compact('accreditations', 'doctors', 'treatments'));
    }

    /**
     * Create Hospital with given payload.
     *
     * @param CreateHospitalAPIRequest $request
     *
     * @throws ValidatorException
     *
     */
    public function store(CreateHospitalAPIRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            $hospital = $this->hospitalRepository->create($input);
            $accreditation_id = [];
            if (!empty($input['accreditations'])) {
                foreach ($input['accreditations'] as $data) {
                    if (intval($data) != 0) {
                        $accreditation_id[] = intval($data);
                    } else {
                        $model = Accreditation::create(['name' => $data]);
                        $accreditation_id[] = $model->id;
                    }
                }
            }
            if ($request->hasFile('logo')) {
                $hospital->attachImage('logo', 'logo', false);
            }
            if (!empty($input['doctors']) && $input['doctors']) {
                $result = $hospital->doctors()->attach($input['doctors']);
            }
            if (!empty($input['treatments']) && $input['treatments']) {
                $result = $hospital->treatments()->attach($input['treatments']);
            }
            if (!empty($accreditation_id) && $accreditation_id) {
                $result = $hospital->accreditation()->attach($accreditation_id);
            }
            $hospital->countries()->sync($input['country_id'] ?? []);
            $hospital->states()->sync($input['state_id'] ?? []);
            $hospital->cities()->sync($input['city_id'] ?? []);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
        return redirect(route('hospitals.index'))->with('success', "Hospital added successfully");
    }

    /**
     * Get single Hospital record.
     *
     * @param int $id
     *
     */
    public function show(int $id)
    {
        $hospital = $this->hospitalRepository->findOrFail($id);
        return $this->module_view('edit', compact('hospital'));
    }

    /**
     * Update Hospital with given payload.
     *
     * @param UpdateHospitalAPIRequest $request
     * @param int $id
     *
     * @throws ValidatorException
     *
     */
    public function update(UpdateHospitalAPIRequest $request, int $id)
    {
        $input = $request->except('logo');
        DB::beginTransaction();
        try {
            $hospital = Hospital::findOrFail($id);
            if ($request->hasFile('logo')) {
                $hospital->updateImage('logo', 'logo', false);
            }
            $accreditation_id = [];
            if (!empty($input['accreditations'])) {
                foreach ($input['accreditations'] as $data) {
                    if (intval($data) != 0) {
                        $accreditation_id[] = intval($data);
                    } else {
                        $model = Accreditation::create(['name' => $data]);
                        $accreditation_id[] = $model->id;
                    }
                }
            }
            $hospital->doctors()->sync($input['doctors'] ?? []);
            $hospital->treatments()->sync($input['treatments'] ?? []);
            $hospital->accreditation()->sync($accreditation_id);
            $hospital->countries()->sync($input['country_id'] ?? []);
            $hospital->states()->sync($input['state_id'] ?? []);
            $hospital->cities()->sync($input['city_id'] ?? []);
            $hospital = $this->hospitalRepository->update($input, $id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', "Hospital updated successfully");
    }

    /**
     * Delete given Hospital.
     */
    public function destroy(int $id)
    {
        try {
            $hospital = Hospital::findOrFail($id);
            $hospital->doctors()->detach();
            $hospital->tags()->detach();
            $hospital->accreditation()->detach();
            $hospital->treatments()->detach();
            $hospital->is_active = false;
            $hospital->save();
            return back()->with('success', 'Hospital deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

    }

}
