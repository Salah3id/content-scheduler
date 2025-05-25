<?php

namespace App\Http\Controllers;

use App\DTOs\Posts\CreatePostData;
use App\Http\Requests\CreatePostRequest;
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


        dd($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $post->load('platforms');

        return $this->addData('post', $post)
            ->useView('Posts/Edit')
            ->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
