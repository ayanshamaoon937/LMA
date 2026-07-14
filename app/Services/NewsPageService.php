<?php

namespace App\Services;

use App\Models\Page;

class NewsPageService
{
    private ?Page $page = null;

    private function getPage(): Page
    {
        if (!$this->page) {
            $this->page = Page::with('sections')->where('slug', 'news')->firstOrFail();
        }
        return $this->page;
    }

    public function getHero(): array
    {
        $section = $this->getPage()->section('hero');
        return [
            'title' => $section?->title,
            'subtitle' => $section?->subtitle,
            'image' => $section?->image,
        ];
    }

    public function getMetaData(): array
    {
        return [
            'meta_title' => $this->getPage()->meta_title,
            'meta_description' => $this->getPage()->meta_description,
            'meta_keywords' => json_decode($this->getPage()->meta_keywords) ?? [],
        ];
    }

    public function getAllSections(): array
    {
        return [
            'hero' => $this->getHero(),
            'meta' => $this->getMetaData(),
        ];
    }
}
