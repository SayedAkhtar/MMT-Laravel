<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateAccomodationAPIRequest;
use App\Http\Requests\Client\BulkUpdateAccomodationAPIRequest;
use App\Http\Requests\Client\CreateAccomodationAPIRequest;
use App\Http\Requests\Client\UpdateAccomodationAPIRequest;
use App\Http\Resources\Client\AccomodationCollection;
use App\Http\Resources\Client\AccomodationResource;
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
     * Accommodation's Listing API.
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
     * Create Accommodation with given payload.
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
     * Get single Accommodation record.
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
     * Update Accommodation with given payload.
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
     * Delete given Accommodation.
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

        return $this->successResponse('Accommodation deleted successfully.');
    }

    /**
     * Bulk create Accommodation's.
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
     * Bulk update Accommodation's data.
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