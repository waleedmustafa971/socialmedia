import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'ea5807b7624b43ddfd0b',
    cluster: 'ap2',
    encrypted: true
});

window.Echo.channel('messages')
    .join()
    .listen('MessageSent', (e) => {
        console.log('Received event:', e);
        console.log(`New message received: ${e.message}`);
        // Update your UI with the new message
        // For example, you can append the new message to a conversation list
        const conversationList = document.getElementById('conversation-list');
        const newMessageHTML = `
            <div>
                <p>${e.message.body}</p>
                <span>sent by ${e.message.sender_id}</span>
            </div>
        `;
        conversationList.innerHTML += newMessageHTML;
    });