<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateAccreditationHospitalAPIRequest;
use App\Http\Requests\Client\BulkUpdateAccreditationHospitalAPIRequest;
use App\Http\Requests\Client\CreateAccreditationHospitalAPIRequest;
use App\Http\Requests\Client\UpdateAccreditationHospitalAPIRequest;
use App\Http\Resources\Client\AccreditationHospitalCollection;
use App\Http\Resources\Client\AccreditationHospitalResource;
use App\Repositories\AccreditationHospitalRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class AccreditationHospitalController extends AppBaseController
{
    /**
     * @var AccreditationHospitalRepository
     */
    private AccreditationHospitalRepository $accreditationHospitalRepository;

    /**
     * @param AccreditationHospitalRepository $accreditationHospitalRepository
     */
    public function __construct(AccreditationHospitalRepository $accreditationHospitalRepository)
    {
        $this->accreditationHospitalRepository = $accreditationHospitalRepository;
    }

    /**
     * AccreditationHospital's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return AccreditationHospitalCollection
     */
    public function index(Request $request): AccreditationHospitalCollection
    {
        $accreditationHospitals = $this->accreditationHospitalRepository->fetch($request);

        return new AccreditationHospitalCollection($accreditationHospitals);
    }

    /**
     * Create AccreditationHospital with given payload.
     *
     * @param CreateAccreditationHospitalAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccreditationHospitalResource
     */
    public function store(CreateAccreditationHospitalAPIRequest $request): AccreditationHospitalResource
    {
        $input = $request->all();
        $accreditationHospital = $this->accreditationHospitalRepository->create($input);

        return new AccreditationHospitalResource($accreditationHospital);
    }

    /**
     * Get single AccreditationHospital record.
     *
     * @param int $id
     *
     * @return AccreditationHospitalResource
     */
    public function show(int $id): AccreditationHospitalResource
    {
        $accreditationHospital = $this->accreditationHospitalRepository->findOrFail($id);

        return new AccreditationHospitalResource($accreditationHospital);
    }

    /**
     * Update AccreditationHospital with given payload.
     *
     * @param UpdateAccreditationHospitalAPIRequest $request
     * @param int                                   $id
     *
     * @throws ValidatorException
     *
     * @return AccreditationHospitalResource
     */
    public function update(UpdateAccreditationHospitalAPIRequest $request, int $id): AccreditationHospitalResource
    {
        $input = $request->all();
        $accreditationHospital = $this->accreditationHospitalRepository->update($input, $id);

        return new AccreditationHospitalResource($accreditationHospital);
    }

    /**
     * Delete given AccreditationHospital.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->accreditationHospitalRepository->delete($id);

        return $this->successResponse('AccreditationHospital deleted successfully.');
    }

    /**
     * Bulk create AccreditationHospital's.
     *
     * @param BulkCreateAccreditationHospitalAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccreditationHospitalCollection
     */
    public function bulkStore(BulkCreateAccreditationHospitalAPIRequest $request): AccreditationHospitalCollection
    {
        $accreditationHospitals = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accreditationHospitalInput) {
            $accreditationHospitals[$key] = $this->accreditationHospitalRepository->create($accreditationHospitalInput);
        }

        return new AccreditationHospitalCollection($accreditationHospitals);
    }

    /**
     * Bulk update AccreditationHospital's data.
     *
     * @param BulkUpdateAccreditationHospitalAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccreditationHospitalCollection
     */
    public function bulkUpdate(BulkUpdateAccreditationHospitalAPIRequest $request): AccreditationHospitalCollection
    {
        $accreditationHospitals = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accreditationHospitalInput) {
            $accreditationHospitals[$key] = $this->accreditationHospitalRepository->update($accreditationHospitalInput, $accreditationHospitalInput['id']);
        }

        return new AccreditationHospitalCollection($accreditationHospitals);
    }
}
