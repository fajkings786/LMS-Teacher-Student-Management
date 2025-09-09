<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();

        // Purani picture delete karna (agar hai)
        if ($user->profile_picture && file_exists(storage_path('app/public/' . $user->profile_picture))) {
            unlink(storage_path('app/public/' . $user->profile_picture));
        }

        // Nayi picture upload
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');

        $user->profile_picture = $path;
        $user->save();

        return back()->with('success', 'Profile picture updated successfully!');
    }
}
