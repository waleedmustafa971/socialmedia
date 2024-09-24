<div>
    @foreach($posts as $post)
    <div class="post">
        <h2>{{ $post->title }}</h2>
        <p>by {{ $post->user->name }} in {{ $post->community->name }}</p>
        <p>{{ $post->body }}</p>

        <!-- Voting Component -->
        <livewire:post-vote :post="$post" />

        <!-- Display the vote count -->
        <div>Votes: {{ $post->votes->sum('value') }}</div>

        <a href="{{ route('post.show', $post->id) }}">View Post</a>
    </div>
@endforeach

</div>
