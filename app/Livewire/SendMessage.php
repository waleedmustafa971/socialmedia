<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Event;

class SendMessage extends Component
{
    public $message = '';
    public $receiverId;
    public $messages = []; // Property to hold messages
    public $sending = false; // Property to track if the message is being sent

    protected $listeners = ['echo:messages,MessageSent' => 'handleMessageSent'];

    public function mount($receiverId)
    {
        $this->receiverId = $receiverId;
        $this->messages = Message::all(); // Load existing messages
        $this->loadMessages(); // Load messages on mount
    }

    public function handleMessageSent(MessageSent $event)
{
    // Only add the message to the conversation if it's not the sender's own message
    if ($event->message->sender_id !== Auth::id()) {
        $this->messages[] = $event->message;
    }
    $this->sending = false; // Reset the sending flag
}

    public function loadMessages()
    {
        $this->messages = Message::where(function ($query) {
            $query->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', $this->receiverId);
        })->orderBy('created_at', 'asc')->get()->toArray();
    }

    public function sendMessage()
{
    $this->sending = true; // Set the sending flag
    try {
        $this->validate([
            'message' => 'required|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->receiverId,
            'body' => $this->message,
        ]);

        broadcast(new MessageSent($message))->toOthers(); // Broadcast the event to all users except the sender

        $this->message = ''; // Clear the input
        $this->sending = false; // Reset the sending flag
    } catch (\Exception $e) {
        \Log::error('Message sending error: ' . $e->getMessage());
        // You can also send the error to the frontend if needed
        Event::dispatch(new \App\Events\MessageError($e->getMessage()));
    }
}

    public function addMessage($message)
    {
        // Add the new message to the list
        $this->messages[] = $message;
    }

    public function render()
    {
        return view('livewire.send-message', ['messages' => $this->messages]);
    }
}
