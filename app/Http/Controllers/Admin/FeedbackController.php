<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);

        return view('admin.feedbacks.index', compact('feedbacks'));

    }

    public function archived()
    {
        // Show only archived feedbacks
        $archivedFeedbacks = Feedback::onlyTrashed()->latest()->paginate(10);

        return view('admin.feedbacks.archived', compact('archivedFeedbacks'));
    }
    
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')
        ->with('success', 'Feedback has been archived.');
    }

    public function restore($id)
    {
        $feedback = Feedback::onlyTrashed()->findOrFail($id);
        $feedback->restore(); // Restore archived feedback

        return redirect()->route('admin.feedbacks.archived')
            ->with('success', 'Feedback has been restored.');
    }

}
