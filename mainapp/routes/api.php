<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostApiController;
use App\Http\Controllers\UserLoginApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User Login API
Route::post('/login', [UserLoginApiController::class, 'create']);

// Post API
Route::post('/post', [PostApiController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/delete-post/{post}', [PostApiController::class, 'destroy'])->middleware('auth:sanctum', 'can:delete,post');

// Category API
Route::apiResource('categories', CategoryController::class);
