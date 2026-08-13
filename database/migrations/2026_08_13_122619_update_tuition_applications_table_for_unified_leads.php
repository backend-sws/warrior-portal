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
        Schema::table('tuition_applications', function (Blueprint $table) {
            // Drop old column
            $table->dropForeign(['tuition_requirement_id']);
            $table->dropColumn('tuition_requirement_id');

            // Add new column
            $table->foreignId('home_tuition_lead_id')->nullable()->constrained('home_tuition_leads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuition_applications', function (Blueprint $table) {
            $table->dropForeign(['home_tuition_lead_id']);
            $table->dropColumn('home_tuition_lead_id');

            $table->foreignId('tuition_requirement_id')->nullable()->constrained('tuition_requirements')->onDelete('cascade');
        });
    }
};
