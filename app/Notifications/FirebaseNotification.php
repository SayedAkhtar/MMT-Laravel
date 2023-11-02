<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\FcmChannel;

class FirebaseNotification extends Notification
{
    use Queueable;
    protected $title;
    protected $body;
    protected $image;
    protected array $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(String $title, String $body, String $image = "", array $data = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->image = $image;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toFcm($notifiable)
    {
        $notification = \NotificationChannels\Fcm\Resources\Notification::create()
            ->setTitle($this->title)
            ->setBody($this->body);
        if(!empty($this->image)){
            $notification = $notification->setImage($this->image);
        }
        if(!empty($this->data)){
            
            return FcmMessage::create()->setData($this->data)->setNotification($notification);
        }else{
            return FcmMessage::create()->setNotification($notification);
        }
        
    }
}
