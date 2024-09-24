<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'bio', // Add this
    'profile_picture', // Add this
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship with comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relationship with votes
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }


        public function posts()
    {
        return $this->hasMany(Post::class);
    }


    // Users who follow the current user
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }

    // Users that the current user is following
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    // Check if the current user is following another user
    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    // Follow another user
    public function follow(User $user)
    {
        $this->following()->attach($user->id);
    }

    // Unfollow a user
    public function unfollow(User $user)
    {
        $this->following()->detach($user->id);
    }

    // Relationship with the sender
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship with the receiver
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

     // Query scope for unread messages
     public function scopeUnread($query)
    {
        return $query->where('read_at', null); // Assuming you have a `read_at` column
    }

     // Custom validation logic (if needed)
     public static function validateMessage($data)
    {
        return \Validator::make($data, [
            'body' => 'required|string|max:1000', // Example validation rule
            'receiver_id' => 'required|exists:users,id',
        ]);
    }
}
