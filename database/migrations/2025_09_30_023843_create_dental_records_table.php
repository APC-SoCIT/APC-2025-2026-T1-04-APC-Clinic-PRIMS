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
            $table->string('oral_hygiene')->nullable();
            $table->string('gingival_color')->nullable();
            $table->boolean('prophylaxis')->default(false);
            $table->json('teeth')->nullable(); // store your $teeth array as JSON
            $table->text('recommendation')->nullable();
            $table->timestamps();

            // appointment reference
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            
            $table->foreignId('doctor_id')->nullable()->constrained('clinic_staff')->onDelete('set null');
            $table->timestamp('archived_at')->nullable();
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
