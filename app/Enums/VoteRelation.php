<?php

namespace App\Enums;

enum VoteRelation: string
{
    case REL_USER = 'user';
    case REL_POST = 'post';

    public function label(): string
    {
        return match ($this) {
            self::REL_USER => __('Vartotojas'),
            self::REL_POST => __('Naujiena'),
        };
    }

    public static function toArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($relation) => [$relation->value => $relation->label()])
            ->toArray();
    }
}
