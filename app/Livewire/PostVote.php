<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Vote;

class PostVote extends Component
{
    public $post;
    public $comment; // Add this if you want to handle comment voting

    public function mount($postId = null, $commentId = null)
    {
        if ($postId) {
            $this->post = Post::findOrFail($postId);
        }

        if ($commentId) {
            $this->comment = Comment::findOrFail($commentId);
        }
    }

    public function vote($value)
    {
        if ($this->post) {
            Vote::updateOrCreate(
                ['user_id' => auth()->id(), 'post_id' => $this->post->id],
                ['value' => $value]
            );
        }

        if ($this->comment) {
            Vote::updateOrCreate(
                ['user_id' => auth()->id(), 'comment_id' => $this->comment->id],
                ['value' => $value]
            );
        }

        session()->flash('message', 'Vote recorded!');
    }

    public function render()
    {
        return view('livewire.post-vote');
    }
}
