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
        Schema::table('employer_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('employer_profiles', 'phone')) {
                $table->string('phone')->nullable()->after('contact_person');
            }
            if (!Schema::hasColumn('employer_profiles', 'alt_phone')) {
                $table->string('alt_phone')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('employer_profiles', 'email')) {
                $table->string('email')->nullable()->after('alt_phone');
            }
            if (!Schema::hasColumn('employer_profiles', 'state_id')) {
                $table->foreignId('state_id')->nullable()->after('address')->constrained('states')->nullOnDelete();
            }
            if (!Schema::hasColumn('employer_profiles', 'city_id')) {
                $table->foreignId('city_id')->nullable()->after('state_id')->constrained('cities')->nullOnDelete();
            }
            if (!Schema::hasColumn('employer_profiles', 'board')) {
                $table->string('board')->nullable()->after('city_id');
            }
            if (!Schema::hasColumn('employer_profiles', 'institution_type')) {
                $table->string('institution_type')->nullable()->default('School')->after('board');
            }
            if (!Schema::hasColumn('employer_profiles', 'website')) {
                $table->string('website')->nullable()->after('institution_type');
            }
            if (!Schema::hasColumn('employer_profiles', 'status')) {
                $table->string('status')->default('Active Client')->after('website');
            }
            if (!Schema::hasColumn('employer_profiles', 'notes')) {
                $table->text('notes')->nullable()->after('about');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employer_profiles', function (Blueprint $table) {
            $columns = ['phone', 'alt_phone', 'email', 'state_id', 'city_id', 'board', 'institution_type', 'website', 'status', 'notes'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('employer_profiles', $col)) {
                    if (in_array($col, ['state_id', 'city_id'])) {
                        $table->dropForeign(['employer_profiles_' . $col . '_foreign']);
                    }
                    $table->dropColumn($col);
                }
            }
        });
    }
};
