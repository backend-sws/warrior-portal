<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::statement("ALTER TABLE home_tuition_leads MODIFY COLUMN status ENUM('New Lead', 'Pending', 'Approved', 'Demo Scheduled', 'Demo Completed', 'Confirmed', 'Cancelled') NOT NULL DEFAULT 'New Lead'");
        } catch (\Exception $e) {
            // Fallback for drivers that do not use raw MySQL enum modification
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement("ALTER TABLE home_tuition_leads MODIFY COLUMN status ENUM('New Lead', 'Demo Scheduled', 'Demo Completed', 'Confirmed', 'Pending', 'Cancelled') NOT NULL DEFAULT 'New Lead'");
        } catch (\Exception $e) {
            // Fallback
        }
    }
};
