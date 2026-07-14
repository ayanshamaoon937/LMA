<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Base Meta Frame Setup
            $page = Page::updateOrCreate(
                ['slug' => 'contact'],
                [
                    'title' => 'Contact Us',
                    'meta_title' => 'Get In Touch | FCM',
                    'meta_description' => 'Contact our London office to discuss your project requirements.',
                    'meta_keywords' => json_encode(['contact fcm', 'clerk of works london']),
                ]
            );

            // 2. Populating Contact Block Properties
            $page->sections()->updateOrCreate(
                ['section_key' => 'contact'],
                [
                    'title' => 'Get In Touch',
                    'subtitle' => '+020 323 5758',
                    'button_text' => 'info@fcmltd.co.uk',
                    'content' => '<p>We are waiting for you at our London office or in other way, you can contact us via the contact form below to discuss your project, your idea.</p>',
                ]
            );

            // 3. Populating Map Object Matrix seamlessly via the single text JSON meta container
            $page->sections()->updateOrCreate(
                ['section_key' => 'map'],
                [
                    'meta' => [
                        'center_lat' => 51.52,
                        'center_lng' => -0.08,
                        'zoom' => 11,
                        'locations' => [
                            ['label' => null, 'lat' => 51.54, 'lng' => -0.23],
                            ['label' => null, 'lat' => 51.535, 'lng' => -0.10],
                            ['label' => null, 'lat' => 51.52, 'lng' => -0.01],
                            ['label' => null, 'lat' => 51.525, 'lng' => 0.02],
                            ['label' => null, 'lat' => 51.48, 'lng' => -0.08],
                            ['label' => null, 'lat' => 51.61, 'lng' => 0.04],
                        ],
                    ],
                ]
            );
        });
    }
}