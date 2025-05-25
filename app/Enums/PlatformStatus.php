<?php

namespace App\Enums;

enum PlatformStatus: int
{
    case SCHEDULED = 0;
    case PUBLISHED = 1;
    case DELETED = 2;
    case FAILED_ON_PUBLISH = 3;
    case FAILED_ON_DELETE = 4;

    public function label(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Scheduled',
            self::PUBLISHED => 'Published',
            self::DELETED => 'Deleted',
            self::FAILED_ON_PUBLISH => 'Failed on Publish',
            self::FAILED_ON_DELETE => 'Failed on Delete',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SCHEDULED => 'orange',
            self::PUBLISHED => 'green',
            self::DELETED => 'gray',
            self::FAILED_ON_PUBLISH => 'red',
            self::FAILED_ON_DELETE => 'red',
        };
    }

}