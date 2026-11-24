<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Enums\Gender;
use App\Enums\Clinic;
use App\Enums\CustomerSource;
use App\Enums\Membership;
use App\Enums\PatientType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Pasien')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('external_id')
                        ->label('No. ID')
                        ->helperText('Nomor ID dari aplikasi operasional')
                        ->unique(ignoreRecord: true)
                        ->maxLength(50),

                    TextInput::make('name')
                        ->label('Nama Pasien')
                        ->required()
                        ->maxLength(255),

                    DatePicker::make('birth_date')
                        ->label('Tgl. Lahir')
                        ->maxDate(now())
                        ->native(false)
                        ->displayFormat('d/m/Y'),

                    Select::make('gender')
                        ->label('Jenis Kelamin')
                        ->options(Gender::class)
                        ->native(false),

                    TextInput::make('wa')
                        ->label('WhatsApp')
                        ->tel()
                        ->maxLength(20)
                        ->unique(ignoreRecord: true),

                    TextInput::make('occupation')
                        ->label('Pekerjaan')
                        ->maxLength(255),

                    Textarea::make('address')
                        ->label('Alamat')
                        ->rows(2)
                        ->columnSpanFull(),
                ]),

            Section::make('Informasi Membership')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    Select::make('membership')
                        ->label('Membership')
                        ->options(Membership::class)
                        ->native(false),

                    Select::make('patient_type')
                        ->label('Tipe Pasien')
                        ->options(PatientType::class)
                        ->default(PatientType::Baru)
                        ->required()
                        ->native(false),
                ]),

            Section::make('Informasi Awal')
                ->columns(2)
                ->columnSpanFull()
                ->collapsible()
                ->schema([
                    Select::make('first_clinic')
                        ->label('Klinik pertama')
                        ->options(Clinic::class)
                        ->native(false)
                        ->searchable()
                        ->preload(),

                    DatePicker::make('first_visit_at')
                        ->label('Kunjungan pertama')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->default(now()),

                    Select::make('source')
                        ->label('Sumber')
                        ->options(CustomerSource::class)
                        ->native(false)
                        ->searchable()
                        ->preload(),

                    Textarea::make('notes')
                        ->label('Catatan')
                        ->rows(2)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
