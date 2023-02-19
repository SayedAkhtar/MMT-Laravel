<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateWellnessCenterAPIRequest;
use App\Http\Requests\Device\BulkUpdateWellnessCenterAPIRequest;
use App\Http\Requests\Device\CreateWellnessCenterAPIRequest;
use App\Http\Requests\Device\UpdateWellnessCenterAPIRequest;
use App\Http\Resources\Device\WellnessCenterCollection;
use App\Http\Resources\Device\WellnessCenterResource;
use App\Repositories\WellnessCenterRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class WellnessCenterController extends AppBaseController
{
    /**
     * @var WellnessCenterRepository
     */
    private WellnessCenterRepository $wellnessCenterRepository;

    /**
     * @param WellnessCenterRepository $wellnessCenterRepository
     */
    public function __construct(WellnessCenterRepository $wellnessCenterRepository)
    {
        $this->wellnessCenterRepository = $wellnessCenterRepository;
    }

    /**
     * WellnessCenter's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return WellnessCenterCollection
     */
    public function index(Request $request): WellnessCenterCollection
    {
        $wellnessCenters = $this->wellnessCenterRepository->fetch($request);

        return new WellnessCenterCollection($wellnessCenters);
    }

    /**
     * Create WellnessCenter with given payload.
     *
     * @param CreateWellnessCenterAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return WellnessCenterResource
     */
    public function store(CreateWellnessCenterAPIRequest $request): WellnessCenterResource
    {
        $input = $request->all();
        $wellnessCenter = $this->wellnessCenterRepository->create($input);

        return new WellnessCenterResource($wellnessCenter);
    }

    /**
     * Get single WellnessCenter record.
     *
     * @param int $id
     *
     * @return WellnessCenterResource
     */
    public function show(int $id): WellnessCenterResource
    {
        $wellnessCenter = $this->wellnessCenterRepository->findOrFail($id);

        return new WellnessCenterResource($wellnessCenter);
    }

    /**
     * Update WellnessCenter with given payload.
     *
     * @param UpdateWellnessCenterAPIRequest $request
     * @param int                            $id
     *
     * @throws ValidatorException
     *
     * @return WellnessCenterResource
     */
    public function update(UpdateWellnessCenterAPIRequest $request, int $id): WellnessCenterResource
    {
        $input = $request->all();
        $wellnessCenter = $this->wellnessCenterRepository->update($input, $id);

        return new WellnessCenterResource($wellnessCenter);
    }

    /**
     * Delete given WellnessCenter.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->wellnessCenterRepository->delete($id);

        return $this->successResponse('WellnessCenter deleted successfully.');
    }

    /**
     * Bulk create WellnessCenter's.
     *
     * @param BulkCreateWellnessCenterAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return WellnessCenterCollection
     */
    public function bulkStore(BulkCreateWellnessCenterAPIRequest $request): WellnessCenterCollection
    {
        $wellnessCenters = collect();

        $input = $request->get('data');
        foreach ($input as $key => $wellnessCenterInput) {
            $wellnessCenters[$key] = $this->wellnessCenterRepository->create($wellnessCenterInput);
        }

        return new WellnessCenterCollection($wellnessCenters);
    }

    /**
     * Bulk update WellnessCenter's data.
     *
     * @param BulkUpdateWellnessCenterAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return WellnessCenterCollection
     */
    public function bulkUpdate(BulkUpdateWellnessCenterAPIRequest $request): WellnessCenterCollection
    {
        $wellnessCenters = collect();

        $input = $request->get('data');
        foreach ($input as $key => $wellnessCenterInput) {
            $wellnessCenters[$key] = $this->wellnessCenterRepository->update($wellnessCenterInput, $wellnessCenterInput['id']);
        }

        return new WellnessCenterCollection($wellnessCenters);
    }
}