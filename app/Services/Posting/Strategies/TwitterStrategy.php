<?php

namespace App\Services\Posting\Strategies;

use App\DTOs\Posts\PostPublishData;
use App\Services\Posting\Contracts\PostStrategyInterface;

class TwitterStrategy implements PostStrategyInterface
{
    public function publish(PostPublishData $data): bool
    {
        return rand(0, 1); 
    }

    public function delete($postId): bool
    {
        return rand(0, 1); 
    }
}