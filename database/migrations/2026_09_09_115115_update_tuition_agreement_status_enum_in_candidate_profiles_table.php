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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE candidate_profiles MODIFY COLUMN tuition_agreement_status ENUM('not_required', 'request_pending', 'pending_signature', 'signed') NOT NULL DEFAULT 'not_required'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("UPDATE candidate_profiles SET tuition_agreement_status = 'not_required' WHERE tuition_agreement_status = 'request_pending'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE candidate_profiles MODIFY COLUMN tuition_agreement_status ENUM('not_required', 'pending_signature', 'signed') NOT NULL DEFAULT 'not_required'");
    }
};
