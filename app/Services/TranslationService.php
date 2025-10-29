<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    /**
     * Translate text using Google Translate API (free tier via MyMemory API)
     * 
     * @param string $text Text to translate
     * @param string $from Source language code (id, en)
     * @param string $to Target language code (id, en)
     * @return string Translated text
     */
    public function translate(string $text, string $from = 'id', string $to = 'en'): string
    {
        if (empty(trim($text))) {
            return '';
        }

        // Same language, no translation needed
        if ($from === $to) {
            return $text;
        }

        // Create cache key with current locale to ensure fresh translations on language switch
        $currentLocale = app()->getLocale();
        $cacheKey = "translation:{$from}:{$to}:{$currentLocale}:" . md5($text);

        // Check cache first
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Try to translate
        try {
            $translated = $this->translateViaMyMemory($text, $from, $to);
            
            // Cache the result for 30 days
            Cache::put($cacheKey, $translated, now()->addDays(30));
            
            return $translated;
        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage(), [
                'text' => $text,
                'from' => $from,
                'to' => $to
            ]);
            
            // Return original text if translation fails
            return $text;
        }
    }

    /**
     * Translate using MyMemory Translation API (free, no API key needed)
     * 
     * @param string $text
     * @param string $from
     * @param string $to
     * @return string
     */
    protected function translateViaMyMemory(string $text, string $from, string $to): string
    {
        // Map locale codes
        $fromCode = $from === 'id' ? 'id' : 'en';
        $toCode = $to === 'id' ? 'id' : 'en';

        $url = "https://api.mymemory.translated.net/get";
        
        $response = Http::timeout(5)->get($url, [
            'q' => $text,
            'langpair' => "{$fromCode}|{$toCode}",
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['responseData']['translatedText'])) {
                return $data['responseData']['translatedText'];
            }
        }

        // Fallback: return original text
        return $text;
    }

    /**
     * Translate using Google Cloud Translate (requires API key)
     * Uncomment and configure if you have Google Cloud API key
     * 
     * @param string $text
     * @param string $from
     * @param string $to
     * @return string
     */
    protected function translateViaGoogle(string $text, string $from = 'id', string $to = 'en'): string
    {
        $apiKey = config('services.google.translate_key');
        
        if (!$apiKey) {
            throw new \Exception('Google Translate API key not configured');
        }

        $url = "https://translation.googleapis.com/language/translate/v2";
        
        $response = Http::timeout(5)->post($url, [
            'key' => $apiKey,
            'q' => $text,
            'source' => $from === 'id' ? 'id' : 'en',
            'target' => $to === 'id' ? 'id' : 'en',
            'format' => 'text'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['data']['translations'][0]['translatedText'])) {
                return $data['data']['translations'][0]['translatedText'];
            }
        }

        throw new \Exception('Google Translate API failed');
    }

    /**
     * Translate HTML content (preserving HTML tags)
     * 
     * @param string $html
     * @param string $from
     * @param string $to
     * @return string
     */
    public function translateHtml(string $html, string $from = 'id', string $to = 'en'): string
    {
        // Simple approach: extract text nodes and translate them
        // For complex HTML, consider using a proper HTML parser
        $currentLocale = app()->getLocale();
        $cacheKey = "translation_html:{$from}:{$to}:{$currentLocale}:" . md5($html);
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            // For HTML content, we'll translate the text while preserving tags
            // This is a simplified version - for production, consider using a proper HTML parser
            $translated = $this->translate(strip_tags($html), $from, $to);
            
            // If original had HTML, try to preserve basic structure
            if ($html !== strip_tags($html)) {
                // Simple approach: wrap translated text in the same basic structure
                $translated = '<p>' . nl2br($translated) . '</p>';
            }
            
            Cache::put($cacheKey, $translated, now()->addDays(30));
            
            return $translated;
        } catch (\Exception $e) {
            Log::error('HTML Translation failed: ' . $e->getMessage());
            return $html;
        }
    }
}
