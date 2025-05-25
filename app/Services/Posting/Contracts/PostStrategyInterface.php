<?php

namespace App\Services\Posting\Contracts;

interface PostStrategyInterface
{
    /**
     * Publish a post.
     *
     * @param array $data
     * @return mixed
     */
    public function publish(array $data);


    /**
     * Delete a post.
     *
     * @param int|string $postId
     * @return mixed
     */
    public function delete($postId);
}