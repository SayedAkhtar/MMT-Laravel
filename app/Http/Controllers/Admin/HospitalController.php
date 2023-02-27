<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateHospitalAPIRequest;
use App\Http\Requests\Device\BulkUpdateHospitalAPIRequest;
use App\Http\Requests\Device\CreateHospitalAPIRequest;
use App\Http\Requests\Device\UpdateHospitalAPIRequest;
use App\Http\Resources\Device\HospitalCollection;
use App\Http\Resources\Device\HospitalResource;
use App\Repositories\HospitalRepository;
use App\Traits\isViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

class HospitalController extends AppBaseController
{
    use isViewModule;

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
    public function index(Request $request) : View
    {
        $hospitals = $this->hospitalRepository->fetch($request);
        return $this->module_view('list', compact('hospitals'));
    }

    public function create()
    {
        return $this->module_view('add');
    }

    /**
     * Create Hospital with given payload.
     *
     * @param CreateHospitalAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return HospitalResource
     */
    public function store(CreateHospitalAPIRequest $request): HospitalResource
    {
        $input = $request->all();
        $hospital = $this->hospitalRepository->create($input);

        return new HospitalResource($hospital);
    }

    /**
     * Get single Hospital record.
     *
     * @param int $id
     *
     * @return HospitalResource
     */
    public function show(int $id): HospitalResource
    {
        $hospital = $this->hospitalRepository->findOrFail($id);

        return new HospitalResource($hospital);
    }

    /**
     * Update Hospital with given payload.
     *
     * @param UpdateHospitalAPIRequest $request
     * @param int                      $id
     *
     * @throws ValidatorException
     *
     * @return HospitalResource
     */
    public function update(UpdateHospitalAPIRequest $request, int $id): HospitalResource
    {
        $input = $request->all();
        $hospital = $this->hospitalRepository->update($input, $id);

        return new HospitalResource($hospital);
    }

    /**
     * Delete given Hospital.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->hospitalRepository->delete($id);

        return $this->successResponse('Hospital deleted successfully.');
    }

    /**
     * Bulk create Hospital's.
     *
     * @param BulkCreateHospitalAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return HospitalCollection
     */
    public function bulkStore(BulkCreateHospitalAPIRequest $request): HospitalCollection
    {
        $hospitals = collect();

        $input = $request->get('data');
        foreach ($input as $key => $hospitalInput) {
            $hospitals[$key] = $this->hospitalRepository->create($hospitalInput);
        }

        return new HospitalCollection($hospitals);
    }

    /**
     * Bulk update Hospital's data.
     *
     * @param BulkUpdateHospitalAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return HospitalCollection
     */
    public function bulkUpdate(BulkUpdateHospitalAPIRequest $request): HospitalCollection
    {
        $hospitals = collect();

        $input = $request->get('data');
        foreach ($input as $key => $hospitalInput) {
            $hospitals[$key] = $this->hospitalRepository->update($hospitalInput, $hospitalInput['id']);
        }

        return new HospitalCollection($hospitals);
    }
}
