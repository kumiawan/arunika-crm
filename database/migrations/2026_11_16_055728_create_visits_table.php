<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('clinic');
            $table->foreignId('customer_id')->constrained();
            $table->date('visit_date');
            $table->string('membership')->nullable();
            $table->string('closing_type')->nullable();
            $table->string('closing_note')->nullable();
            $table->unsignedBigInteger('nominal')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('source_ref')->nullable();
            $table->timestamps();

            $table->index(['clinic', 'visit_date']);
            $table->index(['customer_id', 'visit_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
