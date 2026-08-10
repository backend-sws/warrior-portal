<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatePaymentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_payment_account_id',
        'payment_date',
        'amount',
        'payment_mode',
        'type',
        'collected_by',
        'remarks',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function account()
    {
        return $this->belongsTo(CandidatePaymentAccount::class, 'candidate_payment_account_id');
    }
}
