<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeTuitionLead extends Model
{
    protected $fillable = [
        'user_id', 'parent_name', 'parent_mobile', 'teacher_name', 'teacher_contact', 'location', 
        'class', 'board', 'subjects', 'fee', 'preferred_timing', 'enquiry_date', 
        'tutor_preference', 'dues', 'additional_notes', 'status', 'follow_up_date'
    ];

    protected $casts = [
        'enquiry_date' => 'date',
        'follow_up_date' => 'date',
    ];

    public function followUps()
    {
        return $this->hasMany(HomeTuitionLeadFollowUp::class)->latest();
    }
}
