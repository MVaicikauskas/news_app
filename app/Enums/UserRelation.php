<?php

namespace App\Enums;

enum UserRelation: string
{
    case REL_POSTS = 'posts';
    case REL_VOTES = 'votes';

    public function label(): string
    {
        return match ($this) {
            self::REL_POSTS => __('Naujienos'),
            self::REL_VOTES => __('Balsai'),
        };
    }

    public static function toArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($relation) => [$relation->value => $relation->label()])
            ->toArray();
    }
}
