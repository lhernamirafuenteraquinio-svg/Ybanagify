<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'category' => 'required|string',
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create($validated);

        return response()->json(['message' => 'Thank you for your feedback!']);
    }

}
