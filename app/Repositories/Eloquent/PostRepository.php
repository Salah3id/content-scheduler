<?php

namespace App\Repositories\Eloquent;

use App\DTOs\Posts\CreatePostData;
use App\DTOs\Posts\UpdatePostData;
use App\Enums\PostStatus;
use App\Models\Post;
use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\Contracts\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    protected $allowedIncludes = [
        'platforms',
    ];
    protected $allowedFilters = [
        'scheduled_time',
        'user_id',

    ];
    protected $allowedFiltersExact = [
        'status',
        'id',
    ];
    protected $allowedRelationSort = [];
    protected $allowedFilterScopes = [];
    protected $allowedFields = [];
    protected $allowedAppends = [];
    protected $allowedSorts = [];
    protected $allowedDefaultSorts = [];

    public function model()
    {
        return Post::class;
    }

    public function ownedByUser($userId = null)
    {
        if (is_null($userId)) {
            $userId = auth()->id();
        }

        if (is_null($userId)) {
            throw new \InvalidArgumentException('User ID must be provided or authenticated user must be available.');
        }

        $this->model->where('user_id', $userId);

        return $this;
    }

    public function create(CreatePostData $data): Post
    {

        $post = $this->model->create($data->toArray());

        $syncPlatforms = array_fill_keys($data->platform_ids, ['platform_status' => PostStatus::SCHEDULED]);

        $post->platforms()->sync($syncPlatforms);

        return $post;
    }

    public function update(UpdatePostData $data): Post
    {

        $post = $this->model->findOrFail($data->post_id);

        $existingPlatforms = $post->platforms()->pluck('platform_id')->toArray();

        $syncPlatforms = [];
        foreach ($data->platform_ids as $platformId) {
            if (in_array($platformId, $existingPlatforms)) {
            $syncPlatforms[$platformId] = [];
            } else {
            $syncPlatforms[$platformId] = ['platform_status' => PostStatus::SCHEDULED];
            }
        }

        $post->update($data->toArray());

        $syncPlatforms = array_fill_keys($data->platform_ids, ['platform_status' => PostStatus::SCHEDULED]);

        $post->platforms()->sync($syncPlatforms);

        return $post;
    }
}
