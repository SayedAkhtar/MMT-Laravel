<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Apn\ApnVoipChannel;
use NotificationChannels\Apn\ApnVoipMessage;
use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\Payload;
use Pushok\Payload\Alert;

class IosCallNotification extends Notification
{
    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        // return [ApnVoipChannel::class];
        $customClient = new Client(AuthProvider\Token::create(config('broadcasting.connections.apn')));
        return $customClient;
    }

    public function toApnVoip($notifiable)
    {
        
        return ApnVoipMessage::create()
            ->badge(1);
    }
}
