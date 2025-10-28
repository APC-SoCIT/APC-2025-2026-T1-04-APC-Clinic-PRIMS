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
        Schema::create('dental_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');

            // Intraoral Exam + Procedures
            $table->json('oral_hygiene')->nullable(); // stores plaque level + remarks
            $table->string('gingival_color')->nullable();
            $table->json('procedures')->nullable(); // stores multiple selected procedures
            $table->text('procedure_notes')->nullable(); // additional notes

            // Tooth chart
            $table->json('teeth')->nullable(); // upper + lower arrays

            // Recommendation
            $table->text('recommendation')->nullable();

            // References
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->foreignId('doctor_id')->nullable()->constrained('clinic_staff')->onDelete('set null');

            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dental_records');
    }
};
