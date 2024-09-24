<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    // Follow a user
    public function store(User $user)
    {
        // Authenticated user follows the target user
        Auth::user()->following()->attach($user->id);

        return back()->with('success', 'You are now following ' . $user->name);
    }

    // Unfollow a user
    public function destroy(User $user)
    {
        // Authenticated user unfollows the target user
        Auth::user()->following()->detach($user->id);

        return back()->with('success', 'You have unfollowed ' . $user->name);
    }
}
