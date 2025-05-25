<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\PlatformStatus;

class PostPlatform extends Model
{
    use PlatformStatus;

    protected $casts = [
        'platform_status' => PlatformStatus::class,
    ];
}
