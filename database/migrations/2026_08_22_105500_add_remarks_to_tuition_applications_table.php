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
            if (!Schema::hasColumn('tuition_applications', 'remarks')) {
                $table->text('remarks')->nullable()->after('status');
            }
            if (!Schema::hasColumn('tuition_applications', 'demo_date')) {
                $table->dateTime('demo_date')->nullable()->after('remarks');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuition_applications', function (Blueprint $table) {
            $table->dropColumn(['remarks', 'demo_date']);
        });
    }
};
