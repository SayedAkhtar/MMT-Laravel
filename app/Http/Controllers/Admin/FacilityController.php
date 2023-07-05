<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateFacilityAPIRequest;
use App\Http\Requests\Device\BulkUpdateFacilityAPIRequest;
use App\Http\Requests\Device\CreateFacilityAPIRequest;
use App\Http\Requests\Device\UpdateFacilityAPIRequest;
use App\Http\Resources\Device\FacilityCollection;
use App\Http\Resources\Device\FacilityResource;
use App\Repositories\FacilityRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class FacilityController extends AppBaseController
{
    /**
     * @var FacilityRepository
     */
    private FacilityRepository $facilityRepository;

    /**
     * @param FacilityRepository $facilityRepository
     */
    public function __construct(FacilityRepository $facilityRepository)
    {
        $this->facilityRepository = $facilityRepository;
    }

    /**
     * Facility's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return FacilityCollection
     */
    public function index(Request $request): FacilityCollection
    {
        $facilities = $this->facilityRepository->fetch($request);

        return new FacilityCollection($facilities);
    }

    /**
     * Create Facility with given payload.
     *
     * @param CreateFacilityAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return FacilityResource
     */
    public function store(CreateFacilityAPIRequest $request): FacilityResource
    {
        $input = $request->all();
        $facility = $this->facilityRepository->create($input);

        return new FacilityResource($facility);
    }

    /**
     * Get single Facility record.
     *
     * @param int $id
     *
     * @return FacilityResource
     */
    public function show(int $id): FacilityResource
    {
        $facility = $this->facilityRepository->findOrFail($id);

        return new FacilityResource($facility);
    }

    /**
     * Update Facility with given payload.
     *
     * @param UpdateFacilityAPIRequest $request
     * @param int                      $id
     *
     * @throws ValidatorException
     *
     * @return FacilityResource
     */
    public function update(UpdateFacilityAPIRequest $request, int $id): FacilityResource
    {
        $input = $request->all();
        $facility = $this->facilityRepository->update($input, $id);

        return new FacilityResource($facility);
    }

    /**
     * Delete given Facility.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->facilityRepository->delete($id);

        return $this->successResponse('Facility deleted successfully.');
    }

    /**
     * Bulk create Facility's.
     *
     * @param BulkCreateFacilityAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return FacilityCollection
     */
    public function bulkStore(BulkCreateFacilityAPIRequest $request): FacilityCollection
    {
        $facilities = collect();

        $input = $request->get('data');
        foreach ($input as $key => $facilityInput) {
            $facilities[$key] = $this->facilityRepository->create($facilityInput);
        }

        return new FacilityCollection($facilities);
    }

    /**
     * Bulk update Facility's data.
     *
     * @param BulkUpdateFacilityAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return FacilityCollection
     */
    public function bulkUpdate(BulkUpdateFacilityAPIRequest $request): FacilityCollection
    {
        $facilities = collect();

        $input = $request->get('data');
        foreach ($input as $key => $facilityInput) {
            $facilities[$key] = $this->facilityRepository->update($facilityInput, $facilityInput['id']);
        }

        return new FacilityCollection($facilities);
    }
}