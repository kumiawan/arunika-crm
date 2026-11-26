<?php

namespace App\Filament\Resources\Visits\Tables;

use App\Enums\Clinic;
use App\Enums\Membership;
use App\Enums\ClosingType;
use App\Enums\PatientType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->with(['customer']))
            ->columns([
                TextColumn::make('visit_date')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('clinic')
                    ->label('Klinik')
                    ->badge(),
                TextColumn::make('customer.patient_type')
                    ->label('Pasien')
                    ->badge(),
                TextColumn::make('membership')
                    ->label('Membership')
                    ->badge(),
                TextColumn::make('closing_type')
                    ->label('Tipe Transaksi')
                    ->badge()->toggleable(),
                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->formatStateUsing(fn($state)
                        => $state === null ? '-' : 'Rp '
                            . number_format($state, 0, ',', '.'))
                    ->alignEnd()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('clinic')
                    ->label('Klinik')
                    ->options(Clinic::class),
                SelectFilter::make('membership')
                    ->label('Anggota')
                    ->options(Membership::class),
                SelectFilter::make('closing_type')
                    ->label('Tipe')
                    ->options(ClosingType::class),
                SelectFilter::make('customer.patient_type')
                    ->label('Pasien')
                    ->options(PatientType::class)
                    ->query(fn($query, array $data) => filled($data['value'])
                        ? $query->whereHas('customer', fn($q) => $q->where('patient_type', $data['value']))
                        : $query),
                SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->options(fn() => collect(range(0, 23))->mapWithKeys(function ($i) {
                        $bulan = now()->startOfMonth()->subMonths($i);

                        return [$bulan->format('Y-m') => $bulan->translatedFormat('F Y')];
                    })->all())
                    ->query(function (Builder $query, array $data) {
                        if (blank($data['value'] ?? null)) {
                            return $query;
                        }
                        [$year, $month] = explode('-', $data['value']);

                        return $query->whereYear('visit_date', $year)->whereMonth('visit_date', $month);
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('visit_date', 'desc');
    }
}
