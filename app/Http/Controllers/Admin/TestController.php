<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateTestAPIRequest;
use App\Http\Requests\Device\BulkUpdateTestAPIRequest;
use App\Http\Requests\Device\CreateTestAPIRequest;
use App\Http\Requests\Device\UpdateTestAPIRequest;
use App\Http\Resources\Device\TestCollection;
use App\Http\Resources\Device\TestResource;
use App\Repositories\TestRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class TestController extends AppBaseController
{
    /**
     * @var TestRepository
     */
    private TestRepository $testRepository;

    /**
     * @param TestRepository $testRepository
     */
    public function __construct(TestRepository $testRepository)
    {
        $this->testRepository = $testRepository;
    }

    /**
     * Test's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return TestCollection
     */
    public function index(Request $request): TestCollection
    {
        $tests = $this->testRepository->fetch($request);

        return new TestCollection($tests);
    }

    /**
     * Create Test with given payload.
     *
     * @param CreateTestAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return TestResource
     */
    public function store(CreateTestAPIRequest $request): TestResource
    {
        $input = $request->all();
        $test = $this->testRepository->create($input);

        return new TestResource($test);
    }

    /**
     * Get single Test record.
     *
     * @param int $id
     *
     * @return TestResource
     */
    public function show(int $id): TestResource
    {
        $test = $this->testRepository->findOrFail($id);

        return new TestResource($test);
    }

    /**
     * Update Test with given payload.
     *
     * @param UpdateTestAPIRequest $request
     * @param int                  $id
     *
     * @throws ValidatorException
     *
     * @return TestResource
     */
    public function update(UpdateTestAPIRequest $request, int $id): TestResource
    {
        $input = $request->all();
        $test = $this->testRepository->update($input, $id);

        return new TestResource($test);
    }

    /**
     * Delete given Test.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->testRepository->delete($id);

        return $this->successResponse('Test deleted successfully.');
    }

    /**
     * Bulk create Test's.
     *
     * @param BulkCreateTestAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return TestCollection
     */
    public function bulkStore(BulkCreateTestAPIRequest $request): TestCollection
    {
        $tests = collect();

        $input = $request->get('data');
        foreach ($input as $key => $testInput) {
            $tests[$key] = $this->testRepository->create($testInput);
        }

        return new TestCollection($tests);
    }

    /**
     * Bulk update Test's data.
     *
     * @param BulkUpdateTestAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return TestCollection
     */
    public function bulkUpdate(BulkUpdateTestAPIRequest $request): TestCollection
    {
        $tests = collect();

        $input = $request->get('data');
        foreach ($input as $key => $testInput) {
            $tests[$key] = $this->testRepository->update($testInput, $testInput['id']);
        }

        return new TestCollection($tests);
    }
}