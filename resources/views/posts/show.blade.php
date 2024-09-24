<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $post->title }}</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add custom CSS -->




    <style>


        body {
            background-color: #DAE0E6;
            color: #1A1A1B;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }
        .container {
            max-width: 1000px;
            margin-top: 20px;
        }
        .post-container, .comment-container {
            background: #ffffff;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 15px;
            margin-bottom: 15px;
        }
        .post-title {
            font-size: 1.5rem;
            font-weight: 500;
            color: #1A1A1B;
            margin-bottom: 10px;
        }
        .post-metadata {
            font-size: 0.75rem;
            color: #7C7C7C;
            margin-bottom: 10px;
        }
        .post-body, .comment-body {
            font-size: 0.875rem;
            line-height: 1.5;
        }
        .comment-header {
            font-size: 0.75rem;
            color: #7C7C7C;
            margin-bottom: 5px;
        }
        .comment-form {
            margin-top: 20px;
        }
        .vote-button {
            background: none;
            border: none;
            color: #7C7C7C;
            font-size: 1.5rem;
            padding: 0;
            cursor: pointer;
        }
        .vote-button.upvoted {
            color: #28a745; /* Green for upvoted */
        }
        .vote-button.downvoted {
            color: #dc3545; /* Red for downvoted */
        }
        .btn-primary {
            background-color: #FF4500;
            border-color: #FF4500;
        }
        .btn-secondary {
            background-color: #EDEFF1;
            border-color: #EDEFF1;
            color: #1A1A1B;
        }
        .btn-primary:hover {
            background-color: #FF5722;
            border-color: #FF5722;
        }
        .btn-secondary:hover {
            background-color: #DAE0E6;
            border-color: #DAE0E6;
        }
        .post-image {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-top: 15px;
        }
        .btn-delete {
            background: none;
            border: none;
            color: #DC3545;
            font-size: 1.25rem;
            padding: 0;
            margin-left: 10px;
        }
        .btn-delete:hover {
            color: #C82333;
        }
        .vote-button {
            background: none;
            border: none;
            color: #7C7C7C;
            font-size: 1.5rem;
            padding: 0;
            cursor: pointer;
            transition: color 0.2s ease; /* Add smooth transition for color change */
        }
        .vote-button.upvoted {
            color: #28a745; /* Green for upvoted */
        }
        .vote-button.downvoted {
            color: #dc3545; /* Red for downvoted */
        }

        .custom-alert {
    background-color: #d4edda; /* Light green background */
    color: #155724; /* Dark green text */
    border-color: #c3e6cb; /* Border color */
    padding: 15px; /* Add padding */
    border-radius: 0.25rem; /* Rounded corners */
    position: relative; /* For positioning the close button */
    margin-bottom: 20px; /* Spacing below the alert */
}

    </style>

@if (session('status'))
<div class="alert alert-success custom-alert">
    {{ session('status') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
</head>
<body>
    <div class="container">
        <div class="post-container">
            <!-- Post Voting -->
            <div class="mb-2 d-flex align-items-center">
                <button class="vote-button {{ $post->isUpvotedBy(Auth::user()) ? 'upvoted' : '' }}" onclick="vote('up', '{{ $post->id }}')">
                    <i class="fas fa-arrow-up"></i>
                </button>
                <button class="vote-button {{ $post->isDownvotedBy(Auth::user()) ? 'downvoted' : '' }}" onclick="vote('down', '{{ $post->id }}')">
                    <i class="fas fa-arrow-down"></i>
                </button>
            </div>
            <!-- Post Title -->
            <h1 class="post-title">{{ $post->title }}</h1>
            <!-- Post Metadata -->
            <div class="post-metadata">
                Posted by <a href="{{ route('profile.show', $post->user->id) }}">
                    u/{{ $post->user->name ?? 'unknown' }}
                </a>  • {{ $post->created_at->diffForHumans() }}
                @if (Auth::check() && Auth::user()->id === $post->user_id)
                    <!-- Delete Post Button -->
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @endif
            </div>
            <!-- Post Body -->
            <div class="post-body">
                <p>{{ $post->body }}</p>

                <!-- Post Image -->
                @if($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="post-image">
                @endif
            </div>
        </div>

        <!-- Comment form -->
        <div class="comment-form post-container">
            <h3 class="mb-3 h6">Comment as u/{{ Auth::user()->name }}</h3>
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="mb-3">
                    <textarea name="body" class="form-control" id="body" rows="3" placeholder="What are your thoughts?" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Comment</button>
            </form>
        </div>

        <!-- Display comments -->
        <h2 class="mt-4 mb-3 h6">Comments</h2>
        @forelse ($post->comments as $comment)
            <div class="comment-container">
                <div class="comment-header">
                    u/{{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}
                    @if (Auth::check() && Auth::user()->id === $comment->user_id)
                        <!-- Delete Comment Button -->
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endif
                </div>
                <div class="comment-body">
                    <p>{{ $comment->body }}</p>
                </div>
                <!-- Comment Voting -->
                <div class="mt-2 d-flex align-items-center">
                    <button class="vote-button {{ $comment->isUpvotedBy(Auth::user()) ? 'upvoted' : '' }}" onclick="vote('up', '{{ $comment->id }}', 'comment')">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                    <button class="vote-button {{ $comment->isDownvotedBy(Auth::user()) ? 'downvoted' : '' }}" onclick="vote('down', '{{ $comment->id }}', 'comment')">
                        <i class="fas fa-arrow-down"></i>
                    </button>
                </div>
            </div>
        @empty
            <p class="text-muted">No comments yet.</p>
        @endforelse

        <!-- Back to posts -->
        <a href="{{ route('posts.index') }}" class="mt-4 btn btn-secondary">Back to posts</a>
    </div>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
       function vote(type, id, entity = 'post') {
            // Find the clicked button and its sibling (the other vote button)
            const clickedButton = event.currentTarget;
            const siblingButton = clickedButton.nextElementSibling || clickedButton.previousElementSibling;

            // Immediately update the UI
            if (type === 'up') {
                clickedButton.classList.toggle('upvoted');
                siblingButton.classList.remove('downvoted');
            } else {
                clickedButton.classList.toggle('downvoted');
                siblingButton.classList.remove('upvoted');
            }

            fetch(`/vote/${entity}/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // If the server request fails, revert the UI change
                    if (type === 'up') {
                        clickedButton.classList.remove('upvoted');
                    } else {
                        clickedButton.classList.remove('downvoted');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert the UI change on error as well
                if (type === 'up') {
                    clickedButton.classList.remove('upvoted');
                } else {
                    clickedButton.classList.remove('downvoted');
                }
            });
        }
    </script>
</body>
</html>
