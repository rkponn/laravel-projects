<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserLoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. 
|
*/

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('user.index');

// User Routes
Route::post('/register', [UserController::class, 'create'])->middleware('guest');

// User Session Routes
Route::post('/login', [UserLoginController::class, 'store'])->middleware('guest');
Route::post('/logout', [UserLoginController::class, 'destroy'])->middleware('mustBeLoggedIn');

// Avatar routes
Route::get('/manage-avatar', [AvatarController::class, "create"])->middleware('mustBeLoggedIn');
Route::post('/manage-avatar', [AvatarController::class, "store"])->middleware('mustBeLoggedIn');

// Post Routes 
Route::get('/search/{term}',[PostController::class, 'index'])->middleware('auth');
Route::get('/post',[PostController::class, 'create'])->middleware('mustBeLoggedIn');
Route::post('/post',[PostController::class, 'store'])->middleware('auth');
Route::get('/post/{post}',[PostController::class, 'show'])->middleware('auth');
Route::get('/post/{post}/edit',[PostController::class, 'edit'])->middleware('can:update,post');
Route::put('/post/{post}',[PostController::class, 'update'])->middleware('can:update,post');
Route::delete('/post/{post}',[PostController::class, 'destroy'])->middleware('can:delete,post');

// PROFILE ROUTES 
Route::get('/profile/{user:username}',[ProfileController::class, 'profile'])->middleware('auth');
Route::get('/profile/{user:username}/followers',[ProfileController::class, 'profileFollowers'])->middleware('auth');
Route::get('/profile/{user:username}/following',[ProfileController::class, 'profileFollowing'])->middleware('auth');


Route::middleware('cache.headers:public;max_age=20;etag')->group(function() {
// Group - disk cache for 20 seconds the data for post, followers, and following. (Speed improvement)
    Route::get('/profile/{user:username}/json',[ProfileController::class, 'profileJson'])->middleware('auth');
    Route::get('/profile/{user:username}/followers/json',[ProfileController::class, 'profileFollowersJson'])->middleware('auth');
    Route::get('/profile/{user:username}/following/json',[ProfileController::class, 'profileFollowingJson'])->middleware('auth');
});

// FOLLOW ROUTES
Route::post('/follow/{user:username}', [FollowController::class, 'follow'])->middleware('mustBeLoggedIn');
Route::post('/unfollow/{user:username}', [FollowController::class, 'unfollow'])->middleware('mustBeLoggedIn');

// CHAT ROUTES
Route::post('/send-chat-message', [ChatController::class, 'sendChat'])->middleware('mustBeLoggedIn');