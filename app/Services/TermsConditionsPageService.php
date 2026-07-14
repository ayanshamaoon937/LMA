<?php

namespace App\Services;

use App\Models\Page;

class TermsConditionsPageService
{
    private ?Page $page = null;

    private function getPage(): Page
    {
        if (!$this->page) {
            $this->page = Page::with('sections')->where('slug', 'terms-conditions')->firstOrFail();
        }
        return $this->page;
    }

    public function getHero(): array
    {
        $section = $this->getPage()->section('hero');
        return [
            'title' => $section?->title,
            'button_text' => $section?->button_text,
            'image' => $section?->image,
        ];
    }

    public function getContent(): array
    {
        $section = $this->getPage()->section('content');
        return [
            'title' => $section?->title,
            'content' => $section?->content,
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
            'content' => $this->getContent(),
            'meta' => $this->getMetaData(),
        ];
    }
}
