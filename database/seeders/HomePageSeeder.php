<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Service;
use App\Models\NewsArticle;
use App\Models\Project;
use App\Models\Certification;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    /**
     * Seeds the homepage with the content that is currently hardcoded
     * in resources/views (or wherever the home blade lives), so the
     * CMS has real starting data instead of blank fields.
     *
     * Note: "Our Sectors" items are seeded as part of the our_sectors
     * page_section's `meta` JSON column (used by the Repeater field on
     * the Homepage admin page), not as a separate model/table.
     */
    public function run(): void
    {
        $page = Page::firstOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Home',
                'meta_title' => 'Clerks of Works Services and Site Inspections | FCM',
                'meta_description' => 'FCM provides leading Clerks of Works and construction inspection services throughout London and the home counties.',
            ]
        );

        $sections = [
            'top_bar' => [
                'title' => '6th Floor, International House, 223 Regent Street, London W1B 2QD',
                'subtitle' => '0207 323 5758',
                'button_text' => 'info@fcmltd.co.uk',
            ],
            'hero' => [
                'title' => 'Clerks of Works Services and Site Inspections',
                'subtitle' => 'Most construction professionals are concerned about quality and safety in their building projects.',
                'content' => '<p>We will act as your eyes and ears on site and help your contractors to get it right first time, giving you peace of mind that you are protected from defects and deficiencies.</p>',
            ],
            'who_we_are' => [
                'title' => 'Established for over 30 years',
                'content' => '<p>FCM provides leading Clerks of Works and construction inspection services throughout London and the home counties. The business was founded in 1986 by Francis Murray to offer clients the best professional service and value. As a collective, FCM offers a breadth and depth of experience and expertise across many sectors, without passing on the overheads of extremely large consulting and recruitment companies.</p>',
            ],
            'what_we_do_services' => [
                'title' => 'WHAT WE DO',
                'subtitle' => 'Our Services',
                'content' => '<p>We will act as your eyes and ears on site and help your contractors to get it right first time, giving you peace of mind that you are protected from defects and deficiencies. We are a professional and experienced team of clerks of works, with a strong track record of delivering high quality work for our clients.</p>',
            ],
            'what_we_do_projects' => [
                'title' => 'What WE DO',
                'subtitle' => 'Latest Projects',
                'button_text' => 'View More',
            ],

            'upto_date_news' => [
                'title' => 'UPTO DATE',
                'subtitle' => 'News',
            ],

            'video' => [
                'title' => null,
                'content' => 'assets/images/video/placeholder-video.mp4',
                'image' => 'assets/images/Video Placeholder.png',
            ],
            'our_sectors' => [
                'title' => 'OUR SECTORS',
                'content' => '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper.</p>',
                'image' => 'assets/images/Our Sectors.png',
                // Icons are left blank deliberately — the original site used
                // Bootstrap icon classes (bi-mortarboard, bi-bank, bi-building)
                // which don't carry over. Upload an .svg per item via the CMS.
                'meta' => [
                    'items' => [
                        [
                            'icon' => null,
                            'title' => 'Health & Education',
                            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat',
                        ],
                        [
                            'icon' => null,
                            'title' => 'Government',
                            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat',
                        ],
                        [
                            'icon' => null,
                            'title' => 'Commercial',
                            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat',
                        ],
                    ],
                ],
            ],

             'map' => [
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
            ],
            'contact' => [
                'title' => 'Get In Touch',
                'subtitle' => '+020 323 5758',
                'button_text' => 'info@fcmltd.co.uk',
                'content' => '<p>We are waiting for you at our London office or in other way, you can contact us via the contact form below to discuss your project, your idea.</p>',
            ],
        ];

        foreach ($sections as $key => $data) {
            $page->sections()->updateOrCreate(
                ['section_key' => $key],
                $data
            );
        }

        // $services = [
        //     ['title' => "Clerks of\nWorks Service", 'image' => 'assets/images/services/service-1.png'],
        //     ['title' => "M&E Clerks of\nWorks Service", 'image' => 'assets/images/services/service-2.png'],
        //     ['title' => "Dispute\nResolutions", 'image' => 'assets/images/services/service-3.png'],
        //     ['title' => "NEC Supervisor\nServices", 'image' => 'assets/images/services/service-4.png'],
        //     ['title' => "CQC\nInspections", 'image' => 'assets/images/services/service-5.png'],
        // ];

        // foreach ($services as $i => $service) {
        //     Service::firstOrCreate(
        //         ['title' => $service['title']],
        //         ['image' => $service['image'], 'sort_order' => $i]
        //     );
        // }

        // $news = [
        //     [
        //         'title' => "FCM'S ROBERT STEWART RECEIVES ANOTHER PRESTIGIOUS AWARD",
        //         'excerpt' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao',
        //         'image' => 'assets/images/news/news-1.png',
        //         'published_at' => '2026-05-10',
        //     ],
        //     [
        //         'title' => 'CORRECT INSTALLATION OF FIRE DOORS',
        //         'excerpt' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao',
        //         'image' => 'assets/images/news/news-2.png',
        //         'published_at' => '2026-05-21',
        //     ],
        //     [
        //         'title' => 'CORRECT INSTALLATION OF EXTRACT DUCTS',
        //         'excerpt' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao',
        //         'image' => 'assets/images/news/news-3.png',
        //         'published_at' => '2026-05-30',
        //     ],
        // ];

        // foreach ($news as $i => $article) {
        //     NewsArticle::firstOrCreate(
        //         ['title' => $article['title']],
        //         [
        //             'excerpt' => $article['excerpt'],
        //             'image' => $article['image'],
        //             'published_at' => $article['published_at'],
        //             'sort_order' => $i,
        //         ]
        //     );
        // }

        // $projects = [
        //     ['title' => '400 Longwater Avenue', 'category' => 'Construction', 'image' => 'assets/images/projects/projects-1.png'],
        //     ['title' => 'Delaney Two', 'category' => 'Cladding Works', 'image' => 'assets/images/projects/projects-2.png'],
        //     ['title' => 'Apex House', 'category' => 'Construction', 'image' => 'assets/images/projects/projects-3.png'],
        //     ['title' => 'Greenwich Millennium Village', 'category' => 'Construction', 'image' => 'assets/images/projects/projects-4.png'],
        // ];

        // foreach ($projects as $i => $project) {
        //     Project::firstOrCreate(
        //         ['title' => $project['title']],
        //         ['category' => $project['category'], 'image' => $project['image'], 'sort_order' => $i]
        //     );
        // }

        // $certifications = [
        //     [
        //         'description' => 'Proud members of the institute of clerks of works and construction inspectorate of great britain',
        //         'logo' => 'assets/images/institute-logo.png',
        //     ],
        //     [
        //         'description' => 'ISO 9001:2015 Registered Firm',
        //         'logo' => 'assets/images/QAS International.jpg',
        //     ],
        //     [
        //         'description' => 'Proud member of the London Chamber of Commerce and Industry',
        //         'logo' => 'assets/images/London Chamber of Commerce.jpg',
        //     ],
        // ];

        // foreach ($certifications as $i => $cert) {
        //     Certification::firstOrCreate(
        //         ['description' => $cert['description']],
        //         ['logo' => $cert['logo'], 'sort_order' => $i]
        //     );
        // }
    }
}
