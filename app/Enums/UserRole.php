<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case AUTHOR = 'author';
    case USER = 'user';
    case ROLES = 'roles';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => __('Administratorius'),
            self::AUTHOR => __('Autorius'),
            self::USER => __('Vartotojas'),
            self::ROLES => __('Rolės'),
        };
    }

    public static function toArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($role) => [$role->value => $role->label()])
            ->toArray();
    }
}
