<?php

namespace App\Livewire;

use Livewire\Component;

class PostCreate extends Component
{
    public $title;
    public $body;
    public $community_id;

    public function createPost()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
            'community_id' => 'required|exists:communities,id',
        ]);

        Post::create([
            'title' => $this->title,
            'body' => $this->body,
            'community_id' => $this->community_id,
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', 'Post created successfully!');
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.post-create', [
            'communities' => Community::all(),
        ]);
    }
}

