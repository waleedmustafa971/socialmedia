<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'post_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function downvote($user)
    {
        $this->votes()->updateOrCreate(
            ['user_id' => $user->id],
            ['type' => -1]
        );
    }

    public function upvote($user)
    {
        $this->votes()->updateOrCreate(
            ['user_id' => $user->id],
            ['type' => 1]
        );
    }

    public function isUpvotedBy($user)
    {
        return $this->votes()->where('user_id', $user->id)->where('type', 1)->exists();
    }

    public function isDownvotedBy($user)
    {
        return $this->votes()->where('user_id', $user->id)->where('type', -1)->exists();
    }


}

