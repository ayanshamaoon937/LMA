<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutUsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Create or update the root Page model entry for 'about'
            $page = Page::updateOrCreate(
                ['slug' => 'about'],
                [
                    'title' => 'About Us',
                    'meta_title' => 'About Us | FCM',
                    'meta_description' => 'Established for over 30 years, let us be your eyes and ears on-site.',
                    'meta_keywords' => json_encode(['about fcm', 'construction experts', 'clerk of works']),
                ]
            );

            // 2. Define the individual sections matching your Filament form keys
            $sections = [
                'hero' => [
                    'title' => 'About Us',
                    'image' => 'pages/about/hero-placeholder.jpg',
                ],
                'established' => [
                    'title' => 'WHO WE ARE',
                    'subtitle' => 'Established for over 30 years',
                    'content' => '<p>FCM provide construction supervision services throughout London and the home counties. The business was founded by Antony Fox-Cumming and John Murray, two fellow professional chartered construction professionals with a breadth and depth of experience across many sectors, with tracking on the construction delivery of many large-scale building schemes in recent decades.</p><p>All of our Clerks of Works are either Members of the Institute of Clerks of Works and Construction Inspectorate (ICWCI), or are qualified experts in their field.</p>',
                    'button_text' => 'FCM Faculty Certificates',
                ],
                'middle_break' => [
                    'image' => 'pages/about/architecture-break.jpg',
                ],
                'what_we_do' => [
                    'title' => 'WHAT WE DO',
                    'subtitle' => 'Let us be your eyes and ears',
                    'content' => '<p>What could be more frustrating than expecting to acquire a bespoke asset, cleanly finished, and ready for use only to find that it is riddled with defects or legacy problems that turn ownership into a major headache?</p><p>Our Consultancy services are backed by decades of experience.</p>',
                    'meta' => [
                        'items' => [
                            ['list_string' => 'We measure performance against specifications, drawings, standards, and codes.'],
                            ['list_string' => 'We monitor workmanship, material installation, testing, and compliance.'],
                            ['list_string' => 'Our Consultancy services are backed by decades of experience.'],
                            ['list_string' => 'We bring wide-ranging knowledge of cost and safety regulations.'],
                            ['list_string' => 'We source materials with a focus on carbon impact reduction.'],
                        ],
                    ],
                ],
                'lower_break' => [
                    'image' => 'pages/about/site-worker-break.jpg',
                ],
                'help_banner' => [
                    'title' => 'We Are Here to Help',
                    'content' => '<p>FCM has a breadth and depth of experience on large structural projects without losing our overheads of extremely large consulting and monitoring companies. All our Clerks of Works are either Members of the Institute of Clerks of Works and Construction Inspectorate (ICWCI), or are qualified experts in their specialist field. To discuss how a Clerk of Works could add value to your project, contact us on <strong>0207 223 2345</strong>, email us at <a href="mailto:info@fcm.com">info@fcm.com</a> or complete our enquiry form.</p>',
                ],
            ];

            // 3. Persist the sections using your model relationship
            foreach ($sections as $key => $data) {
                $page->sections()->updateOrCreate(
                    ['section_key' => $key],
                    $data
                );
            }
        });
    }
}