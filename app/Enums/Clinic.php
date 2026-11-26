<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Clinic: string implements HasLabel
{
    case Studio = 'studio';
    case Pusat = 'pusat';

    public function getLabel(): string
    {
        return match ($this) {
            self::Studio => 'Klinik Studio',
            self::Pusat => 'Klinik Pusat',
        };
    }
}
