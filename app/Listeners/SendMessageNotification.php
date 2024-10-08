<?php

namespace App\Listeners;

use App\Events\MessageSent;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Message;
use App\Models\Counseling;

class SendMessageNotification
{
    public function handle(MessageSent $event)
    {
        $sender = $event->sender;
        $message = $event->message;
        // get counseling
        $counseling_id = $message->counseling_id;
        $counseling = Counseling::find($counseling_id);
        $counseling_author_id = $counseling->user_id;
        $author_user = User::find($counseling_author_id);

        // Get users has role 1
        // Jika sender bukan Counseling Author
        $users = User::where('id', '!=', $counseling_author_id)->whereHas('roles', function ($query) use ($role_id) {
            $query->where('role_id', $role_id);
        })->get();


        // Jika sender adalah Counseling Author
        if ($sender->id == $counseling->user_id) {            
            // get users has role 1            
            foreach ($users as $user) {
                Mail::to($user->email)->send(new \App\Mail\NewMessageNotification($sender, $message));
            }
        } 

        if ($sender->hasRole(1)) {
            // Kirim email ke counseling author jika author bukan sender
            if ($author_user->id !== $counseling->user_id) {
                Mail::to($author_user->email)->send(new \App\Mail\NewMessageNotification($sender, $message));            
            }
            
            foreach ($users as $user) {
                Mail::to($user->email)->send(new \App\Mail\NewMessageNotification($sender, $message));
            }
        }
        
    }
}
