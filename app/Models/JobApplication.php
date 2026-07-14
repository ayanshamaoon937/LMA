<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    protected $table = 'job_applications';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'cover_letter',
        'job_application_cv_id',
    ];

    /**
     * Get the CV associated with this job application.
     */
    public function cv(): BelongsTo
    {
        return $this->belongsTo(JobApplicationCv::class, 'job_application_cv_id');
    }
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class,'position','slug');
    }
}
