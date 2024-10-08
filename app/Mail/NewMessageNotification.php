<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $message;

    public function __construct($sender, $message)
    {
        $this->sender = $sender;
        $this->message = $message;
    }

    public function build()
    {
        return $this->view('emails.new_message_notification')
                    ->with([
                        'senderName' => $this->sender->name,
                        'messageContent' => $this->message->content,
                    ]);
    }
}
