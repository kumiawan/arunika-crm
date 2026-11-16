<?php

namespace App\Filament\Resources\Visits\Tables;

use App\Enums\ClosingType;
use App\Enums\Membership;
use App\Models\Visit;
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
            ->modifyQueryUsing(fn(Builder $query) => $query->with(['customer', 'clinic']))
            ->columns([
                TextColumn::make('visit_date')->label('Tanggal')->date('d/m/Y')->sortable(),
                TextColumn::make('customer.name')->label('Customer')->searchable(),
                TextColumn::make('clinic.name')->label('Klinik')->badge(),
                TextColumn::make('status')
                    ->label('Status')
                    ->state(fn(Visit $record) => $record->customer?->first_visit_at?->isSameDay($record->visit_date) ? 'Baru' : 'Lama')
                    ->badge()
                    ->color(fn(string $state) => $state === 'Baru' ? 'success' : 'gray'),
                TextColumn::make('membership')->label('Anggota')->badge(),
                TextColumn::make('closing_type')->label('Tipe')->badge()->toggleable(),
                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->formatStateUsing(fn($state) => $state === null ? '-' : 'Rp ' . number_format($state, 0, ',', '.'))
                    ->alignEnd()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('clinic_id')
                    ->label('Klinik')
                    ->relationship('clinic', 'name'),
                SelectFilter::make('membership')
                    ->label('Anggota')
                    ->options(Membership::class),
                SelectFilter::make('closing_type')
                    ->label('Tipe')
                    ->options(ClosingType::class),
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
