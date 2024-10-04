<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\DownloadController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [RegisterController::class, 'create'])->name('registerForm')->middleware('guest');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('login', [LoginController::class, 'create'])->name('loginForm')->middleware('guest');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
Route::get('logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('change-information', [ProfileController::class, 'changeInformation'])->name('changeInformation');
Route::post('update-information', [ProfileController::class, 'updateInformation'])->name('updateInformation');
Route::resource('posts', PostController::class);
Route::get('generate', [ImageController::class, 'generateForm'])->name('generateForm');
Route::post('generate', [ImageController::class, 'generate'])->name('generate');
