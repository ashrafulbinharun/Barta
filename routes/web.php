<?php

use App\Http\Controllers\Auth\AuthenticateUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/login', [AuthenticateUserController::class, 'create'])->name('login');
Route::post('/login', [AuthenticateUserController::class, 'store']);
Route::post('/logout', [AuthenticateUserController::class, 'destroy'])->name('logout');
Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store']);
