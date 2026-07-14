<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegalPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // --- 1. SEED PRIVACY POLICY SITE STRUCT ---
            $privacy = Page::updateOrCreate(
                ['slug' => 'privacy-policy'],
                [
                    'title' => 'Privacy Policy',
                    'meta_title' => 'Privacy Policy | FCM',
                    'meta_description' => 'Read our data protection policies.',
                    'meta_keywords' => json_encode(['privacy policy', 'fcm architecture']),
                ]
            );

            $privacy->sections()->updateOrCreate(
                ['section_key' => 'hero'],
                [
                    'title' => 'Privacy Policy',
                    'button_text' => 'Get in touch with us',
                    'image' => 'pages/legal/hero-banner.jpg',
                ]
            );

            $privacy->sections()->updateOrCreate(
                ['section_key' => 'content'],
                [
                    'title' => 'Privacy Policy',
                    'content' => '<h2>PRIVACY STATEMENT</h2><p>FCM has created this privacy statement in order to demonstrate our commitment to privacy...</p>',
                ]
            );

            // --- 2. SEED TERMS & CONDITIONS SITE STRUCT ---
            $terms = Page::updateOrCreate(
                ['slug' => 'terms-conditions'],
                [
                    'title' => 'Terms & Conditions',
                    'meta_title' => 'Terms and Conditions | FCM',
                    'meta_description' => 'Review user agreements and regulatory boundaries.',
                    'meta_keywords' => json_encode(['terms conditions', 'fcm usage guidelines']),
                ]
            );

            $terms->sections()->updateOrCreate(
                ['section_key' => 'hero'],
                [
                    'title' => 'Terms and Conditions',
                    'button_text' => 'Get in touch with us',
                    'image' => 'pages/legal/hero-banner.jpg',
                ]
            );

            $terms->sections()->updateOrCreate(
                ['section_key' => 'content'],
                [
                    'title' => 'Terms and Conditions',
                    'content' => '<h2>TERMS AND CONDITIONS</h2><p>FCM has created this privacy statement in order to demonstrate our commitment to the privacy of our customers...</p>',
                ]
            );
        });
    }
}