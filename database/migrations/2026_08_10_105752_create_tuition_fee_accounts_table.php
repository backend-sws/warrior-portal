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
        Schema::create('tuition_fee_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->string('student_name');
            $table->string('mobile_number');
            $table->text('address')->nullable();
            $table->string('class')->nullable();
            $table->string('subject')->nullable();
            $table->string('teacher_name')->nullable();
            $table->date('teacher_joining_date')->nullable();
            $table->decimal('monthly_fee', 10, 2)->default(0.00);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('next_due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuition_fee_accounts');
    }
};
