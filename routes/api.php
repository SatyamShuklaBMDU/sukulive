<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\DiamondController;
use App\Http\Controllers\API\FollowController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PlansController;
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
Route::post('reset-password', [LoginController::class, 'resetPassword'])->middleware('auth:sanctum');

Route::post('follow', [FollowController::class, 'follow'])->middleware('auth:sanctum');
Route::post('unfollow', [FollowController::class, 'unfollow'])->middleware('auth:sanctum');

Route::post('customers/media', [PostController::class, 'uploadMedia'])->middleware('auth:sanctum');
Route::get('customers/media', [PostController::class, 'getMedia'])->middleware('auth:sanctum');
Route::get('random/posts',[PostController::class,'randomPost'])->middleware('auth:sanctum');

Route::post('posts/like-unlike', [LikeController::class, 'likeOrUnlikePost'])->middleware('auth:sanctum');

Route::post('posts/add-comment', [CommentController::class, 'addComment'])->middleware('auth:sanctum');

Route::post('notifications', [NotificationController::class, 'getNotifications'])->middleware('auth:sanctum');

Route::get('get-plans', [PlansController::class, 'getPlans'])->middleware('auth:sanctum');

Route::get('diamonds', [DiamondController::class, 'getDiamonds'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/messages', [MessageController::class, 'sendMessage']);
    Route::get('/conversation/{conversation_id}/messages', [MessageController::class, 'getMessages']);
});
