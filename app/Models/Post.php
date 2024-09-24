<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'community_id'];


    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }






    public function comments()
{
    return $this->hasMany(Comment::class);
}

public function upvotes()
{
    return $this->votes()->where('type', 1);
}

public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

// app/Models/Post.php

public function isUpvotedBy($user)
    {
        return $this->votes()->where('user_id', $user->id)->where('type', 1)->exists();
    }

    public function isDownvotedBy($user)
    {
        return $this->votes()->where('user_id', $user->id)->where('type', -1)->exists();
    }

public function upvote($user)
    {
        $this->votes()->updateOrCreate(
            ['user_id' => $user->id],
            ['type' => 1]
        );
    }

    public function downvote($user)
    {
        $this->votes()->updateOrCreate(
            ['user_id' => $user->id],
            ['type' => -1]
        );
    }

}

