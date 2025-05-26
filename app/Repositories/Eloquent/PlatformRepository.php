<?php

namespace App\Repositories\Eloquent;

use App\Enums\PlatformStatus;
use App\Models\Platform;
use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\Contracts\PlatformRepositoryInterface;

class PlatformRepository extends BaseRepository implements PlatformRepositoryInterface
{
    protected $allowedIncludes = [];
    protected $allowedFilters = [];
    protected $allowedFiltersExact = [
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
        return Platform::class;
    }

    public function getPostStats()
    {
        return $this->model()::query()
            ->leftJoin('platform_post', 'platforms.id', '=', 'platform_post.platform_id')
            ->select('platforms.*')
            ->selectRaw("
            COUNT(CASE WHEN platform_post.platform_status = ? THEN 1 END) as scheduled_count,
            COUNT(CASE WHEN platform_post.platform_status = ? THEN 1 END) as published_count,
            COUNT(CASE WHEN platform_post.platform_status = ? THEN 1 END) as failed_on_publish_count,
            COUNT(CASE WHEN platform_post.platform_status = ? THEN 1 END) as failed_on_delete_count,
            COUNT(platform_post.id) as total_posts
        ", [
                PlatformStatus::SCHEDULED->value,
                PlatformStatus::PUBLISHED->value,
                PlatformStatus::FAILED_ON_PUBLISH->value,
                PlatformStatus::FAILED_ON_DELETE->value,
            ])
            ->groupBy('platforms.id')
            ->get()
            ->map(function ($platform) {
                $total = $platform->total_posts;

                $platform->publishing_success_rate = $total > 0
                    ? round(($platform->published_count / $total) * 100, 2)
                    : 0;

                $failedCount = $platform->failed_on_publish_count;

                $platform->publishing_failure_rate = $total > 0
                    ? round(($failedCount / $total) * 100, 2)
                    : 0;

                return $platform;
            });
    }
}
