<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dictionary;
use App\Models\VisitorLog;

class DictionaryController extends Controller
{
    public function index(Request $request)
    {
        // Get search term and selected letter from request
        $search = $request->input('search');
        $letter = $request->input('letter');

        // Log the visit
        VisitorLog::create([
            'ip_address' => $request->ip(),
            'action' => 'dictionary',
            'user_agent' => $request->userAgent(),
        ]);
        
        // Query only visible dictionary entries
        $entries = Dictionary::query()
            ->where('is_visible', true) // ✅ Only show visible entries
            ->when($search, function ($query, $search) {
                return $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('filipino_word', 'like', "%$search%")
                             ->orWhere('ybanag_translation', 'like', "%$search%");
                });
            })
            ->when($letter, function ($query, $letter) {
                return $query->where('filipino_word', 'like', $letter . '%');
            })
            ->orderBy('filipino_word')
            ->get();

        // Return view with data
        return view('dictionary', compact('entries', 'search', 'letter'));
    }
}
