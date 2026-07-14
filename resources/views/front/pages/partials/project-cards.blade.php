@forelse ($projects as $project)
    <div class="col-md-6 project-item" data-id="{{ $project->id }}">
        <div class="project-card position-relative overflow-hidden project-card-inner">
            <img src="{{ $project->image ? asset('storage/'.$project->image) : asset('assets/images/projects/project-placeholder.webp') }}"
                 class="w-100 h-100" alt="{{ $project->title }}">
            <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 project-overlay-gradient"></div>
            <div class="position-absolute bottom-0 start-0 p-4 text-white">
                <h3 class="ff-baskervville mb-1 project-card-title">
                    {{ $project->title }}{{ $project->subtitle ? ' - '.$project->subtitle : '' }}
                </h3>
                <p class="ff-gill-sans-light mb-0 project-card-subtitle">{{ $projectCard['button_text'] }}</p>
            </div>
            <a href="{{ route('page.project-detail', $project->slug) }}" class="stretched-link"></a>
        </div>
    </div>
@empty
    {{-- handled by JS via isEmpty flag on filter, this covers initial page load with no results --}}
@endforelse