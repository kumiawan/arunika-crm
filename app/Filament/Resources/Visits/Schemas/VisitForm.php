<?php

namespace App\Filament\Resources\Visits\Schemas;

use Closure;
use App\Enums\Clinic;
use App\Models\Customer;
use App\Enums\Membership;
use App\Enums\ClosingType;
use App\Enums\PaymentMethod;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class VisitForm
{
    public static function configure(Schema $schema, bool $withCustomer = true): Schema
    {
        $kunjungan = [
            Select::make('clinic')
                ->label('Klinik')
                ->options(Clinic::class)
                ->required(),
            DatePicker::make('visit_date')
                ->label('Tanggal')
                ->default(now())
                ->required(),
        ];

        if ($withCustomer) {
            array_unshift($kunjungan, Select::make('customer_id')
                ->label('Customer')
                ->relationship('customer', 'name')
                ->getOptionLabelFromRecordUsing(
                    fn(Customer $record) => $record->name . ($record->wa ? " ({$record->wa})" : '')
                )
                ->searchable(['name', 'wa'])
                ->required()
                ->live()
                ->afterStateUpdated(
                    fn($state, Set $set) => $set('membership', Customer::find($state)?->membership?->value)
                )
                ->createOptionForm([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required(),
                    TextInput::make('wa')
                        ->label('Nomor WA')
                        ->tel()
                        ->rules([
                            fn() => function (string $attribute, $value, Closure $fail) {
                                $wa = Customer::normalizeWa($value);
                                if ($wa && Customer::where('wa', $wa)->exists()) {
                                    $fail('Nomor WA sudah terdaftar.');
                                }
                            },
                        ]),
                ])
                ->columnSpanFull());
        }

        return $schema->components([
            Section::make('Kunjungan')
                ->columns(2)
                ->schema($kunjungan),
            Section::make('Transaksi')
                ->columns(2)
                ->schema([
                    Select::make('membership')
                        ->label('Membership')
                        ->options(Membership::class),
                    Select::make('closing_type')
                        ->label('Tipe transaksi')
                        ->options(ClosingType::class),
                    TextInput::make('nominal')
                        ->label('Nominal')
                        ->numeric()
                        ->minValue(0)
                        ->prefix('Rp'),
                    Select::make('payment_method')
                        ->label('Metode bayar')
                        ->options(PaymentMethod::class),
                    TextInput::make('closing_note')
                        ->label('Catatan')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
