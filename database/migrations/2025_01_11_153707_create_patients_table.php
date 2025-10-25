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
        Schema::create('patients', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('category_id')->nullable(); // Placeholder for foreign key

            $table->string('apc_id_number')->unique();
            $table->string('first_name');
            $table->string('middle_initial', 2)->nullable();
            $table->string('last_name');

            $table->enum('gender', ['Male', 'Female', 'Other']);
            // age should be here but it can be calculated from date_of_birth
            $table->date('date_of_birth');
            $table->string('nationality')->nullable();

            $table->string('blood_type')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('contact_number');
            
            $table->string('email')->unique();
            $table->string('house_unit_number')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
