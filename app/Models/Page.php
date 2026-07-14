<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    // protected $fillable = [
    //     'title',
    //     'slug',
    //     'meta_title',
    //     'meta_description',
    // ];

    protected $guarded = [];

    public function sections()
    {
        return $this->hasMany(PageSection::class);
    }

    public function section(string $key): ?PageSection
    {
        return $this->sections
            ->where('section_key', $key)
            ->first();
    }
}