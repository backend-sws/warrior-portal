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
        Schema::table('tuition_fee_accounts', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'paid', 'overdue'])->default('pending')->after('status');
            $table->date('follow_up_date')->nullable()->after('next_due_date');
            $table->text('follow_up_notes')->nullable()->after('follow_up_date');
            $table->date('last_paid_date')->nullable()->after('follow_up_notes');
            $table->integer('total_payments_count')->default(0)->after('last_paid_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuition_fee_accounts', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'follow_up_date', 'follow_up_notes', 'last_paid_date', 'total_payments_count']);
        });
    }
};
