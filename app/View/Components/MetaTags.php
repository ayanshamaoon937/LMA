<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\View\Component;
use App\Helpers\Helper;


class MetaTags extends Component
{
    public $title;
    public $description;
    public $keywords;
    public $author;
    public $image;
    public $url;
    public $ogTitle;
    public $ogDescription;
    public $canonical_url;
    public $meta_robot;
    /**
     * Create a new component instance.
     */
    public function __construct(
        Request $request,
        $title = null,
        $description = null,
        $keywords = null,
        $author = null,
        $image = null,
        $url = null,
        $ogTitle = null,
        $ogDescription = null,
        $canonical_url = null,
        $meta_robot = null,
    ) {
        $seoDefault = $this->defaultSeoFor($request);
        $this->title = $title ?? $seoDefault['title'] ?? config('site.name');
        $this->description = $description ?? $seoDefault['description'] ?? 'Default site description...';
        $this->keywords = $keywords ?? $seoDefault['keywords'] ?? 'Default, Keywords, Here';
        $this->author = $author ?? $seoDefault['author'] ?? 'Default Author';
        $this->image = $image == "no-image" || !$image ? $seoDefault['image'] ?? asset('assets/images/logo.png') : $image;
        $this->url = $url ?? url('/');
        $this->ogTitle = $ogTitle == "" ? $title : $ogTitle;
        $this->ogDescription = $ogDescription == "" ? $description : $ogDescription;
        $this->canonical_url = $canonical_url == "" ? url()->current() : $canonical_url;
        $this->meta_robot = $meta_robot;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.meta-tags');
    }



    protected function defaultSeoFor(Request $request): array
    {
        $defaultImage = asset('assets/images/logo.png');

        return [

            'home' => [
                'title' => $this->get_title('landing_page_seo_info'),
                'description' => $this->get_description('landing_page_seo_info'),
                'keywords' => $this->get_keywords('landing_page_seo_info'),
                'image' => $defaultImage,
            ],

            'articles.index' => [
                'title' => $this->get_title('articles_page_seo_info'),
                'description' => $this->get_description('articles_page_seo_info'),
                'keywords' => $this->get_keywords('articles_page_seo_info'),
                'image' => $defaultImage,
            ],
          

        ][$request->route()?->getName() ?? 'home']
            ?? [
                'title' => $this->get_title('landing_page_seo_info'),
                'description' => $this->get_description('landing_page_seo_info'),
                'keywords' => $this->get_keywords('landing_page_seo_info'),
                'image' => $defaultImage,
            ];
    }


    protected function get_title($case)
    {
        $seo_info = get_Seo_Tags($case);
        return $seo_info['meta_title'] ?? 'Home';
    }
    protected function get_description($case)
    {
        $seo_info = get_Seo_Tags($case);
        return $seo_info['meta_description'] ?? 'Default site description...';
    }
    protected function get_keywords($case)
    {
        $seo_info = get_Seo_Tags($case);
        return $seo_info['seo_tags'] ?? 'Home';
    }
}
