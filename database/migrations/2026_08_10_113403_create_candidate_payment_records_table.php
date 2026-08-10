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
        Schema::create('candidate_payment_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_payment_account_id')->constrained()->cascadeOnDelete();
            $table->date('payment_date');
            $table->decimal('amount', 10, 2);
            $table->string('payment_mode'); // Cash, UPI, Bank
            $table->string('type')->default('Collected'); // Collected (from candidate) or Paid (to candidate)
            $table->string('collected_by')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_payment_records');
    }
};
