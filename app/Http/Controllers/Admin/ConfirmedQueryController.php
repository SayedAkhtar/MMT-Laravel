<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateConfirmedQueryAPIRequest;
use App\Http\Requests\Device\BulkUpdateConfirmedQueryAPIRequest;
use App\Http\Requests\Device\CreateConfirmedQueryAPIRequest;
use App\Http\Requests\Device\UpdateConfirmedQueryAPIRequest;
use App\Http\Resources\Device\ConfirmedQueryCollection;
use App\Http\Resources\Device\ConfirmedQueryResource;
use App\Repositories\ConfirmedQueryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
use Twilio\TwiML\Voice\Redirect;

class ConfirmedQueryController extends AppBaseController
{
    /**
     * @var ConfirmedQueryRepository
     */
    private ConfirmedQueryRepository $confirmedQueryRepository;

    /**
     * @param ConfirmedQueryRepository $confirmedQueryRepository
     */
    public function __construct(ConfirmedQueryRepository $confirmedQueryRepository)
    {
        $this->confirmedQueryRepository = $confirmedQueryRepository;
    }

    /**
     * ConfirmedQuery's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return ConfirmedQueryCollection
     */
    public function index(Request $request): ConfirmedQueryCollection
    {
        $confirmedQueries = $this->confirmedQueryRepository->fetch($request);

        return new ConfirmedQueryCollection($confirmedQueries);
    }

    /**
     * Create ConfirmedQuery with given payload.
     *
     * @param CreateConfirmedQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     */
    public function store(CreateConfirmedQueryAPIRequest $request)
    {
        $input = $request->all();
        $query = $this->confirmedQueryRepository->findWhere(['query_id' => $request->query_id])->first();
        if(empty($query)){
            $this->confirmedQueryRepository->create($input);
        }else{
            $input = array_filter($input, fn($value) => !is_null($value) && $value !== '');
            $result = $this->confirmedQueryRepository->update($input, $query->id);
        }
        return redirect()->back()->with('success', 'Details Updated');
    }

    /**
     * Get single ConfirmedQuery record.
     *
     * @param int $id
     *
     * @return ConfirmedQueryResource
     */
    public function show(int $id): ConfirmedQueryResource
    {
        $confirmedQuery = $this->confirmedQueryRepository->findOrFail($id);

        return new ConfirmedQueryResource($confirmedQuery);
    }

    /**
     * Update ConfirmedQuery with given payload.
     *
     * @param UpdateConfirmedQueryAPIRequest $request
     * @param int                            $id
     *
     * @throws ValidatorException
     *
     * @return ConfirmedQueryResource
     */
    public function update(UpdateConfirmedQueryAPIRequest $request, int $id): ConfirmedQueryResource
    {
        $input = $request->all();
        $confirmedQuery = $this->confirmedQueryRepository->update($input, $id);

        return new ConfirmedQueryResource($confirmedQuery);
    }

    /**
     * Delete given ConfirmedQuery.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->confirmedQueryRepository->delete($id);

        return $this->successResponse('ConfirmedQuery deleted successfully.');
    }

    /**
     * Bulk create ConfirmedQuery's.
     *
     * @param BulkCreateConfirmedQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return ConfirmedQueryCollection
     */
    public function bulkStore(BulkCreateConfirmedQueryAPIRequest $request): ConfirmedQueryCollection
    {
        $confirmedQueries = collect();

        $input = $request->get('data');
        foreach ($input as $key => $confirmedQueryInput) {
            $confirmedQueries[$key] = $this->confirmedQueryRepository->create($confirmedQueryInput);
        }

        return new ConfirmedQueryCollection($confirmedQueries);
    }

    /**
     * Bulk update ConfirmedQuery's data.
     *
     * @param BulkUpdateConfirmedQueryAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return ConfirmedQueryCollection
     */
    public function bulkUpdate(BulkUpdateConfirmedQueryAPIRequest $request): ConfirmedQueryCollection
    {
        $confirmedQueries = collect();

        $input = $request->get('data');
        foreach ($input as $key => $confirmedQueryInput) {
            $confirmedQueries[$key] = $this->confirmedQueryRepository->update($confirmedQueryInput, $confirmedQueryInput['id']);
        }

        return new ConfirmedQueryCollection($confirmedQueries);
    }
}