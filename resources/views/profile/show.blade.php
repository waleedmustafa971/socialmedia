<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}'s Profile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f3a953;
            --background-color: #f4f7f9;
            --text-color: #333;
            --light-text-color: #666;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .profile-header {
    display: flex;
    align-items: center;
    background-color: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.profile-info-messages {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-grow: 1;
}

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            font-weight: bold;
            margin-right: 30px;
        }

        .profile-info {
            flex-grow: 1;
        }

        .profile-info h1 {
            margin: 0 0 10px 0;
            font-size: 36px;
            color: var(--primary-color);
        }

        .profile-info p {
            margin: 5px 0;
            font-size: 16px;
            color: var(--light-text-color);
        }

        .bio-section, .posts-section {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .inbox-container {
    margin-left: 20px; /* Some space between name and button */
}

.inbox-button {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 25px;
    text-decoration: none;
    display: flex;
    align-items: center;
    position: relative;
    transition: background-color 0.3s ease;
}

.inbox-button i {
    margin-right: 10px;
}

.inbox-button:hover {
    background-color: #3a7bc8;
}

.inbox-badge {
    background-color: var(--secondary-color);
    color: white;
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 15px;
    position: absolute;
    top: -10px;
    right: -10px;
    font-weight: bold;
}

        .bio-section h3, .posts-section h2 {
            color: var(--primary-color);
            margin-top: 0;
        }

        .bio-content {
            font-size: 16px;
            line-height: 1.6;
        }

        .edit-bio-btn, .follow-button, .create-post-button, .view-all-posts-button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .edit-bio-btn:hover, .follow-button:hover, .create-post-button:hover, .view-all-posts-button:hover {
            background-color: #3a7bc8;
        }

        .follow-button.unfollow {
            background-color: var(--secondary-color);
        }

        .follow-button.unfollow:hover {
            background-color: #e09843;
        }

        .posts-list {
            list-style-type: none;
            padding: 0;
        }

        .posts-list li {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            transition: background-color 0.3s ease;
        }

        .posts-list li:hover {
            background-color: #f9f9f9;
        }

        .posts-list li a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
        }

        .post-date {
            color: var(--light-text-color);
            font-size: 14px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .posts-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .posts-header h2 {
            margin: 0;
        }

        .create-post-button, .view-all-posts-button {
            font-size: 14px;
            padding: 8px 15px;
        }

        .create-post-button i, .view-all-posts-button i {
            margin-right: 5px;
        }

        .button-group {
            display: flex;
            gap: 10px;
        }
        .connections-section {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .connections-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .connection-count {
            font-size: 18px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .connection-list {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .connection-item {
            display: flex;
            align-items: center;
            background-color: #f0f2f5;
            border-radius: 25px;
            padding: 5px 15px;
            font-size: 14px;
        }

        .connection-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }

        .view-all-btn {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
        }

        .view-all-btn:hover {
            text-decoration: underline;
        }
          /* Foldable section */
          .foldable-section {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .foldable-section.expanded {
            max-height: 500px; /* Adjust based on content */
        }

        .toggle-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 25px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .toggle-btn:hover {
            background-color: #3a7bc8;
        }

        .connection-item a {
            text-decoration: none;
            color: var(--primary-color);
            font-weight: bold;
        }

        .connection-item a:hover {
            text-decoration: underline;
        }

        .inbox-container {
    display: flex;
    align-items: center;
    margin-left: auto; /* Align to the right */
}

.inbox-button {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 25px;
    text-decoration: none;
    display: flex;
    align-items: center;
    position: relative;
    transition: background-color 0.3s ease;
}

.inbox-button i {
    margin-right: 10px;
}

.inbox-button:hover {
    background-color: #3a7bc8;
}

.inbox-badge {
    background-color: var(--secondary-color);
    color: white;
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 15px;
    position: absolute;
    top: -10px;
    right: -10px;
    font-weight: bold;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <div class="profile-picture">
                {{ strtoupper(substr($user->name, 0, 2)) }}


            </div>











            <div class="profile-info">

                <h1>{{ $user->name }}</h1>
                <p><i class="fas fa-calendar-alt"></i> Joined: {{ $user->created_at->format('F d, Y') }}</p>
                <div class="inbox-container">
                    <a href="{{ route('messages.inbox') }}" class="inbox-button">
                        <i class="fas fa-envelope"></i> Messages
                        {{-- <span class="inbox-badge">3</span> <!-- Example notification badge --> --}}
                    </a>
                </div>
                @if (Auth::id() !== $user->id)
                    @if (Auth::user()->isFollowing($user))
                        <form action="{{ route('follow.destroy', $user->id) }}" method="POST" class="follow-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="follow-button unfollow">Unfollow</button>
                        </form>
                    @else
                        <form action="{{ route('follow.store', $user->id) }}" method="POST" class="follow-form">
                            @csrf
                            <button type="submit" class="follow-button follow">Follow</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>

        <div class="connections-section">
            <div class="connections-header">
                <h3>Connections</h3>
                <div>
                    <span class="connection-count">{{ $user->followers->count() }} Followers</span>
                    <span class="connection-count">{{ $user->following->count() }} Following</span>
                </div>
            </div>

            <button class="toggle-btn" id="toggleFriendsBtn">Show Friends</button>

            <div id="friendsList" class="foldable-section">
                <div class="connection-list">
                    <h4>Followers</h4>
                    @forelse ($user->followers->take(5) as $follower)
                        <div class="connection-item">
                            <div class="connection-avatar">
                                {{ strtoupper(substr($follower->name, 0, 1)) }}
                            </div>
                            <a href="{{ route('profile.show', $follower->id) }}">{{ $follower->name }}</a>
                        </div>
                    @empty
                        <p>No followers yet.</p>
                    @endforelse

                    @if ($user->followers->count() > 5)
                        <a href="#" class="view-all-btn">View all followers</a>
                    @endif
                </div>

                <div class="connection-list">
                    <h4>Following</h4>
                    @forelse ($user->following->take(5) as $following)
                        <div class="connection-item">
                            <div class="connection-avatar">
                                {{ strtoupper(substr($following->name, 0, 1)) }}
                            </div>
                            <a href="{{ route('profile.show', $following->id) }}">{{ $following->name }}</a>
                        </div>
                    @empty
                        <p>Not following anyone yet.</p>
                    @endforelse

                    @if ($user->following->count() > 5)
                        <a href="#" class="view-all-btn">View all following</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="bio-section">
            <h3><i class="fas fa-user"></i> Bio</h3>
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="bio-display">
                <p id="bio-content" class="bio-content">{{ $user->bio ?: 'No bio available.' }}</p>
                @if (Auth::id() === $user->id)
                    <button id="edit-bio-btn" class="edit-bio-btn">Edit Bio</button>
                @endif
            </div>

            @if (Auth::id() === $user->id)
                <div id="bio-form" style="display: none;">
                    <form action="{{ route('profile.updateBio', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <textarea name="bio" id="bio-input" rows="3" class="form-control" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                        </div>
                        <button type="submit" class="edit-bio-btn">Save Bio</button>
                        <button type="button" id="cancel-edit-btn" class="edit-bio-btn">Cancel</button>
                    </form>
                </div>
            @endif
        </div>

        <div class="posts-section">
            <div class="posts-header">
                <h2>{{ $user->name }}'s Posts</h2>
                <div class="button-group">
                    <a href="{{ route('posts.index') }}" class="view-all-posts-button">
                        <i class="fas fa-globe"></i> View All Posts
                    </a>
                    @if (Auth::id() === $user->id)
                        <a href="{{ route('post.create') }}" class="create-post-button">
                            <i class="fas fa-plus"></i> Create Post
                        </a>
                    @endif
                </div>
            </div>
            @if ($user->posts->isEmpty())
                <p class="no-posts">No posts available.</p>
            @else
                <ul class="posts-list">
                    @foreach ($user->posts as $post)
                        <li>
                            <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                            <span class="post-date">• {{ $post->created_at->diffForHumans() }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>


</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Friends List Section
    const toggleFriendsBtn = document.getElementById('toggleFriendsBtn');
    const friendsList = document.getElementById('friendsList');

    if (toggleFriendsBtn) {
        toggleFriendsBtn.addEventListener('click', function() {
            if (friendsList.classList.contains('expanded')) {
                friendsList.classList.remove('expanded');
                toggleFriendsBtn.textContent = 'Show Friends';
            } else {
                friendsList.classList.add('expanded');
                toggleFriendsBtn.textContent = 'Hide Friends';
            }
        });
    }
    // Bio Edit Section
    const bioDisplay = document.getElementById('bio-display');
    const bioForm = document.getElementById('bio-form');
    const editBioBtn = document.getElementById('edit-bio-btn');
    const cancelEditBtn = document.getElementById('cancel-edit-btn');

    if (editBioBtn) {
        editBioBtn.addEventListener('click', function() {
            bioDisplay.style.display = 'none';
            bioForm.style.display = 'block';
        });
    }

    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function() {
            bioDisplay.style.display = 'block';
            bioForm.style.display = 'none';
        });
    }
});

</script>
</html>

