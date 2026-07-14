<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $urls = [
            '/',
            '/about-us',
            '/services',
            '/projects',
            '/careers',
            '/news',
            '/contact',
            '/privacy-policy',
            '/terms-of-use',
        ];

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

        foreach ($urls as $url) {
            $urlElement = $xml->addChild('url');
            $urlElement->addChild('loc', url($url));
            $urlElement->addChild('lastmod', Carbon::now()->toAtomString());
            $urlElement->addChild('changefreq', 'weekly');
            $urlElement->addChild('priority', $url === '/' ? '1.0' : '0.8');
        }

        // Add dynamic service detail pages
        try {
            $services = \App\Models\Service::active()->get();
            foreach ($services as $service) {
                $urlElement = $xml->addChild('url');
                $urlElement->addChild('loc', route('page.service-detail', ['slug' => $service->slug]));
                $urlElement->addChild('lastmod', $service->updated_at->toAtomString());
                $urlElement->addChild('changefreq', 'monthly');
                $urlElement->addChild('priority', '0.7');
            }
            $this->info("Added {$services->count()} service(s).");
        } catch (\Exception $e) {
            $this->warn('Could not fetch services: ' . $e->getMessage());
        }

        // Add dynamic project detail pages
        try {
            $projects = \App\Models\Project::active()->get();
            foreach ($projects as $project) {
                $urlElement = $xml->addChild('url');
                $urlElement->addChild('loc', route('page.project-detail', ['slug' => $project->slug]));
                $urlElement->addChild('lastmod', $project->updated_at->toAtomString());
                $urlElement->addChild('changefreq', 'monthly');
                $urlElement->addChild('priority', '0.7');
            }
            $this->info("Added {$projects->count()} project(s).");
        } catch (\Exception $e) {
            $this->warn('Could not fetch projects: ' . $e->getMessage());
        }

        // Add dynamic news/article detail pages
        try {
            $articles = \App\Models\NewsArticle::active()->get();
            foreach ($articles as $article) {
                $urlElement = $xml->addChild('url');
                $urlElement->addChild('loc', route('page.news-detail', ['slug' => $article->slug]));
                $urlElement->addChild('lastmod', $article->updated_at->toAtomString());
                $urlElement->addChild('changefreq', 'monthly');
                $urlElement->addChild('priority', '0.6');
            }
            $this->info("Added {$articles->count()} news article(s).");
        } catch (\Exception $e) {
            $this->warn('Could not fetch news articles: ' . $e->getMessage());
        }

        $xml->asXML(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at ' . public_path('sitemap.xml'));
    }
}
