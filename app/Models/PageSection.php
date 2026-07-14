<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    // protected $fillable = [
    //     'page_id',
    //     'section_key',
    //     'title',
    //     'subtitle',
    //     'content',
    //     'image',
    //     'meta',
    //     'button_text',
    //     'button_link',
    //     'sort_order',
    //     'is_active',
    // ];

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'meta' => 'array',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}