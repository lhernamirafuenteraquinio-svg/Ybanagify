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
        $translated = 'Not found';
        $audio = null;

        if (!$input) {
            return response()->json([
                'translated' => '',
                'audio' => null
            ]);
        }

        switch ($direction) {
            case 'filipino_to_ybanag':
                $translation = Translation::where('filipino_word', $input)
                    ->where('is_visible', true) // ✅ only visible translations
                    ->first();
                if ($translation) {
                    $translated = $translation->ybanag_translation;
                    $audio = $translation->pronunciation_audio; // MP3 filename

                    // Log Ybanag word
                    if (!empty($translated)) {
                        TranslationLog::create([
                            'ybanag_translation' => $translated
                        ]);
                    }
                }
                break;

            case 'ybanag_to_filipino':
                $translation = Translation::where('ybanag_translation', $input)->first();
                if ($translation) {
                    $translated = $translation->filipino_word;
                    $audio = $translation->pronunciation_audio; // MP3 filename still used

                    // ✅ Log Ybanag word (always log the Ybanag side)
                    if (!empty($translation->ybanag_translation)) {
                        TranslationLog::create([
                            'ybanag_translation' => $translation->ybanag_translation
                        ]);
                    }
                }
                break;

            default:
                $translated = 'Invalid direction';
        }

        return response()->json([
            'translated' => $translated,
            'audio' => $audio
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

        // Determine the correct column based on direction
        switch ($direction) {
            case 'filipino_to_ybanag':
                $suggestions = Translation::where('filipino_word', 'like', $query . '%')
                    ->where('is_visible', true) // ✅ only visible translations
                    ->limit(5)
                    ->pluck('filipino_word');
                break;

            case 'ybanag_to_filipino':
                $suggestions = Translation::where('ybanag_translation', 'like', $query . '%')
                    ->where('is_visible', true) // ✅ only visible translations
                    ->limit(5)
                    ->pluck('ybanag_translation');
                break;

            default:
                $suggestions = collect([]);
        }

        return response()->json($suggestions);
    }
}
