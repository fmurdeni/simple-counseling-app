<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Counseling;
use App\Models\Message;

use App\Services\SentimentAnalyzerService;

class CounselingController extends Controller
{
    public function index()
    {
        // Fetch all counselings from the database
        $per_page = 2;
        if (Auth::user()->hasRole('1')) {
            $counselings = Counseling::all();
            // $counselings = Counseling::paginate($per_page);
            $total = Counseling::count();

        } else {
            $counselings = Counseling::where('user_id', Auth::id())->get();
            $total = $counselings->count();
            // $counselings = $counselings->paginate($per_page);
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
        $sentimentAnalyzer = new SentimentAnalyzerService();
        $texts = $request->input('topic') . ' ' . $request->input('description');
        $sentiment = $sentimentAnalyzer->analyzeMessage($texts);
        

        $counseling = Counseling::create([
            'user_id' => auth()->id(),
            'topic' => $request->input('topic'),
            'description' => $request->input('description'),
            'time_preference' => $request->input('time_preference'),
            'status' => 'pending',
            'level' => $sentiment['urgency_level'],
            'emotion' => $sentiment['emotion'] ?? 'neutral',
        ]);
        
        // get all users has role 1 & send them the notification
        $users = Auth::user()->whereHas('roles', function ($query) {
            $query->where('name', '1');
        })->get();
        
        foreach ($users as $user) {
            $user->notify(new NewPendingCounseling($counseling));
        }
        
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
        $sentimentAnalyzer = new SentimentAnalyzerService();
        $texts = $request->input('topic') . ' ' . $request->input('description');
        $sentiment = $sentimentAnalyzer->analyzeMessage($texts);
        $counseling->level = $sentiment['urgency_level'];
        $counseling->emotion = $sentiment['emotion'];

        $counseling->save();

        return back()->with('success', 'Permintaan konseling berhasil diubah.');
       
    }

    public function destroy($id)
    {
        $counseling = Counseling::findOrFail($id);
        $counseling->delete();
        return redirect()->route('counselings.index')->with('success', 'Permintaan konseling berhasil dihapus.');
    }



    public function approve($id)
    {
        $counseling = Counseling::findOrFail($id);
        $counseling->status = 'approved';
        $counseling->save();

        return redirect()->back()->with('status', 'Konseling disetujui.');
    }

    public function reject($id)
    {
        $counseling = Counseling::findOrFail($id);
        $counseling->status = 'rejected';
        $counseling->save();

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

