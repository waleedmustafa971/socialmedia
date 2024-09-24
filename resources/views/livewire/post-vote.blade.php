<div>
    <!-- Display votes for posts or comments -->
    <button wire:click="vote(1)" class="btn btn-success">Upvote</button>
    <button wire:click="vote(-1)" class="btn btn-danger">Downvote</button>

    @if ($post)
        <p>Post votes: {{ $post->votes->sum('value') }}</p>
    @elseif ($comment)
        <p>Comment votes: {{ $comment->votes->sum('value') }}</p>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
</div>
