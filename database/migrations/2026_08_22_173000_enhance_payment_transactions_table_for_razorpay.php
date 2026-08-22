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
        Schema::table('payment_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('payment_transactions', 'gateway')) {
                $table->string('gateway', 30)->default('razorpay')->after('status');
            }
            if (!Schema::hasColumn('payment_transactions', 'order_id')) {
                $table->string('order_id', 100)->nullable()->after('transaction_id')->index();
            }
            if (!Schema::hasColumn('payment_transactions', 'payment_id')) {
                $table->string('payment_id', 100)->nullable()->after('order_id')->index();
            }
            if (!Schema::hasColumn('payment_transactions', 'signature')) {
                $table->string('signature', 255)->nullable()->after('payment_id');
            }
            if (!Schema::hasColumn('payment_transactions', 'currency')) {
                $table->string('currency', 10)->default('INR')->after('amount');
            }
            if (!Schema::hasColumn('payment_transactions', 'invoice_id')) {
                $table->unsignedBigInteger('invoice_id')->nullable()->after('signature')->index();
            }
            if (!Schema::hasColumn('payment_transactions', 'tuition_lead_id')) {
                $table->unsignedBigInteger('tuition_lead_id')->nullable()->after('invoice_id')->index();
            }
            if (!Schema::hasColumn('payment_transactions', 'payment_method')) {
                $table->string('payment_method', 50)->nullable()->after('gateway');
            }
            if (!Schema::hasColumn('payment_transactions', 'error_code')) {
                $table->string('error_code', 100)->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('payment_transactions', 'error_description')) {
                $table->text('error_description')->nullable()->after('error_code');
            }
            if (!Schema::hasColumn('payment_transactions', 'webhook_payload')) {
                $table->json('webhook_payload')->nullable()->after('gateway_response');
            }
            if (!Schema::hasColumn('payment_transactions', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('webhook_payload');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->dropColumn([
                'gateway',
                'order_id',
                'payment_id',
                'signature',
                'currency',
                'invoice_id',
                'tuition_lead_id',
                'payment_method',
                'error_code',
                'error_description',
                'webhook_payload',
                'ip_address'
            ]);
        });
    }
};
