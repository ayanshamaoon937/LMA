<?php

namespace App\Services;

use App\Models\Accreditation;
use App\Models\Page;
use App\Models\NewsArticle;
use App\Models\Project;
use App\Models\Service;

class HomePageService
{
    private ?Page $page = null;

    private function getPage(): ?Page
    {
        if (!$this->page) {
            $this->page = Page::with('sections')->where('slug', 'home')->first();
        }
        return $this->page;
    }

    public function getTopBar(): array
    {
        $section = $this->getPage()?->section('top_bar');
        return [
            'address' => $section?->title ?: '6th Floor, International House, 223 Regent Street, London W1B 2QD',
            'phone' => $section?->subtitle ?: '0207 323 5758',
            'email' => $section?->button_text ?: 'info@fcmltd.co.uk',
        ];
    }

    public function getHero(): array
    {
        $section = $this->getPage()?->section('hero');
        return [
            'title' => $section?->title ?: 'Clerks of Works Services and Site Inspections',
            'subtitle' => $section?->subtitle,
            'content' => $section?->content ?: '<p class="hero-text ff-gill-sans-light fw-light text-white mb-3">Most construction professionals are concerned about quality and safety in their building projects.</p><p class="hero-text ff-gill-sans-light fw-light text-white mb-3">We will act as your eyes and ears on site and help your contractors to get it right first time, giving you peace of mind that you are protected from defects and deficiencies.</p>',
            'button_text' => $section?->button_text ?: 'Get in touch',
            'image' => $section?->image,
            'video' => $section?->video,
        ];
    }

    public function getWhoWeAre(): array
    {
        $section = $this->getPage()?->section('who_we_are');
        return [
            'title' => $section?->title ?: 'Who We Are',
            'subtitle' => $section?->subtitle ?: 'Established for over 30 years',
            'content' => $section?->content ?: '<p class="description text-custom-color-1 mx-auto ff-gill-sans-light mb-4">FCM provides leading Clerks of Works and construction inspection services throughout London and the home counties. The business was founded in 1986 by Francis Murray to offer clients the best professional service and value. As a collective, FCM offers a breadth and depth of experience and expertise across many sectors, without passing on the overheads of extremely large consulting and recruitment companies</p>',
            'image' => $section?->image,
            'button_text' => $section?->button_text ?: 'Enquire Today',
        ];
    }

    public function getWhatWeDoServices(): array
    {
        $section = $this->getPage()?->section('what_we_do_services');
        return [
            'title' => $section?->title ?: 'What We Do',
            'subtitle' => $section?->subtitle ?: 'Our Services',
            'content' => $section?->content ?: '<p class="description text-custom-color-1 mx-auto ff-gill-sans-light mb-5">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper</p>',
        ];
    }

    public function getWhatWeDoProjects(): array
    {
        $section = $this->getPage()?->section('what_we_do_projects');
        return [
            'title' => $section?->title ?: 'What We Do',
            'subtitle' => $section?->subtitle ?: 'Latest Projects',
            'button_text' => $section?->button_text ?: 'View More',
        ];
    }

    public function getUptoDateNews(): array
    {
        $section = $this->getPage()?->section('upto_date_news');
        return [
            'title' => $section?->title ?: 'Keep Up To Date',
            'subtitle' => $section?->subtitle ?: 'Latest News',
        ];
    }

    public function getVideo(): array
    {
        $section = $this->getPage()?->section('video');
        return [
            'video' => $section?->video,
        ];
    }

    public function getOurSectors(): array
    {
        $section = $this->getPage()?->section('our_sectors');
      
        $defaultItems = [
            [
                'icons' => 'bi bi-mortarboard',
                'title' => 'Health & Education',
                'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat'
            ],
            [
                'icons' => 'bi bi-bank',
                'title' => 'Government',
                'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat'
            ],
            [
                'icons' => 'bi bi-building',
                'title' => 'Commercial',
                'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat'
            ],
        ];

        return [
            'title' => $section?->title ?: 'OUR SECTORS',
            'content' => $section?->content ?: '<p class="sectors-description ff-gill-sans-light mb-5">Lorem ipsum dolor sit amet, consectetuer adipiscing sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper</p>',
            'image' => $section?->image ? asset('storage/' . $section->image) : asset('assets/images/our-sectors.webp'),
            'items' => $section?->meta['items'] ?? $defaultItems,
        ];
    }

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

    public function getContact(): array
    {
        $section = $this->getPage()?->section('contact');
        return [
            'title' => $section?->title ?: 'Get In Touch',
            'subtitle' => $section?->subtitle ?: 'Contact',
            'phone' => $section?->subtitle ?: '+020 323 5758',
            'email' => $section?->button_text ?: 'info@fcmltd.co.uk',
            'content' => $section?->content ?: 'We are waiting for you at out London office or in other way, you can contact us via the contact form below to discuss your project, your idea',
        ];
    }

    public function getMetaData(): array
    {
        $page = $this->getPage();
        return [
            'meta_title' => $page?->meta_title ?: 'Home | FCM',
            'meta_description' => $page?->meta_description,
            'meta_keywords' => $page?->meta_keywords ? (json_decode($page->meta_keywords) ?? []) : [],
        ];
    }

    public function getServicesList()
    {
        $services = Service::active()->limit(6)->ordered()->get();
        if ($services->isEmpty()) {
          return collect();   
        // return collect([
            //     (object)['title' => "Clerks of\nWorks Service", 'image' => null, 'slug' => 'clerks-of-works-service', 'static_image' => 'assets/images/services/service-1.webp'],
            //     (object)['title' => "M&E Clerks of\nWorks Service", 'image' => null, 'slug' => 'me-clerks-of-works-service', 'static_image' => 'assets/images/services/service-2.webp'],
            //     (object)['title' => "Dispute\nResolutions", 'image' => null, 'slug' => 'dispute-resolutions', 'static_image' => 'assets/images/services/service-3.webp'],
            //     (object)['title' => "NEC Supervisor\nServices", 'image' => null, 'slug' => 'nec-supervisor-services', 'static_image' => 'assets/images/services/service-4.webp'],
            //     (object)['title' => "CQC\nInspections", 'image' => null, 'slug' => 'cqc-inspections', 'static_image' => 'assets/images/services/service-5.webp']
            // ]);
        }
        return $services;
    }

    public function getProjectsList()
    {
        $projects = Project::with('category')->active()->ordered()->limit(4)->get();
        if ($projects->isEmpty()) {
          return collect();    
        // return collect([
            //     (object)['title'=>'400 Longwater Avenue', 'category' => (object)['name' => 'Construction'], 'image' => null, 'static_image' => 'assets/images/projects/project-1.webp'],
            //     (object)['title'=>'Delaney Two', 'category' => (object)['name' => 'Cladding Works'], 'image' => null, 'static_image' => 'assets/images/projects/project-2.webp'],
            //     (object)['title'=>'Apex House', 'category' => (object)['name' => 'Construction'], 'image' => null, 'static_image' => 'assets/images/projects/project-3.webp'],
            //     (object)['title'=>'Greenwich Millennium Village', 'category' => (object)['name' => 'Construction'], 'image' => null, 'static_image' => 'assets/images/projects/project-4.webp']
            // ]);
        }
        return $projects;
    }

    public function getNewsList()
    {
        $news = NewsArticle::active()->limit(3)->ordered()->get();
        if ($news->isEmpty()) {
          return collect();    
        // return collect([
            //     (object)['title'=>"FCM'S ROBERT STEWART RECIEVES\nANOTHER PRESTIGIOUS AWARD", 'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao', 'image' => null, 'static_image' => 'assets/images/news/news-1.webp', 'published_at' => \Carbon\Carbon::parse('2023-05-10')],
            //     (object)['title'=>"CORRECT INSTALLATION\nOF FIRE DOORS", 'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao', 'image' => null, 'static_image' => 'assets/images/news/news-2.webp', 'published_at' => \Carbon\Carbon::parse('2023-05-21')],
            //     (object)['title'=>"CORRECT INSTALLATION OF\nEXTRACT DUCTS", 'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao', 'image' => null, 'static_image' => 'assets/images/news/news-3.webp', 'published_at' => \Carbon\Carbon::parse('2023-05-30')]
            // ]);
        }
        return $news;
    }

    public function getAccreditationsList()
    {
        $accreditations = Accreditation::active()->limit(3)->get();
        if ($accreditations->isEmpty()) {
          return collect();    
        // return collect([
            //     (object)['title'=>"FCM'S ROBERT STEWART RECIEVES\nANOTHER PRESTIGIOUS AWARD", 'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao', 'image' => null, 'static_image' => 'assets/images/news/news-1.webp', 'published_at' => \Carbon\Carbon::parse('2023-05-10')],
            //     (object)['title'=>"CORRECT INSTALLATION\nOF FIRE DOORS", 'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao', 'image' => null, 'static_image' => 'assets/images/news/news-2.webp', 'published_at' => \Carbon\Carbon::parse('2023-05-21')],
            //     (object)['title'=>"CORRECT INSTALLATION OF\nEXTRACT DUCTS", 'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao', 'image' => null, 'static_image' => 'assets/images/news/news-3.webp', 'published_at' => \Carbon\Carbon::parse('2023-05-30')]
            // ]);
        }
        return $accreditations;
    }

    public function getAllSections(): array
    {
        return [
            'top_bar' => $this->getTopBar(),
            'hero' => $this->getHero(),
            'who_we_are' => $this->getWhoWeAre(),
            'what_we_do_services' => $this->getWhatWeDoServices(),
            'what_we_do_projects' => $this->getWhatWeDoProjects(),
            'upto_date_news' => $this->getUptoDateNews(),
            'video' => $this->getVideo(),
            'our_sectors' => $this->getOurSectors(),
            'map' => $this->getMap(),
            'contact' => $this->getContact(),
            'meta' => $this->getMetaData(),
            'services_list' => $this->getServicesList(),
            'projects_list' => $this->getProjectsList(),
            'news_list' => $this->getNewsList(),
            'accreditations_list' => $this->getAccreditationsList(),
        ];
    }
}
