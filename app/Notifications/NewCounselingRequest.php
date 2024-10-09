<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCounselingRequest extends Notification implements ShouldQueue
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
        $urgent_level = $this->counseling->level;
        if ($urgent_level == 'medium') {
            $level = 'Sedang';
        } elseif ($urgent_level == 'high') {
            $level = 'Tinggi';
        } else {
            $level = 'Rendah';
        }

        Log::info('Notifikasi NewCounselingRequest masuk queue');
        
        return (new MailMessage)
                    ->subject('Permintaan Konseling Baru '.now()->format('d-m-Y H:i:s'))
                    ->line('Sebuah permintaan konseling baru telah diajukan dengan prioritas '.$level.'.')
                    ->action('Lihat Permintaan', url('/admin/counselings/'.$this->counseling->id))
                    ->line('Mohon tinjau dan ambil tindakan yang sesuai.');
    }
}

