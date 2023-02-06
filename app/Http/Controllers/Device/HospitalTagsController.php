<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateHospitalTagsAPIRequest;
use App\Http\Requests\Device\BulkUpdateHospitalTagsAPIRequest;
use App\Http\Requests\Device\CreateHospitalTagsAPIRequest;
use App\Http\Requests\Device\UpdateHospitalTagsAPIRequest;
use App\Http\Resources\Device\HospitalTagsCollection;
use App\Http\Resources\Device\HospitalTagsResource;
use App\Repositories\HospitalTagsRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class HospitalTagsController extends AppBaseController
{
    /**
     * @var HospitalTagsRepository
     */
    private HospitalTagsRepository $hospitalTagsRepository;

    /**
     * @param HospitalTagsRepository $hospitalTagsRepository
     */
    public function __construct(HospitalTagsRepository $hospitalTagsRepository)
    {
        $this->hospitalTagsRepository = $hospitalTagsRepository;
    }

    /**
     * HospitalTags's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return HospitalTagsCollection
     */
    public function index(Request $request): HospitalTagsCollection
    {
        $hospitalTags = $this->hospitalTagsRepository->fetch($request);

        return new HospitalTagsCollection($hospitalTags);
    }

    /**
     * Create HospitalTags with given payload.
     *
     * @param CreateHospitalTagsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return HospitalTagsResource
     */
    public function store(CreateHospitalTagsAPIRequest $request): HospitalTagsResource
    {
        $input = $request->all();
        $hospitalTags = $this->hospitalTagsRepository->create($input);

        return new HospitalTagsResource($hospitalTags);
    }

    /**
     * Get single HospitalTags record.
     *
     * @param int $id
     *
     * @return HospitalTagsResource
     */
    public function show(int $id): HospitalTagsResource
    {
        $hospitalTags = $this->hospitalTagsRepository->findOrFail($id);

        return new HospitalTagsResource($hospitalTags);
    }

    /**
     * Update HospitalTags with given payload.
     *
     * @param UpdateHospitalTagsAPIRequest $request
     * @param int                          $id
     *
     * @throws ValidatorException
     *
     * @return HospitalTagsResource
     */
    public function update(UpdateHospitalTagsAPIRequest $request, int $id): HospitalTagsResource
    {
        $input = $request->all();
        $hospitalTags = $this->hospitalTagsRepository->update($input, $id);

        return new HospitalTagsResource($hospitalTags);
    }

    /**
     * Delete given HospitalTags.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->hospitalTagsRepository->delete($id);

        return $this->successResponse('HospitalTags deleted successfully.');
    }

    /**
     * Bulk create HospitalTags's.
     *
     * @param BulkCreateHospitalTagsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return HospitalTagsCollection
     */
    public function bulkStore(BulkCreateHospitalTagsAPIRequest $request): HospitalTagsCollection
    {
        $hospitalTags = collect();

        $input = $request->get('data');
        foreach ($input as $key => $hospitalTagsInput) {
            $hospitalTags[$key] = $this->hospitalTagsRepository->create($hospitalTagsInput);
        }

        return new HospitalTagsCollection($hospitalTags);
    }

    /**
     * Bulk update HospitalTags's data.
     *
     * @param BulkUpdateHospitalTagsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return HospitalTagsCollection
     */
    public function bulkUpdate(BulkUpdateHospitalTagsAPIRequest $request): HospitalTagsCollection
    {
        $hospitalTags = collect();

        $input = $request->get('data');
        foreach ($input as $key => $hospitalTagsInput) {
            $hospitalTags[$key] = $this->hospitalTagsRepository->update($hospitalTagsInput, $hospitalTagsInput['id']);
        }

        return new HospitalTagsCollection($hospitalTags);
    }
}