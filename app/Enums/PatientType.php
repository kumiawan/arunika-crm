<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PatientType: string implements HasLabel, HasColor
{
    case Baru = 'baru';
    case Lama = 'lama';

    public function getLabel(): string
    {
        return match ($this) {
            self::Baru => 'Baru',
            self::Lama => 'Lama',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Baru => 'success',
            self::Lama => 'info',
        };
    }
}
