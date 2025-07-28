<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFollowController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// auth routes
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/register', [UserController::class, 'create'])->name('users.create');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/login', [UserController::class, 'loginForm'])->name('login.form');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// view post
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->where('post', '[0-9]+')
    ->name('posts.show');


// view user profile
Route::get('/profile/{userId}', [UserController::class, 'show'])->name('profile.show');

Route::middleware('auth')->group(function () {
    //user routes
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::get('/profile/{userId}/edit', [UserController::class, 'edit'])->name('profile.edit');

    //post routes
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    //like/unlike post
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{post}/like', [PostController::class, 'unlike'])->name('posts.unlike');

    //comment routes
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    //like/unlike comment
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::delete('/comments/{comment}/like', [CommentController::class, 'unlike'])->name('comments.unlike');

    //follow routes
    Route::post('/follow/{userId}', [UserFollowController::class, 'follow'])->name('follow');
    Route::delete('/unfollow/{userId}', [UserFollowController::class, 'unfollow'])->name('unfollow');
});
