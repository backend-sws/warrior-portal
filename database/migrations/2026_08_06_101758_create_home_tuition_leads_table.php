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
        Schema::create('home_tuition_leads', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->string('parent_mobile');
            $table->string('teacher_contact')->nullable();
            $table->string('location');
            $table->string('class');
            $table->string('subjects');
            $table->string('fee')->nullable();
            $table->string('preferred_timing')->nullable();
            $table->date('enquiry_date')->nullable();
            $table->enum('tutor_preference', ['Male', 'Female', 'Any'])->default('Any');
            $table->string('dues')->nullable(); // e.g., paid by tutor or parent
            $table->text('additional_notes')->nullable();
            $table->enum('status', ['New Lead', 'Demo Scheduled', 'Demo Completed', 'Confirmed', 'Pending', 'Cancelled'])->default('New Lead');
            $table->date('follow_up_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_tuition_leads');
    }
};
