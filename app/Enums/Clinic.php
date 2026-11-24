<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Clinic: string implements HasLabel
{
    case Studio = 'Studio';
    case Pusat = 'Pusat';

    public function getLabel(): string
    {
        return match ($this) {
            self::Studio => 'Klinik Studio',
            self::Pusat => 'Klinik Pusat',
        };
    }
}
