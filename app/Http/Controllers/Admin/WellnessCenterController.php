<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateWellnessCenterAPIRequest;
use App\Http\Requests\Device\UpdateWellnessCenterAPIRequest;
use App\Models\DetoxificationCategory;
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
     * @throws ValidatorException
     *
     */
    public function store(CreateWellnessCenterAPIRequest $request)
    {
        $input = $request->except('logo');
        DB::beginTransaction();
        try {
            $wellnessCenter = $this->wellnessCenterRepository->create($input);
            if (isset($input['detoxification'])) {
                $detoxification_id = [];
                foreach ($input['detoxification'] as $detox) {
                    if (intval($detox) != 0) {
                        $detoxification_id[] = intval($detox);
                    } else {
                        $detoxification = DetoxificationCategory::create(['name' => $detox]);
                        $detoxification_id[] = $detoxification->id;
                    }
                }
                $wellnessCenter->detoxification()->attach($detoxification_id);
            }
            if ($request->hasFile('logo')) {
                $wellnessCenter->attachImage('logo', 'wellness-center-logo', false);
            }
            if ($request->hasFile('images')) {
                $wellnessCenter->attachImage('images', 'wellness-center-images', true);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }


        return redirect(route('wellness-centers.index'))->with('success', "Wellness Center added successfully");
    }

    /**
     * Get single WellnessCenter record.
     *
     * @param int $id
     *
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
     * @throws ValidatorException
     *
     */
    public function update(UpdateWellnessCenterAPIRequest $request, int $id)
    {
        $input = $request->all();
        try {
            DB::transaction(function () use ($input, $request, $id) {
                $detoxification_id = [];
                if (!empty($input['detoxification'])) {
                    foreach ($input['detoxification'] as $detox) {
                        if (intval($detox) != 0) {
                            $detoxification_id[] = intval($detox);
                        } else {
                            $detoxification = DetoxificationCategory::create(['name' => $detox]);
                            $detoxification_id[] = $detoxification->id;
                        }
                    }
                }
                $wellnessCenter = $this->wellnessCenterRepository->update($input, $id);
                $wellnessCenter->detoxification()->sync($detoxification_id);
                if ($request->hasFile('logo')) {
                    $wellnessCenter->updateImage('logo', 'wellness-center-logo', false);
                }
                if ($request->hasFile('images')) {
                    $wellnessCenter->updateImage('images', 'wellness-center-images', true);
                }
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', "Wellness Center added successfully");
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
    public function destroy(int $id): JsonResponse
    {
        $this->wellnessCenterRepository->delete($id);

        return $this->successResponse('WellnessCenter deleted successfully.');
    }

}
