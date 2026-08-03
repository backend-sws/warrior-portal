<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_requirement_id',
        'candidate_id',
        'status',
    ];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function tuition()
    {
        return $this->belongsTo(TuitionRequirement::class, 'tuition_requirement_id');
    }
}
