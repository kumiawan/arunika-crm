<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case TunaiTransfer = 'tunai_transfer';
    case PotongSaldo = 'potong_saldo';

    public function getLabel(): string
    {
        return match ($this) {
            self::TunaiTransfer => 'Tunai atau transfer',
            self::PotongSaldo => 'Potong saldo',
        };
    }
}
