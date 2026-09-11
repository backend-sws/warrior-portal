<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    /** @use HasFactory<\Database\Factories\CandidateProfileFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_profile_complete' => 'boolean',
        'is_agreement_signed' => 'boolean',
        'is_fee_paid' => 'boolean',
        'registration_completed_at' => 'datetime',
        'signature_date_time' => 'datetime',
        'tuition_agreement_signed_at' => 'datetime',
        'plan_started_at' => 'datetime',
        'agreement_status' => 'string',
        'tuition_agreement_status' => 'string',
        'tuition_subjects' => 'array',
        'classes_interested' => 'array',
        'preferred_locations' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function highestQualification()
    {
        return $this->belongsTo(Qualification::class, 'highest_qualification_id');
    }

    public function preferredState()
    {
        return $this->belongsTo(State::class, 'preferred_state_id');
    }

    public function preferredCity()
    {
        return $this->belongsTo(City::class, 'preferred_city_id');
    }

    public function isHomeTutor(): bool
    {
        return $this->candidate_category === 'home_tutor';
    }

    public function isSchoolJob(): bool
    {
        return $this->candidate_category === 'school_job';
    }

    public function isBoth(): bool
    {
        return $this->candidate_category === 'both' || empty($this->candidate_category);
    }

    public function appliesForHomeTuition(): bool
    {
        return in_array($this->candidate_category, ['home_tutor', 'both']) || empty($this->candidate_category);
    }

    public function appliesForSchoolJob(): bool
    {
        return in_array($this->candidate_category, ['school_job', 'both']) || empty($this->candidate_category);
    }

    /**
     * Get Google Maps pinpoint URL if coordinates are available.
     */
    public function getGoogleMapsUrlAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return null;
    }

    /**
     * Calculate live profile completion percentage (25%, 50%, 75%, 100%)
     */
    public function getCompletionPercentageAttribute(): int
    {
        if ($this->is_profile_complete && isset($this->attributes['profile_completion_percentage']) && (int)$this->attributes['profile_completion_percentage'] >= 100) {
            return 100;
        }

        $category = $this->candidate_category ?: 'both';
        $stepsPassed = 0;

        // Step 1: Basic Personal Details (Common) - 25%
        // Gender, DOB, and User's name & contact
        $hasBasic = !empty($this->gender) 
            && !empty($this->date_of_birth) 
            && ($this->user && !empty($this->user->name) && (!empty($this->user->phone) || !empty($this->user->email) || !empty($this->whatsapp_no)));
        if ($hasBasic) $stepsPassed++;

        // Step 2: Education & Experience (Common) - 25%
        $hasEducationExp = (!empty($this->highest_qualification_id) || !empty($this->highest_qualification_name)) 
            && (!empty($this->experience_range) || isset($this->experience_years));
        if ($hasEducationExp) $stepsPassed++;

        // Step 3: Domain Preferences - 25%
        if ($category === 'home_tutor') {
            // Needs tuition subjects, classes interested, and teaching mode or area
            $hasPreferences = (!empty($this->tuition_subjects) && count($this->tuition_subjects) > 0)
                && (!empty($this->classes_interested) && count($this->classes_interested) > 0)
                && (!empty($this->teaching_mode) || !empty($this->preferred_areas));
        } elseif ($category === 'school_job') {
            // Needs position applying for, specialization or category, and expected salary
            $hasPreferences = !empty($this->position_applying_for) 
                && (!empty($this->subject_specialization) || !empty($this->category_id))
                && (!empty($this->expected_salary) || !empty($this->current_salary));
        } else {
            // Both: At least tuition subjects and school position
            $hasPreferences = (!empty($this->tuition_subjects) && count($this->tuition_subjects) > 0)
                && !empty($this->position_applying_for);
        }
        if ($hasPreferences) $stepsPassed++;

        // Step 4: Documents & Location Details - 25%
        if ($category === 'home_tutor') {
            // Resume or preferred areas / time slots
            $hasDocsLoc = !empty($this->resume_path) || (!empty($this->preferred_areas) && !empty($this->available_time_slot));
        } elseif ($category === 'school_job') {
            // Resume is mandatory, and preferred locations selected
            $hasDocsLoc = !empty($this->resume_path) && (!empty($this->preferred_locations) && count($this->preferred_locations) > 0);
        } else {
            // Both: Resume and preferred locations/areas
            $hasDocsLoc = !empty($this->resume_path) && (!empty($this->preferred_locations) || !empty($this->preferred_areas));
        }
        if ($hasDocsLoc) $stepsPassed++;

        // Return exact quartile percentage (0, 25, 50, 75, 100)
        return match($stepsPassed) {
            4 => 100,
            3 => 75,
            2 => 50,
            1 => 25,
            default => 0,
        };
    }

    /**
     * Get list of missing profile fields
     */
    public function getMissingProfileFieldsAttribute(): array
    {
        $missing = [];
        $category = $this->candidate_category ?: 'both';

        if (empty($this->gender) || empty($this->date_of_birth)) {
            $missing[] = 'Gender & Date of Birth';
        }
        if (empty($this->highest_qualification_id) && empty($this->highest_qualification_name)) {
            $missing[] = 'Highest Qualification';
        }
        if (empty($this->experience_range) && !isset($this->experience_years)) {
            $missing[] = 'Teaching Experience';
        }

        if ($category === 'home_tutor' || $category === 'both') {
            if (empty($this->tuition_subjects) || count($this->tuition_subjects) === 0) {
                $missing[] = 'Tuition Subjects';
            }
            if (empty($this->classes_interested) || count($this->classes_interested) === 0) {
                $missing[] = 'Interested Classes';
            }
            if (empty($this->preferred_areas)) {
                $missing[] = 'Preferred Home Tuition Areas';
            }
        }

        if ($category === 'school_job' || $category === 'both') {
            if (empty($this->position_applying_for)) {
                $missing[] = 'Position Applying For';
            }
            if (empty($this->resume_path)) {
                $missing[] = 'Resume / CV';
            }
            if (empty($this->preferred_locations) || count($this->preferred_locations) === 0) {
                $missing[] = 'Preferred Locations';
            }
        }

        return $missing;
    }

    /**
     * Check if profile is 100% complete
     */
    public function getIsCompletedAttribute(): bool
    {
        return $this->completion_percentage >= 100;
    }
}
