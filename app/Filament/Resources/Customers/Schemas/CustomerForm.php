<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Enums\CustomerSource;
use App\Enums\Membership;
use App\Models\Customer;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('wa')
                        ->label('Nomor WA')
                        ->tel()
                        ->maxLength(20)
                        ->unique(ignoreRecord: true)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($state, Set $set) => $set('wa', Customer::normalizeWa($state)))
                        ->helperText('Format bebas, otomatis menjadi 62…'),
                    DatePicker::make('birth_date')
                        ->label('Tanggal lahir'),
                    Select::make('source')
                        ->label('Sumber')
                        ->options(CustomerSource::class),
                ]),
            Section::make('Klinik dan keanggotaan')
                ->columns(2)
                ->schema([
                    Select::make('first_clinic_id')
                        ->label('Klinik pertama')
                        ->relationship('firstClinic', 'name'),
                    DatePicker::make('first_visit_at')
                        ->label('Kunjungan pertama'),
                    Select::make('membership')
                        ->label('Anggota')
                        ->options(Membership::class),
                ]),
            Textarea::make('notes')
                ->label('Catatan')
                ->columnSpanFull(),
        ]);
    }
}
