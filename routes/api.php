<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ImagesController;

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

Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{post:slug}', [PostsController::class, 'show']);
Route::get('/users/{user}', [UsersController::class, 'show']);
Route::get('/roles', [RolesController::class, 'index']);
Route::get('/categories', [CategoriesController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum'], function () {
//    private routes
    Route::get('/users', [UsersController::class, 'index']);
    Route::get('/me', [UsersController::class, 'me']);
    Route::get('/me/posts', [UsersController::class, 'userPosts']);
    Route::post('/me', [UsersController::class, 'editMe']);
    Route::post('/posts/store', [PostsController::class, 'store']);
    Route::delete('/users/{user}', [UsersController::class, 'destroy']);
    Route::post('/images/store', [ImagesController::class, 'store']);
    Route::delete('/posts/{post:slug}', [PostsController::class, 'destroy']);
    Route::put('/posts/{post:slug}', [PostsController::class, 'update']);
}
);
