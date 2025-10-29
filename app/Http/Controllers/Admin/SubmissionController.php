<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Entry;
use App\Models\Dictionary;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.submissions.index', compact('submissions'));
    }

    public function approve($id)
    {
        $submission = Submission::findOrFail($id);

        DB::transaction(function () use ($submission) {
            
            // ✅ Automatically add to Entry table
            Entry::create([
                'filipino_word' => $submission->filipino_word,
                'ybanag_translation' => $submission->ybanag_translation,
                'pronunciation' => $submission->pronunciation,
                'english_example_sentence' => $submission->english_example_sentence,
                'filipino_example_sentence' => $submission->filipino_example_sentence,
                'ybanag_example_sentence' => $submission->ybanag_example_sentence,
                'filipino_word' => $submission->filipino_word,
                'ybanag_translation' => $submission->ybanag_translation,
                'pronunciation_audio' => $submission->pronunciation_audio ? 'audio/' . $submission->pronunciation_audio : null,
            ]);
            
            // ✅ Automatically add to Dictionary table
            Dictionary::create([
                'filipino_word' => $submission->filipino_word,
                'ybanag_translation' => $submission->ybanag_translation,
                'pronunciation' => $submission->pronunciation,
                'english_example_sentence' => $submission->english_example_sentence,
                'filipino_example_sentence' => $submission->filipino_example_sentence,
                'ybanag_example_sentence' => $submission->ybanag_example_sentence,
            ]);

            // ✅ Automatically add to Translation table
            Translation::create([
                'filipino_word' => $submission->filipino_word,
                'ybanag_translation' => $submission->ybanag_translation,
                'pronunciation_audio' => $submission->pronunciation_audio ? 'audio/' . $submission->pronunciation_audio : null,
            ]);

            // ✅ Update submission status
            $submission->status = 'approved';
            $submission->save();
        });

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Submission approved and automatically added to Dictionary and Translation tables!');
    }

    public function reject($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->status = 'rejected';
        $submission->save();

        return redirect()->route('admin.submissions.index')->with('success', 'Submission rejected.');
    }

    public function undo($id)
    {
        $submission = Submission::findOrFail($id);
        
        if (in_array($submission->status, ['approved', 'rejected'])) {
            $submission->status = 'pending';
            $submission->save();

            return redirect()->route('admin.submissions.index')->with('success', 'Submission status has been reset to pending.');
        }

        return redirect()->route('admin.submissions.index')->with('error', 'Cannot undo this submission.');
    }

}
