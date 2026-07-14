<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Core Page Initialization
            $page = Page::updateOrCreate(
                ['slug' => 'news'],
                [
                    'title' => 'News',
                    'meta_title' => 'Latest Insights & Updates | FCM',
                    'meta_description' => 'Stay informed with updates, field tracking guidance, and corporate announcements from FCM.',
                    'meta_keywords' => json_encode(['fcm news', 'construction monitoring updates']),
                ]
            );

            // 2. Static Hero Block Initialization with both text values populated
            $page->sections()->updateOrCreate(
                ['section_key' => 'hero'],
                [
                    'title' => 'News',
                    'subtitle' => 'An inside look at our world',
                    'image' => 'pages/news/hero-banner.jpg',
                    'content' => null,
                    'button_text' => null,
                    'meta' => null
                ]
            );
        });
    }
}