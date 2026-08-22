<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_reminder_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('type');            // service_charge, renewal, payment_pending, interview, profile_completion, plan_expiry, late_fee, custom
            $table->string('target');          // "All" or "Candidate #123"
            $table->integer('count_sent')->default(0);
            $table->string('note')->nullable(); // For custom messages
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_reminder_logs');
    }
};
