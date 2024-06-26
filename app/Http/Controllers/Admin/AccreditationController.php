<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateAccreditationAPIRequest;
use App\Http\Requests\Device\UpdateAccreditationAPIRequest;
use App\Http\Resources\Device\AccreditationCollection;
use App\Http\Resources\Device\AccreditationResource;
use App\Repositories\AccreditationRepository;
use App\Traits\IsViewModule;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

class AccreditationController extends AppBaseController
{
    use IsViewModule;

    protected $module;
    /**
     * @var AccreditationRepository
     */
    private AccreditationRepository $accreditationRepository;

    /**
     * @param AccreditationRepository $accreditationRepository
     */
    public function __construct(AccreditationRepository $accreditationRepository)
    {
        $this->accreditationRepository = $accreditationRepository;
        $this->module = 'module/hospital/accreditation';
    }

    /**
     * Accreditation's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return AccreditationCollection
     */
    public function index(Request $request)
    {
        $accreditations = $this->accreditationRepository->fetch($request);
        return $this->module_view('list', compact('accreditations'));
    }

    public function create()
    {
        return $this->module_view('add');
    }

    public function store(CreateAccreditationAPIRequest $request)
    {
        $input = $request->except('logo');
        $accreditation = $this->accreditationRepository->create($input);
        if ($request->hasFile('logo')) {
            $accreditation->attachImage('logo', 'logo', false);
        }
        if ($accreditation) {
            return back()->with('success', "Data added successfully");
        } else {
            return back()->with('error', "Cannot add data");
        }
    }

    /**
     * Get single Accreditation record.
     *
     * @param int $id
     *
     * @return AccreditationResource
     */
    public function show(int $id): View
    {
        $accreditation = $this->accreditationRepository->findOrFail($id);
        return $this->module_view('edit', compact('accreditation'));
    }

    /**
     * Update Accreditation with given payload.
     *
     * @param UpdateAccreditationAPIRequest $request
     * @param int $id
     *
     * @throws ValidatorException
     *
     */
    public function update(UpdateAccreditationAPIRequest $request, int $id)
    {
        $input = $request->except('logo');
        $accreditation = $this->accreditationRepository->update($input, $id);
        if ($request->hasFile('logo')) {
            $accreditation->updateImage('logo', 'logo', false);
        }
        return back()->with('success', "Update successfully");
    }


    public function delete(int $id)
    {
        $this->accreditationRepository->delete($id);

        return back()->with('success', 'Accreditation deleted successfully.');
    }

}
