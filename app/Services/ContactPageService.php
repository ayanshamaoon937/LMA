<?php

namespace App\Services;

use App\Models\Page;

class ContactPageService
{
    private ?Page $page = null;

    private function getPage(): Page
    {
        if (!$this->page) {
            $this->page = Page::with('sections')->where('slug', 'contact')->firstOrFail();
        }
        return $this->page;
    }

    public function getContact(): array
    {
        $section = $this->getPage()->section('contact');
        return [
            'title' => $section?->title,
            'subtitle' => $section?->subtitle,
            'phone' => get_setting('phone'),
            'email' => get_setting('email'),
            'content' => $section?->content,
        ];
    }

    // public function getMap(): array
    // {
    //     $section = $this->getPage()->section('map');
    //     return [
    //         'center_lat' => $section?->meta['center_lat'] ?? 51.52,
    //         'center_lng' => $section?->meta['center_lng'] ?? -0.08,
    //         'zoom' => $section?->meta['zoom'] ?? 11,
    //         'locations' => $section?->meta['locations'] ?? [],
    //     ];
    // }


    public function getMap(): array
    {
        $section = $this->getPage()?->section('map');
        return [
            'center_lat' => $section?->meta['center_lat'] ?? 51.52,
            'center_lng' => $section?->meta['center_lng'] ?? -0.08,
            'zoom' => $section?->meta['zoom'] ?? 11,
            'locations' => $section?->meta['locations'] ?? [
                ['label' => null, 'lat' => 51.54, 'lng' => -0.23],
                ['label' => null, 'lat' => 51.535, 'lng' => -0.10],
                ['label' => null, 'lat' => 51.52, 'lng' => -0.01],
                ['label' => null, 'lat' => 51.525, 'lng' => 0.02],
                ['label' => null, 'lat' => 51.48, 'lng' => -0.08],
                ['label' => null, 'lat' => 51.61, 'lng' => 0.04],
            ],
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
            'contact' => $this->getContact(),
            'map' => $this->getMap(),
            'meta' => $this->getMetaData(),
        ];
    }
}
