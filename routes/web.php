<?php

use App\Http\Controllers\Auth\AuthenticateUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\GlobalFeedController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', GlobalFeedController::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticateUserController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticateUserController::class, 'store']);
    Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisterUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::resource('/posts', PostController::class, [
        'except' => 'index',
    ]);

    Route::post('/posts/{post}/like', LikeController::class)->name('posts.like')->middleware('throttle:5,1');

    // notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    Route::controller(AvatarController::class)->group(function () {
        Route::patch('avatar/update', 'update')->name('profile.avatar.update');
        Route::delete('avatar/delete', 'destroy')->name('profile.avatar.delete');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile/{user}', 'index')->name('profile.index');
        Route::get('profile/{user}/edit', 'edit')->name('profile.edit');
        Route::patch('profile/{user}', 'update')->name('profile.update');
    });

    Route::post('/logout', [AuthenticateUserController::class, 'destroy'])->name('logout');
});
