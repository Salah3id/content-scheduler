<?php

namespace App\Services\Posting\Contracts;

use App\DTOs\Posts\PostPublishData;

interface PostStrategyInterface
{
    /**
     * Publish a post.
     *
     * @param array $data
     * @return mixed
     */
    public function publish(PostPublishData $data);


    /**
     * Delete a post.
     *
     * @param int|string $postId
     * @return mixed
     */
    public function delete($postId);
}