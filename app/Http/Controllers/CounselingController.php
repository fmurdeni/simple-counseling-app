<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Counseling;
use App\Models\Message;
use App\Models\User;

use App\Services\SentimentAnalyzerService;
use App\Services\TextAnalysisService;

use App\Notifications\NewCounselingRequest;
use App\Notifications\CounselingApproved;
use App\Notifications\CounselingRejected;


class CounselingController extends Controller
{
    public function index()
    {
        // Fetch all counselings from the database
        $per_page = 5;
        if (Auth::user()->hasRole('1')) {
            // $counselings = Counseling::all();
            $counselings = Counseling::orderBy('updated_at', 'desc')->paginate($per_page);
            $total = Counseling::count();

        } else {
            $counselings = Counseling::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->paginate($per_page);
            
        }

        // Return the view with counselings data
        return view('counselings.index', compact('counselings'));
    }

    public function create()
    {
        return view('counselings.create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'topic' => 'required',
            'time_preference' => 'required|in:morning,afternoon,evening',
        ]);

        // analize the description
        $sentimentAnalyzer = new TextAnalysisService();
        $texts = $request->input('topic') . '. ' . $request->input('description');
        $sentiment = $sentimentAnalyzer->analyzeMessage($texts);
        

        $counseling = Counseling::create([
            'user_id' => auth()->id(),
            'topic' => $request->input('topic'),
            'description' => $request->input('description'),
            'time_preference' => $request->input('time_preference'),
            'status' => 'pending',
            'level' => $sentiment['urgency_level'],
            'sentiment' => $sentiment['sentiment'],
        ]);
        
        
        // Get user has role 1
        $users = User::whereHas('roles', function ($query) {
            $query->where('role_id', '1');
        });

        $users->get()->each(function ($user) use ($counseling) {
            $user->notify(new NewCounselingRequest($counseling));
        });
        
        return redirect()->route('counselings.index')->with('success', 'Permintaan konseling berhasil dikirim.');
    }


    public function show($id)
    {
        $counseling = Counseling::findOrFail($id);
        $messages = Message::where('counseling_id', $counseling->id)->get();
        return view('counselings.show', compact('counseling', 'messages'));
    }

    public function edit($id)
    {
        $counseling = Counseling::findOrFail($id);
        return view('counselings.edit', compact('counseling'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'topic' => 'required',
            'time_preference' => 'required|in:morning,afternoon,evening',
        ]);

        $counseling = Counseling::findOrFail($id);
        $counseling->description = $request->input('description');
        $counseling->topic = $request->input('topic');
        $counseling->time_preference = $request->input('time_preference');

        // analize the description
        $sentimentAnalyzer = new TextAnalysisService();
        $texts = $request->input('topic') . '. ' . $request->input('description');
        $sentiment = $sentimentAnalyzer->analyzeMessage($texts);

        $counseling->level = $sentiment['urgency_level'];
        $counseling->sentiment = $sentiment['sentiment'];

        $counseling->save();

        return back()->with('success', 'Permintaan konseling berhasil diubah.');
       
    }

    public function destroy($id)
    {
        $counseling = Counseling::findOrFail($id);
        $counseling->delete();

        // Get all messages from the counseling
        $messages = Message::where('counseling_id', $id)->get();

        // Delete the messages
        foreach ($messages as $message) {
            $message->delete();
        }

        return redirect()->route('counselings.index')->with('success', 'Permintaan konseling berhasil dihapus.');
    }


    public function approve($id)
    {
        $counseling = Counseling::findOrFail($id);
        $counseling->status = 'approved';
        $counseling->save();

        $author = User::findOrFail($counseling->user_id);
        $author->notify(new CounselingApproved($counseling));

        return back()->with('success', 'Konseling disetujui.');

    }

    public function reject($id)
    {
        $counseling = Counseling::findOrFail($id);
        $counseling->status = 'rejected';
        $counseling->save();

        $author = User::findOrFail($counseling->user_id);
        $author->notify(new CounselingRejected($counseling));

        return redirect()->back()->with('status', 'Konseling ditolak.');
    }

    public function start($id)
    {
        $counseling = Counseling::findOrFail($id);
        $counseling->status = 'ongoing';
        $counseling->save();

        return redirect()->back()->with('status', 'Konseling dimulai.');
    }

    public function end($id)
    {
        $counseling = Counseling::findOrFail($id);
        $counseling->status = 'completed';
        $counseling->save();

        return redirect()->back()->with('status', 'Konseling selesai.');
    }

}

