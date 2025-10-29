<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dictionary;
use App\Models\Translation;
use App\Models\VisitorLog;
use App\Models\Feedback;

class DashboardController extends Controller
{
    public function index()
    {
        $translationCount = Translation::count();
        $dictionaryCount = Dictionary::count();
        $visitorLogCount = VisitorLog::count();
        $feedbackCount = Feedback::count();

        // Combine for total entries
        $totalEntries = $translationCount + $dictionaryCount;

        $latestTranslations = Translation::latest()->take(5)->get()->map(function ($item) {
            return [
                'filipino' => $item->filipino_word,
                'ybanag' => $item->ybanag_translation,
                'added_by' => 'Admin',
                'entry_type' => 'Translation',
                'created_at' => $item->created_at,
            ];
        });

        $latestDictionaries = Dictionary::latest()->take(5)->get()->map(function ($item) {
            return [
                'filipino' => $item->filipino_word,
                'ybanag' => $item->ybanag_translation,
                'added_by' => 'Admin',
                'entry_type' => 'Ybanag Word',
                'created_at' => $item->created_at,
            ];
        });

        // Combine and sort both
        $recentAdditions = $latestTranslations
            ->merge($latestDictionaries)
            ->sortByDesc('created_at')
            ->take(5);

        return view('admin.dashboard', compact(
            'translationCount', 
            'dictionaryCount', 
            'visitorLogCount',
            'feedbackCount',
            'totalEntries',
            'recentAdditions'
        ));
    }
}
