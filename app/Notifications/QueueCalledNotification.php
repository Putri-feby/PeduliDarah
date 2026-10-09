<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Queue;

class QueueCalledNotification extends Notification
{
    use Queueable;

    protected $donationQueue;

    /**
     * Create a new notification instance.
     */
    public function __construct(Queue $queue)
    {
        $this->donationQueue = $queue;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'queue_id' => $this->donationQueue->id,
            'queue_number' => $this->donationQueue->queue_number,
            'schedule_id' => $this->donationQueue->schedule_id,
            'message' => 'Giliran Anda telah tiba!',
            'description' => 'Silakan menunggu di ruang donor darah. Nomor antrean Anda: ' . $this->donationQueue->queue_number,
        ];
    }
}
