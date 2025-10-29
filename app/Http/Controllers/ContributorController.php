<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;

class ContributorController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'filipino_word' => 'required|string|max:255',
            'ybanag_translation' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
            'pronunciation_audio' => 'nullable|file|mimes:mp3,wav|max:10240', 
            'english_example_sentence' => 'nullable|string',
            'filipino_example_sentence' => 'nullable|string',
            'ybanag_example_sentence' => 'nullable|string',
            'submitted_by' => 'nullable|string|max:255',
            'submitted_email' => 'nullable|email|max:255',
        ]);

        if ($request->hasFile('pronunciation_audio')) {
            $file = $request->file('pronunciation_audio');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/audio', $filename);
            $validated['pronunciation_audio'] = $filename;
        }

        $submission = new Submission($validated);
        $submission->submitted_ip = $request->ip();
        $submission->user_agent = $request->header('User-Agent');
        $submission->save();

        return redirect()->back()->with('success', 'Thank you for your submission! It will be reviewed by the admin before approval.');
    }
}
