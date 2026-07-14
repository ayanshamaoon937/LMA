@extends('front.newLayout.protected')
@use(Illuminate\Support\Str)

@section('header')
    <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <style>
        /* ── FilePond Upload Box ────────────────────────────────────── */
        .filepond--root {
            font-family: "Gill Sans Light", sans-serif;
            margin-bottom: 0;
            min-height: 220px !important;
            font-size: 1rem;
            /* Put the dashed border and background on the ROOT element */
            background-color: #f8f9fa !important;
            border: 2px dashed var(--custom-color-2, #4c99f5) !important;
            border-radius: 8px !important;
            transition: background-color 0.25s ease, border-color 0.25s ease;
            box-sizing: border-box;
        }
        
        /* Hide the internal panel completely to avoid double backgrounds/borders */
        .filepond--panel-root {
            display: none !important;
        }
        
        /* Hover / drag states */
        .filepond--root:hover,
        .filepond--root.filepond--is-drag-over {
            background-color: #e8f0fe !important;
            border-color: var(--custom-color-1, #09205d) !important;
        }
        
        /* Make the drop label fill the whole box and center content */
        .filepond--drop-label {
            min-height: 220px !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
        .filepond--drop-label label {
            cursor: pointer;
            width: 100%;
        }
        .filepond--credits {
            display: none !important;
        }
    </style>
@endsection

@section('content')

<main>
    <!-- Hero Section -->
    <section class="careers-hero-section d-flex align-items-center" @if(!empty($cms['hero']['image'])) style="background-image: url('{{ asset('storage/' . $cms['hero']['image']) }}');" @endif>
        <div class="container">
            <div class="row mx-0">
                <div class="col-lg-6 px-0">
                    <div class="d-flex flex-column justify-content-start">
                        <h1 class="ff-baskervville hero-title mb-3">{{ $cms['hero']['title'] ?? 'Build Your Career With FCM' }}</h1>
                        <p class="ff-gill-sans-light hero-subtitle">{!! $cms['hero']['content'] ?? 'Join a team of experienced building, civil, and M&E Clerks of Works working on prestigious projects across the UK.' !!}</p>
                        <div class="d-flex flex-wrap gap-3 btn-wrapper">
                            <a href="{{ $cms['hero']['primary_btn_link'] ?? '#current-opportunities' }}" class="btn btn-primary text-decoration-none text-white ff-gill-sans text-uppercase"><span> {{ $cms['hero']['primary_btn_text'] ?? 'View Open Positions' }}</span> <i class="bi bi-arrow-right"></i></a>
                            <a href="{{ $cms['hero']['secondary_btn_link'] ?? '#apply-today' }}" class="btn btn-outline-white text-decoration-none ff-gill-sans max-w text-uppercase align-self-start" ><span> {{ $cms['hero']['secondary_btn_text'] ?? 'Submit Your CV' }}</span> <i class="bi bi-upload"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join FCM Section -->
    <section class="py-5 mt-4 join-section">
        <div class="container text-center">
            <h6 class="fw-semibold text-custom-color-1 subtitle ff-gill-sans-medium fw-bold mb-2 ">{{ $cms['why_join']['subtitle'] ?? 'WHY JOIN FCM?' }}</h6>
            <h2 class="ff-baskervville mb-5 text-custom-color-2">{{ $cms['why_join']['title'] ?? 'More than just a job' }}</h2>
            
            <div class="row g-4 justify-content-center">
                @if(!empty($cms['why_join']['items']) && count($cms['why_join']['items']) > 0)
                    @foreach($cms['why_join']['items'] as $item)
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card bg-white">
                            <div class="icon-wrapper">
                                @if(!empty($item['icons']))
                                <i class="{{ $item['icons'] }}"></i>
                                @else
                                <img src="assets/images/icons/crane.svg" alt="Icon" onerror="this.outerHTML='<i class=\'bi bi-building\'></i>'">
                                @endif
                            </div>
                            <h4 class="ff-baskervville text-custom-color-2 fw-bold fs-5 mb-3">{{ $item['title'] ?? '' }}</h4>
                            <p class="ff-gill-sans-light mb-0 text-custom-color-1 fs-6">{{ $item['description'] ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                <!-- Feature 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card bg-white">
                        <div class="icon-wrapper">
                            <img src="assets/images/icons/crane.svg" alt="Crane" onerror="this.outerHTML='<i class=\'bi bi-building\'></i>'">
                        </div>
                        <h4 class="ff-baskervville text-custom-color-2 fw-bold fs-5 mb-3">Challenging Projects</h4>
                        <p class="ff-gill-sans-light mb-0 text-custom-color-1 fs-6">Work on high-profile construction and infrastructure projects.</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card bg-white">
                        <div class="icon-wrapper">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h4 class="ff-baskervville text-custom-color-2 fw-bold fs-5 mb-3">Career Growth</h4>
                        <p class="ff-gill-sans-light mb-0 text-custom-color-1 fs-6">Continuous learning and professional development to help you grow.</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card bg-white">
                        <div class="icon-wrapper">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4 class="ff-baskervville text-custom-color-2 fw-bold fs-5 mb-3">Collaborative Team</h4>
                        <p class="ff-gill-sans-light mb-0 text-custom-color-1 fs-6">Work alongside experienced and supportive professionals.</p>
                    </div>
                </div>
                <!-- Feature 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card bg-white">
                        <div class="icon-wrapper">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <h4 class="ff-baskervville text-custom-color-2 fw-bold fs-5 mb-3">Industry Excellence</h4>
                        <p class="ff-gill-sans-light mb-0 text-custom-color-1 fs-6">Join a company known for quality, integrity and reliability.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Life at FCM Section -->
    <section class="py-5 bg-white life-at-fcm">
        <div class="container text-center">
            <h6 class="fw-semibold text-custom-color-1 subtitle ff-gill-sans-medium fw-bold mb-2 ">{{ $cms['life_at_fcm']['subtitle'] ?? 'LIFE AT FCM' }}</h6>
            <h2 class="ff-baskervville mb-5 text-custom-color-2">{{ $cms['life_at_fcm']['title'] ?? 'Team. Culture. Impact.' }}</h2>
            
            <div class="row g-3 mb-5">
                @php $validLifeImages = collect($cms['life_at_fcm']['images'] ?? [])->filter(fn($img) => !empty($img['image']))->values(); @endphp
                @if($validLifeImages->count() > 0)
                    @foreach($validLifeImages as $image)
                    <div class="col-md-3 col-6">
                        <div class="life-gallery-wrapper">
                            <img src="{{ asset('storage/' . $image['image']) }}" class="life-gallery-img" alt="{{ $image['alt'] ?? 'Life at FCM' }}">
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="col-md-3 col-6">
                    <div class="life-gallery-wrapper">
                        <img src="assets/images/careers/careers-life-1.webp" class="life-gallery-img" alt="Life at FCM 1">
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="life-gallery-wrapper">
                        <img src="assets/images/careers/careers-life-2.webp" class="life-gallery-img" alt="Life at FCM 2">
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="life-gallery-wrapper">
                        <img src="assets/images/careers/careers-life-3.webp" class="life-gallery-img" alt="Life at FCM 3">
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="life-gallery-wrapper">
                        <img src="assets/images/careers/careers-life-4.webp" class="life-gallery-img" alt="Life at FCM 4">
                    </div>
                </div>
                @endif
            </div>
            <a href="#current-opportunities" class="btn btn-primary text-decoration-none text-white ff-gill-sans text-uppercase"><span> View Our Projects</span> <i class="bi bi-arrow-right"></i></a>
        </div>
    </section>

    <!-- Current Opportunities Section -->
    <section id="current-opportunities" class="py-5 bg-light current-opportunities">
        <div class="container text-center">
            <h6 class="fw-semibold text-custom-color-1 subtitle ff-gill-sans-medium fw-bold mb-2 ">{{ $cms['positions_section']['title'] ?? 'CURRENT OPPORTUNITIES' }}</h6>
            <h2 class="ff-baskervville mb-5 text-custom-color-2">{{ $cms['positions_section']['subtitle'] ?? 'Open Positions' }}</h2>
            
            <div class="row g-4 text-start justify-content-center mb-5">
                @if(isset($jobs) && count($jobs) > 0)
                    @foreach($jobs as $job)
                    <div class="col-lg-4 col-md-6">
                        <div class="job-card bg-white">
                            <h4 class="ff-baskervville text-custom-color-2 fw-bold fs-5 mb-3">{{ $job->title }}</h4>
                            <div class="job-tags ff-gill-sans text-custom-color-1">
                                <span><i class="bi bi-geo-alt"></i> {{ $job->location ?? 'Various' }}</span>
                                <span><i class="bi bi-briefcase"></i> {{ $job->employment_type?->value ?? 'Full Time' }}</span>
                            </div>
                            <p class="ff-gill-sans-light mb-4 fs-6 text-custom-color-1">{{ Str::limit(strip_tags($job->description), 100) }}</p>
                            
                            <div class="job-actions">
                                <a href="#apply-today" class="btn btn-primary text-decoration-none text-white ff-gill-sans text-uppercase"><span> {{ $cms['positions_section']['button_text'] ?? 'Apply Now' }}</span></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                <!-- Job 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="job-card bg-white">
                        <h4 class="ff-baskervville text-custom-color-2 fw-bold fs-5 mb-3">Clerk of Works</h4>
                        <div class="job-tags ff-gill-sans text-custom-color-1">
                            <span><i class="bi bi-geo-alt"></i> London</span>
                            <span><i class="bi bi-briefcase"></i> Full Time</span>
                        </div>
                        <p class="ff-gill-sans-light mb-4 fs-6 text-custom-color-1">Ensure high standards of workmanship and compliance on construction projects.</p>
                        
                        <div class="job-actions">
                            <a href="#apply-today" class="btn btn-primary text-decoration-none text-white ff-gill-sans text-uppercase"><span> Apply Now</span></a>
                        </div>
                    </div>
                </div>
                <!-- Job 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="job-card bg-white">
                        <h4 class="ff-baskervville text-custom-color-2 fw-bold fs-5 mb-3">Building Inspector</h4>
                        <div class="job-tags ff-gill-sans text-custom-color-1">
                            <span><i class="bi bi-geo-alt"></i> Birmingham</span>
                            <span><i class="bi bi-briefcase"></i> Full Time</span>
                        </div>
                        <p class="ff-gill-sans-light mb-4 fs-6 text-custom-color-1">Carry out site inspections and ensure projects meet regulatory standards.</p>
                        
                        <div class="job-actions">
                            <a href="#apply-today" class="btn btn-primary text-decoration-none text-white ff-gill-sans text-uppercase"><span> Apply Now</span></a>
                        </div>
                    </div>
                </div>
                <!-- Job 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="job-card bg-white">
                        <h4 class="ff-baskervville text-custom-color-2 fw-bold fs-5 mb-3">M&E Clerk of Works</h4>
                        <div class="job-tags ff-gill-sans text-custom-color-1">
                            <span><i class="bi bi-geo-alt"></i> Manchester</span>
                            <span><i class="bi bi-briefcase"></i> Full Time</span>
                        </div>
                        <p class="ff-gill-sans-light mb-4 fs-6 text-custom-color-1">Monitor and verify M&E installations and ensure compliance with specifications.</p>
                        
                        <div class="job-actions">
                            <a href="#apply-today" class="btn btn-primary text-decoration-none text-white ff-gill-sans text-uppercase"><span> Apply Now</span></a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Employee Benefits Banner -->
    <section class="benefits-section">
        <div class="container text-center">
            <h6 class="fw-semibold text-white subtitle ff-gill-sans-medium fw-bold mb-5 ">{{ $cms['benefits']['title'] ?? 'EMPLOYEE BENEFITS' }}</h6>
            
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-3 gap-md-4">
                @if(!empty($cms['benefits']['items']) && count($cms['benefits']['items']) > 0)
                    @foreach($cms['benefits']['items'] as $index => $item)
                        <div class="benefit-item">
                            <i class="{{ $item['icons'] ?? 'bi bi-star' }}"></i>
                            <p class="text-start ff-gill-sans">{!! nl2br(e($item['label'] ?? '')) !!}</p>
                        </div>
                        @if(!$loop->last)
                        <div class="benefit-divider d-none d-md-block"></div>
                        @endif
                    @endforeach
                @else
                <div class="benefit-item">
                    <i class="bi bi-currency-pound"></i>
                    <p class="text-start ff-gill-sans">Competitive<br>Salary</p>
                </div>
                <div class="benefit-divider d-none d-md-block"></div>
                <div class="benefit-item">
                    <i class="bi bi-clock-history"></i>
                    <p class="text-start ff-gill-sans">Flexible<br>Working</p>
                </div>
                <div class="benefit-divider d-none d-md-block"></div>
                <div class="benefit-item">
                    <i class="bi bi-piggy-bank"></i>
                    <p class="text-start ff-gill-sans">Pension<br>Scheme</p>
                </div>
                <div class="benefit-divider d-none d-lg-block"></div>
                <div class="benefit-item">
                    <i class="bi bi-mortarboard"></i>
                    <p class="text-start ff-gill-sans">Professional<br>Training</p>
                </div>
                <div class="benefit-divider d-none d-md-block"></div>
                <div class="benefit-item">
                    <i class="bi bi-graph-up"></i>
                    <p class="text-start ff-gill-sans">Career<br>Progression</p>
                </div>
                <div class="benefit-divider d-none d-md-block"></div>
                <div class="benefit-item">
                    <i class="bi bi-people"></i>
                    <p class="text-start ff-gill-sans">Supportive<br>Team Environment</p>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Apply Today Section -->
    <section id="apply-today" class="py-5 my-3 apply-today">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="fw-semibold text-custom-color-1 subtitle ff-gill-sans-medium fw-bold mb-4 ">{{ $cms['submit_applications']['title'] ?? 'APPLY TODAY' }}</h6>
                <h2 class="ff-baskervville text-custom-color-2">{{ $cms['submit_applications']['subtitle'] ?? 'Submit Your Application' }}</h2>
            </div>
            
            <div class="row g-5">
                <!-- Form Side -->
                <div class="col-lg-8">
                    <form id="job-application-form" class="ajax-form" action="{{ route('jobs.apply') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <input type="text" name="first_name" class="form-control py-2 ff-gill-sans-light" placeholder="First Name *" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="last_name" class="form-control py-2 ff-gill-sans-light" placeholder="Last Name *" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control py-2 ff-gill-sans-light" placeholder="Email Address *" required>
                            </div>
                            <div class="col-md-6">
                                <input type="tel" name="phone" class="form-control py-2 ff-gill-sans-light" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="mb-4">
                            <select name="position" class="form-select py-2 ff-gill-sans-light text-muted" required>
                                <option value="" selected disabled>Position Applying For *</option>
                                @if(isset($jobs))
                                    @foreach($jobs as $job)
                                    <option value="{{ $job->slug ?? $job->id }}">{{ $job->title }}</option>
                                    @endforeach
                                @endif
                                {{-- <option value="clerk_of_works">Clerk of Works</option>
                                <option value="building_inspector">Building Inspector</option>
                                <option value="me_clerk">M&E Clerk of Works</option>
                                <option value="other">Other / Open Application</option> --}}
                            </select>
                        </div>
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="filepond-wrapper h-100">
                                    <input type="file" id="cv-file" accept=".pdf,.doc,.docx">
                                    <input type="hidden" name="cv" id="cv-hidden">
                                    <div id="cv-errors" class="mt-1"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <textarea name="cover_letter" class="form-control h-100 py-3 ff-gill-sans-light" placeholder="Cover Letter (Optional)
Tell us about yourself..." style="min-height: 150px;"></textarea>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary text-decoration-none text-white ff-gill-sans text-uppercase border-0">
                                <span>Submit Application</span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Info Panel Side -->
                <div class="col-lg-4">
                    <div class="info-panel">
                        @if(!empty($cms['submit_applications']['application_sidebar_items']) && count($cms['submit_applications']['application_sidebar_items']) > 0)
                            @foreach($cms['submit_applications']['application_sidebar_items'] as $item)
                            <div class="info-item">
                                <div class="icon-circle"><i class="{{ $item['icons'] ?? 'bi bi-info-circle' }}"></i></div>
                                <p class="ff-gill-sans text-muted">{!! nl2br(e($item['title'] ?? '')) !!}</p>
                            </div>
                            @endforeach
                        @else
                        <div class="info-item">
                            <div class="icon-circle"><i class="bi bi-shield-check"></i></div>
                            <p class="ff-gill-sans text-muted">All applications are treated<br>in strict confidence.</p>
                        </div>
                        <div class="info-item">
                            <div class="icon-circle"><i class="bi bi-envelope"></i></div>
                            <p class="ff-gill-sans text-muted">We'll review your application<br>and get back to you.</p>
                        </div>
                        <div class="info-item">
                            <div class="icon-circle"><i class="bi bi-people"></i></div>
                            <p class="ff-gill-sans text-muted">Suitable candidates will be<br>invited for an interview.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recruitment Process Section -->
    <section class="py-5 bg-white recruitment-process-section">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="fw-semibold text-custom-color-1 subtitle ff-gill-sans-medium fw-bold mb-4 ">{{ $cms['recruitment_process']['title'] ?? 'OUR RECRUITMENT PROCESS' }}</h6>
            </div>
            
            <div class="timeline-section mt-4">
               
                <div class="row g-4 position-relative">
                     <div class="timeline-line d-none d-md-block"></div>
                     @if(!empty($cms['recruitment_process']['steps']) && count($cms['recruitment_process']['steps']) > 0)
                        @foreach($cms['recruitment_process']['steps'] as $index => $step)
                        <div class="col-md-2 {{ $index === 0 ? 'offset-md-1' : '' }} col-12 timeline-step">
                            <div class="step-number ff-gill-sans"><span>{{ $step['number'] ?? ($index + 1) }}</span></div>
                            <h5 class="ff-baskervville text-custom-color-2">{{ $step['title'] ?? '' }}</h5>
                            <p class="ff-gill-sans-light text-custom-color-1">{{ $step['description'] ?? '' }}</p>
                        </div>
                        @endforeach
                     @else
                    <div class="col-md-2 offset-md-1 col-12 timeline-step">
                        <div class="step-number ff-gill-sans"><span>1</span></div>
                        <h5 class="ff-baskervville text-custom-color-2">Submit Application</h5>
                        <p class="ff-gill-sans-light text-custom-color-1">Send us your CV and application.</p>
                    </div>
                    <div class="col-md-2 col-12 timeline-step">
                        <div class="step-number ff-gill-sans"><span>2</span></div>
                        <h5 class="ff-baskervville text-custom-color-2">Initial Review</h5>
                        <p class="ff-gill-sans-light text-custom-color-1">We review your application carefully.</p>
                    </div>
                    <div class="col-md-2 col-12 timeline-step">
                        <div class="step-number ff-gill-sans"><span>3</span></div>
                        <h5 class="ff-baskervville text-custom-color-2">Interview</h5>
                        <p class="ff-gill-sans-light text-custom-color-1">Meet the team and discuss the opportunity.</p>
                    </div>
                    <div class="col-md-2 col-12 timeline-step">
                        <div class="step-number ff-gill-sans"><span>4</span></div>
                        <h5 class="ff-baskervville text-custom-color-2">Offer</h5>
                        <p class="ff-gill-sans-light text-custom-color-1">Successful candidates receive an offer.</p>
                    </div>
                    <div class="col-md-2 col-12 timeline-step">
                        <div class="step-number ff-gill-sans"><span>5</span></div>
                        <h5 class="ff-baskervville text-custom-color-2">Join FCM</h5>
                        <p class="ff-gill-sans-light text-custom-color-1">Welcome aboard! Let's build the future together.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Footer CTA -->
    <section class="careers-footer-cta mt-4" @if(!empty($cms['careers_cta']['image'])) style="background-image: url('{{ asset('storage/' . $cms['careers_cta']['image']) }}');" @endif>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="ff-baskervville cta-title">{!! $cms['careers_cta']['title'] ?? 'Ready to Build Your<br>Future With FCM?' !!}</h2>
                    <p class="ff-gill-sans-light fs-5 mb-4">{!! $cms['careers_cta']['content'] ?? "We're always looking for talented professionals<br>to join our growing team." !!}</p>
                    <div class="btn-wrapper">
                        <a href="#apply-today" class="btn btn-outline-white text-decoration-none ff-gill-sans max-w text-uppercase align-self-start" ><span> {{ $cms['careers_cta']['button_text'] ?? 'Apply Now' }}</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


@endsection




@push('scripts')
    <!-- FilePond JS -->
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Only register the size plugin.
            // NOTE: filepond-plugin-file-validate-type is intentionally NOT used.
            // It has long-standing, unresolved bugs where fileValidateTypeDetectType
            // resolving a correct MIME type still gets rejected when combined with
            // acceptedFileTypes (see pqina/filepond-plugin-file-validate-type issues
            // #11, #23, #51 and pqina/filepond issue #923). Browser/OS MIME sniffing
            // is unreliable, so we validate by file extension ourselves instead.
            FilePond.registerPlugin(
                FilePondPluginFileValidateSize
            );

            const ALLOWED_EXTENSIONS = ['pdf', 'doc', 'docx'];
            const TYPE_ERROR_MESSAGE = 'Invalid file type. Please upload a PDF, DOC, or DOCX.';

            const pondInput = document.querySelector('#cv-file');
            if (pondInput) {

                const showTypeError = (message) => {
                    const errorsEl = document.getElementById('cv-errors');
                    if (errorsEl) {
                        errorsEl.textContent = message || '';
                        errorsEl.style.display = message ? 'block' : 'none';
                    }
                };

                const getExtension = (filename) => {
                    const name = (filename || '').toLowerCase();
                    return name.includes('.') ? name.split('.').pop() : '';
                };

                const pond = FilePond.create(pondInput, {
                    name: 'cv',
                    maxFileSize: '5MB',
                    labelMaxFileSizeExceeded: 'File is too large. Max size is 5MB.',

                    // ── Our own, reliable extension check. Runs before FilePond ──
                    // adds the file to the pond. Return false to silently block it;
                    // we surface the message ourselves via #cv-errors.
                    beforeAddFile: (item) => {
                        const file = item.file;
                        const ext = getExtension(file && file.name);

                        if (!ALLOWED_EXTENSIONS.includes(ext)) {
                            showTypeError(TYPE_ERROR_MESSAGE);
                            return false;
                        }

                        showTypeError('');
                        return true;
                    },

                    // ── Custom idle label (all inline styles — Bootstrap classes do NOT ──
                    // cascade into FilePond's internal DOM elements)
                    labelIdle: `
                        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:1.25rem 0;text-align:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none"
                                 stroke="var(--custom-color-2,#4c99f5)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                 style="margin-bottom:0.65rem;">
                                <polyline points="16 16 12 12 8 16"></polyline>
                                <line x1="12" y1="12" x2="12" y2="21"></line>
                                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path>
                            </svg>
                            <strong style="display:block;color:#1a1a2e;font-size:1rem;font-weight:700;margin-bottom:0.35rem;">
                                Upload Your CV <span style="color:#dc3545;">*</span>
                            </strong>
                            <span style="display:block;color:#6c757d;font-size:0.875rem;line-height:1.6;">
                                Drag &amp; drop your file here<br>
                                or <span class="filepond--label-action" style="color:var(--custom-color-2,#4c99f5);text-decoration:underline;font-weight:600;cursor:pointer;">browse files</span>
                            </span>
                            <span style="display:block;color:#adb5bd;font-size:0.75rem;margin-top:0.5rem;">
                                PDF, DOC, DOCX &mdash; Max 5 MB
                            </span>
                        </div>
                    `,

                    server: {
                        process: {
                            url: '{{ route("jobs.upload-cv") }}',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            onload:  (response) => {
                                document.getElementById('cv-hidden').value = response;
                                return response;
                            },
                            onerror: (response) => {
                                document.getElementById('cv-hidden').value = '';
                                try {
                                    const data = JSON.parse(response);
                                    if (data.errors && data.errors.cv) {
                                        return data.errors.cv[0];
                                    }
                                    return data.message || 'Upload failed.';
                                } catch (e) {
                                    return 'Upload failed.';
                                }
                            }
                        },
                        revert: {
                            url: '{{ route("jobs.revert-cv") }}',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        }
                    }
                });

                // ── JustValidate integration ──────────────────────────────────────────
                const form = document.getElementById('job-application-form');

                // Pond event listeners should only be bound once ever.
                let pondListenersBound = false;

                function registerCvField(validator) {
                    if (!validator) return;

                    // Remove old registration first to avoid duplicates.
                    try { validator.removeField('[name="cv"]'); } catch (e) { /* first time — fine */ }

                    validator.addField('[name="cv"]', [{
                        validator: () => {
                            const cvVal = document.getElementById('cv-hidden').value;
                            return !!(cvVal && cvVal.trim() !== '' && pond.getFiles().length > 0);
                        },
                        errorMessage: 'Please upload your CV.'
                    }], { errorsContainer: '#cv-errors' });

                    // Bind FilePond → JustValidate sync events only once.
                    if (!pondListenersBound) {
                        pond.on('processfile', (error) => {
                            if (!error) {
                                const v = form.validatorInstance;
                                if (v) v.revalidateField('[name="cv"]');
                            }
                        });
                        pond.on('removefile', () => {
                            document.getElementById('cv-hidden').value = '';
                            const v = form.validatorInstance;
                            // Only revalidate after the user has already tried to submit once.
                            if (v && v.isSubmitted) v.revalidateField('[name="cv"]');
                        });
                        pondListenersBound = true;
                    }
                }

                // First registration: wait for form-validator.js to finish init.
                setTimeout(() => {
                    const validator = form && form.validatorInstance;
                    if (!validator) return;

                    // ── Monkey-patch validator.refresh ────────────────────────────
                    // ajax-form.js calls validator.refresh() after every successful
                    // submit. That wipes all manually-added fields. We intercept it
                    // here so registerCvField() always runs right after refresh().
                    const _originalRefresh = validator.refresh.bind(validator);
                    validator.refresh = function () {
                        _originalRefresh();            // runs destroy + initialize + re-add built-in fields
                        registerCvField(validator);    // immediately re-add our CV field
                    };

                    // Initial registration.
                    registerCvField(validator);
                }, 150);


                // Clean up FilePond on every successful submit.
                // The CV field re-registration is handled by the monkey-patched
                // validator.refresh above — no extra setTimeout needed.
                form.addEventListener('ajax-form:success', () => {
                    pond.removeFiles();
                    document.getElementById('cv-hidden').value = '';
                    showTypeError('');
                });
            }
        });
    </script>
@endpush

