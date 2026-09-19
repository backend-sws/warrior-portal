<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TuitionFeeAccount extends Model
{
    protected $fillable = [
        'parent_name',
        'student_name',
        'mobile_number',
        'parent_email',
        'address',
        'class',
        'subject',
        'teacher_name',
        'teacher_phone',
        'teacher_email',
        'teacher_joining_date',
        'monthly_fee',
        'status',
        'payment_status',
        'next_due_date',
        'follow_up_date',
        'follow_up_notes',
        'last_paid_date',
        'total_payments_count',
    ];

    protected $casts = [
        'teacher_joining_date' => 'date',
        'next_due_date' => 'date',
        'follow_up_date' => 'date',
        'last_paid_date' => 'date',
        'monthly_fee' => 'decimal:2',
        'total_payments_count' => 'integer',
    ];

    // ─── Relationships ──────────────────────────────────────────
    public function payments()
    {
        return $this->hasMany(TuitionFeePayment::class);
    }

    // ─── Query Scopes ───────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDueToday($query)
    {
        return $query->active()->whereDate('next_due_date', Carbon::today());
    }

    public function scopeOverdue($query)
    {
        return $query->active()
            ->where('next_due_date', '<', Carbon::today())
            ->where('payment_status', '!=', 'paid');
    }

    public function scopeFollowUpToday($query)
    {
        return $query->active()
            ->whereNotNull('follow_up_date')
            ->whereDate('follow_up_date', Carbon::today());
    }

    public function scopePending($query)
    {
        return $query->active()->where('payment_status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->active()->where('payment_status', 'paid');
    }

    public function scopeDueSoon($query, $days = 3)
    {
        $today = Carbon::today();
        return $query->active()->whereBetween('next_due_date', [$today, $today->copy()->addDays($days)]);
    }

    // ─── Computed Helpers ───────────────────────────────────────
    public function getComputedStatusAttribute()
    {
        if ($this->status === 'inactive') return 'inactive';
        if ($this->payment_status === 'paid') return 'paid';
        if ($this->next_due_date && Carbon::parse($this->next_due_date)->isPast() && !Carbon::parse($this->next_due_date)->isToday()) {
            return 'overdue';
        }
        if ($this->next_due_date && Carbon::parse($this->next_due_date)->diffInDays(Carbon::today()) <= 3) {
            return 'due_soon';
        }
        return 'clear';
    }

    public function getDaysOverdueAttribute()
    {
        if ($this->next_due_date && Carbon::parse($this->next_due_date)->isPast()) {
            return Carbon::parse($this->next_due_date)->diffInDays(Carbon::today());
        }
        return 0;
    }

    public function getDisplayTeacherPhoneAttribute()
    {
        if (!empty($this->teacher_phone)) {
            return $this->teacher_phone;
        }
        if ($this->teacher_name) {
            $user = User::where('name', $this->teacher_name)->first();
            return $user?->phone ?? $user?->whatsapp_no ?? $user?->profile?->whatsapp_no;
        }
        return null;
    }

    public function getDisplayTeacherEmailAttribute()
    {
        if (!empty($this->teacher_email)) {
            return $this->teacher_email;
        }
        if ($this->teacher_name) {
            $user = User::where('name', $this->teacher_name)->first();
            return $user?->email;
        }
        return null;
    }

    public function getDisplayParentEmailAttribute()
    {
        if (!empty($this->parent_email)) {
            return $this->parent_email;
        }
        if ($this->mobile_number) {
            $lead = HomeTuitionLead::where('parent_mobile', $this->mobile_number)->first();
            return $lead?->email;
        }
        return null;
    }
}
