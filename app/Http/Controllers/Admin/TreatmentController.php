<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateTreatmentAPIRequest;
use App\Http\Requests\Device\UpdateTreatmentAPIRequest;
use App\Repositories\TreatmentRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class TreatmentController extends AppBaseController
{
    use IsViewModule;

    protected $module;
    /**
     * @var TreatmentRepository
     */
    private TreatmentRepository $treatmentRepository;

    /**
     * @param TreatmentRepository $treatmentRepository
     */
    public function __construct(TreatmentRepository $treatmentRepository)
    {
        $this->treatmentRepository = $treatmentRepository;
        $this->module = 'module/treatment';
    }

    public function index(Request $request)
    {
        $treatments = $this->treatmentRepository->fetch($request);
        return $this->module_view('list', compact('treatments'));
    }

    public function create()
    {
        return $this->module_view('add');
    }

    /**
     * Create Treatment with given payload.
     *
     * @param CreateTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     */
    public function store(CreateTreatmentAPIRequest $request)
    {
        $input = $request->all();
        $treatment = $this->treatmentRepository->create($input);
        if ($request->hasFile('images')) {
            $treatment->addMultipleMediaFromRequest(['images'])->each(fn($fileAdder) => $fileAdder->toMediaCollection('treatment'));
        }
        if ($request->has('hospitals')) {
            $treatment->hospitals()->attach($request->get('hospitals'));
        }
        if ($request->has('doctors')) {
            $treatment->doctors()->attach($request->get('doctors'));
        }
        if ($request->has('specializations')) {
            $treatment->doctors()->attach($request->get('specializations'));
        }
        return back()->with('success', "Treatment added successfully");
    }

    /**
     * Get single Treatment record.
     *
     * @param int $id
     *
     */
    public function show(int $id)
    {
        $treatment = $this->treatmentRepository->findOrFail($id);
        foreach ($treatment->doctors as &$data) {
            $data->name = $data->user->name;
        }
        $treatment->images = $treatment->getFirstMediaUrl('treatment-logo');
        return $this->module_view('edit', compact('treatment'));
    }

    /**
     * Update Treatment with given payload.
     *
     * @param UpdateTreatmentAPIRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidatorException
     *
     */
    public function update(UpdateTreatmentAPIRequest $request, int $id)
    {
        $input = $request->all();
        $treatment = $this->treatmentRepository->update($input, $id);
        if ($request->hasFile('images')) {
            $result = $treatment->updateImage('images', 'treatment-logo', false);
        }

        if ($request->has('hospitals')) {
            $treatment->hospitals()->sync($request->get('hospitals'));
        }
        if ($request->has('doctors')) {
            $treatment->doctors()->sync($request->get('doctors'));
        }
        if ($request->has('specializations')) {
            $treatment->doctors()->sync($request->get('specializations'));
        }
        return back()->with('success', "Updated successfully");
    }

    /**
     * Delete given Treatment.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     *
     */
    public function delete(int $id): JsonResponse
    {
        $this->treatmentRepository->delete($id);

        return $this->successResponse('Treatment deleted successfully.');
    }

}
