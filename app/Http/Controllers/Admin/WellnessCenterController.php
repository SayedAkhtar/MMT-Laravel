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
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

class WellnessCenterController extends AppBaseController
{
    use IsViewModule;

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
        $this->module = 'module/wellness-center';
    }

    /**
     * WellnessCenter's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     */
    public function index(Request $request)
    {
        $wellnessCenters = $this->wellnessCenterRepository->fetch($request);

        return $this->module_view('list', compact('wellnessCenters'));
    }

    public function create()
    {
        return $this->module_view('add');
    }

    /**
     * Create WellnessCenter with given payload.
     *
     * @param CreateWellnessCenterAPIRequest $request
     *
     * @return WellnessCenterResource
     * @throws ValidatorException
     *
     */
    public function store(CreateWellnessCenterAPIRequest $request)
    {
        $input = $request->except('logo');
        DB::transaction(function () use ($input, $request) {
            $wellnessCenter = $this->wellnessCenterRepository->create($input);
            if ($request->hasFile('logo')) {
                $wellnessCenter->attachImage('logo', 'wellness-center-logo', false);
            }
            if ($request->hasFile('images')) {
                $wellnessCenter->attachImage('images', 'wellness-center-images', true);
            }
        });

        return back()->with('success', "Wellness Center added successfully");
    }

    /**
     * Get single WellnessCenter record.
     *
     * @param int $id
     *
     * @return WellnessCenterResource
     */
    public function show(int $id)
    {
        $wellnessCenter = $this->wellnessCenterRepository->findOrFail($id);
        $wellnessCenter->logo = $wellnessCenter->getFirstMediaUrl('wellness-center-logo');
        $imageUrls = [];
        foreach ($wellnessCenter->getMedia('wellness-center-images') as $media) {
            $imageUrls[] = $media->getFullUrl();
        }
        $wellnessCenter->images = $imageUrls;
        return $this->module_view('edit', compact('wellnessCenter'));
    }

    /**
     * Update WellnessCenter with given payload.
     *
     * @param UpdateWellnessCenterAPIRequest $request
     * @param int $id
     *
     * @return WellnessCenterResource
     * @throws ValidatorException
     *
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
     * @return JsonResponse
     * @throws Exception
     *
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
     * @return WellnessCenterCollection
     * @throws ValidatorException
     *
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
     * @return WellnessCenterCollection
     * @throws ValidatorException
     *
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
