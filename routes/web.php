<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFollowController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    //user routes
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');

    //post routes
    Route::post('/posts', [PostController::class, 'store'])->name('posts.create');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.delete');

    //comment routes
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.create');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.delete');

    //follow routes
    Route::post('/follow/{userId}', [UserFollowController::class, 'follow'])->name('follow');
    Route::delete('/unfollow/{userId}', [UserFollowController::class, 'unfollow'])->name('unfollow');
});
