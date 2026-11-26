<?php

namespace App\Filament\Resources\Customers\RelationManagers;

use App\Filament\Resources\Visits\Schemas\VisitForm;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    protected static ?string $title = 'Riwayat kunjungan';

    public function form(Schema $schema): Schema
    {
        return VisitForm::configure($schema, withCustomer: false);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('visit_date')
            ->columns([
                TextColumn::make('visit_date')->label('Tanggal')->date('d/m/Y')->sortable(),
                TextColumn::make('clinic')->label('Klinik')->badge(),
                TextColumn::make('membership')->label('Anggota')->badge(),
                TextColumn::make('closing_type')->label('Tipe')->badge(),
                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->formatStateUsing(fn($state) => $state === null ? '-' : 'Rp ' . number_format($state, 0, ',', '.'))
                    ->alignEnd(),
            ])
            ->defaultSort('visit_date', 'desc')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
