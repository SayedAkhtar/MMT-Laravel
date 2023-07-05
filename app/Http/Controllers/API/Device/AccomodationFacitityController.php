<?php

namespace App\Http\Controllers\API\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateAccomodationFacitityAPIRequest;
use App\Http\Requests\Device\BulkUpdateAccomodationFacitityAPIRequest;
use App\Http\Requests\Device\CreateAccomodationFacitityAPIRequest;
use App\Http\Requests\Device\UpdateAccomodationFacitityAPIRequest;
use App\Http\Resources\Device\AccomodationFacitityCollection;
use App\Http\Resources\Device\AccomodationFacitityResource;
use App\Repositories\AccomodationFacitityRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class AccomodationFacitityController extends AppBaseController
{
    /**
     * @var AccomodationFacitityRepository
     */
    private AccomodationFacitityRepository $accomodationFacitityRepository;

    /**
     * @param AccomodationFacitityRepository $accomodationFacitityRepository
     */
    public function __construct(AccomodationFacitityRepository $accomodationFacitityRepository)
    {
        $this->accomodationFacitityRepository = $accomodationFacitityRepository;
    }

    /**
     * AccomodationFacitity's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return AccomodationFacitityCollection
     */
    public function index(Request $request): AccomodationFacitityCollection
    {
        $accomodationFacitities = $this->accomodationFacitityRepository->fetch($request);

        return new AccomodationFacitityCollection($accomodationFacitities);
    }

    /**
     * Create AccomodationFacitity with given payload.
     *
     * @param CreateAccomodationFacitityAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccomodationFacitityResource
     */
    public function store(CreateAccomodationFacitityAPIRequest $request): AccomodationFacitityResource
    {
        $input = $request->all();
        $accomodationFacitity = $this->accomodationFacitityRepository->create($input);

        return new AccomodationFacitityResource($accomodationFacitity);
    }

    /**
     * Get single AccomodationFacitity record.
     *
     * @param int $id
     *
     * @return AccomodationFacitityResource
     */
    public function show(int $id): AccomodationFacitityResource
    {
        $accomodationFacitity = $this->accomodationFacitityRepository->findOrFail($id);

        return new AccomodationFacitityResource($accomodationFacitity);
    }

    /**
     * Update AccomodationFacitity with given payload.
     *
     * @param UpdateAccomodationFacitityAPIRequest $request
     * @param int                                  $id
     *
     * @throws ValidatorException
     *
     * @return AccomodationFacitityResource
     */
    public function update(UpdateAccomodationFacitityAPIRequest $request, int $id): AccomodationFacitityResource
    {
        $input = $request->all();
        $accomodationFacitity = $this->accomodationFacitityRepository->update($input, $id);

        return new AccomodationFacitityResource($accomodationFacitity);
    }

    /**
     * Delete given AccomodationFacitity.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->accomodationFacitityRepository->delete($id);

        return $this->successResponse('AccomodationFacitity deleted successfully.');
    }

    /**
     * Bulk create AccomodationFacitity's.
     *
     * @param BulkCreateAccomodationFacitityAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccomodationFacitityCollection
     */
    public function bulkStore(BulkCreateAccomodationFacitityAPIRequest $request): AccomodationFacitityCollection
    {
        $accomodationFacitities = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accomodationFacitityInput) {
            $accomodationFacitities[$key] = $this->accomodationFacitityRepository->create($accomodationFacitityInput);
        }

        return new AccomodationFacitityCollection($accomodationFacitities);
    }

    /**
     * Bulk update AccomodationFacitity's data.
     *
     * @param BulkUpdateAccomodationFacitityAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccomodationFacitityCollection
     */
    public function bulkUpdate(BulkUpdateAccomodationFacitityAPIRequest $request): AccomodationFacitityCollection
    {
        $accomodationFacitities = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accomodationFacitityInput) {
            $accomodationFacitities[$key] = $this->accomodationFacitityRepository->update($accomodationFacitityInput, $accomodationFacitityInput['id']);
        }

        return new AccomodationFacitityCollection($accomodationFacitities);
    }
}
