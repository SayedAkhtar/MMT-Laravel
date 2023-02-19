<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateDesignationAPIRequest;
use App\Http\Requests\Device\BulkUpdateDesignationAPIRequest;
use App\Http\Requests\Device\CreateDesignationAPIRequest;
use App\Http\Requests\Device\UpdateDesignationAPIRequest;
use App\Http\Resources\Device\DesignationCollection;
use App\Http\Resources\Device\DesignationResource;
use App\Repositories\DesignationRepository;
use App\Traits\isViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Livewire\Livewire;
use Prettus\Validator\Exceptions\ValidatorException;

class DesignationController extends AppBaseController
{
    use isViewModule;
    protected $module;
    /**
     * @var DesignationRepository
     */
    private DesignationRepository $designationRepository;

    /**
     * @param DesignationRepository $designationRepository
     */
    public function __construct(DesignationRepository $designationRepository)
    {
        $this->designationRepository = $designationRepository;
        $this->module = "module/doctor/designation";
    }

    /**
     * Designation's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return DesignationCollection
     */
    public function index(Request $request)
    {
        $designations = $this->designationRepository->fetch($request);
        return $this->module_view('list', compact('designations'));
    }

    /**
     * Create Designation with given payload.
     *
     * @param CreateDesignationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return Redirect
     */
    public function store(CreateDesignationAPIRequest $request)
    {
        $input = $request->all();
        $designation = $this->designationRepository->create($input);
        if(empty($designation)){
            return $this->errorResponse("Could not created designation", 404);
        }
        return back();
    }

    /**
     * Get single Designation record.
     *
     * @param int $id
     *
     * @return DesignationResource
     */
    public function show(int $id): DesignationResource
    {
        $designation = $this->designationRepository->findOrFail($id);

        return new DesignationResource($designation);
    }

    /**
     * Update Designation with given payload.
     *
     * @param UpdateDesignationAPIRequest $request
     * @param int                         $id
     *
     * @throws ValidatorException
     *
     * @return
     */
    public function update(UpdateDesignationAPIRequest $request, int $id)
    {
        $input = $request->validated();
        $designation = $this->designationRepository->update($input, $id);
        return redirect()->back()->with('success', "Updated designation with ID $id");
    }

    /**
     * Delete given Designation.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->designationRepository->delete($id);

        return $this->successResponse('Designation deleted successfully.');
    }

    /**
     * Bulk create Designation's.
     *
     * @param BulkCreateDesignationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DesignationCollection
     */
    public function bulkStore(BulkCreateDesignationAPIRequest $request): DesignationCollection
    {
        $designations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $designationInput) {
            $designations[$key] = $this->designationRepository->create($designationInput);
        }

        return new DesignationCollection($designations);
    }

    /**
     * Bulk update Designation's data.
     *
     * @param BulkUpdateDesignationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DesignationCollection
     */
    public function bulkUpdate(BulkUpdateDesignationAPIRequest $request): DesignationCollection
    {
        $designations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $designationInput) {
            $designations[$key] = $this->designationRepository->update($designationInput, $designationInput['id']);
        }

        return new DesignationCollection($designations);
    }
}