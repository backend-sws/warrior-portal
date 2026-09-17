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
        Schema::table('candidate_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('candidate_profiles', 'tuition_upgrade_status')) {
                $table->string('tuition_upgrade_status', 30)->default('none')->after('candidate_category');
            }
            if (!Schema::hasColumn('candidate_profiles', 'tuition_upgrade_requested_at')) {
                $table->timestamp('tuition_upgrade_requested_at')->nullable()->after('tuition_upgrade_status');
            }
            if (!Schema::hasColumn('candidate_profiles', 'tuition_upgrade_approved_at')) {
                $table->timestamp('tuition_upgrade_approved_at')->nullable()->after('tuition_upgrade_requested_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('candidate_profiles', 'tuition_upgrade_status')) {
                $columns[] = 'tuition_upgrade_status';
            }
            if (Schema::hasColumn('candidate_profiles', 'tuition_upgrade_requested_at')) {
                $columns[] = 'tuition_upgrade_requested_at';
            }
            if (Schema::hasColumn('candidate_profiles', 'tuition_upgrade_approved_at')) {
                $columns[] = 'tuition_upgrade_approved_at';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
