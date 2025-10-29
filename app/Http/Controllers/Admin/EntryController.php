<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\Dictionary;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    /**
     * Display a listing of the entries (with search support).
     */
    public function index(Request $request)
    {
        $query = Entry::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('filipino_word', 'LIKE', "%{$search}%")
                  ->orWhere('ybanag_translation', 'LIKE', "%{$search}%")
                  ->orWhere('english_example_sentence', 'LIKE', "%{$search}%")
                  ->orWhere('filipino_example_sentence', 'LIKE', "%{$search}%")
                  ->orWhere('ybanag_example_sentence', 'LIKE', "%{$search}%");
        }

        $entries = $query->latest()->paginate(10);

        return view('admin.entries.index', compact('entries'));
    }

    /**
     * Store a newly created entry in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'filipino_word' => 'required|string|max:255',
            'ybanag_translation' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'pronunciation_audio' => 'nullable|mimes:mp3,wav,ogg|max:10240',
            'english_example_sentence' => 'nullable|string',
            'filipino_example_sentence' => 'nullable|string',
            'ybanag_example_sentence' => 'nullable|string',
        ]);

        $data = $request->all();

        // Upload audio if present
        if ($request->hasFile('pronunciation_audio')) {
            $data['pronunciation_audio'] = $request->file('pronunciation_audio')->store('audio', 'public');
        }

        DB::transaction(function() use ($data) {
            // Create main entry
            $entry = Entry::create($data);

            // Save to dictionary
            Dictionary::create([
                'filipino_word' => $data['filipino_word'],
                'ybanag_translation' => $data['ybanag_translation'],
                'pronunciation' => $data['pronunciation'] ?? null,
                'pronunciation_audio' => $data['pronunciation_audio'] ?? null,
                'english_example_sentence' => $data['english_example_sentence'] ?? null,
                'filipino_example_sentence' => $data['filipino_example_sentence'] ?? null,
                'ybanag_example_sentence' => $data['ybanag_example_sentence'] ?? null,
            ]);

            // Save to translations
            Translation::create([
                'filipino_word' => $data['filipino_word'],
                'ybanag_translation' => $data['ybanag_translation'],
                'pronunciation_audio' => $data['pronunciation_audio'] ?? null,
            ]);
        });

        return redirect()->route('admin.entries.index')->with('success', 'New entry added successfully!');
    }

    /**
     * Show the form for editing the specified entry.
     */
    public function edit($id)
    {
        $entry = Entry::findOrFail($id);
        return view('admin.entries.edit', compact('entry'));
    }

    /**
     * Update the specified entry in storage.
     */
    public function update(Request $request, $id)
    {
        $entry = Entry::findOrFail($id);

        $request->validate([
            'filipino_word' => 'required|string|max:255',
            'ybanag_translation' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'pronunciation_audio' => 'nullable|mimes:mp3,wav,ogg|max:10240',
            'english_example_sentence' => 'nullable|string',
            'filipino_example_sentence' => 'nullable|string',
            'ybanag_example_sentence' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('pronunciation_audio')) {
            $data['pronunciation_audio'] = $request->file('pronunciation_audio')->store('audio', 'public');
        }

        $originalFilipinoWord = $entry->filipino_word;

        DB::transaction(function() use ($entry, $data, $originalFilipinoWord) {
            // Update main entry
            $entry->update($data);

            // Update dictionary
            Dictionary::where('filipino_word', $originalFilipinoWord)
                      ->update([
                          'filipino_word' => $data['filipino_word'],
                          'ybanag_translation' => $data['ybanag_translation'],
                          'pronunciation' => $data['pronunciation'] ?? null,
                          'pronunciation_audio' => $data['pronunciation_audio'] ?? $entry->pronunciation_audio,
                          'english_example_sentence' => $data['english_example_sentence'] ?? null,
                          'filipino_example_sentence' => $data['filipino_example_sentence'] ?? null,
                          'ybanag_example_sentence' => $data['ybanag_example_sentence'] ?? null,
                      ]);

            // Update translations
            Translation::where('filipino_word', $originalFilipinoWord)
                       ->update([
                           'filipino_word' => $data['filipino_word'],
                           'ybanag_translation' => $data['ybanag_translation'],
                           'pronunciation_audio' => $data['pronunciation_audio'] ?? $entry->pronunciation_audio,
                       ]);
        });

        return redirect()->route('admin.entries.index')->with('success', 'Entry updated successfully!');
    }

    /**
     * Remove the specified entry from storage.
     */
    public function destroy($id)
    {
        $entry = Entry::findOrFail($id);

        DB::transaction(function() use ($entry) {
            Dictionary::where('filipino_word', $entry->filipino_word)->delete();
            Translation::where('filipino_word', $entry->filipino_word)->delete();
            $entry->delete();
        });

        return redirect()->route('admin.entries.index')->with('success', 'Entry deleted successfully!');
    }
}
