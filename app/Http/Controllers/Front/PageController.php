<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\GoogleRecaptcha;
use App\Models\Job;
use App\Models\NewsArticle;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Services\CmsService;
use Illuminate\Http\Request;

class PageController extends Controller
{

    protected readonly CmsService $cms;

    public function __construct(CmsService $cms)
    {
        $this->cms = $cms;
    }

    public function index()
    {
        $cms = $this->cms->allSections('home');
        return view('front.pages.index', [
            'cms' => $cms,
            'services' => $cms['services_list'],
            'projects' => $cms['projects_list'],
            'news' => $cms['news_list'],
            'accreditations' => $cms['accreditations_list'],
            'recaptcha' => GoogleRecaptcha::first(),
        ]);
    }

    public function aboutUs()
    {
        $cms = $this->cms->allSections('about');
        return view('front.pages.about-us', [
            'cms' => $cms,
        ]);
    }

    // public function news()
    // {
    //     $cms = $this->cms->allSections('news');
    //     $articles = NewsArticle::active()->ordered()->paginate(6);
    //     return view('front.pages.news', [
    //         'cms' => $cms,
    //         'articles' => $articles,
    //     ]);
    // }

    // public function loadMoreNews()
    // {
    //     $page = request('page', 2);
    //     $articles = NewsArticle::active()->ordered()->paginate(6, ['*'], 'page', $page);

    //     if ($articles->isEmpty()) {
    //         return response()->json(['html' => '', 'hasMore' => false]);
    //     }

    //     $html = '';
    //     foreach ($articles as $article) {
    //         $html .= view('front.partials.news-card', compact('article'))->render();
    //     }

    //     return response()->json([
    //         'html' => $html,
    //         'hasMore' => $articles->hasMorePages(),
    //         'nextPage' => $articles->currentPage() + 1,
    //     ]);
    // }

    // public function news()
    // {
    //     $cms = $this->cms->allSections('news');
    //     $articles = NewsArticle::active()->ordered()->paginate(6);

    //     return view('front.pages.news', [
    //         'cms' => $cms,
    //         'articles' => $articles,
    //     ]);
    // }

    // public function loadMoreNews(Request $request)
    // {
    //     $validated = $request->validate([
    //         'page' => ['nullable', 'integer', 'min:2'],
    //     ]);

    //     $page = $validated['page'] ?? 2;
    //     $articles = NewsArticle::active()->ordered()->paginate(6, ['*'], 'page', $page);

    //     if ($articles->isEmpty()) {
    //         return response()->json(['html' => '', 'hasMore' => false]);
    //     }

    //     $html = '';
    //     foreach ($articles as $article) {
    //         $html .= view('front.partials.news-card', compact('article'))->render();
    //     }

    //     return response()->json([
    //         'html' => $html,
    //         'hasMore' => $articles->hasMorePages(),
    //         'nextPage' => $articles->currentPage() + 1,
    //     ]);
    // }


    public function news(Request $request)
    {

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $search = trim($validated['search'] ?? '');

        $cms = $this->cms->allSections('news');
        $query = NewsArticle::active()->ordered();
         if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }
      $articles = $query->paginate(6)->appends(['search' => $search]);

        return view('front.pages.news', [
            'cms' => $cms,
            'articles' => $articles,
            'search' => $search,
        ]);
    }

    public function loadMoreNews(Request $request)
    {
        $validated = $request->validate([
            'page' => ['nullable', 'integer', 'min:2'],
             'search' => ['nullable', 'string', 'max:100'],
        ]);

        $page = $validated['page'] ?? 2;
        $search = trim($validated['search'] ?? '');
        
        // $articles = NewsArticle::active()->ordered()->paginate(2, ['*'], 'page', $page);
         $query = NewsArticle::active()->ordered();
         if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(6, ['*'], 'page', $page);
        if ($articles->isEmpty()) {
            return response()->json(['html' => '', 'hasMore' => false]);
        }

        $html = '';
        foreach ($articles as $article) {
            $html .= view('front.partials.news-card', compact('article'))->render();
        }

        return response()->json([
            'html' => $html,
            'hasMore' => $articles->hasMorePages(),
            'nextPage' => $articles->currentPage() + 1,
        ]);
    }
    

    private function resolveCategorySlug(?string $slug): ?string
    {
        if (!$slug) return null;

        return ProjectCategory::active()->where('slug', $slug)->exists() ? $slug : null;
    }

    public function projects(Request $request)
    {
        $cms = $this->cms->allSections('projects');
        $categories = ProjectCategory::active()->ordered()->get();

        $projects =  Project::active()->ordered()->with('category')->get();

        return view('front.pages.projects', [
            'cms' => $cms,
            'categories' => $categories,
            'projects' => $projects,
        ]);
    }

    

    // public function services()
    // {
    //     $cms = $this->cms->allSections('services');
    //     $services = Service::active()->ordered()->paginate(6);

    //     return view('front.pages.services', [
    //         'cms'      => $cms,
    //         'services' => $services,
    //     ]);
    // }

    // public function loadMoreServices()
    // {
    //     $page = request('page', 2);
    //     $cms = $this->cms->allSections('services');
    //     $services = Service::active()->ordered()->paginate(6, ['*'], 'page', $page);

    //     if ($services->isEmpty()) {
    //         return response()->json(['html' => '', 'hasMore' => false]);
    //     }

    //     $startIndex = ($page - 1) * 6;

    //     $html = '';
    //     foreach ($services as $i => $service) {
    //         $index = $startIndex + $i;
    //         $html .= view('front.partials.service-block', compact('service', 'cms', 'index'))->render();
    //     }

    //     return response()->json([
    //         'html' => $html,
    //         'hasMore' => $services->hasMorePages(),
    //         'nextPage' => $services->currentPage() + 1,
    //     ]);
    // }


    // public function services()
    // {
    //     $cms = $this->cms->allSections('services');
    //     $services = Service::active()->ordered()->paginate(2);

    //     return view('front.pages.services', [
    //         'cms'      => $cms,
    //         'services' => $services,
    //     ]);
    // }

    // public function loadMoreServices(Request $request)
    // {
    //     $validated = $request->validate([
    //         'page' => ['nullable', 'integer', 'min:2'],
    //     ]);

    //     $page = $validated['page'] ?? 2;
    //     $cms = $this->cms->allSections('services');
    //     $services = Service::active()->ordered()->paginate(2, ['*'], 'page', $page);

    //     if ($services->isEmpty()) {
    //         return response()->json(['html' => '', 'hasMore' => false]);
    //     }

    //     $startIndex = ($page - 1) * 2;

    //     $html = '';
    //     foreach ($services as $i => $service) {
    //         $index = $startIndex + $i;
    //         $html .= view('front.partials.service-block', compact('service', 'cms', 'index'))->render();
    //     }

    //     return response()->json([
    //         'html'     => $html,
    //         'hasMore'  => $services->hasMorePages(),
    //         'nextPage' => $services->currentPage() + 1,
    //     ]);
    // }

    public function services()
    {
        $cms = $this->cms->allSections('services');
        $services = Service::active()->ordered()->paginate(6);

        return view('front.pages.services', [
            'cms'      => $cms,
            'services' => $services,
        ]);
    }

    public function loadMoreServices(Request $request)
    {
        $validated = $request->validate([
            'page' => ['nullable', 'integer', 'min:2'],
        ]);

        $page = $validated['page'] ?? 2;
        $cms = $this->cms->allSections('services');
        $services = Service::active()->ordered()->paginate(6, ['*'], 'page', $page);

        if ($services->isEmpty()) {
            return response()->json(['html' => '', 'hasMore' => false]);
        }

        $html = '';
        foreach ($services as $i => $service) {
            // global index across all pages, not just this page's local loop index
            $index = (($page - 1) * $services->perPage()) + $i;
            $html .= view('front.partials.service-block', compact('service', 'cms', 'index'))->render();
        }

        return response()->json([
            'html'     => $html,
            'hasMore'  => $services->hasMorePages(),
            'nextPage' => $services->currentPage() + 1,
        ]);
    }

    public function privacyPolicy()
    {
        return view('front.pages.privacy-policy', [
            'cms' => $this->cms->allSections('privacy-policy')
        ]);
    }

    public function termsOfUse()
    {
        return view('front.pages.terms-of-use', [
            'cms' => $this->cms->allSections('terms-conditions')
        ]);
    }

    public function careers()
    {
        $cms = $this->cms->allSections('careers');
        $jobs = Job::active()->ordered()->get();

        return view('front.pages.careers', [
            'cms' => $cms,
            'jobs' => $jobs,
        ]);
    }

    public function contact()
    {
        return view('front.pages.contact', [
            'cms' => $this->cms->allSections('contact'),
            'recaptcha' => GoogleRecaptcha::first(),
        ]);
    }

    public function generateStaticServices()
    {
        return view('front.pages.generate-static-services');
    }

    public function newsDetail($slug = null)
    {
        $article = $slug ? NewsArticle::where('slug', $slug)->where('is_active', true)->first() : null;
        $related = NewsArticle::active()->ordered()
            ->when($article, fn($q) => $q->where('id', '!=', $article->id))
            ->take(3)->get();
        $cms = $this->cms->allSections('news');

        return view('front.pages.news-detail', [
            'article' => $article,
            'related' => $related,
            'cms' => $cms,
        ]);
    }

    // public function projectDetail($slug = null)
    // {
    //     $project = $slug ? Project::where('slug', $slug)->where('is_active', true)->with('category')->first() : null;
    //     $related = Project::active()->ordered()
    //         ->when($project, fn($q) => $q->where('id', '!=', $project->id))
    //         ->take(3)->get();
    //     $cms = $this->cms->allSections('projects');

    //     return view('front.pages.project-detail', [
    //         'project' => $project,
    //         'related' => $related,
    //         'cms' => $cms,
    //     ]);
    // }

    // public function serviceDetail($slug)
    // {
    //     $service = Service::where('slug', $slug)->where('is_active', true)->first();

    //     if (!$service) {
    //         return view('front.pages.service-detail', compact('slug'));
    //     }

    //     $relatedProjects = Project::active()->ordered()->take(3)->get();
    //     $cms = $this->cms->allSections('services');

    //     return view('front.pages.service-detail', [
    //         'service'         => $service,
    //         'relatedProjects' => $relatedProjects,
    //         'cms'             => $cms,
    //         'slug'            => $slug,
    //     ]);
    // }

    public function serviceDetail(string $slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail(); // 404 if slug is invalid/inactive

        $relatedProjects = Project::query()
            ->active()
            ->ordered()
            ->take(3)
            ->get();

        $cms = $this->cms->allSections('services');

        return view('front.pages.service-detail', [
            'service'         => $service,
            'relatedProjects' => $relatedProjects,
            'cms'             => $cms,
        ]);
    }
}
