<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;


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
Route::get('/', [UserController::class, "homepage"]);

// Register
Route::post('/register', [UserController::class, "register"]);

// Login
Route::post('/login', [UserController::class, "login"]);

// Logout
Route::post('/logout', [UserController::class, "logout"]);

//=============//
// BLOG ROUTES //
//=============//
Route::get('/create-post',[PostController::class, 'showCreateForm']);
Route::post('/create-post',[PostController::class, 'storeNewPost']);

Route::get('/post/{post}',[PostController::class, 'viewSinglePost']);