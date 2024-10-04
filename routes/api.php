<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ImageController;

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('profile', [ApiController::class, 'profile']);
    Route::put('profile/update', [ApiController::class, 'updatePassword']);
    Route::post('profile/updateImg', [ApiController::class, 'updateImg']);
    Route::get('logout', [ApiController::class, 'logout']);
    Route::post('generate', [ImageController::class, 'generate']);
    Route::post('posts', [PostController::class, 'store']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);
});

Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{id}', [PostController::class, 'show']);
