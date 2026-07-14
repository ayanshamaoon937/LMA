<?php

namespace App\Services;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Support\Facades\DB;

class PageContentService
{
    public function updateSection(
        Page $page,
        string $key,
        array $data
    ): void {
        DB::transaction(function () use ($page, $key, $data) {

            PageSection::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'section_key' => $key,
                ],
                $data
            );
        });
    }
}