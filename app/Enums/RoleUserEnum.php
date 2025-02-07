<?php

namespace App\Enums;

enum RoleUserEnum: string
{
    //
    case USER = 'user';
    case ADMIN = 'admin';

    public static function options(): array
    {
        return array_map(fn($category) => $category->value, self::cases());
    }
}
