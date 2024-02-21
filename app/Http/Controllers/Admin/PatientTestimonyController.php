<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreatePatientTestimonyAPIRequest;
use App\Http\Requests\Device\BulkUpdatePatientTestimonyAPIRequest;
use App\Http\Requests\Device\CreatePatientTestimonyAPIRequest;
use App\Http\Requests\Device\UpdatePatientTestimonyAPIRequest;
use App\Http\Resources\Device\PatientTestimonyCollection;
use App\Http\Resources\Device\PatientTestimonyResource;
use App\Models\PatientTestimony;
use App\Repositories\PatientTestimonyRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class PatientTestimonyController extends AppBaseController
{
    use IsViewModule;

    /**
     * @var PatientTestimonyRepository
     */
    private PatientTestimonyRepository $patientTestimonyRepository;

    /**
     * @param PatientTestimonyRepository $patientTestimonyRepository
     */
    public function __construct(PatientTestimonyRepository $patientTestimonyRepository)
    {
        $this->patientTestimonyRepository = $patientTestimonyRepository;
        $this->module = "module/patient-testimonials";
    }

    /**
     * PatientTestimony's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $testimonials = $this->patientTestimonyRepository->fetch($request);

        return $this->module_view('list', compact('testimonials'));
    }

    public function create()
    {
        return $this->module_view('add');
    }

    public function store(CreatePatientTestimonyAPIRequest $request)
    {
        $input = $request->all();
        $includedImages = explode(',', $input['photo_names']);
        $paths = [];
        $videos = array_filter( $input['videos'], function ($value) {
            // Filter out empty strings and null values
            return !empty($value) || $value === 0 || $value === '0';
        });
        foreach ($request->file('images') as $file) {
            if (in_array($file->getClientOriginalName(), $includedImages)) {
                $paths[] = $file->store('public/patient_testimony');
            }
        }
        $testimony = PatientTestimony::create([
            'patient_id' => $input['patient_id'] ?? 0,
            'images' => implode(',', $paths),
            'doctor_id' => $input['doctor_id'],
            'hospital_id' => $input['hospital_id'],
            'videos' => $videos ?? null,
            'description' => $input['description'] ?? ""
        ]);
        return redirect(route('patient-testimonies.index'))->with('success', 'Patient Testimony Images Updated');
    }

    /**
     * Get single PatientTestimony record.
     *
     * @param int $id
     *
     * @return PatientTestimonyResource
     */
    public function show(int $id)
    {
        $testimony = $this->patientTestimonyRepository->findOrFail($id);
//        dd($testimony->doctor);
        return $this->module_view('edit', compact('testimony'));
    }

    /**
     * Update PatientTestimony with given payload.
     *
     * @param UpdatePatientTestimonyAPIRequest $request
     * @param int $id
     * @throws ValidatorException
     *
     */
    public function update(UpdatePatientTestimonyAPIRequest $request, int $id)
    {
        $input = $request->all();
        $input['patient_id'] = $input['patient_id'] ?? 0;
        $includedImages = explode(',', $input['photo_names']);
        $paths = [];
        $videos = array_filter( $input['videos'], function ($value) {
            // Filter out empty strings and null values
            return !empty($value) || $value === 0 || $value === '0';
        });
        try {
            if ($request->has('images')) {
                foreach ($request->file('images') as $file) {
                    if (in_array($file->getClientOriginalName(), $includedImages)) {
                        if (($key = array_search($file->getClientOriginalName(), $includedImages)) !== false) {
                            unset($includedImages[$key]);
                        }
                        $paths[] = $file->store('public/patient_testimony');
                    }

                }
            }
            $input['images'] = implode(',', array_unique(array_merge($includedImages, $paths)));
            $input['videos'] = $videos;
            $patientTestimony = $this->patientTestimonyRepository->update($input, $id);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return back()->with('success', "Testimony updated");

    }

    /**
     * Delete given PatientTestimony.
     *
     * @param int $id
     * @throws Exception
     *
     */
    public function destroy(int $id)
    {
        try {
            $this->patientTestimonyRepository->delete($id);
            return back()->with('success', "Successfully deleted");
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }

    }

    /**
     * Bulk create PatientTestimony's.
     *
     * @param BulkCreatePatientTestimonyAPIRequest $request
     *
     * @return PatientTestimonyCollection
     * @throws ValidatorException
     *
     */
    public function bulkStore(BulkCreatePatientTestimonyAPIRequest $request): PatientTestimonyCollection
    {
        $patientTestimonies = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientTestimonyInput) {
            $patientTestimonies[$key] = $this->patientTestimonyRepository->create($patientTestimonyInput);
        }

        return new PatientTestimonyCollection($patientTestimonies);
    }

    /**
     * Bulk update PatientTestimony's data.
     *
     * @param BulkUpdatePatientTestimonyAPIRequest $request
     *
     * @return PatientTestimonyCollection
     * @throws ValidatorException
     *
     */
    public function bulkUpdate(BulkUpdatePatientTestimonyAPIRequest $request): PatientTestimonyCollection
    {
        $patientTestimonies = collect();

        $input = $request->get('data');
        foreach ($input as $key => $patientTestimonyInput) {
            $patientTestimonies[$key] = $this->patientTestimonyRepository->update($patientTestimonyInput, $patientTestimonyInput['id']);
        }

        return new PatientTestimonyCollection($patientTestimonies);
    }
}
