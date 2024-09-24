<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    public function show(User $user, Request $request)
{
    $user->load('posts');
    $editMode = $request->has('editMode');
    $messages = \App\Models\Message::where('receiver_id', $user->id)->get();

    // Get followers of the authenticated user
    $followers = auth()->user()->followers;

    return view('profile.show', compact('user', 'editMode', 'followers')); // Pass followers to the view
}


    public function updateBio(Request $request, User $user)
    {
        Log::info('Update bio method called', ['user_id' => $user->id, 'bio' => $request->bio]);

        $validated = $request->validate([
            'bio' => 'nullable|string|max:255',
        ]);

        try {
            $user->update([
                'bio' => $validated['bio'],
            ]);
            Log::info('Bio updated successfully', ['user_id' => $user->id]);
            return redirect()->route('profile.show', $user->id)->with('success', 'Bio updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating bio', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return redirect()->route('profile.show', $user->id)->with('error', 'Failed to update bio. Please try again.');
        }
    }
}
