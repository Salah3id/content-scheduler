<?php

namespace App\Models\Relations;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait PostRelationsTrait
{

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class)
            ->withPivot('platform_status');
    }
}
