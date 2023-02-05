<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateDetoxificationWellnessAPIRequest;
use App\Http\Requests\Client\BulkUpdateDetoxificationWellnessAPIRequest;
use App\Http\Requests\Client\CreateDetoxificationWellnessAPIRequest;
use App\Http\Requests\Client\UpdateDetoxificationWellnessAPIRequest;
use App\Http\Resources\Client\DetoxificationWellnessCollection;
use App\Http\Resources\Client\DetoxificationWellnessResource;
use App\Repositories\DetoxificationWellnessRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class DetoxificationWellnessController extends AppBaseController
{
    /**
     * @var DetoxificationWellnessRepository
     */
    private DetoxificationWellnessRepository $detoxificationWellnessRepository;

    /**
     * @param DetoxificationWellnessRepository $detoxificationWellnessRepository
     */
    public function __construct(DetoxificationWellnessRepository $detoxificationWellnessRepository)
    {
        $this->detoxificationWellnessRepository = $detoxificationWellnessRepository;
    }

    /**
     * DetoxificationWellness's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return DetoxificationWellnessCollection
     */
    public function index(Request $request): DetoxificationWellnessCollection
    {
        $detoxificationWellnesses = $this->detoxificationWellnessRepository->fetch($request);

        return new DetoxificationWellnessCollection($detoxificationWellnesses);
    }

    /**
     * Create DetoxificationWellness with given payload.
     *
     * @param CreateDetoxificationWellnessAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DetoxificationWellnessResource
     */
    public function store(CreateDetoxificationWellnessAPIRequest $request): DetoxificationWellnessResource
    {
        $input = $request->all();
        $detoxificationWellness = $this->detoxificationWellnessRepository->create($input);

        return new DetoxificationWellnessResource($detoxificationWellness);
    }

    /**
     * Get single DetoxificationWellness record.
     *
     * @param int $id
     *
     * @return DetoxificationWellnessResource
     */
    public function show(int $id): DetoxificationWellnessResource
    {
        $detoxificationWellness = $this->detoxificationWellnessRepository->findOrFail($id);

        return new DetoxificationWellnessResource($detoxificationWellness);
    }

    /**
     * Update DetoxificationWellness with given payload.
     *
     * @param UpdateDetoxificationWellnessAPIRequest $request
     * @param int                                    $id
     *
     * @throws ValidatorException
     *
     * @return DetoxificationWellnessResource
     */
    public function update(UpdateDetoxificationWellnessAPIRequest $request, int $id): DetoxificationWellnessResource
    {
        $input = $request->all();
        $detoxificationWellness = $this->detoxificationWellnessRepository->update($input, $id);

        return new DetoxificationWellnessResource($detoxificationWellness);
    }

    /**
     * Delete given DetoxificationWellness.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->detoxificationWellnessRepository->delete($id);

        return $this->successResponse('DetoxificationWellness deleted successfully.');
    }

    /**
     * Bulk create DetoxificationWellness's.
     *
     * @param BulkCreateDetoxificationWellnessAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DetoxificationWellnessCollection
     */
    public function bulkStore(BulkCreateDetoxificationWellnessAPIRequest $request): DetoxificationWellnessCollection
    {
        $detoxificationWellnesses = collect();

        $input = $request->get('data');
        foreach ($input as $key => $detoxificationWellnessInput) {
            $detoxificationWellnesses[$key] = $this->detoxificationWellnessRepository->create($detoxificationWellnessInput);
        }

        return new DetoxificationWellnessCollection($detoxificationWellnesses);
    }

    /**
     * Bulk update DetoxificationWellness's data.
     *
     * @param BulkUpdateDetoxificationWellnessAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DetoxificationWellnessCollection
     */
    public function bulkUpdate(BulkUpdateDetoxificationWellnessAPIRequest $request): DetoxificationWellnessCollection
    {
        $detoxificationWellnesses = collect();

        $input = $request->get('data');
        foreach ($input as $key => $detoxificationWellnessInput) {
            $detoxificationWellnesses[$key] = $this->detoxificationWellnessRepository->update($detoxificationWellnessInput, $detoxificationWellnessInput['id']);
        }

        return new DetoxificationWellnessCollection($detoxificationWellnesses);
    }
}
