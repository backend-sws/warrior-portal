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
            $table->string('tuition_live_photo_path')->nullable()->after('tuition_signature_data');
            $table->decimal('tuition_latitude', 10, 7)->nullable()->after('tuition_live_photo_path');
            $table->decimal('tuition_longitude', 10, 7)->nullable()->after('tuition_latitude');
            $table->string('tuition_location_name')->nullable()->after('tuition_longitude');
            $table->string('signature_location_name')->nullable()->after('signature_ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'tuition_live_photo_path',
                'tuition_latitude',
                'tuition_longitude',
                'tuition_location_name',
                'signature_location_name',
            ]);
        });
    }
};
