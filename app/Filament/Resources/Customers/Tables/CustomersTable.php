<?php

namespace App\Filament\Resources\Customers\Tables;

use App\Enums\Membership;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('wa')->label('WA')->searchable()->copyable(),
                TextColumn::make('firstClinic.name')->label('Klinik pertama')->badge(),
                TextColumn::make('membership')->label('Anggota')->badge(),
                TextColumn::make('source')->label('Sumber')->badge()->toggleable(),
                TextColumn::make('first_visit_at')->label('Kunjungan pertama')->date('d/m/Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('first_clinic_id')
                    ->label('Klinik')
                    ->relationship('firstClinic', 'name'),
                SelectFilter::make('membership')
                    ->label('Anggota')
                    ->options(Membership::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }
}
