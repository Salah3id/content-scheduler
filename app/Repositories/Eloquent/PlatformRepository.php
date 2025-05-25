<?php

namespace App\Repositories\Eloquent;

use App\Models\Platform;
use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\Contracts\PlatformRepositoryInterface;

class PlatformRepository extends BaseRepository implements PlatformRepositoryInterface
{
    protected $allowedIncludes = [];
    protected $allowedFilters = [];
    protected $allowedFiltersExact = [];
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
}
