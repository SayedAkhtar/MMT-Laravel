<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateSpecializationAPIRequest;
use App\Http\Requests\Device\BulkUpdateSpecializationAPIRequest;
use App\Http\Requests\Device\CreateSpecializationAPIRequest;
use App\Http\Requests\Device\UpdateSpecializationAPIRequest;
use App\Http\Resources\Device\SpecializationCollection;
use App\Repositories\SpecializationRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

class SpecializationController extends AppBaseController
{
    use IsViewModule;

    /**
     * @var SpecializationRepository
     */
    private SpecializationRepository $specializationRepository;

    /**
     * @param SpecializationRepository $specializationRepository
     */
    public function __construct(SpecializationRepository $specializationRepository)
    {
        $this->specializationRepository = $specializationRepository;
        $this->module = 'module/specialization';
    }

    /**
     * Specialization's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     */
    public function index(Request $request)
    {
        $specializations = $this->specializationRepository->fetch($request);
        return $this->module_view('list', compact('specializations'));
    }

    public function create()
    {
        return $this->module_view('add');
    }

    /**
     * Create Specialization with given payload.
     *
     * @param CreateSpecializationAPIRequest $request
     *
     * @return RedirectResponse
     * @throws ValidatorException
     *
     */
    public function store(CreateSpecializationAPIRequest $request): RedirectResponse
    {
        $input = $request->all();
        $specialization = $this->specializationRepository->create($input);
        if ($request->hasFile('logo')) {
            $specialization->attachImage('logo', 'logo', false);
        }
        return back()->with('success', 'Specialization Added');
    }

    /**
     * Get single Specialization record.
     *
     * @param int $id
     *
     * @return View
     */
    public function show(int $id): View
    {
        $specialization = $this->specializationRepository->findOrFail($id);
        return $this->module_view('edit', compact('specialization'));
    }

    /**
     * Update Specialization with given payload.
     *
     * @param UpdateSpecializationAPIRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     * @throws ValidatorException
     *
     */
    public function update(UpdateSpecializationAPIRequest $request, int $id): RedirectResponse
    {
        $input = $request->all();
        $specialization = $this->specializationRepository->update($input, $id);
        if ($request->hasFile('logo')) {
            $specialization->updateImage('logo', 'logo', false);
        }

        return back()->with('success', 'Specialization updated successfully');
    }

    /**
     * Delete given Specialization.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     *
     */
    public function delete(int $id): JsonResponse
    {
        $this->specializationRepository->delete($id);

        return $this->successResponse('Specialization deleted successfully.');
    }

    /**
     * Bulk create Specialization's.
     *
     * @param BulkCreateSpecializationAPIRequest $request
     *
     * @return SpecializationCollection
     * @throws ValidatorException
     *
     */
    public function bulkStore(BulkCreateSpecializationAPIRequest $request): SpecializationCollection
    {
        $specializations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $specializationInput) {
            $specializations[$key] = $this->specializationRepository->create($specializationInput);
        }

        return new SpecializationCollection($specializations);
    }

    /**
     * Bulk update Specialization's data.
     *
     * @param BulkUpdateSpecializationAPIRequest $request
     *
     * @return SpecializationCollection
     * @throws ValidatorException
     *
     */
    public function bulkUpdate(BulkUpdateSpecializationAPIRequest $request): SpecializationCollection
    {
        $specializations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $specializationInput) {
            $specializations[$key] = $this->specializationRepository->update($specializationInput, $specializationInput['id']);
        }

        return new SpecializationCollection($specializations);
    }
}
