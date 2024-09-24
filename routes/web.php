<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\MessageController;
use App\Http\Livewire\SendMessage;
use App\Http\Livewire\MessageInbox;






Route::get('/', function () {
    return view('welcome');
});

// Post routes
Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
Route::post('/posts', [PostController::class, 'store'])->name('post.store');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

// Comment routes
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');


// Voting route
Route::post('/vote/{entity}/{id}', [VoteController::class, 'vote'])->name('vote');

// Profile routes
Route::get('/profile/{user}', [UserProfileController::class, 'show'])->name('profile.show');

// Follow and unfollow routes
Route::post('/profile/{user}/follow', [FollowController::class, 'store'])->name('follow.store');
Route::delete('/profile/{user}/unfollow', [FollowController::class, 'destroy'])->name('follow.destroy');
Route::patch('/profile/{user}/bio', [UserProfileController::class, 'updateBio'])->name('profile.updateBio');
Route::patch('/profile/{user}/bio', [UserProfileController::class, 'updateBio'])->name('profile.updateBio');
Route::get('/debug-bio/{user}', [UserProfileController::class, 'updateBio']);

//messages

Route::middleware(['auth'])->group(function () {
    Route::get('/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/conversation/{userId}', [MessageController::class, 'showConversation'])->name('messages.conversation');
});







// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
