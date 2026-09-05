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

    public function getCategoryAttribute()
    {
        if (!empty($this->tuition_lead_id) 
            || ($this->invoice && (!empty($this->invoice->home_tuition_lead_id) || !empty($this->invoice->tuition_application_id) || stripos($this->invoice->description ?? '', 'tuition') !== false)) 
            || $this->type === 'parent_service_charge') {
            return 'tuition';
        }
        return 'job';
    }

    public function getCategoryLabelAttribute()
    {
        return $this->category === 'tuition' ? 'Home Tuition' : 'School Job';
    }

    public function scopeForCategory($query, $category)
    {
        if ($category === 'tuition') {
            return $query->where(function ($q) {
                $q->whereNotNull('tuition_lead_id')
                  ->orWhere('type', 'parent_service_charge')
                  ->orWhereHas('invoice', function ($invQ) {
                      $invQ->whereNotNull('home_tuition_lead_id')
                           ->orWhereNotNull('tuition_application_id')
                           ->orWhere('description', 'like', '%tuition%');
                  });
            });
        } elseif ($category === 'job') {
            return $query->where(function ($q) {
                $q->where('type', 'registration_fee')
                  ->orWhere(function ($subQ) {
                      $subQ->whereNull('tuition_lead_id')
                           ->where('type', '!=', 'parent_service_charge')
                           ->whereHas('invoice', function ($invQ) {
                               $invQ->whereNull('home_tuition_lead_id')
                                    ->whereNull('tuition_application_id')
                                    ->where('description', 'not like', '%tuition%');
                           });
                  });
            });
        }
        return $query;
    }
}
