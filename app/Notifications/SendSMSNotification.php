<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

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
        return [TwilioChannel::class];
    }

    /**
     * @param    mixed  $notifiable
     *
     * @return  TwilioSmsMessage
     */
    public function toTwilio($notifiable): TwilioSmsMessage
    {
        $code = $notifiable->reset_password_code;
        $link = URL::to('reset-password/'.$code);

        return (new TwilioSmsMessage())
            ->content(html_entity_decode(view('sms.password_reset', compact('link'))));
    }
}
