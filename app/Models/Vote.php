<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    // protected $fillable = ['user_id', 'post_id', 'value'];
    protected $fillable = ['user_id', 'post_id', 'comment_id', 'value','type'];


    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function votable()
    {
        return $this->morphTo();
    }
}