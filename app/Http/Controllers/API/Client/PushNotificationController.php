<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\CreatePushNotificationAPIRequest;
use App\Http\Resources\Client\UserResource;
use App\Models\User;
use App\Notifications\FirebaseNotification;
use App\Notifications\IosCallNotification;
use App\Repositories\PushNotificationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;

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
        $request->validate(['type' => 'required | string', 'uuid' => 'required|string', 'user_id' => 'sometimes', 'hcf_phone' => 'sometimes', 'from' => 'sometimes']);
        try {
            $user = Auth::user();
            $error_string = "";
            if ($user->user_type == '3') {
                $avatar = image_path($user->image);
            } else {
                $avatar = $user->patientDetails->hasMedia('avatar') ? $user->patientDetails->getMedia('avatar')->first()->getUrl() : '';
            }
            $trigger_type = $request->input('type') == 'disconnect' ? 'disconnect_call' : 'connect_call';

            // $user->update(['support_call_id' => $request->input('uuid')]);

            if (!empty($request->input('hcf_phone'))) {
                $hcf = User::where('phone', $request->input('hcf_phone'))
                    // ->whereNull('support_call_id')
                    ->first();
            } elseif (($request->input('from') == 'hcf') && $request->input('user_id')) {
                //This function makes calls to the patient app.
                $hcf = User::where('id', $request->input('user_id'))
                    ->first();
            } else {
                $hcf = User::with('languages')
                    ->whereHas('languages', function ($q) use ($user) {
                        $currentUser = $user->languages->first();
                        if (!empty($currentUser)) {
                            $q->where('language.id', $currentUser->id);
                        } else {
                            $defaultLanguageID = 1;
                            $q->where('language.id', $defaultLanguageID);
                        }
                    })
                    // ->whereNull('support_call_id')
                    ->where('firebase_token', '!=', null)
                    ->where('user_type', User::TYPE_HCF)->first();
            }

            if (empty($hcf)) {
                Log::debug("Request Body : " . json_encode($request->input()));
                return $this->errorResponse("HCF not available at the moment");
            }
            $hcf->update(['support_call_id' => $trigger_type == 'connect_call' ? $request->input('uuid') : null]);
            $token = $hcf->firebase_token;
            if ($hcf->device_type == 'ios') {

                $authProvider = AuthProvider\Certificate::create(config('broadcasting.connections.apn'));
                $alert = Alert::create()->setTitle('MMT HCF CALL');
                $alert = $alert->setBody('MMT Hcf Calling');


                $payload = Payload::create()->setPushType('voip')->setBadge(1);
                $payload->setCustomValue("id", $request->input('uuid'));
                $payload->setCustomValue("nameCaller", $user->name);
                $payload->setCustomValue("handle", $user->phone);
                $payload->setCustomValue("isVideo", false);
                $payload->setCustomValue('trigger_type', $trigger_type);
                $payload->setCustomValue('isCustomNotification', false);

                $deviceTokens = [$hcf->voip_apn_token];
                $notifications = [];
                foreach ($deviceTokens as $deviceToken) {
                    $notifications[] = new Notification($payload, $deviceToken);
                }

                // If you have issues with ssl-verification, you can temporarily disable it. Please see attached note.
                // Disable ssl verification
                // $client = new Client($authProvider, $production = false, [CURLOPT_SSL_VERIFYPEER=>false] );
                $client = new Client($authProvider, $production = true);
                $client->addNotifications($notifications);



                $responses = $client->push(); // returns an array of ApnsResponseInterface (one Response per Notification)
                foreach ($responses as $response) {
                    // The device token
                    $response->getDeviceToken();
                    // A canonical UUID that is the unique ID for the notification. E.g. 123e4567-e89b-12d3-a456-4266554400a0
                    $response->getApnsId();

                    // Status code. E.g. 200 (Success), 410 (The device token is no longer active for the topic.)
                    if ($response->getStatusCode() != 200) {
                        $string = $response->getReasonPhrase();
                        $string .= " " . $response->getErrorReason();
                        $string .= " " . $response->getErrorDescription();
                        Log::error($string);
                        return $this->errorResponse("Could not place call. User has not activated call notifications.");
                    }
                    // E.g. The device token is no longer active for the topic.

                    // E.g. Unregistered

                    // E.g. The device token is inactive for the specified topic.

                    $response->get410Timestamp();
                }
                return $this->successResponse($hcf);
            }
            $messaging = app('firebase.messaging');
            $message = CloudMessage::withTarget('token', $token);
            if ($hcf->device_type != 'android') {
                $message = $message->withNotification(['title' => "Support Call", 'body' => 'This is a call notification for support from MMT Patient App']);
            }
            $message = $message->withData(['click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'screen' => 'call_screen', 'uuid' => $request->input('uuid'), 'patient_name' => $user->name, 'avatar' => $avatar, 'patient_phone' => $user->phone, 'trigger_type' => $trigger_type]);
            $config = AndroidConfig::fromArray([
                'priority' => 'high'
            ]);
            $message = $message->withAndroidConfig($config);
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
            $request->validate(['uuid' => 'sometimes|string', 'user_id' => 'sometimes']);
            $uuid = $request->input('uuid');
            $user_id = $request->input('user_id');
            $messaging = app('firebase.messaging');
            $users = [];
            if (!empty($uuid)) {
                $users = User::where('support_call_id', $uuid)->get();
            }
            if (!empty($user_id)) {
                $users = User::where('id', $user_id)->get();
            }

            foreach ($users as $user) {
                if ($user->device_type == 'ios') {
                    $authProvider = AuthProvider\Certificate::create(config('broadcasting.connections.apn'));
                    $alert = Alert::create()->setTitle('MMT HCF CALL');
                    $alert = $alert->setBody('MMT Hcf Calling');
                    $payload = Payload::create()->setPushType('voip')->setBadge(1);
                    $payload->setCustomValue("id", $request->input('uuid'));
                    $payload->setCustomValue("nameCaller", $user->name);
                    $payload->setCustomValue("handle", $user->phone);
                    $payload->setCustomValue("isVideo", false);
                    $payload->setCustomValue('trigger_type', "disconnect");
                    $payload->setCustomValue('isCustomNotification', false);

                    $deviceTokens = [$user->voip_apn_token];
                    $notifications = [];
                    foreach ($deviceTokens as $deviceToken) {
                        $notifications[] = new Notification($payload, $deviceToken);
                    }
                    $client = new Client($authProvider, $production = true);
                    $client->addNotifications($notifications);
                    $responses = $client->push(); // returns an array of ApnsResponseInterface (one Response per Notification)
                    foreach ($responses as $response) {
                        // The device token
                        $response->getDeviceToken();
                        // A canonical UUID that is the unique ID for the notification. E.g. 123e4567-e89b-12d3-a456-4266554400a0
                        $response->getApnsId();

                        // Status code. E.g. 200 (Success), 410 (The device token is no longer active for the topic.)
                        if ($response->getStatusCode() != 200) {
                            $string = $response->getReasonPhrase();
                            $string .= " " . $response->getErrorReason();
                            $string .= " " . $response->getErrorDescription();
                            Log::error($string);
                            return $this->errorResponse("Could not place call. User has not activated call notifications.");
                        }
                        // E.g. The device token is no longer active for the topic.

                        // E.g. Unregistered

                        // E.g. The device token is inactive for the specified topic.

                        $response->get410Timestamp();
                    }
                }
                if ($user->device_type == 'android') {
                    $token = $user->firebase_token;
                    $message = CloudMessage::withTarget('token', $token);
                    $message = $message->withData(['click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'uuid' => $request->input('uuid'), 'trigger_type' => 'disconnect']);
                    $config = AndroidConfig::fromArray([
                        'priority' => 'high'
                    ]);
                    $message = $message->withAndroidConfig($config);
                    $messaging->send($message);
                }
            }
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse("Could not place call");
        }
    }
}
