<?php

namespace App\Models\Relations;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait UserRelationsTrait
{

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class)
            ->withPivot('is_active')
            ->withTimestamps();
    }
}
