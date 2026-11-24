<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\Membership;
use App\Enums\PatientType;
use App\Enums\CustomerSource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Customer extends Model
{
    protected $fillable = [
        'name', 'wa','patient_type', 'birth_date', 'source', 'membership',
        'first_clinic', 'first_visit_at', 'notes', 'external_id', 'gender',
        'address', 'occupation',
    ];

    protected function casts(): array
    {
        return [
            'birth_date'     => 'date',
            'first_visit_at' => 'date',
            'gender'         => Gender::class,
            'membership'     => Membership::class,
            'source'         => CustomerSource::class,
            'patient_type'   => PatientType::class,
        ];
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

    protected function age(): Attribute
    {
        return Attribute::get(fn() => $this->birth_date?->age);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
