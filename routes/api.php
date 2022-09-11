<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{post:slug}', [PostsController::class, 'show']);
Route::get('/users/{user}', [UsersController::class, 'show']);
Route::get('/roles', [RolesController::class, 'index']);
Route::post('/forgot-password', [ResetPasswordController::class, 'forgot']);

Route::group(['middleware' => 'auth:sanctum'], function () {
//    private routes
    Route::get('/users', [UsersController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [UsersController::class, 'me']);
    Route::get('/me/posts', [UsersController::class, 'userPosts']);
    Route::post('/me', [UsersController::class, 'editMe']);
    Route::post('/posts/store', [PostsController::class, 'store']);
    Route::delete('/users/{user}', [UsersController::class, 'destroy']);
}
);
