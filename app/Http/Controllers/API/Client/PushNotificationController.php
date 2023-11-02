<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\CreatePushNotificationAPIRequest;
use App\Http\Resources\Client\UserResource;
use App\Models\User;
use App\Notifications\FirebaseNotification;
use App\Repositories\PushNotificationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;

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

    public function callHcf(Request $request)
    {
        try {
            $request->validate(['type' => 'required | string', 'uuid' => 'required|string', 'user_id' => 'sometimes', 'hcf_phone' => 'sometimes']);
            $user = Auth::user();
            $trigger_type = $request->input('type') == 'disconnect' ? 'disconnect_call' : 'connect_call';

            $user->update(['support_call_id' => $request->input('uuid')]);
            $avatar = $user->patientDetails->hasMedia('avatar') ? $user->patientDetails->getMedia('avatar')->first()->getUrl() : '';

            if (!empty($request->input('hcf_phone'))) {
                $hcf = User::where('phone', $request->input('phone'))
                            // ->whereNull('support_call_id')
                            ->first();
            } 
            elseif($request->input('user_id')){
                $hcf = User::where('id', $request->input('user_id'))
                            ->first();
            }
            else {
                $hcf = User::with('languages')
                    ->whereHas('languages', function ($q) use ($user) {
                        $q->where('language.id', $user->languages->first()->id);
                    })
                    // ->whereNull('support_call_id')
                    ->where('firebase_token', '!=', null)
                    ->where('user_type', User::TYPE_HCF)->first();
            }

            if (empty($hcf)) {
                Log::debug("Request Body : ".json_encode($request->input()));
                return $this->errorResponse("HCF not available at the moment");
            }
            $hcf->update(['support_call_id' => $trigger_type == 'connect_call' ? $request->input('uuid') : null]);
            $token = $hcf->firebase_token;
            $messaging = app('firebase.messaging');
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification(['title' => "Support Call", 'body' => 'This is a call notification for support from MMT Patient App'])
                ->withData(['click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'screen' => 'call_screen', 'uuid' => $request->input('uuid'), 'patient_name' => $user->name, 'avatar' => $avatar, 'patient_phone' => $user->phone, 'trigger_type' => $trigger_type]);
            $messaging->send($message);
            return $this->successResponse($hcf);

        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse("Could not place call");
        }
    }

    public function disconnectCall(Request $request)
    {
        try {
            $request->validate(['uuid' => 'required|string', 'user_id' => 'sometimes']);
            $user = Auth::user();
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse("Could not place call");
        }
    }
}
