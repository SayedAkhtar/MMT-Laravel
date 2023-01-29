<?php

namespace App\Http\Controllers\API\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateDoctorTagAPIRequest;
use App\Http\Requests\Device\BulkUpdateDoctorTagAPIRequest;
use App\Http\Requests\Device\CreateDoctorTagAPIRequest;
use App\Http\Requests\Device\UpdateDoctorTagAPIRequest;
use App\Http\Resources\Device\DoctorTagCollection;
use App\Http\Resources\Device\DoctorTagResource;
use App\Repositories\DoctorTagRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class DoctorTagController extends AppBaseController
{
    /**
     * @var DoctorTagRepository
     */
    private DoctorTagRepository $doctorTagRepository;

    /**
     * @param DoctorTagRepository $doctorTagRepository
     */
    public function __construct(DoctorTagRepository $doctorTagRepository)
    {
        $this->doctorTagRepository = $doctorTagRepository;
    }

    /**
     * DoctorTag's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return DoctorTagCollection
     */
    public function index(Request $request): DoctorTagCollection
    {
        $doctorTags = $this->doctorTagRepository->fetch($request);

        return new DoctorTagCollection($doctorTags);
    }

    /**
     * Create DoctorTag with given payload.
     *
     * @param CreateDoctorTagAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorTagResource
     */
    public function store(CreateDoctorTagAPIRequest $request): DoctorTagResource
    {
        $input = $request->all();
        $doctorTag = $this->doctorTagRepository->create($input);

        return new DoctorTagResource($doctorTag);
    }

    /**
     * Get single DoctorTag record.
     *
     * @param int $id
     *
     * @return DoctorTagResource
     */
    public function show(int $id): DoctorTagResource
    {
        $doctorTag = $this->doctorTagRepository->findOrFail($id);

        return new DoctorTagResource($doctorTag);
    }

    /**
     * Update DoctorTag with given payload.
     *
     * @param UpdateDoctorTagAPIRequest $request
     * @param int                       $id
     *
     * @throws ValidatorException
     *
     * @return DoctorTagResource
     */
    public function update(UpdateDoctorTagAPIRequest $request, int $id): DoctorTagResource
    {
        $input = $request->all();
        $doctorTag = $this->doctorTagRepository->update($input, $id);

        return new DoctorTagResource($doctorTag);
    }

    /**
     * Delete given DoctorTag.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->doctorTagRepository->delete($id);

        return $this->successResponse('DoctorTag deleted successfully.');
    }

    /**
     * Bulk create DoctorTag's.
     *
     * @param BulkCreateDoctorTagAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorTagCollection
     */
    public function bulkStore(BulkCreateDoctorTagAPIRequest $request): DoctorTagCollection
    {
        $doctorTags = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorTagInput) {
            $doctorTags[$key] = $this->doctorTagRepository->create($doctorTagInput);
        }

        return new DoctorTagCollection($doctorTags);
    }

    /**
     * Bulk update DoctorTag's data.
     *
     * @param BulkUpdateDoctorTagAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DoctorTagCollection
     */
    public function bulkUpdate(BulkUpdateDoctorTagAPIRequest $request): DoctorTagCollection
    {
        $doctorTags = collect();

        $input = $request->get('data');
        foreach ($input as $key => $doctorTagInput) {
            $doctorTags[$key] = $this->doctorTagRepository->update($doctorTagInput, $doctorTagInput['id']);
        }

        return new DoctorTagCollection($doctorTags);
    }
}
