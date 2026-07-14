<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Core Page Initialization
            $page = Page::updateOrCreate(
                ['slug' => 'services'],
                [
                    'title' => 'Our Services',
                    'meta_title' => 'Professional Supervision Services | FCM',
                    'meta_description' => 'Explore the quality assurance, construction monitoring, and specialist consultancy services provided by FCM.',
                    'meta_keywords' => json_encode(['clerk of works', 'm&e supervision', 'nec supervisor', 'quality control inspections']),
                ]
            );

            // 2. Main Page Layout Wrapper Record Setup
            $page->sections()->updateOrCreate(
                ['section_key' => 'hero'],
                [
                    'title' => 'OUR SERVICES',
                    'image' => 'pages/services/hero-banner.jpg',
                    'button_text' => 'SEE MORE',
                    'subtitle' => null,
                    'content' => null,
                    'meta' => null
                ]
            );
        });
    }
}