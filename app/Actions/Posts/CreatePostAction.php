<?php

namespace App\Actions\Posts;

use App\DTOs\Posts\CreatePostData;
use App\Models\Post;
use App\Repositories\Eloquent\PostRepository;

class CreatePostAction
{
    public function execute(CreatePostData $data): Post
    {
        $post = app(PostRepository::class)->create($data);

        return $post;
    }
}
