<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /** Show the profile edit page */
    public function edit()
    {
        return view('profile.edit');
    }

    /** Update name, email, and profile photo */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle profile photo
        if ($request->hasFile('profile_picture')) {
            // Delete old file if exists
            if ($user->profile_picture && file_exists(storage_path('app/public/' . $user->profile_picture))) {
                unlink(storage_path('app/public/' . $user->profile_picture));
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        $user->update($validated);

        return back()->with('status', 'Profile updated successfully!');
    }

    /** Update password */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validate inputs
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Verify if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.'
            ]);
        }

        // Update new password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Password updated successfully!');
    }
}
