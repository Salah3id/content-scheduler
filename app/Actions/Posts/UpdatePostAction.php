<?php

namespace App\Actions\Posts;

use App\DTOs\Posts\UpdatePostData;
use App\Models\Post;
use App\Repositories\Eloquent\PostRepository;

class UpdatePostAction
{
    public function execute(UpdatePostData $data): Post
    {
        $post = app(PostRepository::class)->update($data);

        return $post;
    }
}
