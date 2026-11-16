<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CustomerSource: string implements HasLabel
{
    case Instagram = 'instagram';
    case Facebook = 'facebook';
    case Tiktok = 'tiktok';
    case Event = 'event';
    case Teman = 'teman';

    public function getLabel(): string
    {
        return match ($this) {
            self::Tiktok => 'TikTok',
            default => ucfirst($this->value),
        };
    }
}
