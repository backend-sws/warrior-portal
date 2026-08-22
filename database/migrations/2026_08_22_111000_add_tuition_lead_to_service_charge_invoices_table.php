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
        Schema::table('service_charge_invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('service_charge_invoices', 'home_tuition_lead_id')) {
                $table->foreignId('home_tuition_lead_id')->nullable()->after('job_application_id')->constrained('home_tuition_leads')->nullOnDelete();
            }
            if (!Schema::hasColumn('service_charge_invoices', 'tuition_application_id')) {
                $table->foreignId('tuition_application_id')->nullable()->after('home_tuition_lead_id')->constrained('tuition_applications')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_charge_invoices', function (Blueprint $table) {
            $table->dropForeign(['home_tuition_lead_id']);
            $table->dropForeign(['tuition_application_id']);
            $table->dropColumn(['home_tuition_lead_id', 'tuition_application_id']);
        });
    }
};
