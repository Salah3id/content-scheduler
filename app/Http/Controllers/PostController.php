<?php

namespace App\Http\Controllers;

use App\DTOs\Posts\CreatePostData;
use App\DTOs\Posts\UpdatePostData;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PlatformResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Services\PostService;
use App\Traits\ControllerResponseTrait;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ControllerResponseTrait;

    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $posts = $this->repository
            ->applyQuery()
            ->ownedByUser()
            ->with('platforms')
            ->orderByDesc('created_at')
            ->paginate(10);

        return $this->addData('posts', $posts)
            ->addFilterData($this->repository->getFiltersFromRequest())
            ->useResource(PostResource::class, true)
            ->useView('Posts/Index')
            ->response();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->useView('Posts/Create')
            ->addData('platforms', PlatformResource::collection(
                app(PlatformRepositoryInterface::class)->all()
            ))
            ->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request, PostService $service)
    {
        $post = $service->create(
            data: CreatePostData::fromRequest($request)
        );

        return $this->addData('post', $post)
            ->useResource(PostResource::class)
            ->addData('toast', [
                'type' => 'success',
                'message' => 'Post created successfully',
            ])
            ->addRedirect('posts.index')
            ->response();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return $this->addData('post', $post->load('platforms'))
            ->addData('platforms', PlatformResource::collection(
                app(PlatformRepositoryInterface::class)->all()
            ))
            ->useView('Posts/Edit')
            ->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post, PostService $service)
    {
        $post = $service->update(
            data: UpdatePostData::fromRequest($request)
        );

        return $this->addData('post', $post)
            ->useResource(PostResource::class)
            ->addData('toast', [
                'type' => 'success',
                'message' => 'Post updated successfully',
            ])
            ->addRedirect('posts.index', ['filter[id]' => $post->id])
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, PostService $service)
    {
        $service->delete($post);
        
        return $this
            ->addData('post', $post)
            ->addData('toast', [
                'type' => 'success',
                'message' => 'Post deleted successfully',
            ])

            ->useResource(PostResource::class)
            ->addRedirect('posts.index')
            ->response();
    }
}
