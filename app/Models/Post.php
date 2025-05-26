<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Models\Relations\PostRelationsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory, PostRelationsTrait, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'content',
        'scheduled_time',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => PostStatus::class,
        'scheduled_time' => 'datetime',
    ];
}
