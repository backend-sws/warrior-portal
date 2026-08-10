<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatePaymentAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_name',
        'mobile_number',
        'address',
        'tuition_assigned',
        'joining_date',
        'monthly_amount',
        'status',
        'next_due_date',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'next_due_date' => 'date',
    ];

    public function payments()
    {
        return $this->hasMany(CandidatePaymentRecord::class);
    }
}
