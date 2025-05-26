<?php

namespace App\Services;

use App\Actions\Posts\CreatePostAction;
use App\Actions\Posts\UpdatePostAction;
use App\DTOs\Posts\CreatePostData;
use App\DTOs\Posts\UpdatePostData;
use App\Enums\PostStatus;
use App\Models\Post;

class PostService
{
    public function __construct(
        protected CreatePostAction $createPostAction,
        protected UpdatePostAction $updatePostAction
    ) {}

    public function create(CreatePostData $data): Post
    {
        return $this->createPostAction->execute($data);
    }

    public function update(UpdatePostData $data): Post
    {
        return $this->updatePostAction->execute($data);
    }

    public function delete(Post $post): bool
    {
        $post->status = PostStatus::DELETED;
        $post->save();
        
        return $post->delete();
    }
}
