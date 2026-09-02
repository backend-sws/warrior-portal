<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    /** @use HasFactory<\Database\Factories\JobPostFactory> */
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($job) {
            if (empty($job->job_id)) {
                $job->job_id = 'JOB-' . str_pad($job->id, 4, '0', STR_PAD_LEFT);
                $job->saveQuietly();
            }
        });
    }

    public function getJobIdAttribute($value)
    {
        return $value ?: ('JOB-' . str_pad($this->id, 4, '0', STR_PAD_LEFT));
    }

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

    public function getSpecializationDisplayAttribute()
    {
        return $this->specialization_name ?: ($this->specialization?->name ?: 'Not Specified');
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_post_id');
    }

    public function getSuggestedCandidates($limit = 5)
    {
        return CandidateProfile::with(['user', 'category', 'subject', 'highestQualification', 'preferredState', 'preferredCity', 'specialization'])
            ->where('is_profile_complete', true)
            ->get()
            ->map(function ($candidate) {
                $score = 0;
                $matched = [];
                
                if ($this->category_id && $candidate->category_id == $this->category_id) {
                    $score += 25;
                    $matched[] = 'category';
                }
                if ($this->subject_id && $candidate->subject_id == $this->subject_id) {
                    $score += 45;
                    $matched[] = 'subject';
                }
                if ($this->specialization_id && $candidate->specialization_id == $this->specialization_id) {
                    $score += 15;
                    $matched[] = 'specialization';
                }
                if ($this->qualification_id && $candidate->highest_qualification_id == $this->qualification_id) {
                    $score += 15;
                    $matched[] = 'qualification';
                }
                
                $candidate->match_percentage = min(100, $score);
                $candidate->matched_criteria = $matched;
                return $candidate;
            })
            ->filter(function ($candidate) {
                return $candidate->match_percentage > 0;
            })
            ->sortByDesc('match_percentage')
            ->take($limit)
            ->values();
    }
}
