<?php 
namespace App\Services;

use Google\Cloud\Language\LanguageClient;
use Google\Cloud\Translate\V2\TranslateClient;

class TextAnalysisService
{
    protected $languageClient;
    protected $translation;


    public function __construct()
    {
        // Menginisialisasi LanguageClient menggunakan kredensial dari .env
        $this->languageClient = new LanguageClient([
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
            'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE_PATH'),
        ]);

        $this->translation = new TranslateClient([
            'key' => env('GOOGLE_CLOUD_KEY'),
        ]);

    }

    public function analyzeMessage($text)
    {
        // translate text
        $text = $this->translation->translate($text, [
            'target' => 'en'
        ]);

        $text = $text['text'];
        
        $response = $this->languageClient->analyzeSentiment($text);
        $sentiment = $response->sentiment();
        

        // Menentukan level urgensi
        $urgencyLevel = $this->determineUrgency($sentiment, $text);

        return [
            'urgency_level' => $urgencyLevel,            
            'score' => $sentiment,
            'sentiment' => $this->determineConclusion($sentiment),
            'text' => $text
        ];

    }

    private function determineUrgency($sentiment, $text = '') {
        $score = $sentiment['score'];
        $magnitude = $sentiment['magnitude'];
        $urgentKeywords = [ 'urgent', 'immediately', 'asap', 'emergency', 'critical', 'important',
            'soon', 'priority', 'necessary', 'instant', 'promptly', 'expeditiously', 'at once', 'straight away',
            'right away', 'without delay', 'forthwith', 'prompt', 'hasty', 'swift', 'fast', 'rapid', 'speedy', 'expeditious',
            'quick', 'brisk', 'hurried', 'precipitate', 'crucial', 'vital', 'essential', 'imperative', 'mandatory', 'compulsory',
            'required', 'needed', 'wanted', 'desired', 'demanded', 'requested', 'ordered', 'commanded', 'dictated',
            'instructed', 'directed', 'prescribed', 'decreed', 'ordained', 'legislated', 'enacted', 'passed', 'approved',
            'presented', 'offered', 'proffered', 'tendered'
        ];

        $reducedKeywords = [
            "aint", "arent", "cannot", "cant", "couldnt", "darent", "didnt", "doesnt",
            "ain't", "aren't", "can't", "couldn't", "daren't", "didn't", "doesn't",
            "dont", "hadnt", "hasnt", "havent", "isnt", "mightnt", "mustnt", "neither",
            "don't", "hadn't", "hasn't", "haven't", "isn't", "mightn't", "mustn't",
            "neednt", "needn't", "never", "none", "nope", "nor", "not", "nothing", "nowhere",
            "oughtnt", "shant", "shouldnt", "uhuh", "wasnt", "werent",
            "oughtn't", "shan't", "shouldn't", "uh-uh", "wasn't", "weren't",
            "without", "wont", "wouldnt", "won't", "wouldn't", "rarely", "seldom", "despite"
        ];

        $boostKeywords = [
            "absolutely", "amazingly", "awfully", "completely", "considerably", "decidedly", 
            "deeply", "effing","enormous", "enormously", "entirely", "especially", "exceptionally", 
            "extremely", "fabulously", "flipping", "flippin", "fricking", "frickin", "frigging", "friggin", 
            "fully", "fucking", "greatly", "hella", "highly", "hugely", "incredibly", "intensely", 
            "majorly", "more", "most", "particularly", "purely", "quite", "seemingly" , "really", 
            "remarkably", "so", "substantially", "thoroughly", "totally", "tremendous", "tremendously", 
            "uber", "unbelievably", "unusually", "utterly", "very", "almost", "barely", "hardly", "kinda", 
            "kindof", "kinda", "kind of", "kind of", "kind of", "kind of", "kind of", "kind of", "kind of"
        ];
        
        // Cek apakah ada kata kunci urgensi dalam teks
        foreach ($urgentKeywords as $keyword) {
            if (stripos($text, $keyword) !== false) {            
                $magnitude += 0.293;
            }

            // cek apakah ada kata kunci boost yang digabung bersama kata kunci urgensi
            foreach ($boostKeywords as $boostKeyword) {
                if (stripos($text, $boostKeyword . ' ' . $keyword) !== false) {
                    $magnitude += 0.293;
                }
            }
            
            // cek apakah ada kata kunci reduksi yang digabung bersama kata kunci urgensi
            foreach ($reducedKeywords as $reducedKeyword) {
                if (stripos($text, $reducedKeyword . ' ' . $keyword) !== false) {
                    $magnitude -= 0.293;
                }
            }
        }

        // urgensi
        if ( ($score <= -0.1 && $magnitude >= 0.3) || $magnitude >= 0.98) {
            $urgency = 'high';  // Skor sangat negatif dan ada kata kunci serta magnitude tinggi
        } elseif ( $magnitude > 0.5) {
            $urgency = 'medium';  // Skor negatif dan magnitude moderat
        } else {
            $urgency = 'low';  // Skor netral
        }
        return $urgency;
    }

    private function determineConclusion($sentiment)
    {   
        $score = $sentiment['score'];
        // Tentukan kesimpulan berdasarkan skor
        if ($score >= 0.4) {
            $conclusion = "positif";
        } elseif ($score < -0.2) {
            $conclusion = "negatif";
        } else {
            $conclusion = "netral";
        }

        return $conclusion;
    }
}
