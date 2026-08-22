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
            $table->boolean('is_tuition_agreement_signed')->default(false)->after('is_agreement_signed');
            $table->timestamp('tuition_agreement_signed_at')->nullable()->after('is_tuition_agreement_signed');
            $table->text('tuition_signature_data')->nullable()->after('tuition_agreement_signed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn(['is_tuition_agreement_signed', 'tuition_agreement_signed_at', 'tuition_signature_data']);
        });
    }
};
