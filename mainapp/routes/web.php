<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;


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

// ADMIN 
// FIXME: BUILD OUT ADMIN PORTAL
Route::get('/admin', [AdminController::class, 'adminGate'])->middleware('can:visitAdminPages');

// USER ROUTES 
Route::get('/', [UserController::class, "homepage"])->name('login');
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('mustBeLoggedIn');
Route::get('/manage-avatar', [UserController::class, "showAvatarForm"])->middleware('mustBeLoggedIn');
Route::post('/manage-avatar', [UserController::class, "storeAvatar"])->middleware('mustBeLoggedIn');


// BLOG ROUTES 
Route::get('/create-post',[PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post',[PostController::class, 'storeNewPost'])->middleware('auth');
Route::get('/post/{post}',[PostController::class, 'viewSinglePost'])->middleware('auth');
Route::delete('/post/{post}',[PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit',[PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}',[PostController::class, 'updateBlogPost'])->middleware('can:update,post');
Route::get('/search/{term}',[PostController::class, 'search'])->middleware('auth');

// PROFILE ROUTES 
Route::get('/profile/{user:username}',[ProfileController::class, 'profile'])->middleware('auth');
Route::get('/profile/{user:username}/followers',[ProfileController::class, 'profileFollowers'])->middleware('auth');
Route::get('/profile/{user:username}/following',[ProfileController::class, 'profileFollowing'])->middleware('auth');

// FOLLOW ROUTES
Route::post('/follow/{user:username}', [FollowController::class, 'follow'])->middleware('mustBeLoggedIn');
Route::post('/unfollow/{user:username}', [FollowController::class, 'unfollow'])->middleware('mustBeLoggedIn');

// CHAT ROUTES
Route::post('/send-chat-message', [ChatController::class, 'sendChat'])->middleware('mustBeLoggedIn');