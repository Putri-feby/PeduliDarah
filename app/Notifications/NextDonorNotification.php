<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NextDonorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $donationQueue;

    /**
     * Create a new notification instance.
     */
    public function __construct($queue)
    {
        $this->donationQueue = $queue;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Antrean Anda (' . $this->donationQueue->queue_number . ') akan segera dilayani.',
            'description' => 'Silakan bersiap dan menunggu di depan ruang donor darah.',
            'queue_number' => $this->donationQueue->queue_number,
            'schedule_id' => $this->donationQueue->schedule_id,
        ];
    }
}
