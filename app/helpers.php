<?php

use App\Http\Controllers\AppBaseController;
use App\Repositories\SocialLoginRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Laravel\Socialite\Facades\Socialite;

/**
 * @param array $data
 *
 * @return  bool
 */
if (!function_exists('sendPushNotification')) {
    function sendPushNotification(array $data): bool
    {
        $messaging = app('firebase.messaging');

        $notification = Notification::fromArray([
            'title' => $data['title'],
            'body' => $data['content'],
            'data' => [
                'id' => $data['id'],
                'title' => $data['title'],
                'content' => $data['content'],
                'push_notification_settings' => [],
            ]
        ]);

        foreach ($data['device_ids'] as $token) {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification);
            $messaging->send($message);
        }

        return true;
    }
}

/**
 * @param  $provider
 *
 * @return  JsonResponse
 */
if (!function_exists('socialLogin')) {
    function socialLogin($provider): JsonResponse
    {
        $driver = Socialite::driver($provider)->user();

        /** @var  SocialLoginRepository $repo */
        $repo = App::make(SocialLoginRepository::class);
        $data = $repo->socialLogin($provider, $driver->user);

        /** @var  AppBaseController $controller */
        $controller = App::make(AppBaseController::class);

        return $controller->loginSuccess($data);
    }
}

if (!function_exists('image_path')) {
    function image_path(string $path, bool $absolute = false)
    {
        if (\Illuminate\Support\Facades\URL::isValidUrl($path)) {
            return $path;
        } else {
            $imgPath = \Illuminate\Support\Facades\Storage::url($path);
            if ($absolute) {
                return \Illuminate\Support\Facades\URL::to($imgPath);
            }
            return $imgPath;
        }
    }
}


if (!function_exists('google_map_validate')) {
    function google_map_validate($iframe)
    {
        return (preg_match('/<iframe\s*src="https:\/\/www\.google\.com\/maps\/embed\?[^"]+"*\s*[^>]+>*<\/iframe>/', $iframe)) ? true : false;
    }
}


if (!function_exists('sendMsg91OTP')) {
    function sendMsg91OTP($mobile, $code)
    {
        $client = new \GuzzleHttp\Client();
        $url = "https://control.msg91.com/api/v5/otp?template_id=648ae47fd6fc057a7101bb53&mobile=$mobile&otp=$code";
        try {
            $response = $client->request('POST', $url, [
                'headers' => [
                    'accept' => 'application/json',
                    'authkey' => config('services.msg91'),
                    'content-type' => 'application/json',
                ],
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return "failed";
        }

        return json_decode($response->getBody(), true)['type'];
    }
}
