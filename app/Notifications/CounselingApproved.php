<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CounselingApproved extends Notification implements ShouldQueue
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
        
        Log::info('Notifikasi CounselingApproved masuk queue');
        return (new MailMessage)
                    ->subject('Permintaan Konseling Disetujui '.now()->format('d-m-Y H:i:s'))
                    ->line('Permintaan konseling Anda telah disetujui.')
                    ->action('Lihat Detail', url('/admin/counselings/'.$this->counseling->id))
                    ->line('Sekarang anda dapat mengakses konseling, dan memulai sesi.');
    }
}
