<?php

namespace App\Services\Posting\Strategies;

use App\Services\Posting\Contracts\PostStrategyInterface;

class LinkedInStrategy implements PostStrategyInterface
{
    public function publish(array $data)
    {
        return true;
    }

    public function delete($postId)
    {
        return true;
    }
}