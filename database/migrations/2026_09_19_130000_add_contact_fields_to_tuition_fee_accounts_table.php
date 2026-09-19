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
        Schema::table('tuition_fee_accounts', function (Blueprint $table) {
            if (!Schema::hasColumn('tuition_fee_accounts', 'parent_email')) {
                $table->string('parent_email')->nullable()->after('mobile_number');
            }
            if (!Schema::hasColumn('tuition_fee_accounts', 'teacher_phone')) {
                $table->string('teacher_phone')->nullable()->after('teacher_name');
            }
            if (!Schema::hasColumn('tuition_fee_accounts', 'teacher_email')) {
                $table->string('teacher_email')->nullable()->after('teacher_phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuition_fee_accounts', function (Blueprint $table) {
            $table->dropColumn(['parent_email', 'teacher_phone', 'teacher_email']);
        });
    }
};
