<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateDetoxificationCategoryAPIRequest;
use App\Http\Requests\Client\BulkUpdateDetoxificationCategoryAPIRequest;
use App\Http\Requests\Client\CreateDetoxificationCategoryAPIRequest;
use App\Http\Requests\Client\UpdateDetoxificationCategoryAPIRequest;
use App\Http\Resources\Client\DetoxificationCategoryCollection;
use App\Http\Resources\Client\DetoxificationCategoryResource;
use App\Repositories\DetoxificationCategoryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class DetoxificationCategoryController extends AppBaseController
{
    /**
     * @var DetoxificationCategoryRepository
     */
    private DetoxificationCategoryRepository $detoxificationCategoryRepository;

    /**
     * @param DetoxificationCategoryRepository $detoxificationCategoryRepository
     */
    public function __construct(DetoxificationCategoryRepository $detoxificationCategoryRepository)
    {
        $this->detoxificationCategoryRepository = $detoxificationCategoryRepository;
    }

    /**
     * DetoxificationCategory's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return DetoxificationCategoryCollection
     */
    public function index(Request $request): DetoxificationCategoryCollection
    {
        $detoxificationCategories = $this->detoxificationCategoryRepository->fetch($request);

        return new DetoxificationCategoryCollection($detoxificationCategories);
    }

    /**
     * Create DetoxificationCategory with given payload.
     *
     * @param CreateDetoxificationCategoryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DetoxificationCategoryResource
     */
    public function store(CreateDetoxificationCategoryAPIRequest $request): DetoxificationCategoryResource
    {
        $input = $request->all();
        $detoxificationCategory = $this->detoxificationCategoryRepository->create($input);

        return new DetoxificationCategoryResource($detoxificationCategory);
    }

    /**
     * Get single DetoxificationCategory record.
     *
     * @param int $id
     *
     * @return DetoxificationCategoryResource
     */
    public function show(int $id): DetoxificationCategoryResource
    {
        $detoxificationCategory = $this->detoxificationCategoryRepository->findOrFail($id);

        return new DetoxificationCategoryResource($detoxificationCategory);
    }

    /**
     * Update DetoxificationCategory with given payload.
     *
     * @param UpdateDetoxificationCategoryAPIRequest $request
     * @param int                                    $id
     *
     * @throws ValidatorException
     *
     * @return DetoxificationCategoryResource
     */
    public function update(UpdateDetoxificationCategoryAPIRequest $request, int $id): DetoxificationCategoryResource
    {
        $input = $request->all();
        $detoxificationCategory = $this->detoxificationCategoryRepository->update($input, $id);

        return new DetoxificationCategoryResource($detoxificationCategory);
    }

    /**
     * Delete given DetoxificationCategory.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->detoxificationCategoryRepository->delete($id);

        return $this->successResponse('DetoxificationCategory deleted successfully.');
    }

    /**
     * Bulk create DetoxificationCategory's.
     *
     * @param BulkCreateDetoxificationCategoryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DetoxificationCategoryCollection
     */
    public function bulkStore(BulkCreateDetoxificationCategoryAPIRequest $request): DetoxificationCategoryCollection
    {
        $detoxificationCategories = collect();

        $input = $request->get('data');
        foreach ($input as $key => $detoxificationCategoryInput) {
            $detoxificationCategories[$key] = $this->detoxificationCategoryRepository->create($detoxificationCategoryInput);
        }

        return new DetoxificationCategoryCollection($detoxificationCategories);
    }

    /**
     * Bulk update DetoxificationCategory's data.
     *
     * @param BulkUpdateDetoxificationCategoryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return DetoxificationCategoryCollection
     */
    public function bulkUpdate(BulkUpdateDetoxificationCategoryAPIRequest $request): DetoxificationCategoryCollection
    {
        $detoxificationCategories = collect();

        $input = $request->get('data');
        foreach ($input as $key => $detoxificationCategoryInput) {
            $detoxificationCategories[$key] = $this->detoxificationCategoryRepository->update($detoxificationCategoryInput, $detoxificationCategoryInput['id']);
        }

        return new DetoxificationCategoryCollection($detoxificationCategories);
    }
}
