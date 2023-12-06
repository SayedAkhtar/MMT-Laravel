<?php

use Illuminate\Support\Facades\Storage;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "ably", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ],
        ],

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

        'apn' => [
            'app_bundle_id' => env('APN_BUNDLE_ID'),
            'certificate_path' => env('APN_PRIVATE_KEY'),
            'certificate_secret' => env('APN_SECRET_KEY'),
            'production' => env('APN_PRODUCTION', false),

            // 'key_id' => env('APN_KEY_ID'),
            // 'team_id' => env('APN_TEAM_ID'),
            // 'app_bundle_id' => env('APN_BUNDLE_ID', ""),
            // 'private_key_content' => Storage::path('private/' . env('APN_PRIVATE_KEY', "")),
            // 'production' => env('APN_PRODUCTION', false),
        ],

    ],

];
