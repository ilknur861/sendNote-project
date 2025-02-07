<?php

namespace App\Enums;

enum BlogCategoryEnum: string
{
    //
    case BACKEND = 'Backend';
    case FRONTEND = 'Frontend';
    case AI = 'AI';
    case ML = 'ML';
    case DATASCIENCE = 'Data science';

    public static function options(): array
    {
        return array_map(fn($category) => $category->value, self::cases());
    }
}
