<?php

namespace App\Models;

use App\Enums\EmploymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Job extends Model
{
    protected $table = 'jobs_postings';

    protected $fillable = [
        'title',
        'location',
        'employment_type',
        'description',
        'full_description',
        'slug',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'employment_type' => EmploymentType::class,
    ];

    protected static function booted(): void
    {
        static::saving(function (Job $job) {
            if (empty($job->slug) && ! empty($job->title)) {
                $job->slug = Str::slug($job->title);
            }
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'position', 'slug');
    }
}
