<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/',[PagesController::class, 'home'])->name('home');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('dashboard', [PagesController::class, 'dashboard'])->name('dashboard');
    Route::resource('posts', PostController::class)->except(['show']);
    Route::resource('platforms', PlatformController::class)->only(['index']);

    Route::post('platforms/{platform}/toggle', [PlatformController::class, 'toggleUserStatus'])
        ->name('platforms.toggleUserStatus');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
