<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateAccomodationTypeAPIRequest;
use App\Http\Requests\Device\BulkUpdateAccomodationTypeAPIRequest;
use App\Http\Requests\Device\CreateAccomodationTypeAPIRequest;
use App\Http\Requests\Device\UpdateAccomodationTypeAPIRequest;
use App\Http\Resources\Device\AccomodationTypeCollection;
use App\Http\Resources\Device\AccomodationTypeResource;
use App\Repositories\AccomodationTypeRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class AccomodationTypeController extends AppBaseController
{
    /**
     * @var AccomodationTypeRepository
     */
    private AccomodationTypeRepository $accomodationTypeRepository;

    /**
     * @param AccomodationTypeRepository $accomodationTypeRepository
     */
    public function __construct(AccomodationTypeRepository $accomodationTypeRepository)
    {
        $this->accomodationTypeRepository = $accomodationTypeRepository;
    }

    /**
     * AccomodationType's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return AccomodationTypeCollection
     */
    public function index(Request $request): AccomodationTypeCollection
    {
        $accomodationTypes = $this->accomodationTypeRepository->fetch($request);

        return new AccomodationTypeCollection($accomodationTypes);
    }

    /**
     * Create AccomodationType with given payload.
     *
     * @param CreateAccomodationTypeAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccomodationTypeResource
     */
    public function store(CreateAccomodationTypeAPIRequest $request): AccomodationTypeResource
    {
        $input = $request->all();
        $accomodationType = $this->accomodationTypeRepository->create($input);

        return new AccomodationTypeResource($accomodationType);
    }

    /**
     * Get single AccomodationType record.
     *
     * @param int $id
     *
     * @return AccomodationTypeResource
     */
    public function show(int $id): AccomodationTypeResource
    {
        $accomodationType = $this->accomodationTypeRepository->findOrFail($id);

        return new AccomodationTypeResource($accomodationType);
    }

    /**
     * Update AccomodationType with given payload.
     *
     * @param UpdateAccomodationTypeAPIRequest $request
     * @param int                              $id
     *
     * @throws ValidatorException
     *
     * @return AccomodationTypeResource
     */
    public function update(UpdateAccomodationTypeAPIRequest $request, int $id): AccomodationTypeResource
    {
        $input = $request->all();
        $accomodationType = $this->accomodationTypeRepository->update($input, $id);

        return new AccomodationTypeResource($accomodationType);
    }

    /**
     * Delete given AccomodationType.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->accomodationTypeRepository->delete($id);

        return $this->successResponse('AccomodationType deleted successfully.');
    }

    /**
     * Bulk create AccomodationType's.
     *
     * @param BulkCreateAccomodationTypeAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccomodationTypeCollection
     */
    public function bulkStore(BulkCreateAccomodationTypeAPIRequest $request): AccomodationTypeCollection
    {
        $accomodationTypes = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accomodationTypeInput) {
            $accomodationTypes[$key] = $this->accomodationTypeRepository->create($accomodationTypeInput);
        }

        return new AccomodationTypeCollection($accomodationTypes);
    }

    /**
     * Bulk update AccomodationType's data.
     *
     * @param BulkUpdateAccomodationTypeAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccomodationTypeCollection
     */
    public function bulkUpdate(BulkUpdateAccomodationTypeAPIRequest $request): AccomodationTypeCollection
    {
        $accomodationTypes = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accomodationTypeInput) {
            $accomodationTypes[$key] = $this->accomodationTypeRepository->update($accomodationTypeInput, $accomodationTypeInput['id']);
        }

        return new AccomodationTypeCollection($accomodationTypes);
    }
}