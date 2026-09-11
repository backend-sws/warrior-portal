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
        if (Schema::hasTable('home_tuition_leads')) {
            Schema::table('home_tuition_leads', function (Blueprint $table) {
                if (!Schema::hasColumn('home_tuition_leads', 'latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable()->after('location');
                }
                if (!Schema::hasColumn('home_tuition_leads', 'longitude')) {
                    $table->decimal('longitude', 11, 7)->nullable()->after('latitude');
                }
            });
        }

        if (Schema::hasTable('job_posts')) {
            Schema::table('job_posts', function (Blueprint $table) {
                if (!Schema::hasColumn('job_posts', 'latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable()->after('city_id');
                }
                if (!Schema::hasColumn('job_posts', 'longitude')) {
                    $table->decimal('longitude', 11, 7)->nullable()->after('latitude');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('home_tuition_leads')) {
            Schema::table('home_tuition_leads', function (Blueprint $table) {
                $columns = [];
                if (Schema::hasColumn('home_tuition_leads', 'latitude')) $columns[] = 'latitude';
                if (Schema::hasColumn('home_tuition_leads', 'longitude')) $columns[] = 'longitude';
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }

        if (Schema::hasTable('job_posts')) {
            Schema::table('job_posts', function (Blueprint $table) {
                $columns = [];
                if (Schema::hasColumn('job_posts', 'latitude')) $columns[] = 'latitude';
                if (Schema::hasColumn('job_posts', 'longitude')) $columns[] = 'longitude';
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
