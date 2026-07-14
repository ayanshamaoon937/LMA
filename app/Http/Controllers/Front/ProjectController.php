<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Services\ProjectPageService;
class ProjectController extends Controller
{
     protected int $perPage = 6;

    public function projects(Request $request)
    {
        $service = app(ProjectPageService::class);

        $categories = ProjectCategory::active()->ordered()->get();

        $activeCategory = $request->query('category');
        $selectedCategory = $activeCategory
            ? $categories->firstWhere('slug', $activeCategory)
            : null;

        $projectsQuery = Project::query()->active()->ordered()->with('category');

        if ($activeCategory) {
            $projectsQuery->whereHas('category', fn ($q) => $q->where('slug', $activeCategory));
        }

        $totalCount = $projectsQuery->count();
        $projects = $projectsQuery->take($this->perPage)->get();

        return view('front.pages.projects', [
            'categories'       => $categories,
            'activeCategory'   => $activeCategory,
            'selectedCategory' => $selectedCategory,
            'projects'         => $projects,
            'perPage'          => $this->perPage,
            'totalCount'       => $totalCount,
            'hasMore'          => $totalCount > $this->perPage,
            'intro'            => $service->getIntro(),
            'projectCard'      => $service->getProjectCard(),
            'listing'          => $service->getListing(),
        ]);
    }

    /**
     * AJAX endpoint: returns rendered project cards + pagination meta as JSON.
     */
    public function filterProjects(Request $request)
    {
        $request->validate([
            'category' => 'nullable|string',
            'offset'   => 'nullable|integer|min:0',
        ]);

        $category = $request->input('category');
        $offset   = (int) $request->input('offset', 0);
        $perPage  = $this->perPage;

        $projectsQuery = Project::query()->active()->ordered()->with('category');

        if ($category) {
            $projectsQuery->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        $totalCount = $projectsQuery->count();
        $projects   = $projectsQuery->skip($offset)->take($perPage)->get();

        $service = app(ProjectPageService::class);
        $categories = ProjectCategory::active()->ordered()->get();
        $selectedCategory = $category ? $categories->firstWhere('slug', $category) : null;

        $html = view('front.pages.partials.project-cards', [
            'projects'    => $projects,
            'projectCard' => $service->getProjectCard(),
        ])->render();

        $nextOffset = $offset + $projects->count();

        return response()->json([
            'html'        => $html,
            'total'       => $totalCount,
            'nextOffset'  => $nextOffset,
            'hasMore'     => $nextOffset < $totalCount,
            'isEmpty'     => $totalCount === 0,
            'noRecordsText' => $service->getListing()['no_records_text'],
            'title'       => $selectedCategory ? strtoupper($selectedCategory->name) : 'ALL PROJECTS',
            'subtitle'    => ($selectedCategory?->hero_subtitle) ?? $service->getIntro()['title'],
            'description' => ($selectedCategory?->hero_description) ?? $service->getIntro()['content'],
        ]);
    }

    public function projectDetail(string $slug)
    {
        $project = Project::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail(); // 404 if slug doesn't exist or is inactive

        $related = Project::query()
            ->active()
            ->ordered()
            ->where('id', '!=', $project->id)
            ->when($project->project_category_id, function ($q) use ($project) {
                // prioritise same-category projects
                $q->orderByRaw('project_category_id = ? DESC', [$project->project_category_id]);
            })
            ->take(3)
            ->get();
            // dd($related);

        $service = app(ProjectPageService::class);

        return view('front.pages.project-detail', [
            'project'    => $project,
            'related'    => $related,
            'metaData'   => $service->getMetaData(),
        ]);
    }
}
