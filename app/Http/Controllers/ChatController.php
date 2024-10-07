<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Services\SentimentAnalyzerService;

class ChatController extends Controller
{
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        // Validate the input
        $validatedData = $request->validate([
            'message' => 'required|string|max:1000',
            'counseling_id' => 'required|integer|exists:counselings,id',
        ]);

        // Create and save the new message
        $message = new Message();
        $message->user_id = Auth::id();
        $message->message = $validatedData['message'];
        $message->counseling_id = $validatedData['counseling_id'];
        
        $sentimentAnalyzer = new SentimentAnalyzerService();        
        $sentiment = $sentimentAnalyzer->analyzeMessage($validatedData['message']);
        
        $message->emotion = $sentiment['emotion'];

        $message->save();

        // Return the response with success and the rendered HTML
        return response()->json(['success' => true]);
    }

    public function getMessages( Request $request) {
        $counseling_id = $request->input('counseling_id');
        $messages = Message::where('counseling_id', $counseling_id)->get();
        // return $messages;
        return view('components.message-items', ['messages' => $messages]);
    }

    
}
