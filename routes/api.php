<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Http\Request;

Route::middleware('guest')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('api.register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('api.login');

    Route::post('/password/email', [PasswordResetLinkController::class, 'store'])
        ->name('api.password.email');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/profile', [ProfileController::class, 'edit'])
        ->name('api.profile.edit');

    Route::put('/user/profile', [ProfileController::class, 'update'])
        ->name('api.profile.update');

    Route::delete('/user/profile', [ProfileController::class, 'destroy'])
        ->name('api.profile.destroy');

    Route::get('/dashboard', [PagesController::class, 'dashboard'])
        ->name('api.dashboard');

    Route::resource('posts', PostController::class)
        ->except(['show'])
        ->names('api.posts');

    Route::resource('platforms', PlatformController::class)
        ->only(['index'])
        ->names('api.platforms');

    Route::post('platforms/{platform}/toggle', [PlatformController::class, 'toggleUserStatus'])
        ->name('api.platforms.toggleUserStatus');

    Route::get('/posts/analytics', [PagesController::class, 'dashboard'])
        ->name('api.posts.analytics');
});
