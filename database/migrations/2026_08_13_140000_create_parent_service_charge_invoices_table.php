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
        Schema::create('parent_service_charge_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_tuition_lead_id')->constrained('home_tuition_leads')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('invoice_number')->unique();
            $table->string('title');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('USD');
            $table->date('due_date')->nullable();
            $table->enum('status', ['Unpaid', 'Paid', 'Cancelled'])->default('Unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_service_charge_invoices');
    }
};
