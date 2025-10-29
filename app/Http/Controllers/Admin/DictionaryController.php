<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dictionary;

class DictionaryController extends Controller
{
    public function index(Request $request)
    {
        $entries = Dictionary::query()
            ->when($request->visibility, function ($query) use ($request) {
                if ($request->visibility === 'visible') {
                    $query->where('is_visible', true);
                } elseif ($request->visibility === 'hidden') {
                    $query->where('is_visible', false);
                }
            })
            ->orderBy('created_at', 'desc') // latest entries first
            ->paginate(10);

        return view('admin.dictionary.index', compact('entries'));
    }

    // Toggle visibility (Show/Hide)
    public function toggleVisibility($id)
    {
        $entry = Dictionary::findOrFail($id);
        $entry->is_visible = !$entry->is_visible; // flip value (true -> false, false -> true)
        $entry->save();

        return response()->json([
            'success' => true,
            'is_visible' => $entry->is_visible,
        ]);
    }
}
