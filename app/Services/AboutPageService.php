<?php

namespace App\Services;

use App\Models\Page;

class AboutPageService
{
    private ?Page $page = null;

    private function getPage(): Page
    {
        if (!$this->page) {
            $this->page = Page::with('sections')->where('slug', 'about')->firstOrFail();
        }
        return $this->page;
    }

    public function getHero(): array
    {
        $section = $this->getPage()->section('hero');
        return [
            'title' => $section?->title,
            'image' => $section?->image,
        ];
    }

    public function getEstablished(): array
    {
        $section = $this->getPage()->section('established');
        return [
            'title' => $section?->title,
            'subtitle' => $section?->subtitle,
            'content' => $section?->content,
            'button_text' => $section?->button_text,
        ];
    }

    public function getMiddleBreak(): array
    {
        $section = $this->getPage()->section('middle_break');
        return [
            'image' => $section?->image,
        ];
    }

    public function getWhatWeDo(): array
    {
        $section = $this->getPage()->section('what_we_do');
        return [
            'title' => $section?->title,
            'subtitle' => $section?->subtitle,
            'content' => $section?->content,
            'items' => $section?->meta['items'] ?? [],
        ];
    }

    public function getLowerBreak(): array
    {
        $section = $this->getPage()->section('lower_break');
        return [
            'image' => $section?->image,
        ];
    }

    public function getHelpBanner(): array
    {
        $section = $this->getPage()->section('help_banner');
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
            'established' => $this->getEstablished(),
            'middle_break' => $this->getMiddleBreak(),
            'what_we_do' => $this->getWhatWeDo(),
            'lower_break' => $this->getLowerBreak(),
            'help_banner' => $this->getHelpBanner(),
            'meta' => $this->getMetaData(),
        ];
    }
}
