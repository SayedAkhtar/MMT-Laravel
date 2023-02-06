<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateAccomodationAPIRequest;
use App\Http\Requests\Device\BulkUpdateAccomodationAPIRequest;
use App\Http\Requests\Device\CreateAccomodationAPIRequest;
use App\Http\Requests\Device\UpdateAccomodationAPIRequest;
use App\Http\Resources\Device\AccomodationCollection;
use App\Http\Resources\Device\AccomodationResource;
use App\Repositories\AccomodationRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class AccomodationController extends AppBaseController
{
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
    }

    /**
     * Accomodation's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return AccomodationCollection
     */
    public function index(Request $request): AccomodationCollection
    {
        $accomodations = $this->accomodationRepository->fetch($request);

        return new AccomodationCollection($accomodations);
    }

    /**
     * Create Accomodation with given payload.
     *
     * @param CreateAccomodationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccomodationResource
     */
    public function store(CreateAccomodationAPIRequest $request): AccomodationResource
    {
        $input = $request->all();
        $accomodation = $this->accomodationRepository->create($input);

        return new AccomodationResource($accomodation);
    }

    /**
     * Get single Accomodation record.
     *
     * @param int $id
     *
     * @return AccomodationResource
     */
    public function show(int $id): AccomodationResource
    {
        $accomodation = $this->accomodationRepository->findOrFail($id);

        return new AccomodationResource($accomodation);
    }

    /**
     * Update Accomodation with given payload.
     *
     * @param UpdateAccomodationAPIRequest $request
     * @param int                          $id
     *
     * @throws ValidatorException
     *
     * @return AccomodationResource
     */
    public function update(UpdateAccomodationAPIRequest $request, int $id): AccomodationResource
    {
        $input = $request->all();
        $accomodation = $this->accomodationRepository->update($input, $id);

        return new AccomodationResource($accomodation);
    }

    /**
     * Delete given Accomodation.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->accomodationRepository->delete($id);

        return $this->successResponse('Accomodation deleted successfully.');
    }

    /**
     * Bulk create Accomodation's.
     *
     * @param BulkCreateAccomodationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccomodationCollection
     */
    public function bulkStore(BulkCreateAccomodationAPIRequest $request): AccomodationCollection
    {
        $accomodations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accomodationInput) {
            $accomodations[$key] = $this->accomodationRepository->create($accomodationInput);
        }

        return new AccomodationCollection($accomodations);
    }

    /**
     * Bulk update Accomodation's data.
     *
     * @param BulkUpdateAccomodationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccomodationCollection
     */
    public function bulkUpdate(BulkUpdateAccomodationAPIRequest $request): AccomodationCollection
    {
        $accomodations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accomodationInput) {
            $accomodations[$key] = $this->accomodationRepository->update($accomodationInput, $accomodationInput['id']);
        }

        return new AccomodationCollection($accomodations);
    }
}