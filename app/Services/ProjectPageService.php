<?php

namespace App\Services;

use App\Models\Page;

class ProjectPageService
{
    private ?Page $page = null;

    protected function getPage(): Page
    {
        if (! $this->page) {
            $this->page = Page::with('sections')
                ->where('slug', 'projects')
                ->firstOrFail();
        }

        return $this->page;
    }

    public function getIntro(): array
    {
        $section = $this->getPage()->section('intro');

        return [
            'button_text' => $section?->button_text ?? 'ALL PROJECTS',
            'title' => $section?->title ?? '',
            'content' => $section?->content ?? '',
        ];
    }

    public function getListing(): array
    {
        $section = $this->getPage()->section('project_listing');

        return [
            'load_more_text'  => $section?->button_text ?? 'LOAD MORE',
            'no_records_text' => $section?->description ?? 'No Records Found',
        ];
    }

    public function getProjectCard(): array
    {
        $section = $this->getPage()->section('project_card');

        return [
            'button_text' => $section?->button_text ?? 'View Project',
        ];
    }

    public function getMetaData(): array
    {
        $page = $this->getPage();

        return [
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keywords' => json_decode($page->meta_keywords, true) ?? [],
        ];
    }

    public function getAllSections(): array
    {
        return [
            'intro' => $this->getIntro(),
            'project_listing'=> $this->getListing(),
            'project_card' => $this->getProjectCard(),
            'meta' => $this->getMetaData(),
        ];
    }
}