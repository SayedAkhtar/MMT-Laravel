<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\BulkCreateQualificationAPIRequest;
use App\Http\Requests\Device\BulkUpdateQualificationAPIRequest;
use App\Http\Requests\Device\CreateQualificationAPIRequest;
use App\Http\Requests\Device\UpdateQualificationAPIRequest;
use App\Http\Resources\Device\QualificationCollection;
use App\Http\Resources\Device\QualificationResource;
use App\Repositories\QualificationRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class QualificationController extends AppBaseController
{
    /**
     * @var QualificationRepository
     */
    private QualificationRepository $qualificationRepository;

    /**
     * @param QualificationRepository $qualificationRepository
     */
    public function __construct(QualificationRepository $qualificationRepository)
    {
        $this->qualificationRepository = $qualificationRepository;
    }

    /**
     * Qualification's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return QualificationCollection
     */
    public function index(Request $request): QualificationCollection
    {
        $qualifications = $this->qualificationRepository->fetch($request);

        return new QualificationCollection($qualifications);
    }

    /**
     * Create Qualification with given payload.
     *
     * @param CreateQualificationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return QualificationResource
     */
    public function store(CreateQualificationAPIRequest $request): QualificationResource
    {
        $input = $request->all();
        $qualification = $this->qualificationRepository->create($input);

        return new QualificationResource($qualification);
    }

    /**
     * Get single Qualification record.
     *
     * @param int $id
     *
     * @return QualificationResource
     */
    public function show(int $id): QualificationResource
    {
        $qualification = $this->qualificationRepository->findOrFail($id);

        return new QualificationResource($qualification);
    }

    /**
     * Update Qualification with given payload.
     *
     * @param UpdateQualificationAPIRequest $request
     * @param int                           $id
     *
     * @throws ValidatorException
     *
     * @return QualificationResource
     */
    public function update(UpdateQualificationAPIRequest $request, int $id): QualificationResource
    {
        $input = $request->all();
        $qualification = $this->qualificationRepository->update($input, $id);

        return new QualificationResource($qualification);
    }

    /**
     * Delete given Qualification.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->qualificationRepository->delete($id);

        return $this->successResponse('Qualification deleted successfully.');
    }

    /**
     * Bulk create Qualification's.
     *
     * @param BulkCreateQualificationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return QualificationCollection
     */
    public function bulkStore(BulkCreateQualificationAPIRequest $request): QualificationCollection
    {
        $qualifications = collect();

        $input = $request->get('data');
        foreach ($input as $key => $qualificationInput) {
            $qualifications[$key] = $this->qualificationRepository->create($qualificationInput);
        }

        return new QualificationCollection($qualifications);
    }

    /**
     * Bulk update Qualification's data.
     *
     * @param BulkUpdateQualificationAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return QualificationCollection
     */
    public function bulkUpdate(BulkUpdateQualificationAPIRequest $request): QualificationCollection
    {
        $qualifications = collect();

        $input = $request->get('data');
        foreach ($input as $key => $qualificationInput) {
            $qualifications[$key] = $this->qualificationRepository->update($qualificationInput, $qualificationInput['id']);
        }

        return new QualificationCollection($qualifications);
    }
}