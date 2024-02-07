<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\ProfilePostController;
use App\Http\Controllers\ProfileFollowerController;
use App\Http\Controllers\ProfileFollowingController;


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
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// User Routes
Route::post('/register', [UserController::class, 'store'])->middleware('guest');

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

// Profile 
Route::get('/profile/{user:username}',[ProfilePostController::class, 'show'])->middleware('auth');
Route::get('/profile/{user:username}/followers',[ProfileFollowerController::class, 'show'])->middleware('auth');
Route::get('/profile/{user:username}/following',[ProfileFollowingController::class, 'show'])->middleware('auth');


Route::middleware('cache.headers:public;max_age=2;etag')->group(function() {
// Group - disk cache for 2 seconds the data for post, followers, and following. (Speed improvement)
    Route::get('/profile/{user:username}/json',[ProfilePostController::class, 'index'])->middleware('auth');
    Route::get('/profile/{user:username}/followers/json',[ProfileFollowerController::class, 'index'])->middleware('auth');
    Route::get('/profile/{user:username}/following/json',[ProfileFollowingController::class, 'index'])->middleware('auth');
});

// Follow Routes
Route::post('/follow/{user:username}', [FollowController::class, 'create'])->middleware('mustBeLoggedIn');
Route::post('/unfollow/{user:username}', [FollowController::class, 'destroy'])->middleware('mustBeLoggedIn');

// Chat Routes
Route::post('/send-chat-message', [ChatController::class, 'create'])->middleware('mustBeLoggedIn');