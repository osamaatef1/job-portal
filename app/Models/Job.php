<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'user_jobs';

    protected $fillable = [
        'title',
        'description',
        'location',
        'salary_range',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }
}