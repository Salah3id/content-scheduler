<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use App\Traits\ControllerResponseTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagesController extends Controller
{
    use ControllerResponseTrait;
    public function home()
    {
        return Inertia::render('Welcome');
    }

    public function dashboard()
    {
        $platforms = app(PlatformRepositoryInterface::class)
        ->getPostStats()
        ->load('users');

        return $this
            ->useView('Dashboard')
            ->useResource(PlatformResource::class, true)
            ->addData('platforms', $platforms)
            ->response();
    }
}
