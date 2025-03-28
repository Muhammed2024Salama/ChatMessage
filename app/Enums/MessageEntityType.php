<?php

namespace App\Enums;

enum MessageEntityType: string
{
    case PROJECT = 'project';
    case PROPERTY = 'property';
    case DEVELOPER = 'developer';

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
