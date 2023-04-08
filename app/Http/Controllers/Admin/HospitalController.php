<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateHospitalAPIRequest;
use App\Http\Requests\Device\UpdateHospitalAPIRequest;
use App\Http\Resources\Device\HospitalCollection;
use App\Models\Hospital;
use App\Models\User;
use App\Repositories\AccreditationRepository;
use App\Repositories\HospitalRepository;
use App\Repositories\TreatmentRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
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
        $hospitals = $this->hospitalRepository->fetch($request);
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
        try {
            $hospital = $this->hospitalRepository->create($input);
            if ($request->hasFile('logo')) {
                $hospital->attachImage('logo', 'logo', false);
            }
            if ($input['doctors']) {
                $result = $hospital->doctors()->attach($input['doctors']);
            }
            if ($input['treatments']) {
                $result = $hospital->treatments()->attach($input['treatments']);
            }
            if ($input['accreditations']) {
                $result = $hospital->treatments()->attach($input['accreditations']);
            }
        } catch (\Exception $e) {
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
        $input = $request->all();
//        dd($input);
        DB::beginTransaction();
        try {
            $hospital = Hospital::findOrFail($id);
            if ($request->hasFile('logo')) {
                $hospital->attachImage('logo', 'logo', false);
            }
            if (!empty($input['doctors'])) {
                $result = $hospital->doctors()->sync($input['doctors']);
            } else {
                $hospital->doctors()->sync([]);
            }
            if (!empty($input['treatments'])) {
                $result = $hospital->treatments()->sync($input['treatments']);
            } else {
                $result = $hospital->treatments()->sync([]);
            }
            if (!empty($input['accreditations'])) {
                $result = $hospital->accreditation()->sync($input['accreditations']);
            } else {
                $result = $hospital->accreditation()->sync([]);
            }
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
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     *
     */
    public function destroy(int $id): JsonResponse
    {
        $this->hospitalRepository->delete($id);

        return $this->successResponse('Hospital deleted successfully.');
    }

}
