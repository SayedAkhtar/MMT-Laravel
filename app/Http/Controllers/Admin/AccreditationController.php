<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateAccreditationAPIRequest;
use App\Http\Requests\Device\BulkUpdateAccreditationAPIRequest;
use App\Http\Requests\Device\CreateAccreditationAPIRequest;
use App\Http\Requests\Device\UpdateAccreditationAPIRequest;
use App\Http\Resources\Device\AccreditationCollection;
use App\Http\Resources\Device\AccreditationResource;
use App\Repositories\AccreditationRepository;
use App\Traits\isViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Prettus\Validator\Exceptions\ValidatorException;

class AccreditationController extends AppBaseController
{
    use isViewModule;
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

    /**
     * Create Accreditation with given payload.
     *
     * @param CreateAccreditationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccreditationResource
     */
    public function store(CreateAccreditationAPIRequest $request)
    {
        $input = $request->all();
        if($request->hasFile('logo') ){
            $fileName = time().'_'.Str::slug(($request->get('name'))).'.'.$request->file('logo')->getClientOriginalExtension();
            $filePath= $request->file('logo')->store('uploads');
            if($filePath){
                $input['logo'] = $filePath;
            }
        }
        $accreditation = $this->accreditationRepository->create($input);
        if($accreditation){
            return back()->with('success', "Data added successfully");
        }else{
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
    public function show(int $id): AccreditationResource
    {
        $accreditation = $this->accreditationRepository->findOrFail($id);

        return new AccreditationResource($accreditation);
    }

    /**
     * Update Accreditation with given payload.
     *
     * @param UpdateAccreditationAPIRequest $request
     * @param int                           $id
     *
     * @throws ValidatorException
     *
     * @return AccreditationResource
     */
    public function update(UpdateAccreditationAPIRequest $request, int $id): AccreditationResource
    {
        $input = $request->all();
        $accreditation = $this->accreditationRepository->update($input, $id);

        return new AccreditationResource($accreditation);
    }

    /**
     * Delete given Accreditation.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->accreditationRepository->delete($id);

        return $this->successResponse('Accreditation deleted successfully.');
    }

    /**
     * Bulk create Accreditation's.
     *
     * @param BulkCreateAccreditationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccreditationCollection
     */
    public function bulkStore(BulkCreateAccreditationAPIRequest $request): AccreditationCollection
    {
        $accreditations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accreditationInput) {
            $accreditations[$key] = $this->accreditationRepository->create($accreditationInput);
        }

        return new AccreditationCollection($accreditations);
    }

    /**
     * Bulk update Accreditation's data.
     *
     * @param BulkUpdateAccreditationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccreditationCollection
     */
    public function bulkUpdate(BulkUpdateAccreditationAPIRequest $request): AccreditationCollection
    {
        $accreditations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accreditationInput) {
            $accreditations[$key] = $this->accreditationRepository->update($accreditationInput, $accreditationInput['id']);
        }

        return new AccreditationCollection($accreditations);
    }
}
