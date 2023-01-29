<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class SendSMSNotification extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param    mixed  $notifiable
     *
     * @return  array
     */
    public function via($notifiable): array
    {
        return ['nexmo'];
    }

    /**
     * @param  $notifiable
     *
     * @return  NexmoMessage
     */
    public function toNexmo($notifiable): NexmoMessage
    {
        $code = $notifiable->reset_password_code;
        $link = URL::to('reset-password/'.$code);

        return (new NexmoMessage)
            ->content(html_entity_decode(view('sms.password_reset', compact('link'))));
    }
}
