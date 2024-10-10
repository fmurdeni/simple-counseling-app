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
        $score = $sentiment['score'];
        $magnitude = $sentiment['magnitude'];

        // Menentukan level urgensi
        $urgencyLevel = $this->determineUrgency($score);

        return [
            'urgency_level' => $urgencyLevel,
            'emotion' => '',
            'score' => $sentiment,
            'sentimen' => $this->determineConclusion($score),
        ];

    }

    private function determineUrgency($score)
    {
        $score = $sentiment['score'];
    
        // Daftar kata kunci yang menunjukkan urgensi
         $urgentKeywords = [
            'harus', 'mati', 'saya butuh',
            'urgent', 'immediately', 'asap', 'emergency', 'critical', 
            'darurat', 'penting', 'kritis', 'mendesak',        
            'important', 'soon', 'priority', 'necessary', 
            'secepatnya', 'prioritas', 'segera', 'perlu', 'diperlukan',
        ];

        // Cek apakah ada kata kunci urgensi dalam teks
        $containsUrgentKeyword = false;
        foreach ($urgentKeywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                $containsUrgentKeyword = true;
                break;
            }
        }

        // Menentukan tingkat urgensi
        if ($containsUrgentKeyword && $score < -0.5) {
            return 'high';  // Skor sangat negatif dan ada kata kunci
        } elseif ($score < 0) {
            return 'medium';  // Skor negatif
        } elseif ($score > 0.5) {
            return 'low';  // Skor positif
        } else {
            return 'low';  // Skor netral
        }

    }

    private function determineConclusion($score)
    {
        // Tentukan kesimpulan berdasarkan skor
        if ($score >= 0.25) {
            $conclusion = "positif";
        } elseif ($score <= -0.25) {
            $conclusion = "negatif";
        } else {
            $conclusion = "netral";
        }

        return $conclusion;
    }
}
