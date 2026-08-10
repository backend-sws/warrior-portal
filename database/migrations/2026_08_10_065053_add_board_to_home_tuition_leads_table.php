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
            $table->string('board')->nullable()->after('class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_tuition_leads', function (Blueprint $table) {
            $table->dropColumn('board');
        });
    }
};
