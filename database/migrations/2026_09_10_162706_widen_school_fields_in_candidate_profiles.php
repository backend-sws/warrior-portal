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
            $table->string('b_ed_status', 100)->nullable()->change();
            $table->string('d_el_ed_status', 100)->nullable()->change();
            $table->string('subject_specialization', 150)->nullable()->change();
            $table->string('position_applying_for', 150)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->string('b_ed_status', 20)->nullable()->change();
            $table->string('d_el_ed_status', 20)->nullable()->change();
            $table->string('subject_specialization', 100)->nullable()->change();
            $table->string('position_applying_for', 100)->nullable()->change();
        });
    }
};
