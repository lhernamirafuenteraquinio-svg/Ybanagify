<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Translation;
use App\Models\TranslationLog;

class TranslationController extends Controller
{
    /**
     * Show the translation view.
     */
    public function index()
    {
        return view('translate');
    }

    /**
     * Handle AJAX translation request.
     */
    public function ajaxTranslate(Request $request)
    {
        $input = trim($request->input('text'));
        $direction = $request->input('direction');

        // Return empty if no input
        if (!$input) {
            return response()->json([
                'translated' => '',
                'audio' => null,
                'examples_fil' => [],
                'examples_yba' => []
            ]);
        }

        // Split input into words and punctuation
        preg_match_all('/\w+|[^\w\s]/u', $input, $matches);
        $tokens = $matches[0];

        $translatedTokens = [];
        $examples_fil = [];
        $examples_yba = [];
        $audio = null;

        foreach ($tokens as $token) {
            // Keep punctuation as is
            if (preg_match('/^[^\w]+$/u', $token)) {
                $translatedTokens[] = $token;
                continue;
            }

            $wordLower = mb_strtolower($token, 'UTF-8');
            $translatedWord = $token;

            // Lookup translation
            $translation = null;
            if ($direction === 'filipino_to_ybanag') {
                $translation = \App\Models\Translation::whereRaw('LOWER(filipino_word) = ?', [$wordLower])
                    ->where('is_visible', true)
                    ->first();
            } else {
                $translation = \App\Models\Translation::whereRaw('LOWER(ybanag_translation) = ?', [$wordLower])
                    ->where('is_visible', true)
                    ->first();
            }

            if ($translation) {
                // Set translated word
                if ($direction === 'filipino_to_ybanag') {
                    $translatedWord = $translation->ybanag_translation;
                    if ($translation->filipino_example_sentence) $examples_fil[$wordLower] = $translation->filipino_example_sentence;
                    if ($translation->ybanag_example_sentence) $examples_yba[mb_strtolower($translatedWord, 'UTF-8')] = $translation->ybanag_example_sentence;
                } else {
                    $translatedWord = $translation->filipino_word;
                    if ($translation->ybanag_example_sentence) $examples_yba[$wordLower] = $translation->ybanag_example_sentence;
                    if ($translation->filipino_example_sentence) $examples_fil[mb_strtolower($translatedWord, 'UTF-8')] = $translation->filipino_example_sentence;
                }

                // Set first available audio
                if (!$audio) {
                    $audio = $translation->pronunciation_audio ?? null;
                }

                // ✅ Log Ybanag translation
                TranslationLog::create([
                    'ybanag_translation' => $translation->ybanag_translation
                ]);
            }

            // Preserve original casing
            if (mb_strtoupper($token, 'UTF-8') === $token) {
                $translatedWord = mb_strtoupper($translatedWord, 'UTF-8');
            } elseif (mb_strtolower($token, 'UTF-8') === $token) {
                $translatedWord = mb_strtolower($translatedWord, 'UTF-8');
            } elseif (ucfirst(mb_strtolower($token, 'UTF-8')) === $token) {
                $translatedWord = ucfirst(mb_strtolower($translatedWord, 'UTF-8'));
            }

            $translatedTokens[] = $translatedWord;
        }

        // Combine tokens into final translated text
        $translated = preg_replace('/\s+/', ' ', implode(' ', $translatedTokens));

        return response()->json([
            'translated' => trim($translated),
            'audio' => $audio,
            'examples_fil' => $examples_fil,
            'examples_yba' => $examples_yba
        ]);
    }

    /**
     * Handle AJAX auto-suggestions for input.
     */
    public function ajaxSuggestions(Request $request)
    {
        $query = trim($request->input('query'));
        $direction = $request->input('direction');

        if (!$query) {
            return response()->json([]);
        }

        // Determine column to search
        switch ($direction) {
            case 'filipino_to_ybanag':
                $column = 'filipino_word';
                break;
            case 'ybanag_to_filipino':
                $column = 'ybanag_translation';
                break;
            default:
                return response()->json([]);
        }

        // Fetch suggestions
        $suggestions = Translation::where($column, 'like', $query . '%')
            ->where('is_visible', true)
            ->pluck($column)
            ->toArray();

        // ✅ Filter logic (server-side)
        $filtered = collect($suggestions)
            ->map(fn($word) => trim($word))
            ->filter(fn($word) => str_word_count($word) === 1) // one word only
            ->unique() // remove duplicates
            ->take(3)  // optional: limit to 5 suggestions
            ->values(); // reindex

        return response()->json($filtered);
    }
}