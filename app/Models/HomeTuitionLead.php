<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeTuitionLead extends Model
{
    protected $fillable = [
        'tuition_id', 'user_id', 'parent_name', 'parent_mobile', 'email', 'teacher_name', 'teacher_contact', 'location', 
        'pincode', 'class', 'board', 'subjects', 'fee', 'preferred_timing', 'enquiry_date', 
        'tutor_preference', 'dues', 'additional_notes', 'status', 'follow_up_date',
        'id_proof_front', 'id_proof_back', 'teacher_passport_photo', 'is_finally_appointed', 'is_featured'
    ];

    protected $casts = [
        'enquiry_date' => 'date',
        'follow_up_date' => 'date',
        'is_featured' => 'boolean',
    ];

    protected static function booted()
    {
        static::created(function ($lead) {
            if (empty($lead->tuition_id)) {
                $lead->tuition_id = 'TUI-' . str_pad($lead->id, 4, '0', STR_PAD_LEFT);
                $lead->saveQuietly();
            }
        });
    }

    public function getTuitionIdAttribute($value)
    {
        return $value ?: ('TUI-' . str_pad($this->id, 4, '0', STR_PAD_LEFT));
    }

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
