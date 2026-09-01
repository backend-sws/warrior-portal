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
        if (!Schema::hasColumn('candidate_profiles', 'tuition_agreement_status')) {
            Schema::table('candidate_profiles', function (Blueprint $table) {
                $table->enum('tuition_agreement_status', ['not_required', 'pending_signature', 'signed'])
                      ->default('not_required')
                      ->after('is_tuition_agreement_signed');
            });
        }

        // Initialize tuition_agreement_status = 'signed' for candidate profiles where is_tuition_agreement_signed is already true
        DB::table('candidate_profiles')
            ->where('is_tuition_agreement_signed', true)
            ->update(['tuition_agreement_status' => 'signed']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn('tuition_agreement_status');
        });
    }
};
