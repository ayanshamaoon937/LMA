<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class CareersPageSeeder extends Seeder
{
    /**
     * Seeds the careers page with starting content based on the current
     * design (hero, why join cards, life at fcm gallery, benefits,
     * recruitment process steps, closing banner).
     */
    public function run(): void
    {
        $page = Page::firstOrCreate(
            ['slug' => 'careers'],
            [
                'title' => 'Careers',
                'meta_title' => 'Careers at FCM | Build Your Career With FCM',
                'meta_description' => 'Join a team of experienced building, civil, and M&E Clerks of Works working on prestigious projects across the UK.',
            ]
        );

        $sections = [
            'careers_hero' => [
                'title' => 'Build Your Career With FCM',
                'content' => '<p>Join a team of experienced building, civil, and M&E Clerks of Works working on prestigious projects across the UK.</p>',
                'image' => null,
                'button_text' => 'View Open Positions',
                'button_link' => '#open-positions',
                'meta' => [
                    'secondary_btn_text' => 'Submit Your CV',
                    'secondary_btn_link' => '#apply',
                ],
            ],
            'why_join' => [
                'subtitle' => 'WHY JOIN FCM?',
                'title' => 'More than just a job',
                'meta' => [
                    'items' => [
                        ['icons' => 'bi bi-briefcase', 'title' => 'Challenging Projects', 'description' => 'Work on high-profile construction and infrastructure projects.'],
                        ['icons' => 'bi bi-graph-up', 'title' => 'Career Growth', 'description' => 'Continuous learning and professional development to help you grow.'],
                        ['icons' => 'bi bi-people', 'title' => 'Collaborative Team', 'description' => 'Work alongside experienced and supportive professionals.'],
                        ['icons' => 'bi bi-award', 'title' => 'Industry Excellence', 'description' => 'Join a company known for quality, integrity and reliability.'],
                    ],
                ],
            ],
            'positions_section' => [
                'title' => 'Current Opportunities',
                'subtitle' => 'Explore Open Positions',
                'button_text' => 'Apply Now',
            ],
            'submit_applications' => [
                'title' => 'APPLY TODAY',
                'subtitle' => 'Submit Your Application',
                'meta' => [
                    'application_sidebar_items' => [
                        ['icons' => 'bi bi-file-earmark-text', 'title' => 'Prepare Your CV'],
                        ['icons' => 'bi bi-check-circle', 'title' => 'Check Requirements'],
                        ['icons' => 'bi bi-send', 'title' => 'Submit Online'],
                    ],
                ],
            ],
            'life_at_fcm' => [
                'subtitle' => 'LIFE AT FCM',
                'title' => 'Team. Culture. Impact.',
                'meta' => [
                    'images' => [
                        ['image' => null, 'alt' => 'Team reviewing plans together'],
                        ['image' => null, 'alt' => 'Site inspector on a construction site'],
                        ['image' => null, 'alt' => 'Colleagues discussing project documents'],
                        ['image' => null, 'alt' => 'Inspectors walking through a facility'],
                    ],
                ],
            ],
            'benefits' => [
                'title' => 'EMPLOYEE BENEFITS',
                'meta' => [
                    'items' => [
                        ['icons' => 'bi bi-cash-stack', 'label' => 'Competitive Salary'],
                        ['icons' => 'bi bi-clock', 'label' => 'Flexible Working'],
                        ['icons' => 'bi bi-bank', 'label' => 'Pension Scheme'],
                        ['icons' => 'bi bi-journal-bookmark', 'label' => 'Professional Training'],
                        ['icons' => 'bi bi-arrow-up-right-circle', 'label' => 'Career Progression'],
                        ['icons' => 'bi bi-emoji-smile', 'label' => 'Supportive Team Environment'],
                    ],
                ],
            ],
            'recruitment_process' => [
                'subtitle' => 'OUR PROCESS',
                'title' => 'Our Recruitment Process',
                'meta' => [
                    'steps' => [
                        ['title' => 'Submit Application', 'description' => 'Send us your updated CV and cover letter.'],
                        ['title' => 'Initial Review', 'description' => 'Our recruitment team will review your credentials against requirements.'],
                        ['title' => 'Interview Stage', 'description' => 'Speak with our team leaders to discuss potential alignment.'],
                    ],
                ],
            ],
            'careers_cta' => [
                'title' => 'Ready to Build Your Future With FCM?',
                'content' => '<p>Get in touch today or browse our current vacancies to see where you fit in.</p>',
                'button_text' => 'Get Started',
                'image' => null,
            ],
        ];

        foreach ($sections as $key => $data) {
            $page->sections()->updateOrCreate(
                ['section_key' => $key],
                $data
            );
        }
    }
}