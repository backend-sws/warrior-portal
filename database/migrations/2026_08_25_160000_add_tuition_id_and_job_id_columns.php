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
        if (Schema::hasTable('home_tuition_leads') && !Schema::hasColumn('home_tuition_leads', 'tuition_id')) {
            Schema::table('home_tuition_leads', function (Blueprint $table) {
                $table->string('tuition_id', 50)->nullable()->unique()->after('id');
            });

            // Populate existing tuition records
            $tuitions = DB::table('home_tuition_leads')->get();
            foreach ($tuitions as $t) {
                DB::table('home_tuition_leads')
                    ->where('id', $t->id)
                    ->update(['tuition_id' => 'TUI-' . str_pad($t->id, 4, '0', STR_PAD_LEFT)]);
            }
        }

        if (Schema::hasTable('job_posts') && !Schema::hasColumn('job_posts', 'job_id')) {
            Schema::table('job_posts', function (Blueprint $table) {
                $table->string('job_id', 50)->nullable()->unique()->after('id');
            });

            // Populate existing job records
            $jobs = DB::table('job_posts')->get();
            foreach ($jobs as $j) {
                DB::table('job_posts')
                    ->where('id', $j->id)
                    ->update(['job_id' => 'JOB-' . str_pad($j->id, 4, '0', STR_PAD_LEFT)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('home_tuition_leads') && Schema::hasColumn('home_tuition_leads', 'tuition_id')) {
            Schema::table('home_tuition_leads', function (Blueprint $table) {
                $table->dropColumn('tuition_id');
            });
        }

        if (Schema::hasTable('job_posts') && Schema::hasColumn('job_posts', 'job_id')) {
            Schema::table('job_posts', function (Blueprint $table) {
                $table->dropColumn('job_id');
            });
        }
    }
};
