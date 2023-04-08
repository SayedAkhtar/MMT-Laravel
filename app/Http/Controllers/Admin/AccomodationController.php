<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateAccomodationAPIRequest;
use App\Http\Requests\Device\UpdateAccomodationAPIRequest;
use App\Models\Accommodation;
use App\Models\Facility;
use App\Repositories\AccomodationRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class AccomodationController extends AppBaseController
{
    use IsViewModule;

    /**
     * @var AccomodationRepository
     */
    private AccomodationRepository $accomodationRepository;

    /**
     * @param AccomodationRepository $accomodationRepository
     */
    public function __construct(AccomodationRepository $accomodationRepository)
    {
        $this->accomodationRepository = $accomodationRepository;
        $this->module = "module/accommodations";
    }

    /**
     * Accommodation's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $accommodations = $this->accomodationRepository->fetch($request);
        return $this->module_view('list', compact('accommodations'));
    }

    public function create()
    {
        return $this->module_view('add');
    }

    public function store(CreateAccomodationAPIRequest $request)
    {
        $input = $request->except('images', 'facilities');
        try {
            $accommodation = $this->accomodationRepository->create($input);
            $insert_id = [];
            if (!empty($input['facilities'])) {
                foreach ($input['facilities'] as $data) {
                    if (intval($data) != 0) {
                        $insert_id[] = intval($data);
                    } else {
                        $model = Facility::create(['name' => $data]);
                        $insert_id[] = $model->id;
                    }
                }
                $accommodation->facilities()->attach($insert_id);
            }
            if ($request->hasFile('images')) {
                $accommodation->attachImage('images', 'accommodation-images', true);
            }

        } catch (\Exception $e) {

        }
        return back()->with('success', "Accommodation added successfully");
    }

    /**
     * Get single Accommodation record.
     *
     * @param int $id
     */
    public function show(int $id)
    {
        $accommodation = $this->accomodationRepository->findOrFail($id);
        $images = Accommodation::find($id)->getMedia('accommodation-images');
        $imageUrls = [];
        foreach ($images as $image) {
            $imageUrls[] = $image->getFullUrl();
        }
        $accommodation->images = $imageUrls;
        return $this->module_view('edit', compact('accommodation'));
    }

    /**
     * Update Accommodation with given payload.
     *
     * @param UpdateAccomodationAPIRequest $request
     * @param int $id
     *
     * @throws ValidatorException
     *
     */
    public function update(UpdateAccomodationAPIRequest $request, int $id)
    {
        $input = $request->all();
        try {
            $insert_id = [];
            if (!empty($input['facilities'])) {
                foreach ($input['facilities'] as $data) {
                    if (intval($data) != 0) {
                        $insert_id[] = intval($data);
                    } else {
                        $model = Facility::create(['name' => $data]);
                        $insert_id[] = $model->id;
                    }
                }
            }
            $accommodation = $this->accomodationRepository->update($input, $id);
            $accommodation->facilities()->sync($insert_id);
            if ($request->hasFile('images')) {
                $accommodation->updateImage('images', 'accommodation-images', true);
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect(route('accommodations.index'))->with('success', "Update Successfully");
    }

    /**
     * Delete given Accommodation.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     *
     */
    public function destroy(int $id): JsonResponse
    {
        $this->accomodationRepository->delete($id);

        return $this->successResponse('Accommodation deleted successfully.');
    }

}
