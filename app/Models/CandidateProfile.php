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

    /**
     * Calculate live profile completion percentage
     */
    public function getCompletionPercentageAttribute(): int
    {
        $score = 0;
        $total = 6;

        // 1. Basic Info (DOB & Gender)
        if (!empty($this->date_of_birth) && !empty($this->gender)) $score++;
        // 2. Address
        if (!empty($this->address)) $score++;
        // 3. Location (State & City)
        if (!empty($this->preferred_state_id) && !empty($this->preferred_city_id)) $score++;
        // 4. Qualification
        if (!empty($this->highest_qualification_id)) $score++;
        // 5. School Job Info / Category
        if (!empty($this->category_id)) $score++;
        // 6. Resume Uploaded
        if (!empty($this->resume_path)) $score++;

        return (int) round(($score / $total) * 100);
    }

    /**
     * Get list of missing profile fields
     */
    public function getMissingProfileFieldsAttribute(): array
    {
        $missing = [];
        if (empty($this->date_of_birth) || empty($this->gender)) $missing[] = 'Basic Details (DOB & Gender)';
        if (empty($this->address)) $missing[] = 'Full Residential Address';
        if (empty($this->preferred_state_id) || empty($this->preferred_city_id)) $missing[] = 'Preferred Location (State & City)';
        if (empty($this->highest_qualification_id)) $missing[] = 'Highest Qualification';
        if (empty($this->category_id)) $missing[] = 'Teaching Category';
        if (empty($this->resume_path)) $missing[] = 'Resume / CV';

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
