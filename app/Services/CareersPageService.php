<?php

namespace App\Services;

use App\Models\Page;

class CareersPageService
{
    private ?Page $page = null;

    private function getPage(): Page
    {
        if (!$this->page) {
            $this->page = Page::with('sections')->where('slug', 'careers')->firstOrFail();
        }
        return $this->page;
    }

    public function getHero(): array
    {
        $section = $this->getPage()->section('careers_hero');
        return [
            'title' => $section?->title,
            'content' => $section?->content,
            'image' => $section?->image,
            'primary_btn_text' => $section?->button_text,
            'primary_btn_link' => $section?->button_link,
            'secondary_btn_text' => $section?->meta['secondary_btn_text'] ?? null,
            'secondary_btn_link' => $section?->meta['secondary_btn_link'] ?? null,
        ];
    }

    public function getWhyJoin(): array
    {
        $section = $this->getPage()->section('why_join');
        return [
            'title' => $section?->title,
            'subtitle' => $section?->subtitle,
            'items' => $section?->meta['items'] ?? [],
        ];
    }

    public function getPositionsSection(): array
    {
        $section = $this->getPage()->section('positions_section');
        return [
            'title' => $section?->title,
            'subtitle' => $section?->subtitle,
            'button_text' => $section?->button_text,
        ];
    }

    public function getSubmitApplications(): array
    {
        $section = $this->getPage()->section('submit_applications');
        return [
            'title' => $section?->title,
            'subtitle' => $section?->sub_title,
            'application_sidebar_items' => $section?->meta['application_sidebar_items'] ?? [],
        ];
    }

    public function getLifeAtFcm(): array
    {
        $section = $this->getPage()->section('life_at_fcm');
        return [
            'title' => $section?->title,
            'subtitle' => $section?->subtitle,
            'images' => $section?->meta['images'] ?? [],
        ];
    }

    public function getBenefits(): array
    {
        $section = $this->getPage()->section('benefits');
        return [
            'title' => $section?->title,
            'items' => $section?->meta['items'] ?? [],
        ];
    }

    public function getRecruitmentProcess(): array
    {
        $section = $this->getPage()->section('recruitment_process');
        return [
            'title' => $section?->title,
            'subtitle' => $section?->subtitle,
            'steps' => $section?->meta['steps'] ?? [],
        ];
    }

    public function getCareersCta(): array
    {
        $section = $this->getPage()->section('careers_cta');
        return [
            'title' => $section?->title,
            'content' => $section?->content,
            'button_text' => $section?->button_text,
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
            'why_join' => $this->getWhyJoin(),
            'positions_section' => $this->getPositionsSection(),
            'submit_applications' => $this->getSubmitApplications(),
            'life_at_fcm' => $this->getLifeAtFcm(),
            'benefits' => $this->getBenefits(),
            'recruitment_process' => $this->getRecruitmentProcess(),
            'careers_cta' => $this->getCareersCta(),
            'meta' => $this->getMetaData(),
        ];
    }
}
