<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceChargeInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'due_date'     => 'date',
        'payment_date' => 'datetime',
        'amount'       => 'decimal:2',
        'late_fee'     => 'decimal:2',
    ];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }

    public function tuitionLead()
    {
        return $this->belongsTo(HomeTuitionLead::class, 'home_tuition_lead_id');
    }

    public function tuitionApplication()
    {
        return $this->belongsTo(TuitionApplication::class, 'tuition_application_id');
    }
}
