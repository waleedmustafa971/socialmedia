<div>

    <style>
        /* Modern Message Form Styles */

.message-form-container {
    max-width: 500px;
    margin: 2rem auto;
    padding: 1.5rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
}

.message-form {
    display: flex;
    flex-direction: column;
}

.message-textarea {
    width: 100%;
    min-height: 100px;
    padding: 0.75rem;
    margin-bottom: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    resize: vertical;
}

.message-textarea:focus {
    outline: none;
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
}

.submit-button {
    align-self: flex-end;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(45deg, #4299e1, #667eea);
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.submit-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(66, 153, 225, 0.25);
}

.submit-button:active {
    transform: translateY(0);
    box-shadow: none;
}

.error {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}
</style>


<div class="message-form-container">
<link rel="preload" href="https://fonts.bunny.net/figtree/files/figtree-latin-600-normal.woff2" as="font" type="font/woff2" crossorigin="anonymous">

    <form wire:submit.prevent="sendMessage" class="message-form">

        <div>
            <textarea wire:model.live.debounce.500ms="message" class="message-textarea" placeholder="Type your message here"></textarea>
            @error('message') <span class="error">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="submit-button" {{ $sending ? 'disabled' : '' }}>
            {{ $sending ? 'Sending...' : 'Send Message' }}
        </button>
        </form>

        {{-- <script>
            window.Pusher = window.Pusher || {};
            window.Pusher.logToConsole = true;

            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: 'ea5807b7624b43ddfd0b',
                cluster: 'ap2',
                encrypted: true
            });
        </script> --}}

</div>




</div>

@push('scripts')
<script>
   window.Echo.channel('messages')
    .listen('MessageSent', (e) => {
        console.log(`New message received: ${e.message}`);
        // Update your UI with the new message
    });
</script>
@endpush
