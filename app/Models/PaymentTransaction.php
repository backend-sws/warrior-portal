<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'amount'           => 'decimal:2',
        'gateway_response' => 'array',
        'webhook_payload'  => 'array',
    ];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function invoice()
    {
        return $this->belongsTo(ServiceChargeInvoice::class, 'invoice_id');
    }

    public function tuitionLead()
    {
        return $this->belongsTo(HomeTuitionLead::class, 'tuition_lead_id');
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
