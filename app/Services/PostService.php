<?php

namespace App\Services;

use App\Actions\Posts\CreatePostAction;
use App\DTOs\Posts\CreatePostData;
use App\Models\Post;

class PostService
{
    public function __construct(
        protected CreatePostAction $createPostAction,
    ) {}

    public function create(CreatePostData $data): Post
    {
        return $this->createPostAction->execute($data);
    }
}
