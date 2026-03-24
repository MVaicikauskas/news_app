<?php

namespace App\Enums;

enum PostRelation: string
{
    case REL_AUTHOR = 'author';
    case REL_VOTES = 'votes';
    case REL_MEDIA = 'media';

    public function label(): string
    {
        return match ($this) {
            self::REL_AUTHOR => __('Autorius'),
            self::REL_VOTES => __('Balsai'),
            self::REL_MEDIA => __('Media'),
        };
    }

    public static function toArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($relation) => [$relation->value => $relation->label()])
            ->toArray();
    }
}
