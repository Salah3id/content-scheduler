<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('guest')->group(function () {
    Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])
        ->name('api.register');

    Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])
        ->name('api.login');

    Route::post('/password/email', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])
        ->name('api.password.email');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', [App\Http\Controllers\Settings\ProfileController::class, 'edit'])
        ->name('api.profile.edit');

    Route::put('/user/profile', [App\Http\Controllers\Settings\ProfileController::class, 'update'])
        ->name('api.profile.update');

    Route::delete('/user/profile', [App\Http\Controllers\Settings\ProfileController::class, 'destroy'])
        ->name('api.profile.destroy');

    Route::get('/dashboard', [App\Http\Controllers\PagesController::class, 'dashboard'])
        ->name('api.dashboard');

    Route::resource('posts', App\Http\Controllers\PostController::class)
        ->except(['show'])
        ->names('api.posts');
});
