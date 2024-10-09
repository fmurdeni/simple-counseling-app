<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CounselingRejected extends Notification implements ShouldQueue
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
                    ->subject('Permintaan konseling Anda ditolak ' . now()->format('d-m-Y H:i:s'))
                    ->line('Dengan sangat menyesal, kami menginformasikan bahwa permintaan konseling Anda telah ditolak.')
                    ->action('Lihat Permintaan', url('/admin/counselings/'.$this->counseling->id))
                    ->line('Silakan edit atau ajukan permintaan konseling baru yang lebih baik.');
    }
}
