<?php

namespace App\Filament\Resources\Customers\Tables;

use App\Enums\Gender;
use App\Enums\Clinic;
use App\Enums\Membership;
use App\Enums\PatientType;
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
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex(),

                TextColumn::make('external_id')
                    ->label('No. ID')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('name')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('birth_date')
                    ->label('Tgl. Lahir')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('gender')
                    ->label('JK')
                    ->badge(),

                TextColumn::make('wa')
                    ->label('WhatsApp')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('age')
                    ->label('Usia')
                    ->suffix(' th')
                    ->placeholder('-'),

                TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(40)
                    ->tooltip(fn($state) => $state)
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('occupation')
                    ->label('Pekerjaan')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('membership')
                    ->label('Membership')
                    ->badge(),

                TextColumn::make('patient_type')
                    ->label('Tipe Pasien')
                    ->badge()
                    ->sortable(),

                // Kolom lama, disembunyikan secara default
                TextColumn::make('first_clinic')
                    ->label('Klinik pertama')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('source')
                    ->label('Sumber')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('first_visit_at')
                    ->label('Kunjungan pertama')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                SelectFilter::make('first_clinic')
                    ->label('Klinik')
                    ->options(Clinic::class),
                SelectFilter::make('membership')
                    ->label('Keanggotaan')
                    ->options(Membership::class),
                SelectFilter::make('patient_type')
                    ->label('Tipe Pasien')
                    ->options(PatientType::class),
                SelectFilter::make('gender')
                    ->label('JK')
                    ->options(Gender::class),
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
