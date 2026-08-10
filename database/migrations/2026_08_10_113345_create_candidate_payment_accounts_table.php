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
        Schema::create('candidate_payment_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('mobile_number');
            $table->text('address')->nullable();
            $table->string('tuition_assigned')->nullable();
            $table->date('joining_date');
            $table->decimal('monthly_amount', 10, 2);
            $table->string('status')->default('active'); // active, inactive
            $table->date('next_due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_payment_accounts');
    }
};
