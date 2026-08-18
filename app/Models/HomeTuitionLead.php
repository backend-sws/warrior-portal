<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeTuitionLead extends Model
{
    protected $fillable = [
        'user_id', 'parent_name', 'parent_mobile', 'teacher_name', 'teacher_contact', 'location', 
        'class', 'board', 'subjects', 'fee', 'preferred_timing', 'enquiry_date', 
        'tutor_preference', 'dues', 'additional_notes', 'status', 'follow_up_date',
        'id_proof_front', 'id_proof_back', 'teacher_passport_photo', 'is_finally_appointed'
    ];

    protected $casts = [
        'enquiry_date' => 'date',
        'follow_up_date' => 'date',
    ];

    public function followUps()
    {
        return $this->hasMany(HomeTuitionLeadFollowUp::class)->latest();
    }

    public function serviceChargeInvoices()
    {
        return $this->hasMany(ParentServiceChargeInvoice::class, 'home_tuition_lead_id')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tuitionApplications()
    {
        return $this->hasMany(TuitionApplication::class, 'home_tuition_lead_id');
    }
}
