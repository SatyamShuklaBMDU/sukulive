<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\FollowController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PostController;
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

Route::post('sign-up', [LoginController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::post('update-profile', [LoginController::class, 'update'])->middleware('auth:sanctum');

// follow-unfollow api
Route::post('follow', [FollowController::class, 'follow'])->middleware('auth:sanctum');
Route::post('unfollow', [FollowController::class, 'unfollow'])->middleware('auth:sanctum');

// posts api
Route::post('customers/media', [PostController::class, 'uploadMedia'])->middleware('auth:sanctum');
Route::get('customers/media', [PostController::class, 'getMedia'])->middleware('auth:sanctum');

// like api
Route::post('posts/like-unlike', [LikeController::class, 'likeOrUnlikePost'])->middleware('auth:sanctum');

// comment api
Route::post('posts/add-comment', [CommentController::class, 'addComment'])->middleware('auth:sanctum');


//Notification Api
Route::post('notifications', [NotificationController::class, 'getNotifications'])->middleware('auth:sanctum');
