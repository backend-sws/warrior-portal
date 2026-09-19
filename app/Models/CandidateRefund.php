<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateRefund extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
