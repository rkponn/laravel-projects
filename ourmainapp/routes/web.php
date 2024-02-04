<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//=============//
// USER ROUTES //
//=============//
// Home
Route::get('/', [UserController::class, "homepage"])->name('login');
// Register
Route::post('/register', [UserController::class, "register"])->middleware('guest');
// Login
Route::post('/login', [UserController::class, "login"])->middleware('guest');
// Logout
Route::post('/logout', [UserController::class, "logout"])->middleware('mustBeLoggedIn');


//=============//
// BLOG ROUTES //
//=============//
Route::get('/create-post',[PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post',[PostController::class, 'storeNewPost'])->middleware('auth');
Route::get('/post/{post}',[PostController::class, 'viewSinglePost'])->middleware('auth');
Route::delete('/post/{post}',[PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit',[PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}',[PostController::class, 'updateBlogPost'])->middleware('can:update,post');

//================//
// PROFILE ROUTES //
//================//
Route::get('/profile/{user:username}',[ProfileController::class, 'profile'])->middleware('auth');