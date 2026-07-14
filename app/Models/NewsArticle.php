<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class NewsArticle extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',

        'image',
        
        'published_at',
        
        'is_active',
        'sort_order',
        
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'meta_keywords' => 'array',
    ];

     protected static function booted(): void
    {
          static::addGlobalScope('order', function ($query) {
            $query->orderBy('sort_order');
        });
        static::saving(function (NewsArticle $article) {
            if (empty($article->slug) && ! empty($article->title)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

     public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('published_at', 'desc');
    }
}
