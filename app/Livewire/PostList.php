<?php

namespace App\Livewire;

use Livewire\Component;

class PostList extends Component
{
    public function render()
    {
        return view('livewire.post-list', [
            'posts' => Post::with('community', 'user', 'votes')->get(),
        ]);
    }
}

