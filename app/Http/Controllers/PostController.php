<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Community;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    // Show the post creation form
    public function create()
{
    // Fetch communities from the database
    $communities = Community::all(); // Assuming you have a Community model and table

    return view('post.create', compact('communities'));
}

public function index(Request $request)
{
    $communityId = $request->input('community_id');

    $posts = Post::when($communityId, function ($query, $communityId) {
        return $query->where('community_id', $communityId);
    })->with('user', 'community') // Eager load user and community relationships
      ->latest()
      ->get();

    $communities = Community::all(); // Get all communities for the dropdown

    return view('posts.index', compact('posts', 'communities'));
}


    public function show($id)
    {
        // Fetch the post by ID
        $post = Post::findOrFail($id);
        $post = Post::with('comments')->findOrFail($id); // Eager load comments


        // Return a view with the post data
        return view('posts.show', compact('post'));
    }

    public function destroy($id)
    {
        // Find the post by ID
        $post = Post::findOrFail($id);

        // Check if the authenticated user is the owner of the post
        if (Auth::user()->id !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'You are not authorized to delete this post.');
        }

        // Delete the post
        $post->delete();

        // Redirect back with success message
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }


    // Handle the form submission and store the new post
    public function store(Request $request)
{
    $request->validate([
        'community_id' => 'required|exists:communities,id',
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    $post = new Post();
    $post->community_id = $request->input('community_id');
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    $post->user_id = auth()->id(); // Set the user_id

    if ($request->hasFile('image')) {
        $post->image_path = $request->file('image')->store('images');
    }

    $post->save();

    return redirect()->route('posts.index');
}


}
