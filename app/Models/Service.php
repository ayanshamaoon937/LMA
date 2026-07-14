<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'icon',
        'image',
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
          static::addGlobalScope('order', function ($query) {
            $query->orderBy('sort_order');
        });
        static::saving(function (Service $service) {
            if (empty($service->slug) && ! empty($service->title)) {
                $service->slug = Str::slug($service->title);
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
}
