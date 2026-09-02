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
        Schema::table('job_posts', function (Blueprint $table) {
            if (!Schema::hasColumn('job_posts', 'specialization_name')) {
                $table->string('specialization_name')->nullable()->after('specialization_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_posts', function (Blueprint $table) {
            if (Schema::hasColumn('job_posts', 'specialization_name')) {
                $table->dropColumn('specialization_name');
            }
        });
    }
};
