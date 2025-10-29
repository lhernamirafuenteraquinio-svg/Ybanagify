<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\Dictionary;
use App\Models\Translation;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $entries = Entry::where('filipino_word', 'like', "%{$query}%")
                        ->orWhere('ybanag_translation', 'like', "%{$query}%")
                        ->paginate(10, ['*'], 'entries_page');

        $dictionaries = Dictionary::where('filipino_word', 'like', "%{$query}%")
                                  ->orWhere('ybanag_translation', 'like', "%{$query}%")
                                  ->paginate(10, ['*'], 'dictionary_page');

        $translations = Translation::where('filipino_word', 'like', "%{$query}%")
                                   ->orWhere('ybanag_translation', 'like', "%{$query}%")
                                   ->paginate(10, ['*'], 'translations_page');

        return view('admin.search.results', compact('entries', 'dictionaries', 'translations', 'query'));
    }
}
