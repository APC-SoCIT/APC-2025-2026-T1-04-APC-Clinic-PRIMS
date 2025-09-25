<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();

            // patient info
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');

            // medical concern
            $table->text('reason');
            $table->text('description');
            $table->date('last_visited')->nullable();

            // medical history
            $table->text('allergies')->nullable();
            $table->text('medications')->nullable();
            $table->json('past_medical_history')->nullable();
            $table->json('family_history')->nullable();
            $table->json('personal_history')->nullable();
            $table->json('obgyne_history')->nullable();
            $table->text('hospitalization')->nullable();
            $table->text('operation')->nullable();
            $table->json('immunizations')->nullable();

            // physical examination values
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('bmi')->nullable();
            $table->integer('o2sat')->nullable();
            // physical examination checkbox table is handled in separate table

            // diagnoses also handled in separate table
            
            // prescription
            $table->text('prescription')->nullable();

            // appointment reference
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            
            $table->timestamps();
            $table->timestamp('archived_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
};
