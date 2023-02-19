<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateTagsAPIRequest;
use App\Http\Requests\Device\BulkUpdateTagsAPIRequest;
use App\Http\Requests\Device\CreateTagsAPIRequest;
use App\Http\Requests\Device\UpdateTagsAPIRequest;
use App\Http\Resources\Device\TagsCollection;
use App\Http\Resources\Device\TagsResource;
use App\Repositories\TagsRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class TagsController extends AppBaseController
{
    /**
     * @var TagsRepository
     */
    private TagsRepository $tagsRepository;

    /**
     * @param TagsRepository $tagsRepository
     */
    public function __construct(TagsRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * Tags's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return TagsCollection
     */
    public function index(Request $request): TagsCollection
    {
        $tags = $this->tagsRepository->fetch($request);

        return new TagsCollection($tags);
    }

    /**
     * Create Tags with given payload.
     *
     * @param CreateTagsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return TagsResource
     */
    public function store(CreateTagsAPIRequest $request): TagsResource
    {
        $input = $request->all();
        $tags = $this->tagsRepository->create($input);

        return new TagsResource($tags);
    }

    /**
     * Get single Tags record.
     *
     * @param int $id
     *
     * @return TagsResource
     */
    public function show(int $id): TagsResource
    {
        $tags = $this->tagsRepository->findOrFail($id);

        return new TagsResource($tags);
    }

    /**
     * Update Tags with given payload.
     *
     * @param UpdateTagsAPIRequest $request
     * @param int                  $id
     *
     * @throws ValidatorException
     *
     * @return TagsResource
     */
    public function update(UpdateTagsAPIRequest $request, int $id): TagsResource
    {
        $input = $request->all();
        $tags = $this->tagsRepository->update($input, $id);

        return new TagsResource($tags);
    }

    /**
     * Delete given Tags.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->tagsRepository->delete($id);

        return $this->successResponse('Tags deleted successfully.');
    }

    /**
     * Bulk create Tags's.
     *
     * @param BulkCreateTagsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return TagsCollection
     */
    public function bulkStore(BulkCreateTagsAPIRequest $request): TagsCollection
    {
        $tags = collect();

        $input = $request->get('data');
        foreach ($input as $key => $tagsInput) {
            $tags[$key] = $this->tagsRepository->create($tagsInput);
        }

        return new TagsCollection($tags);
    }

    /**
     * Bulk update Tags's data.
     *
     * @param BulkUpdateTagsAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return TagsCollection
     */
    public function bulkUpdate(BulkUpdateTagsAPIRequest $request): TagsCollection
    {
        $tags = collect();

        $input = $request->get('data');
        foreach ($input as $key => $tagsInput) {
            $tags[$key] = $this->tagsRepository->update($tagsInput, $tagsInput['id']);
        }

        return new TagsCollection($tags);
    }
}