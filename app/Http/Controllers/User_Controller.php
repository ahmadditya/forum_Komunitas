<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;

class User_Controller extends Controller
{
    public function show(User $user)
    {
        return view(
            'profile',
            [
                "title" => $user->name,
                "users" => $user->load(['posts', 'comments']),
                "posts" => Post::where('user_id', $user->id)->with('user', 'category', 'comments')->orderBy('id', 'desc')->get(),
            ]
        );
    }

    public function edit(User $user)
    {
        return view(
            'edit_profile',
            [
                "title" => "Edit Profile",
                "users" => auth()->user()
            ]
        );
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $user->name = $request->input('name');

        // Check if a new profile image has been uploaded
        if ($request->hasFile('profile_image')) {
            // Validate the uploaded file
            $request->validate([
                'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // max:2048 untuk membatasi ukuran file maksimal menjadi 2MB
            ]);

            // Store the new profile image and get its path
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');

            // Delete the previous profile image if it exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Save the path of the new profile image to the user's profile_image attribute
            $user->profile_image = $imagePath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
