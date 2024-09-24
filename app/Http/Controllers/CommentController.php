<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:255',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'body' => $request->body,
            'post_id' => $request->post_id,
            'user_id' => auth()->id(), // Assumes user is authenticated
        ]);

        return redirect()->route('post.show', $request->post_id)->with('status', 'Comment added!');
    }

    public function destroy($id)
{
    // Find the comment by ID
    $comment = Comment::findOrFail($id);

    // Check if the user is authorized to delete the comment
    if (auth()->user()->id !== $comment->user_id) {
        return redirect()->back()->withErrors('You are not authorized to delete this comment.');
    }

    // Delete the comment
    $comment->delete();

    return redirect()->back()->with('status', 'You have successfully deleted your comment!');
}

}
