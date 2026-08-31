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
        if (!Schema::hasTable('school_follow_ups')) {
            Schema::create('school_follow_ups', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employer_profile_id')->nullable()->constrained('employer_profiles')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->text('note');
                $table->string('status_changed_to')->nullable();
                $table->date('next_follow_up_date')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_follow_ups');
    }
};
