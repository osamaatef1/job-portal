<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'user_id',
        'job_application_id',
        'filename',
        'original_name',
        'path',
        'mime_type',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}