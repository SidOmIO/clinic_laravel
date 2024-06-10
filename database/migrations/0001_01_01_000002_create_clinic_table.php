<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->time('time');
            $table->string('remark');
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_id');
            $table->string('patient_email');
            $table->string('doctor_email');
            $table->string('remark');
            $table->double('total_price')->nullable();
            $table->integer('payment_id')->nullable();
            $table->timestamps();
        });

        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('consultation_id');
            $table->string('stripe_id');
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('consultation_id');
            $table->string('medication_id');
            $table->string('quantity');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('consultations');
        Schema::dropIfExists('medications');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('prescriptions');
    }
};
