<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent
{
    use Dispatchable, SerializesModels;

    public $sender;
    public $message;

    public function __construct($sender, $message)
    {
        $this->sender = $sender;
        $this->message = $message;
    }
}

