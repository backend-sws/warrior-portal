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
        // 1. Add whatsapp_no to users table if not exists
        if (!Schema::hasColumn('users', 'whatsapp_no')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('whatsapp_no', 20)->nullable()->after('phone');
            });
        }

        // 2. Add roadmap fields to candidate_profiles table
        Schema::table('candidate_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('candidate_profiles', 'candidate_category')) {
                $table->string('candidate_category', 30)->default('both')->after('user_id'); // home_tutor, school_job, both
            }
            if (!Schema::hasColumn('candidate_profiles', 'whatsapp_no')) {
                $table->string('whatsapp_no', 20)->nullable()->after('candidate_category');
            }
            if (!Schema::hasColumn('candidate_profiles', 'experience_range')) {
                $table->string('experience_range', 50)->nullable()->after('experience_years');
            }
            if (!Schema::hasColumn('candidate_profiles', 'highest_qualification_name')) {
                $table->string('highest_qualification_name', 100)->nullable()->after('highest_qualification_id');
            }

            // Home Tutor specific fields
            if (!Schema::hasColumn('candidate_profiles', 'tuition_subjects')) {
                $table->json('tuition_subjects')->nullable()->after('highest_qualification_name');
            }
            if (!Schema::hasColumn('candidate_profiles', 'classes_interested')) {
                $table->json('classes_interested')->nullable()->after('tuition_subjects');
            }
            if (!Schema::hasColumn('candidate_profiles', 'teaching_mode')) {
                $table->string('teaching_mode', 30)->nullable()->after('classes_interested'); // Offline, Online, Both
            }
            if (!Schema::hasColumn('candidate_profiles', 'preferred_areas')) {
                $table->text('preferred_areas')->nullable()->after('teaching_mode'); // Manual entry (Kankarbagh, Boring Road, etc.)
            }
            if (!Schema::hasColumn('candidate_profiles', 'available_time_slot')) {
                $table->string('available_time_slot', 150)->nullable()->after('preferred_areas');
            }

            // School Job specific fields
            if (!Schema::hasColumn('candidate_profiles', 'b_ed_status')) {
                $table->string('b_ed_status', 20)->nullable()->after('available_time_slot'); // Yes, No, Pursuing
            }
            if (!Schema::hasColumn('candidate_profiles', 'd_el_ed_status')) {
                $table->string('d_el_ed_status', 20)->nullable()->after('b_ed_status'); // Yes, No, Pursuing
            }
            if (!Schema::hasColumn('candidate_profiles', 'subject_specialization')) {
                $table->string('subject_specialization', 100)->nullable()->after('d_el_ed_status');
            }
            if (!Schema::hasColumn('candidate_profiles', 'position_applying_for')) {
                $table->string('position_applying_for', 100)->nullable()->after('subject_specialization');
            }
            if (!Schema::hasColumn('candidate_profiles', 'last_school_name')) {
                $table->string('last_school_name', 200)->nullable()->after('position_applying_for');
            }
            if (!Schema::hasColumn('candidate_profiles', 'last_designation')) {
                $table->string('last_designation', 100)->nullable()->after('last_school_name');
            }
            if (!Schema::hasColumn('candidate_profiles', 'last_drawn_salary')) {
                $table->string('last_drawn_salary', 50)->nullable()->after('last_designation');
            }
            if (!Schema::hasColumn('candidate_profiles', 'preferred_locations')) {
                $table->json('preferred_locations')->nullable()->after('last_drawn_salary'); // Patna, Hajipur, etc.
            }
            if (!Schema::hasColumn('candidate_profiles', 'profile_completion_percentage')) {
                $table->integer('profile_completion_percentage')->default(0)->after('is_profile_complete');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'whatsapp_no')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('whatsapp_no');
            });
        }

        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'candidate_category',
                'whatsapp_no',
                'experience_range',
                'highest_qualification_name',
                'tuition_subjects',
                'classes_interested',
                'teaching_mode',
                'preferred_areas',
                'available_time_slot',
                'b_ed_status',
                'd_el_ed_status',
                'subject_specialization',
                'position_applying_for',
                'last_school_name',
                'last_designation',
                'last_drawn_salary',
                'preferred_locations',
                'profile_completion_percentage',
            ]);
        });
    }
};
