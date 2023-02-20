<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateQueryAPIRequest;
use App\Http\Requests\Device\BulkUpdateQueryAPIRequest;
use App\Http\Requests\Device\CreateQueryAPIRequest;
use App\Http\Requests\Device\UpdateQueryAPIRequest;
use App\Http\Resources\Device\QueryCollection;
use App\Http\Resources\Device\QueryResource;
use App\Models\Query;
use App\Repositories\QueryRepository;
use App\Traits\isViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

class QueryController extends AppBaseController
{
    use isViewModule;
    protected $module;
    /**
     * @var QueryRepository
     */
    private QueryRepository $queryRepository;

    /**
     * @param QueryRepository $queryRepository
     */
    public function __construct(QueryRepository $queryRepository)
    {
        $this->queryRepository = $queryRepository;
        $this->module = 'module/queries';
    }

    /**
     * Query's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $queries = $this->queryRepository->fetch($request);
        return $this->module_view('/list', compact('queries'));
    }

    /**
     * Create Query with given payload.
     *
     * @param CreateQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return QueryResource
     */
    public function store(CreateQueryAPIRequest $request): QueryResource
    {
        $input = $request->all();
        $query = $this->queryRepository->create($input);

        return new QueryResource($query);
    }

    /**
     * Get single Query record.
     *
     * @param int $id
     *
     */
    public function show(Request $request, int $id)
    {
        $query = $this->queryRepository->findOrFail($id);
        $tab = $request->get('tab') ?? 'details';
        $afterOpenQuery = ['upload-medical-visa','upload-ticket', 'coordinator'];
        if(in_array($tab, $afterOpenQuery) && (empty($query->activeQuery) && empty($query->activeQuery->doctor_response))){
            return back()->with('error', "Please upload doctor's review before proceeding");
        }
        return $this->module_view('queries-layout', compact('query', 'tab'));
    }

    /**
     * Update Query with given payload.
     *
     * @param UpdateQueryAPIRequest $request
     * @param int                   $id
     *
     * @throws ValidatorException
     *
     * @return QueryResource
     */
    public function update(UpdateQueryAPIRequest $request, int $id): QueryResource
    {
        $input = $request->all();
        $query = $this->queryRepository->update($input, $id);

        return new QueryResource($query);
    }

    /**
     * Delete given Query.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->queryRepository->delete($id);

        return $this->successResponse('Query deleted successfully.');
    }

    /**
     * Bulk create Query's.
     *
     * @param BulkCreateQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return QueryCollection
     */
    public function bulkStore(BulkCreateQueryAPIRequest $request): QueryCollection
    {
        $queries = collect();

        $input = $request->get('data');
        foreach ($input as $key => $queryInput) {
            $queries[$key] = $this->queryRepository->create($queryInput);
        }

        return new QueryCollection($queries);
    }

    /**
     * Bulk update Query's data.
     *
     * @param BulkUpdateQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return QueryCollection
     */
    public function bulkUpdate(BulkUpdateQueryAPIRequest $request): QueryCollection
    {
        $queries = collect();

        $input = $request->get('data');
        foreach ($input as $key => $queryInput) {
            $queries[$key] = $this->queryRepository->update($queryInput, $queryInput['id']);
        }

        return new QueryCollection($queries);
    }
}