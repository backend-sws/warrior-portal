<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeTuitionLeadFollowUp extends Model
{
    protected $fillable = [
        'home_tuition_lead_id', 'admin_id', 'note', 'follow_up_date'
    ];

    protected $casts = [
        'follow_up_date' => 'date',
    ];

    public function lead()
    {
        return $this->belongsTo(HomeTuitionLead::class, 'home_tuition_lead_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
