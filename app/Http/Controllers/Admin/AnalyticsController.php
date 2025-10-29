<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Translation;
use App\Models\Dictionary;
use App\Models\VisitorLog;
use App\Models\Submission;
use App\Models\TranslationLog;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // ✅ Counts
        $translationCount = Translation::count();
        $dictionaryCount = Dictionary::count();
        $visitorLogCount = VisitorLog::count();
        $submissionPending = Submission::where('status', 'pending')->count();

        // ✅ Monthly visitors (for current year)
        $months = collect();
        $visitorData = collect();
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->startOfYear()->addMonths($i);
            $months->push($month->format('M'));
            $visitorData->push(
                VisitorLog::whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', $month->month)
                    ->count()
            );
        }

        // ✅ Top Ybanag words used (from TranslationLog)
        $topYbanagWords = TranslationLog::select('ybanag_translation', DB::raw('COUNT(*) as count'))
            ->groupBy('ybanag_translation')
            ->orderByDesc('count')
            ->take(10) // top 10
            ->get();

        $ybanagLabels = $topYbanagWords->pluck('ybanag_translation');
        $ybanagData = $topYbanagWords->pluck('count');


        // ✅ Submission status breakdown
        $submissionStatus = Submission::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // ✅ System overview - top stats
        return view('admin.analytics.index', compact(
            'translationCount',
            'dictionaryCount',
            'visitorLogCount',
            'submissionPending',
            'months',
            'visitorData',
            'submissionStatus',
            'ybanagLabels',
            'ybanagData'
        ));
    }
}
