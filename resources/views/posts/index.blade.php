<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            background-color: #DAE0E6;
            color: #1A1A1B;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        h1 {
            color: #1A1A1B;
            font-size: 18px;
            font-weight: 500;
            padding: 10px 0;
            border-bottom: 1px solid #EDEFF1;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .create-post-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .create-post-button i {
            margin-right: 8px;
        }
        .create-post-button:hover {
            background-color: #0056b3;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form label {
            margin-right: 10px;
        }
        .filter-form select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #CCC;
            font-size: 16px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #FFFFFF;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 10px;
            padding: 8px 16px;
            transition: box-shadow 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        li:hover {
            box-shadow: 0 1px 5px rgba(0,0,0,0.2);
        }
        a {
            color: #1A1A1B;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            display: block;
            padding: 8px 0;
        }
        a:hover {
            color: #1A1A1B;
        }
        .post-item {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .vote-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 15px;
        }
        .vote-button {
            background: none;
            border: none;
            color: #878A8C;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
        }
        .vote-count {
            font-size: 12px;
            font-weight: bold;
            margin: 4px 0;
        }
        .post-content {
            flex-grow: 1;
        }
        .post-title {
            margin: 0;
            padding: 0;
        }
        .post-info {
            color: #787C7E;
            font-size: 12px;
            margin-top: 4px;
        }
        .no-posts {
            background-color: #FFFFFF;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
            color: #787C7E;
        }
        .no-posts i {
            font-size: 48px;
            color: #FF6F6F;
            margin-bottom: 10px;
        }
        .delete-button {
            background: none;
            border: none;
            color: #FF6F6F;
            cursor: pointer;
            font-size: 16px;
        }
        .delete-button:hover {
            color: #FF3B3B;
        }

        .alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
    color: #fff;
    font-size: 16px;
}
.alert-success {
    background-color: #28a745;
}
.alert-danger {
    background-color: #dc3545;
}

    </style>
</head>
<body>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="container">
        <h1>
            Posts
            <a href="{{ route('post.create') }}" class="create-post-button">
                <i class="fas fa-plus"></i> Create Post
            </a>
        </h1>

        <!-- Filter by Community -->
        <form action="{{ route('posts.index') }}" method="GET" class="filter-form">
            <label for="community">Filter by Community:</label>
            <select name="community_id" id="community" onchange="this.form.submit()">
                <option value="">All Communities</option>
                @foreach ($communities as $community)
                    <option value="{{ $community->id }}" {{ request('community_id') == $community->id ? 'selected' : '' }}>
                        {{ $community->name }}
                    </option>
                @endforeach
            </select>
        </form>

        @if ($posts->isEmpty())
            <div class="no-posts">
                <i class="fas fa-sad-tear"></i>
                <p>No posts available for this community.</p>
            </div>
        @else
            <ul>
                @foreach ($posts as $post)
                    <li>
                        <div class="post-item">
                            <div class="vote-buttons">
                                <button class="vote-button"><i class="fas fa-arrow-up"></i></button>
                                <span class="vote-count">0</span>
                                <button class="vote-button"><i class="fas fa-arrow-down"></i></button>
                            </div>
                            <div class="post-content">
                                <h2 class="post-title">
                                    <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                                </h2>
                                <p class="post-info">
                                    Posted by <a href="{{ route('profile.show', $post->user->id) }}">
                                        u/{{ $post->user->name ?? 'unknown' }}
                                    </a>  • {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @if (Auth::check() && Auth::user()->id === $post->user_id)
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this post?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
