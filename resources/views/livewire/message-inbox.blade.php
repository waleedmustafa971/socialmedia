<div>
    <h2>Your Inbox</h2>
    @if($messages->isEmpty())
        <p>No messages to display.</p>
    @else
        @foreach ($messages as $message)
            <div class="message">
                <strong>{{ $message->sender->name }}:</strong>
                <p>{{ $message->body }}</p> <!-- Use 'body' instead of 'message' -->
                <small>Sent at {{ $message->created_at->format('M d, Y H:i') }}</small>
            </div>
        @endforeach
    @endif

    <!-- Optional form for sending a message -->
    @if($recipientId)
        <form wire:submit.prevent="sendMessage">
            <textarea wire:model="messageBody" placeholder="Type your message here"></textarea>
            <button type="submit">Send</button>
        </form>
    @endif
</div>
