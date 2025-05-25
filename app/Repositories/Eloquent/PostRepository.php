<?php

namespace App\Repositories\Eloquent;

use App\DTOs\Posts\CreatePostData;
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
        $postData = [
            ...$data->toArray(),
            'user_id' => auth()->id(),
            'status' => PostStatus::SCHEDULED,
        ];

        $post = $this->model->create($postData);

        $syncPlatforms = array_fill_keys($data->platform_ids, ['platform_status' => PostStatus::SCHEDULED]);

        $post->platforms()->sync($syncPlatforms);

        return $post;
    }
}
