<?php

namespace App\Providers;

use App\Models\Platform;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Repositories\Eloquent\PlatformRepository;
use App\Repositories\Eloquent\PostRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register repository bindings.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public $bindings = [
        PostRepositoryInterface::class => PostRepository::class,
        PlatformRepositoryInterface::class => PlatformRepository::class,
    ];
}