<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SentimentAnalyzerService;
use App\Services\TextAnalysisService;

use Google\Cloud\Translate\V2\TranslateClient;

class SentimentAnalyzerController extends Controller
{
    protected $sentimentAnalyzer;
    protected $translation;


    public function __construct(TextAnalysisService $sentimentAnalyzer)
    {
        $this->sentimentAnalyzer = $sentimentAnalyzer;
        $this->translation = new TranslateClient([
            'key' => env('GOOGLE_CLOUD_KEY'),
        ]);
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
        $text = $request->input('message');
        $text = $this->translation->translate($text, [
            'target' => 'en',
        ]);

        $text = $text['text'];

        $textAnalyzer = new TextAnalysisService();
        $result = $textAnalyzer->analyzeMessage($text);

        return response()->json($result);
    }

    
}
