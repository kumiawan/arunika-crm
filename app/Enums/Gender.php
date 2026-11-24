<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel, HasColor
{
    case LakiLaki = 'laki_laki';
    case Perempuan = 'perempuan';

    public function getLabel(): string
    {
        return match ($this) {
            self::LakiLaki => 'L',
            self::Perempuan => 'P',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::LakiLaki => 'info',
            self::Perempuan => 'danger',
        };
    }
}
