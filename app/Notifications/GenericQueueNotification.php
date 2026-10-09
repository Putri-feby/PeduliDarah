<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenericQueueNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $heading;

    public function __construct($message, $heading)
    {
        $this->message = $message;
        $this->heading = $heading;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->heading,
            'description' => $this->message,
        ];
    }
}
