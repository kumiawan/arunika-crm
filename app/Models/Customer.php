<?php

namespace App\Models;

use App\Enums\CustomerSource;
use App\Enums\Membership;
use App\Enums\PatientType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name', 'wa','patient_type', 'birth_date', 'source', 'membership',
        'first_clinic_id', 'first_visit_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'birth_date'     => 'date',
            'first_visit_at' => 'date',
            'source'         => CustomerSource::class,
            'membership'     => Membership::class,
            'patient_type'   => PatientType::class,
        ];
    }

    public function firstClinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'first_clinic_id');
    }

    public static function normalizeWa(?string $value): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $value);

        if ($digits === '') {
            return null;
        }
        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }
        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        return $digits;
    }

    protected function wa(): Attribute
    {
        return Attribute::set(fn($value) => static::normalizeWa($value));
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
