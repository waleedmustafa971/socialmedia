@extends('layouts.app')

<style>/* Modern Conversation Styles */

    .container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    h2 {
        font-size: 1.5rem;
        color: #2d3748;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .messages-container {
        max-height: 500px;
        overflow-y: auto;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 8px;
        background-color: #f7fafc;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #edf2f7;
    }

    .messages-container::-webkit-scrollbar {
        width: 8px;
    }

    .messages-container::-webkit-scrollbar-track {
        background: #edf2f7;
    }

    .messages-container::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 4px;
    }

    .message {
        max-width: 80%;
        margin-bottom: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 18px;
        position: relative;
        line-height: 1.5;
        font-size: 0.95rem;
    }

    .message p {
        margin: 0 0 0.5rem 0;
    }

    .message small {
        font-size: 0.75rem;
        opacity: 0.7;
    }

    .sent {
        background-color: #4299e1;
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 4px;
    }

    .received {
        background-color: #e2e8f0;
        color: #2d3748;
        margin-right: auto;
        border-bottom-left-radius: 4px;
    }

    /* Responsive design */
    @media (max-width: 640px) {
        .container {
            padding: 1rem;
            margin: 1rem;
        }

        .message {
            max-width: 90%;
        }
    }</style>

@section('content')
<div class="container">
    <h2>Conversation with {{ $otherUser->name }}</h2>

    <div class="messages-container">
        @foreach ($messages as $message)
            <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                <p>{{ $message->body }}</p>
                <small>{{ $message->created_at->format('M d, Y H:i') }}</small>
            </div>
        @endforeach
    </div>

    <div>
        @livewire('send-message', ['receiverId' => $otherUser->id])
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/conversation-styles.css') }}">
@endpush

@push('scripts')
<script>
  window.Echo.channel('messages')
    .listen('MessageSent', (e) => {
        console.log(`New message received: ${e.message.body}`);
        // Update your UI with the new message
        const messagesContainer = document.querySelector('.messages-container');
        const newMessageHTML = `
            <div class="message ${e.message.sender_id === currentUserId ? 'sent' : 'received'}">
                <p>${e.message.body}</p>
                <small>${e.message.created_at}</small>
            </div>
        `;
        messagesContainer.innerHTML += newMessageHTML;
    });
</script>
@endpush
