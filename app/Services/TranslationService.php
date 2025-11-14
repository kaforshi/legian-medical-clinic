<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    /**
     * Translate text from Indonesian to English
     * Using Google Translate API (free tier via unofficial method)
     * 
     * @param string $text
     * @return string
     */
    public function translateToEnglish(string $text): string
    {
        if (empty(trim($text))) {
            return $text;
        }

        // Remove HTML tags for translation, we'll add them back if needed
        $plainText = strip_tags($text);
        if (empty(trim($plainText))) {
            return $text; // If only HTML tags, return as is
        }

        try {
            // Add small delay to avoid rate limiting
            usleep(300000); // 0.3 second delay
            
            // Method 1: Try Google Translate API (free unofficial endpoint)
            $url = 'https://translate.googleapis.com/translate_a/single?' . http_build_query([
                'client' => 'gtx',
                'sl' => 'id',
                'tl' => 'en',
                'dt' => 't',
                'q' => $plainText
            ]);
            
            $response = Http::timeout(15)
                ->withoutVerifying() // Skip SSL verification for development
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => '*/*',
                    'Referer' => 'https://translate.google.com/'
                ])
                ->get($url);

            if ($response->successful()) {
                $body = $response->body();
                $result = json_decode($body, true);
                
                Log::debug('Translation API response', [
                    'status' => $response->status(),
                    'body_preview' => substr($body, 0, 200),
                    'result' => $result
                ]);
                
                // Handle response format: [[["translated text",...],...],...]
                if (isset($result[0]) && is_array($result[0])) {
                    $translated = '';
                    foreach ($result[0] as $segment) {
                        if (isset($segment[0]) && is_string($segment[0])) {
                            $translated .= $segment[0];
                        }
                    }
                    $translated = trim($translated);
                    if (!empty($translated) && $translated !== $plainText) {
                        Log::info('Translation successful', [
                            'original' => substr($plainText, 0, 50),
                            'translated' => substr($translated, 0, 50)
                        ]);
                        return $translated;
                    }
                }
            } else {
                Log::warning('Translation API failed', [
                    'status' => $response->status(),
                    'body' => substr($response->body(), 0, 200)
                ]);
            }

            // Method 2: Try MyMemory Translation API (free alternative)
            usleep(300000);
            $response2 = Http::timeout(15)
                ->withoutVerifying() // Skip SSL verification for development
                ->get('https://api.mymemory.translated.net/get', [
                    'q' => $plainText,
                    'langpair' => 'id|en'
                ]);

            if ($response2->successful()) {
                $result = $response2->json();
                if (isset($result['responseData']['translatedText'])) {
                    $translated = $result['responseData']['translatedText'];
                    if (!empty(trim($translated)) && $translated !== $plainText) {
                        Log::info('Translation successful (MyMemory)', [
                            'original' => substr($plainText, 0, 50),
                            'translated' => substr($translated, 0, 50)
                        ]);
                        return $translated;
                    }
                }
            }

        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage(), [
                'text' => substr($plainText, 0, 100),
                'trace' => $e->getTraceAsString()
            ]);
        }

        // Fallback: return original text if translation fails
        Log::warning('Translation failed, using original text', [
            'text' => substr($plainText, 0, 50)
        ]);
        return $text;
    }

    /**
     * Translate multiple texts at once
     * 
     * @param array $texts
     * @return array
     */
    public function translateMultiple(array $texts): array
    {
        $translated = [];
        foreach ($texts as $key => $text) {
            $translated[$key] = $this->translateToEnglish($text);
        }
        return $translated;
    }
}

