<?php

namespace App\Services;

use App\Actions\Posts\CreatePostAction;
use App\Actions\Posts\UpdatePostAction;
use App\DTOs\Posts\CreatePostData;
use App\DTOs\Posts\PostPublishData;
use App\DTOs\Posts\UpdatePostData;
use App\Enums\PlatformStatus;
use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

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

        //TODO: Delete through Platforms Strategies
        $post->status = PostStatus::DELETED;

        return $post->delete();
    }

    public function publish(Post $post): bool
    {
        if ($post->platforms->isEmpty()) {
            return false;
        }

        $allPublished = true;

        foreach ($post->platforms as $platform) {
            try {
                $strategy = $platform->type->strategy();

                $success = $strategy->publish(PostPublishData::fromModel($post));

                $post->platforms()->updateExistingPivot($platform->id, [
                    'platform_status' => $success ? PlatformStatus::PUBLISHED : PlatformStatus::FAILED_ON_PUBLISH
                ]);

                if (!$success) {
                    $allPublished = false;
                    Log::error('Post publishing failed', [
                        'post_id' => $post->id,
                        'platform_id' => $platform->id,
                        'platform_name' => $platform->name
                    ]);
                }
            } catch (\Exception $e) {
                $allPublished = false;
                $post->platforms()->updateExistingPivot($platform->id, [
                    'platform_status' => PlatformStatus::FAILED_ON_PUBLISH
                ]);

                Log::error('Exception during post publishing', [
                    'post_id' => $post->id,
                    'platform_id' => $platform->id,
                    'platform_name' => $platform->name,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        if (!$allPublished) {
            Log::warning('Not all platforms published successfully', [
                'post_id' => $post->id,
                'platforms' => $post->platforms->pluck('name')->toArray()
            ]);
        }

        $post->update(['status' => PostStatus::PUBLISHED]);


        return $allPublished;
    }
}
