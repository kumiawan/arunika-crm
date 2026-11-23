<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customer', Customer::count())
                ->description('Seluruh pelanggan terdaftar')
                ->icon('heroicon-o-users')
                ->color('success'),

            Stat::make('Customer Baru Bulan Ini', Customer::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count())
                ->description('Bulan ' . now()->translatedFormat('F Y'))
                ->icon('heroicon-o-user-plus')
                ->color('info'),
        ];
    }
}
