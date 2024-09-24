<div class="inbox-wrapper">
    <h2 class="inbox-title">Your Inbox</h2>

    <div class="inbox-container">
        <div class="conversations-list">
            <h3 class="section-title">Conversations</h3>
            @forelse ($conversations as $userId => $messages)
                @php
                    $otherUser = $messages->first()->sender_id == Auth::id()
                        ? $messages->first()->receiver
                        : $messages->first()->sender;
                    $lastMessage = $messages->first();
                @endphp
                <a href="{{ route('messages.conversation', $userId) }}" class="conversation-item">
                    <div class="conversation-avatar">
                        {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                    </div>
                    <div class="conversation-content">
                        <strong class="conversation-name">{{ $otherUser->name }}</strong>
                        <p class="conversation-preview">{{ Str::limit($lastMessage->body, 50) }}</p>
                    </div>
                    <small class="conversation-time">{{ $lastMessage->created_at->diffForHumans() }}</small>
                </a>
            @empty
                <p class="empty-message">No conversations yet.</p>
            @endforelse
        </div>

        <div class="followers-list">
            <h3 class="section-title">Followers</h3>
            @forelse ($followers as $follower)
                <a href="{{ route('messages.conversation', $follower->id) }}" class="follower-item">
                    <div class="follower-avatar">
                        {{ strtoupper(substr($follower->name, 0, 1)) }}
                    </div>
                    <span class="follower-name">{{ $follower->name }}</span>
                </a>
            @empty
                <p class="empty-message">No followers yet.</p>
            @endforelse
        </div>
    </div>
</div>

<style>
    .inbox-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem;
        font-family: Arial, sans-serif;
    }

    .inbox-title {
        font-size: 2rem;
        color: #333;
        margin-bottom: 1.5rem;
    }

    .inbox-container {
        display: flex;
        gap: 2rem;
    }

    .conversations-list, .followers-list {
        flex: 1;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
    }

    .section-title {
        font-size: 1.2rem;
        color: #555;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #eee;
    }

    .conversation-item, .follower-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        text-decoration: none;
        color: #333;
        transition: background-color 0.3s ease;
    }

    .conversation-item:hover, .follower-item:hover {
        background-color: #f0f4f8;
    }

    .conversation-avatar, .follower-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #3498db;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 1rem;
    }

    .conversation-content {
        flex: 1;
    }

    .conversation-name, .follower-name {
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .conversation-preview {
        color: #777;
        font-size: 0.9rem;
        margin: 0;
    }

    .conversation-time {
        font-size: 0.8rem;
        color: #999;
    }

    .empty-message {
        color: #999;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .inbox-container {
            flex-direction: column;
        }
    }
</style>
