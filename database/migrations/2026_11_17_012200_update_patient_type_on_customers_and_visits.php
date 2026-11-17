<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('customers', 'patient_type')) {
            Schema::table('customers', function (Blueprint $t) {
                $t->string('patient_type')->default('baru');
            });
        }

        // Opsional: pelanggan yang sudah pernah berkunjung dianggap Lama
        DB::table('customers')
            ->whereIn('id', DB::table('visits')->select('customer_id'))
            ->update(['patient_type' => 'lama']);

        if (Schema::hasColumn('visits', 'status')) {
            Schema::table('visits', function (Blueprint $t) {
                $t->dropColumn('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('customers', 'patient_type')) {
            Schema::table('customers', function (Blueprint $t) {
                $t->dropColumn('patient_type');
            });
        }
    }
};
