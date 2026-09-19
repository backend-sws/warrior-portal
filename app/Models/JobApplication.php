<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'interview_date' => 'datetime',
    ];

    public const STATUS_APPLIED = 'applied';
    public const STATUS_SHORTLISTED = 'shortlisted';
    public const STATUS_FORWARDED = 'forwarded_to_school';
    public const STATUS_DEMO_SCHEDULED = 'demo_scheduled';
    public const STATUS_HIRED = 'hired';
    public const STATUS_REJECTED_BY_SCHOOL = 'rejected_by_school';
    public const STATUS_TUTOR_BACKED_OUT = 'tutor_backed_out';
    public const STATUS_REJECTED_BY_ADMIN = 'rejected_by_admin';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_APPLIED => 'New applied',
            self::STATUS_SHORTLISTED => 'Shortlisted',
            self::STATUS_FORWARDED => 'Forwarded to school/institute',
            self::STATUS_DEMO_SCHEDULED => 'Demo scheduled',
            self::STATUS_HIRED => 'Selected/hired',
            self::STATUS_REJECTED_BY_SCHOOL => 'Rejected by school/institute',
            self::STATUS_TUTOR_BACKED_OUT => 'Tutor backed out',
            self::STATUS_REJECTED_BY_ADMIN => 'Rejected by admin',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        $statuses = self::getStatuses();
        if (isset($statuses[$this->status])) {
            return $statuses[$this->status];
        }
        if ($this->status === 'rejected') {
            return 'Rejected by admin';
        }
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'applied' => 'bg-sky-50 text-sky-700 border border-sky-200',
            'shortlisted' => 'bg-blue-50 text-blue-700 border border-blue-200',
            'forwarded_to_school' => 'bg-indigo-50 text-indigo-700 border border-indigo-200',
            'demo_scheduled', 'interview' => 'bg-amber-50 text-amber-700 border border-amber-200',
            'hired' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
            'rejected_by_school' => 'bg-rose-50 text-rose-700 border border-rose-200',
            'tutor_backed_out' => 'bg-orange-50 text-orange-700 border border-orange-200',
            'rejected_by_admin', 'rejected' => 'bg-red-50 text-red-700 border border-red-200',
            default => 'bg-slate-50 text-slate-700 border border-slate-200',
        };
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function invoice()
    {
        return $this->hasOne(ServiceChargeInvoice::class, 'job_application_id');
    }
}
