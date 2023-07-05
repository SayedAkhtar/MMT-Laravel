<?php

namespace App\Http\Controllers\API\Device;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreatePushNotificationAPIRequest;
use App\Repositories\PushNotificationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PushNotificationController extends AppBaseController
{
    /**
     * @var PushNotificationRepository
     */
    private PushNotificationRepository $pushNotificationRepository;

    /**
     * @param PushNotificationRepository $pushNotificationRepository
     */
    public function __construct(PushNotificationRepository $pushNotificationRepository)
    {
        $this->pushNotificationRepository = $pushNotificationRepository;
    }

    /**
     * Create PushNotification with given payload.
     *
     * @param CreatePushNotificationAPIRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreatePushNotificationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $this->pushNotificationRepository->create($input);

        return $this->successResponse('Device token created successfully.');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function removeDeviceId(Request $request): JsonResponse
    {
        $input = $request->all();

        $this->pushNotificationRepository->destroy($input);

        return $this->successResponse('Device token deleted successfully.');
    }
}
