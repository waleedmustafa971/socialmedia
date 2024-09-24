@extends('layouts.app')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif


@section('content')
    <div class="container">
        <!-- Display Post Title and Body -->
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->body }}</p>
        <p>by {{ $post->user->name }} in {{ $post->community->name }}</p>

        <!-- Comments Section -->
        <div>
            <h3>Comments</h3>
            @foreach($post->comments as $comment)
                <div class="comment">
                    <p>{{ $comment->body }}</p>
                    <p>by {{ $comment->user->name }}</p>
                </div>
            @endforeach
        </div>

        <!-- Comment Form -->
        @auth
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <textarea name="body" placeholder="Add a comment" rows="4"></textarea>
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <button type="submit" class="mt-2 btn btn-primary">Submit</button>
            </form>
        @endauth
    </div>
@endsection
