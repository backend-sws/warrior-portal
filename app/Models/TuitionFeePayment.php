<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TuitionFeePayment extends Model
{
    protected $fillable = [
        'tuition_fee_account_id',
        'payment_date',
        'amount',
        'payment_mode',
        'collected_by',
        'remarks',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function account()
    {
        return $this->belongsTo(TuitionFeeAccount::class, 'tuition_fee_account_id');
    }
}
