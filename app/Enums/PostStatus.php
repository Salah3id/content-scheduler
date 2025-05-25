<?php
namespace App\Enums;

enum PostStatus: int
{
    case SCHEDULED = 0;
    case PUBLISHED = 1;
    case DELETED = 2;

    public function label(): string
    {
        return match ($this) {
            self::PUBLISHED => 'Published',
            self::SCHEDULED => 'Scheduled',
            self::DELETED => 'Deleted',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PUBLISHED => 'green',
            self::SCHEDULED => 'yellow',
            self::DELETED => 'red',
        };
    }

}