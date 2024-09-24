@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Posts</h2>

        <!-- Display all posts -->
        @foreach($posts as $post)
            <div class="post">
                <h3>{{ $post->title }}</h3>
                <p>{{ Str::limit($post->body, 100) }}</p>
                <a href="{{ route('post.show', $post->id) }}">Read more</a>
                <p>Posted by {{ $post->user->name }}</p>
            </div>
        @endforeach

        <!-- Pagination links -->
        {{ $posts->links() }}
    </div>
@endsection
