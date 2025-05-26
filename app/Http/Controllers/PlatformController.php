<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlatformResource;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use App\Traits\ControllerResponseTrait;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    use ControllerResponseTrait;

    public function __construct(PlatformRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $platforms = $this->repository
            ->applyQuery()
            ->paginate(10);

        return $this->addData('platforms', $platforms->load('users'))
            ->useResource(PlatformResource::class, true)
            ->useView('Platforms/Index')
            ->response();
    }

    public function toggleUserStatus(Request $request, int $platformId)
    {
        $platform = $this->repository->findOrFail($platformId);

        // TODO: refactor this to a service
        $userId = $request->user()->id;
        $currentStatus = $platform->users()
            ->wherePivot('user_id', $userId)
            ->first()
            ->pivot
            ->is_active;

        $platform->users()->updateExistingPivot($userId, [
            'is_active' => !$currentStatus
        ]);

        return $this
            ->addData('platform', $platform->load('users'))
            ->useResource(PlatformResource::class)
            ->addRedirect('platforms.index')
            ->addData('toast', [
                'type' => 'success',
                'message' => 'User status toggled successfully.',
            ])
            ->response();
    }
}
