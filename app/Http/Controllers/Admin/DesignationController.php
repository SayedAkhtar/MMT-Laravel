<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateDesignationAPIRequest;
use App\Http\Requests\Device\CreateDesignationAPIRequest;
use App\Http\Requests\Device\UpdateDesignationAPIRequest;
use App\Http\Resources\Device\DesignationCollection;
use App\Repositories\DesignationRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Prettus\Validator\Exceptions\ValidatorException;

class DesignationController extends AppBaseController
{
    use IsViewModule;

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
        $designation = $this->designationRepository->fetch($request);
        return $this->module_view('list', compact('designation'));
    }

    /**
     * Create Designation with given payload.
     *
     * @param CreateDesignationAPIRequest $request
     *
     * @return Redirect
     * @throws ValidatorException
     *
     */

    public function create(Request $request)
    {
        return $this->module_view('add');
    }

    public function store(CreateDesignationAPIRequest $request)
    {
        $input = $request->all();
        $designation = $this->designationRepository->create($input);
        if (empty($designation)) {
            return back()->with('error', "Something went wrong. Please try again");
        }
        return redirect(route('designations.index'))->with('success', "Designation successfully added");
    }

    /**
     * Get single Designation record.
     *
     * @param int $id
     *
     */
    public function show(int $id)
    {
        $designation = $this->designationRepository->findOrFail($id);
        return $this->module_view('add', compact('designation'));
    }

    /**
     * Update Designation with given payload.
     *
     * @param UpdateDesignationAPIRequest $request
     * @param int $id
     *
     * @return
     * @throws ValidatorException
     *
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
     * @return JsonResponse
     * @throws Exception
     *
     */
    public function destroy(int $id): JsonResponse
    {
        $this->designationRepository->delete($id);

        return $this->successResponse('Designation deleted successfully.');
    }

    /**
     * Bulk create Designation's.
     *
     * @param BulkCreateDesignationAPIRequest $request
     *
     * @return DesignationCollection
     * @throws ValidatorException
     *
     */
}
