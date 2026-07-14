<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobApplicationCv extends Model
{
    protected $table = 'job_application_cvs';

    protected $fillable = [
        'filename',
        'file_path',
        'mime_type',
        'file_size',
        'is_temp',
    ];

    protected $casts = [
        'is_temp' => 'boolean',
        'file_size' => 'integer',
    ];

    /**
     * Get the job application associated with this CV.
     */
    public function jobApplication(): HasOne
    {
        return $this->hasOne(JobApplication::class, 'job_application_cv_id');
    }
}
