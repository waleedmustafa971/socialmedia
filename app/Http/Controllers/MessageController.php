<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Event;

class MessageController extends Controller
{

    protected $listeners = ['echo:messages,MessageSent' => 'handleMessageSent'];


    public function inbox()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized access');
        }

        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver_id : $message->sender_id;
            });

        $followers = $user->followers;

        return view('messages.inbox', compact('conversations', 'followers'));
    }



    public function sendMessage(Request $request)
{
    $request->validate(['body' => 'required|string|max:1000']);

    $message = Message::create(['body' => $request->body, 'sender_id' => Auth::id()]);
    broadcast(new MessageSent($message)); // Broadcast the event

    return response()->json($message, 201);
}


    // public function loadMessages()
    // {
    //     $this->messages = Message::where(function ($query) {
    //         $query->where('sender_id', Auth::id())
    //               ->where('receiver_id', $this->otherUserId);
    //     })->orWhere(function ($query) {
    //         $query->where('sender_id', $this->otherUserId)
    //               ->where('receiver_id', Auth::id());
    //     })->orderBy('created_at', 'asc')->get();
    // }

    public function showConversation($userId)
{
    $user = Auth::user();
    if (!$user) {
        abort(403, 'Unauthorized access');
    }

    $otherUser = User::findOrFail($userId); // Fetch the other user

    // Fetch messages in the same way as inbox, but for a specific conversation
    $messages = Message::where(function ($query) use ($userId) {
        $query->where('sender_id', Auth::id())
              ->where('receiver_id', $userId);
    })->orWhere(function ($query) use ($userId) {
        $query->where('sender_id', $userId)
              ->where('receiver_id', Auth::id());
    })->orderBy('created_at', 'asc') // Order messages by creation date
    ->get(); // Fetch messages

    // Broadcast the MessageSent event when a new message is sent
    // broadcast(new MessageSent($messages->last()));

    // Ensure you pass both $otherUser and $messages to the view
    return view('messages.conversation', compact('otherUser', 'messages'));
}

}
