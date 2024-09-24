<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class SendMessage extends Component
{
    public $message = '';
    public $receiverId;

    public function mount($receiverId)
    {
        $this->receiverId = $receiverId;
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|max:1000',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->receiverId,
            'body' => $this->message,
        ]);

        $this->message = '';
        $this->emit('messageSent');
    }

    public function render()
    {
        return view('livewire.send-message');
    }
}
