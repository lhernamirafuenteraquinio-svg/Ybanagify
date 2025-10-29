<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Translation;

class TranslationController extends Controller
{

    public function index(Request $request)
    {
        $translations = Translation::query()
            ->when($request->visibility, function ($query) use ($request) {
                if ($request->visibility === 'visible') {
                    $query->where('is_visible', true);
                } elseif ($request->visibility === 'hidden') {
                    $query->where('is_visible', false);
                }
            })
            ->orderBy('created_at', 'desc') // latest entries first
            ->paginate(10);

        return view('admin.translations.index', compact('translations'));
    }

    public function toggleVisibility($id)
    {
        $translation = Translation::findOrFail($id);
        $translation->is_visible = !$translation->is_visible;
        $translation->save();

        return response()->json([
            'success' => true,
            'is_visible' => $translation->is_visible,
        ]);
    }
}
