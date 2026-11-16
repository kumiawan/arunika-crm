<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ClosingType: string implements HasLabel
{
    case PembelianProduk = 'pembelian_produk';
    case Treatment = 'treatment';
    case TopUpMember = 'top_up_member';
    case JoinMember = 'join_member';
    case Promo = 'promo';
    case PelunasanDp = 'pelunasan_dp';
    case Klaim = 'klaim';
    case Lainnya = 'lainnya';

    public function getLabel(): string
    {
        return match ($this) {
            self::PembelianProduk => 'Pembelian produk',
            self::Treatment => 'Treatment',
            self::TopUpMember => 'Top up member',
            self::JoinMember => 'Join member',
            self::Promo => 'Promo',
            self::PelunasanDp => 'Pelunasan atau DP',
            self::Klaim => 'Klaim paket',
            self::Lainnya => 'Lainnya',
        };
    }
}
