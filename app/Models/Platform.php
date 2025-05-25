<?php

namespace App\Models;

use App\Enums\PlatformType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    protected $casts = [
        'type' => PlatformType::class,
    ];
}
