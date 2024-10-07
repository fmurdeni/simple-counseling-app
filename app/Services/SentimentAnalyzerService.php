<?php

namespace App\Services;

use Sentiment\Analyzer;

class SentimentAnalyzerService
{
    protected $analyzer;

    public function __construct()
    {
        // Initialize the sentiment analyzer
        $this->analyzer = new Analyzer();
    }

    /**
     * Analyze the message to determine its urgency level and emotional tone.
     *
     * @param string $message
     * @return array
     */
    public function analyzeMessage(string $message): array
    {
        // Analyze the sentiment of the message
        $sentiment = $this->analyzer->getSentiment($message);

        // Determine the urgency level based on custom logic
        $urgencyLevel = $this->detectUrgencyLevel($message);

        // Detect emotion using keywords or patterns
        $emotion = $this->detectEmotion($message, $sentiment);

        return [
            'sentiment' => $sentiment, // Sentiment result from analyzer
            'urgency_level' => $urgencyLevel, // low, medium, high
            'emotion' => $emotion, // Emotion string
        ];
    }

    /**
     * Custom function to detect urgency level based on the message.
     *
     * @param string $message
     * @return string
     */
    protected function detectUrgencyLevel(string $message): string
    {
        // Keywords associated with urgency
        $highUrgencyKeywords = [
            'urgent', 'immediately', 'asap', 'emergency', 'critical', 
            'darurat', 'penting', 'kritis', 'mendesak',
        ];
        $mediumUrgencyKeywords = [
            'important', 'soon', 'priority', 'necessary', 
            'secepatnya', 'prioritas', 'segera', 'perlu', 'diperlukan',
        ];
        
        // Check for high urgency keywords
        foreach ($highUrgencyKeywords as $keyword) {
            if (stripos($message, $keyword) !== false) {
                return 'high';
            }
        }

        // Check for medium urgency keywords
        foreach ($mediumUrgencyKeywords as $keyword) {
            if (stripos($message, $keyword) !== false) {
                return 'medium';
            }
        }

        // Default to low urgency
        return 'low';
    }

    /**
     * Custom function to detect emotion based on the message content.
     *
     * @param string $message
     * @param array $sentiment
     * @return string
     */
    protected function detectEmotion(string $message, array $sentiment): string
    {
        // Analyzing the sentiment score
        $negativeScore = $sentiment['negative'] ?? 0;
        $positiveScore = $sentiment['positive'] ?? 0;

        // Example emotion keywords
        $emotionKeywords = [
            'happy' => [
                'I am happy', 'I am joy', 'I am excited', 'I am delighted', 'I am thrilled', 
                'saya bahagia', 'saya gembira', 'saya senang', 'saya riang', 'saya suka'
            ],
            'sad' => [
                'I am sad', 'I am depressed', 'I am down', 'I am unhappy', 'I am sorrowful', 
                'saya sedih', 'saya kesal', 'saya kecewa', 'saya patah hati', 'saya lelah', 
                'terlalu berat', 'terluka'
            ],
            'interest' => [
                'I am interested', 'I am curious', 'I am intrigued', 'I am engaged', 
                'tertarik', 'penasaran', 'ingin tahu', 'terlibat', 'pengen', 'saya ingin', 'saya penasaran'
            ],
            'angry' => [
                'I am angry', 'I am mad', 'I am furious', 'I am upset', 'I am outraged', 
                'marah', 'kesal', 'geram', 'terganggu', 'ngamuk',
                'saya marah', 'saya kesal', 'saya geram', 'saya terganggu', 'saya ngamuk', 
                'saya murka', 'saya berang', 'saya emosi', 'saya jengkel', 'saya sakit hati', 
            ],
            'fear' => [
                'I am afraid', 'I am scared', 'I am fearful', 'I am terrified', 'I am worried', 
                'saya takut', 'khawatir', 'saya cemas', 'saya trauma', 'resah', 
                'ngeri', 'mengerikan', 'saya panik', 'saya terjebak', 'meresahkan'
            ],
            'surprise' => [
                'I am surprised', 'I am amazed', 'I am astonished', 'I am startled', 
                'saya terkejut', 'saya kaget', 'saya heran', 'saya tercengang', 'kejutan', 
                'wah', 'wow', 'kagum', 'terpukau', 'terkesima', 
            ],
            'disgust' => [
                'I am disgusted', 'I am repelled', 'I am sickened', 'saya jijik', 
                'muak', 'saya mual', 'terganggu', 'saya tersinggung', 'benci'
            ],
            'confused' => [
                'I am confused', 'I am puzzled', 'I am disoriented', 'I am perplexed', 
                'saya bingung', 'saya pusing', 'saya kebingungan', 'saya kekiri', 'saya kewalahan', 'ha?', '??', 'apa?', 
                'saya kurang paham', 'saya tidak begitu paham', 'saya agak bingung', 'saya agak pusing', 'saya agak kurang mengerti', 'saya agak tidak mengerti', 'saya agak tidak paham'
            ],
        ];

        // Initialize emotion score counters
        $emotionScores = array_fill_keys(array_keys($emotionKeywords), 0);

        // Count scores based on keyword matches
        foreach ($emotionKeywords as $emotion => $keywords) {
            foreach ($keywords as $keyword) {
                if (stripos($message, $keyword) !== false) {
                    // Increment the score for the matched emotion
                    $emotionScores[$emotion]++;
                }
            }
        }

        // Determine if there are any detected emotions
        $highestScore = max($emotionScores);
        if ($highestScore === 0) {
            return 'neutral'; // No emotions detected
        }

        // Determine the overall emotion based on the scores
        if ($negativeScore > $positiveScore) {
            // If negative score is dominant, check if 'sad' has the highest score
            if ($emotionScores['sad'] > 0) {
                return 'sad';
            }
            return 'angry'; // Default to angry if negative score is high
        }

        // Find the emotion with the highest score
        $dominantEmotion = array_keys($emotionScores, $highestScore);
        
        return !empty($dominantEmotion) ? $dominantEmotion[0] : 'neutral'; // Return the dominant emotion or neutral
    }
}
