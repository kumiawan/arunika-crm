<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('wa', 20)->nullable()->unique();
            $table->date('birth_date')->nullable();
            $table->string('source')->nullable();
            $table->string('membership')->nullable();
            $table->foreignId('first_clinic_id')->nullable()->constrained('clinics')->nullOnDelete();
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
