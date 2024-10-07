<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SentimentAnalyzerService;

class SentimentAnalyzerController extends Controller
{
    protected $sentimentAnalyzer;

    public function __construct(SentimentAnalyzerService $sentimentAnalyzer)
    {
        $this->sentimentAnalyzer = $sentimentAnalyzer;
    }

    /**
     * Analyze the message provided in the request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function analyze(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Analyze the message
        $result = $this->sentimentAnalyzer->analyzeMessage($request->input('message'));

        return response()->json($result);
    }

    
}
