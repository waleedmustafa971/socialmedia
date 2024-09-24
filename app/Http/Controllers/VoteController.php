<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote(Request $request, $entity, $id)
{
    $type = $request->input('type');
    $user = Auth::user();

    // Logic for upvoting or downvoting
    // ...

    // Determine the new vote state
    $entityModel = $this->getEntityModel($entity, $id);
    $upvoted = $entityModel->isUpvotedBy($user);
    $downvoted = $entityModel->isDownvotedBy($user);

    return response()->json([
        'success' => true,
        'upvoted' => $upvoted,
        'downvoted' => $downvoted,
    ]);
}

private function getEntityModel($entity, $id)
{
    if ($entity === 'post') {
        return Post::findOrFail($id);
    }
    if ($entity === 'comment') {
        return Comment::findOrFail($id);
    }
    // Handle other entities
}

}
