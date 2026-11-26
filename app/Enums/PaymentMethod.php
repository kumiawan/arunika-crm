<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case Tunai = 'tunai';
    case Transfer = 'transfer';
    case PotongSaldo = 'potong_saldo';

    public function getLabel(): string
    {
        return match ($this) {
            self::Tunai => 'Tunai',
            self::Transfer => 'Transfer',
            self::PotongSaldo => 'Potong saldo',
        };
    }
}
