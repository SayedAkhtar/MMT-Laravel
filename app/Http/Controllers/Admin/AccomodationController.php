<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateAccomodationAPIRequest;
use App\Http\Requests\Device\UpdateAccomodationAPIRequest;
use App\Http\Resources\Device\AccomodationResource;
use App\Models\Accommodation;
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
        $input = $request->except('images');
        $accommodation = $this->accomodationRepository->create($input);
        if ($request->hasFile('images')) {
            $accommodation->attachImage('images', 'accommodation-images', true);
        }
        if ($request->has('facilities')) {
            $accommodation->facilities()->sync($request->get('facilities'));
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
     * @return AccomodationResource
     * @throws ValidatorException
     *
     */
    public function update(UpdateAccomodationAPIRequest $request, int $id): AccomodationResource
    {
        $input = $request->all();
        $accomodation = $this->accomodationRepository->update($input, $id);

        return new AccomodationResource($accomodation);
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
    public function delete(int $id): JsonResponse
    {
        $this->accomodationRepository->delete($id);

        return $this->successResponse('Accommodation deleted successfully.');
    }

}
