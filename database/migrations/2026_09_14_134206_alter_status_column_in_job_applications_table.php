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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE job_applications MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'applied'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('applied', 'shortlisted', 'rejected', 'hired') NOT NULL DEFAULT 'applied'");
    }
};
