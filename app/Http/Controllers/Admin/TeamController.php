<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::all();
        return view('admin.team.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'role'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'fb'    => 'nullable|url',
            'img'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('team', 'public');
        }

        TeamMember::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member added successfully.');
    }

    public function edit($id)
    {
        $member = TeamMember::findOrFail($id);
        return view('admin.team.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'role'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'fb'    => 'nullable|url|max:255',
            'img'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle profile image upload
        if ($request->hasFile('img')) {
            // Delete old image only if it’s an uploaded image (in storage)
            if ($member->img && Str::startsWith($member->img, 'team/')) {
                Storage::disk('public')->delete($member->img);
            }
            $data['img'] = $request->file('img')->store('team', 'public');
        }

        $member->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);

        // Delete uploaded image only, not default image
        if ($member->img && Str::startsWith($member->img, 'team/')) {
            Storage::disk('public')->delete($member->img);
        }

        $member->delete();

        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully.');
    }
}
