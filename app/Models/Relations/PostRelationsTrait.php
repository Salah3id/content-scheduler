<?php

namespace App\Models\Relations;

use App\Models\Platform;
use App\Models\PostPlatform;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait PostRelationsTrait
{

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'post_platforms')->withPivot('platform_status');
    }
}