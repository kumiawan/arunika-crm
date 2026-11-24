<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->nullable()->unique();
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('wa', 20)->nullable()->unique();
            $table->text('address')->nullable();
            $table->string('occupation')->nullable();
            $table->string('membership')->nullable();
            $table->string('patient_type')->default('baru');
            $table->string('source')->nullable();
            $table->foreignId('first_clinic')->nullable();
            $table->date('first_visit_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
