<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MessageInbox extends Component
{
    public $receivedMessages;
    public $sentMessages;
    public $messageBody;
    public $recipientId;
    public $conversation;

    protected $listeners = ['messageSent' => 'fetchMessages'];

    public function mount($recipient_id = null)
    {
        $this->recipientId = $recipient_id;
        $this->fetchMessages();
    }

    public function fetchMessages()
    {
        $this->receivedMessages = Message::where('receiver_id', Auth::id())
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get();

        $this->sentMessages = Message::where('sender_id', Auth::id())
            ->with('receiver')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($this->recipientId) {
            $this->conversation = Message::where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $this->recipientId);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->recipientId)
                    ->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'messageBody' => 'required|string|max:1000',
            'recipientId' => 'required|exists:users,id',
        ]);

        Message::create([
            'body' => $this->messageBody,
            'sender_id' => Auth::id(),
            'receiver_id' => $this->recipientId,
        ]);

        $this->messageBody = '';
        $this->fetchMessages();
        $this->emit('messageSent');
    }

    public function render()
{
    $messages = Message::where('receiver_id', auth()->id())
                ->orWhere('sender_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
    return view('livewire.message-inbox', ['messages' => $messages]);
}

}
