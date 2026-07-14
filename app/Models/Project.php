<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'content',

        'project_category_id',
        'image',

        'project_date',
        'is_active',
        'sort_order',

        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'meta_keywords' => 'array',
    ];


    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            if (empty($project->slug) && ! empty($project->title)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
