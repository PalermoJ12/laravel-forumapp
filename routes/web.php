<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [LoginController::class, 'login'])->name('login.request');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.request');


Route::middleware('auth:sanctum')->group(function () {


    Route::get('logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/posts', [PostController::class, 'index'])->name('home');
    Route::post('create', [PostController::class, 'store'])->name('create');
    Route::get('show/{id}', [PostController::class, 'show'])->name('show');
    Route::get('edit/{id}', [PostController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [PostController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [PostController::class, 'destroy'])->name('delete');

    Route::get('/posts/create', function () {
        return view('posts.create');
    })->name('posts.create');

});



