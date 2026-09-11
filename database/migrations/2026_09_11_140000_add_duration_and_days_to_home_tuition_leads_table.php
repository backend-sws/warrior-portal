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
        Schema::table('home_tuition_leads', function (Blueprint $table) {
            $table->string('duration_hours')->nullable()->after('preferred_timing');
            $table->string('days_per_week')->nullable()->after('duration_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_tuition_leads', function (Blueprint $table) {
            $table->dropColumn(['duration_hours', 'days_per_week']);
        });
    }
};
