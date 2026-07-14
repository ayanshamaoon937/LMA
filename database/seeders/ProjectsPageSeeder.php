<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
          // 1. Seed CMS Page Layout & Global Button
            $page = Page::updateOrCreate(
                ['slug' => 'projects'],
                [
                    'title' => 'Our Projects',
                    'meta_title' => 'Project Portfolio Showcase | FCM',
                    'meta_description' => 'Browse our tracking record across structural fields.',
                    'meta_keywords' => json_encode(['fcm projects', 'residential design']),
                ]
            );

            $page->sections()->updateOrCreate(
                ['section_key' => 'intro'],
                [
                    'title' => 'Residential',
                    'subtitle' => 'View Projects',
                    'content' => 'We pride ourselves on our meticulous approach to every project, ensuring that each space we design is both functional and aesthetically pleasing. Our residential portfolio showcases our commitment to creating bespoke homes that reflect the unique lifestyles of our clients.',
                    'button_text' => 'ALL PROJECTS',
                    'image' => 'projects/residential-hero.webp', // adjust path as needed
                ]
            );

            $page->sections()->updateOrCreate(
                ['section_key' => 'project_card'],
                [
                    'button_text' => 'View Project',
                    'image' => 'projects/commercial-hero.webp', // adjust path as needed
                ]
            );

          // 2. Seed default project categories (if not exist)
            $categories = [
                [
                    'name' => 'Residential',
                    'slug' => 'residential',
                    'hero_subtitle' => 'Explore our residential projects',
                    'hero_description' => 'Beautiful homes and living spaces crafted with care.',
                    'hero_image' => 'projects/residential-hero.webp',
                    'sort_order' => 1,
                    'is_active' => true,
                ],
                [
                    'name' => 'Commercial',
                    'slug' => 'commercial',
                    'hero_subtitle' => 'Discover our commercial works',
                    'hero_description' => 'Modern offices, retail spaces, and institutional buildings.',
                    'hero_image' => 'projects/commercial-hero.webp',
                    'sort_order' => 2,
                    'is_active' => true,
                ],
            ];

            foreach ($categories as $cat) {
                ProjectCategory::updateOrCreate(
                    ['slug' => $cat['slug']],
                    $cat
                );
            }
        });
    }
}