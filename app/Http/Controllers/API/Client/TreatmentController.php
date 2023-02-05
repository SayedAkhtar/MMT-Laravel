<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateTreatmentAPIRequest;
use App\Http\Requests\Client\BulkUpdateTreatmentAPIRequest;
use App\Http\Requests\Client\CreateTreatmentAPIRequest;
use App\Http\Requests\Client\UpdateTreatmentAPIRequest;
use App\Http\Resources\Client\TreatmentCollection;
use App\Http\Resources\Client\TreatmentResource;
use App\Repositories\TreatmentRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class TreatmentController extends AppBaseController
{
    /**
     * @var TreatmentRepository
     */
    private TreatmentRepository $treatmentRepository;

    /**
     * @param TreatmentRepository $treatmentRepository
     */
    public function __construct(TreatmentRepository $treatmentRepository)
    {
        $this->treatmentRepository = $treatmentRepository;
    }

    /**
     * Treatment's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return TreatmentCollection
     */
    public function index(Request $request): TreatmentCollection
    {
        $treatments = $this->treatmentRepository->fetch($request);

        return new TreatmentCollection($treatments);
    }

    /**
     * Create Treatment with given payload.
     *
     * @param CreateTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return TreatmentResource
     */
    public function store(CreateTreatmentAPIRequest $request): TreatmentResource
    {
        $input = $request->all();
        $treatment = $this->treatmentRepository->create($input);

        return new TreatmentResource($treatment);
    }

    /**
     * Get single Treatment record.
     *
     * @param int $id
     *
     * @return TreatmentResource
     */
    public function show(int $id): TreatmentResource
    {
        $treatment = $this->treatmentRepository->findOrFail($id);

        return new TreatmentResource($treatment);
    }

    /**
     * Update Treatment with given payload.
     *
     * @param UpdateTreatmentAPIRequest $request
     * @param int                       $id
     *
     * @throws ValidatorException
     *
     * @return TreatmentResource
     */
    public function update(UpdateTreatmentAPIRequest $request, int $id): TreatmentResource
    {
        $input = $request->all();
        $treatment = $this->treatmentRepository->update($input, $id);

        return new TreatmentResource($treatment);
    }

    /**
     * Delete given Treatment.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->treatmentRepository->delete($id);

        return $this->successResponse('Treatment deleted successfully.');
    }

    /**
     * Bulk create Treatment's.
     *
     * @param BulkCreateTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return TreatmentCollection
     */
    public function bulkStore(BulkCreateTreatmentAPIRequest $request): TreatmentCollection
    {
        $treatments = collect();

        $input = $request->get('data');
        foreach ($input as $key => $treatmentInput) {
            $treatments[$key] = $this->treatmentRepository->create($treatmentInput);
        }

        return new TreatmentCollection($treatments);
    }

    /**
     * Bulk update Treatment's data.
     *
     * @param BulkUpdateTreatmentAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return TreatmentCollection
     */
    public function bulkUpdate(BulkUpdateTreatmentAPIRequest $request): TreatmentCollection
    {
        $treatments = collect();

        $input = $request->get('data');
        foreach ($input as $key => $treatmentInput) {
            $treatments[$key] = $this->treatmentRepository->update($treatmentInput, $treatmentInput['id']);
        }

        return new TreatmentCollection($treatments);
    }
}
