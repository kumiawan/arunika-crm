<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Membership: string implements HasLabel
{
    case Umum = 'umum';
    case Membership = 'membership';
    case Silver = 'silver';
    case Vvip = 'vvip';
    case Intern = 'intern';

    public function getLabel(): string
    {
        return match ($this) {
            self::Vvip => 'VVIP',
            self::Intern => 'Intern (karyawan, keluarga, owner)',
            default => ucfirst($this->value),
        };
    }
}
