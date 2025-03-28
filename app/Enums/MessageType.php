<?php

namespace App\Enums;

enum MessageType: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case VIDEO = 'video';
    case DOCUMENT = 'document';
    case AUDIO = 'audio';

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
