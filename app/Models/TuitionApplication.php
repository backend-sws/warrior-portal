<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_tuition_lead_id',
        'candidate_id',
        'status',
        'remarks',
        'demo_date',
    ];

    protected $casts = [
        'demo_date' => 'datetime',
    ];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function tuitionLead()
    {
        return $this->belongsTo(HomeTuitionLead::class, 'home_tuition_lead_id');
    }
}
