<?php


namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Service;
use App\Models\Project;
use App\Models\NewsArticle;
use App\Models\Certification;
use App\Services\HomePageContent;

class HomeController extends Controller
{
    public function index(HomePageContent $content)
    {
        $serviceItems = Service::active()->ordered()->get();
        $newsItems = NewsArticle::active()->ordered()->limit(3)->get();
        $projectItems = Project::active()->ordered()->limit(4)->get();
        $certificationItems = Certification::active()->ordered()->get();

        // No dedicated Instagram feed/resource yet — reuse a handful of
        // existing project/news images as a placeholder for the marquee,
        // same as the original static design did. Replace this with a
        // real Instagram API pull or its own CMS section later.
        $instagramImages = collect([
                $projectItems->get(0)?->image,
                $newsItems->get(0)?->image,
                $projectItems->get(2)?->image,
                $newsItems->get(1)?->image,
                $projectItems->get(3)?->image,
            ])
            ->filter()
            ->map(fn ($path) => asset('storage/'.$path))
            ->values();

        return view('front.pages.home', [
            'topBar' => $content->topBar(),
            'hero' => $content->hero(),
            'whoWeAre' => $content->whoWeAre(),
            'whatWeDoServices' => $content->whatWeDoServices(),
            'serviceItems' => $serviceItems,
            'ourSectors' => $content->ourSectors(),
            'uptoDateNews' => $content->uptoDateNews(),
            'newsItems' => $newsItems,
            'whatWeDoProjects' => $content->whatWeDoProjects(),
            'projectItems' => $projectItems,
            'video' => $content->video(),
            'map' => $content->map(),
            'contact' => $content->contact(),
            'certificationItems' => $certificationItems,
            'instagramImages' => $instagramImages,
            'pageMeta' => $content->meta(),
        ]);
    }
}
