<?php

use App\Http\Controllers\AppBaseController;
use App\Repositories\SocialLoginRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Laravel\Socialite\Facades\Socialite;

/**
 * @param array $data
 *
 * @return  bool
 */
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

/**
 * @param  $provider
 *
 * @return  JsonResponse
 */
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

function image_path(string $path)
{
    if (\Illuminate\Support\Facades\URL::isValidUrl($path)) {
        return $path;
    } else {
        return \Illuminate\Support\Facades\Storage::url($path);
    }
}

function google_map_validate($iframe)
{
    return (preg_match('/<iframe\s*src="https:\/\/www\.google\.com\/maps\/embed\?[^"]+"*\s*[^>]+>*<\/iframe>/', $iframe)) ? true : false;
}
