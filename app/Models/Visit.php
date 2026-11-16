<?php

namespace App\Models;

use App\Enums\ClosingType;
use App\Enums\Membership;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    protected $fillable = [
        'clinic_id', 'customer_id', 'visit_date', 'membership', 'closing_type',
        'closing_note', 'nominal', 'payment_method', 'source_ref',
    ];

    protected function casts(): array
    {
        return [
            'visit_date'     => 'date',
            'nominal'        => 'integer',
            'membership'     => Membership::class,
            'closing_type'   => ClosingType::class,
            'payment_method' => PaymentMethod::class,
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    protected static function booted(): void
    {
        // Kunjungan paling awal menentukan "kunjungan pertama" customer.
        static::saved(function (Visit $visit) {
            $customer = $visit->customer;

            if ($customer && (! $customer->first_visit_at || $visit->visit_date->lt($customer->first_visit_at))) {
                $customer->update([
                    'first_visit_at'  => $visit->visit_date,
                    'first_clinic_id' => $visit->clinic_id,
                ]);
            }
        });
    }
}
