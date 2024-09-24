<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class FollowButton extends Component
{
    public $user;
    public $isFollowing;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->isFollowing = Auth::user()->isFollowing($user);
    }

    public function toggleFollow()
    {
        if ($this->isFollowing) {
            Auth::user()->unfollow($this->user);
        } else {
            Auth::user()->follow($this->user);
        }

        // Recheck the follow status
        $this->isFollowing = Auth::user()->isFollowing($this->user);
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}
