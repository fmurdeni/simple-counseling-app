<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPendingCounseling extends Notification implements ShouldQueue
{
    use Queueable;

    protected $counseling;

    public function __construct($counseling)
    {
        $this->counseling = $counseling;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Halo!')
            ->line('Sebuah konseling baru telah dibuat dan saat ini sedang menunggu.')
            ->line('Detail:')
            ->line('ID: ' . $this->counseling->id)
            ->line('Dibuat Pada: ' . $this->counseling->created_at)
            ->action('Lihat Konseling', url('/counselings/' . $this->counseling->id))
            ->line('Terima kasih!');
    }
}
