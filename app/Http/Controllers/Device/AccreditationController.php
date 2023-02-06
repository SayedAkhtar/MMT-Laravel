<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateAccreditationAPIRequest;
use App\Http\Requests\Device\BulkUpdateAccreditationAPIRequest;
use App\Http\Requests\Device\CreateAccreditationAPIRequest;
use App\Http\Requests\Device\UpdateAccreditationAPIRequest;
use App\Http\Resources\Device\AccreditationCollection;
use App\Http\Resources\Device\AccreditationResource;
use App\Repositories\AccreditationRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class AccreditationController extends AppBaseController
{
    /**
     * @var AccreditationRepository
     */
    private AccreditationRepository $accreditationRepository;

    /**
     * @param AccreditationRepository $accreditationRepository
     */
    public function __construct(AccreditationRepository $accreditationRepository)
    {
        $this->accreditationRepository = $accreditationRepository;
    }

    /**
     * Accreditation's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return AccreditationCollection
     */
    public function index(Request $request): AccreditationCollection
    {
        $accreditations = $this->accreditationRepository->fetch($request);

        return new AccreditationCollection($accreditations);
    }

    /**
     * Create Accreditation with given payload.
     *
     * @param CreateAccreditationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccreditationResource
     */
    public function store(CreateAccreditationAPIRequest $request): AccreditationResource
    {
        $input = $request->all();
        $accreditation = $this->accreditationRepository->create($input);

        return new AccreditationResource($accreditation);
    }

    /**
     * Get single Accreditation record.
     *
     * @param int $id
     *
     * @return AccreditationResource
     */
    public function show(int $id): AccreditationResource
    {
        $accreditation = $this->accreditationRepository->findOrFail($id);

        return new AccreditationResource($accreditation);
    }

    /**
     * Update Accreditation with given payload.
     *
     * @param UpdateAccreditationAPIRequest $request
     * @param int                           $id
     *
     * @throws ValidatorException
     *
     * @return AccreditationResource
     */
    public function update(UpdateAccreditationAPIRequest $request, int $id): AccreditationResource
    {
        $input = $request->all();
        $accreditation = $this->accreditationRepository->update($input, $id);

        return new AccreditationResource($accreditation);
    }

    /**
     * Delete given Accreditation.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->accreditationRepository->delete($id);

        return $this->successResponse('Accreditation deleted successfully.');
    }

    /**
     * Bulk create Accreditation's.
     *
     * @param BulkCreateAccreditationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccreditationCollection
     */
    public function bulkStore(BulkCreateAccreditationAPIRequest $request): AccreditationCollection
    {
        $accreditations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accreditationInput) {
            $accreditations[$key] = $this->accreditationRepository->create($accreditationInput);
        }

        return new AccreditationCollection($accreditations);
    }

    /**
     * Bulk update Accreditation's data.
     *
     * @param BulkUpdateAccreditationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return AccreditationCollection
     */
    public function bulkUpdate(BulkUpdateAccreditationAPIRequest $request): AccreditationCollection
    {
        $accreditations = collect();

        $input = $request->get('data');
        foreach ($input as $key => $accreditationInput) {
            $accreditations[$key] = $this->accreditationRepository->update($accreditationInput, $accreditationInput['id']);
        }

        return new AccreditationCollection($accreditations);
    }
}