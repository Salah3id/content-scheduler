<?php

namespace App\DTOs\Posts;

use App\Models\Post;

class PostPublishData
{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
        public readonly string $image = '',
    ) {}

    public static function fromModel(Post $post): self
    {
        return new self(
            title: $post->title,
            content: $post->content,
            image: $post->getFirstMediaUrl("post_cover"),
        );
    }
}