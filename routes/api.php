<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;

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
Route::get('/posts/{slug}', [PostsController::class, 'show']);
Route::get('/users/{user}', [UsersController::class, 'show']);


Route::group(['middleware' => 'auth:sanctum'], function () {
//    private routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [UsersController::class, 'me']);
    Route::get('/me/posts', [UsersController::class, 'userPosts']);
}
);
