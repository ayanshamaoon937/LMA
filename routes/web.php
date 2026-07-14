<?php

use App\Http\Controllers\Front\
{HomeController,NewsLetterController,
ContactUsController,
PageController,
JobController, ProjectController};
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;





Route::get('/refresh-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created';
});

Route::get('/seeder', function () {
    Artisan::call('db:seed --class=RuleSeeder');
    return 'Database Seeded';
});

Route::get('/migrate', function () {
    // Artisan::call('migrate');
    Artisan::call('migrate:refresh --path=database/migrations/2026_05_11_132913_create_rules_table.php');
    return 'Database Refreshed migrated';
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::post('/newsletter/subscribe', [NewsLetterController::class, 'subscribe'])->name('newsletter.subscribe');



Route::controller(ContactUsController::class)
    ->name('contact.')
    ->group(function () {
        Route::get('/contact-us', 'index')->name('index');
        Route::post('/contact-us', 'store')->name('store');
    });


    Route::controller(HomeController::class)
    ->name('home.')
    ->group(function () {
        Route::get('/home', 'index')->name('home');
    });



Route::get('/projects', [ProjectController::class, 'projects'])->name('page.projects');
Route::get('/ajax/projects', [ProjectController::class, 'filterProjects'])->name('ajax.projects.filter');
Route::get('/projects/{slug}', [ProjectController::class, 'projectDetail'])->name('page.project-detail');

// Route::get('/project-detail/{slug?}', 'projectDetail')->name('project-detail');

    
Route::controller(PageController::class)
    ->name('page.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/about-us', 'aboutUs')->name('about-us');
        Route::get('/services', 'services')->name('services');
        Route::get('/services/load-more', 'loadMoreServices')->name('services.load-more');
        Route::get('/privacy-policy', 'privacyPolicy')->name('privacy-policy');
        Route::get('/terms-of-use', 'termsOfUse')->name('terms-of-use');
        Route::get('/news', 'news')->name('news');
        Route::get('/news/load-more', 'loadMoreNews')->name('news.load-more');
        Route::get('/news/{slug?}', 'newsDetail')->name('news-detail');
        // Route::get('/projects', 'projects')->name('projects');
        Route::post('/projects/load-more', 'loadMoreProjects')->name('projects.load-more');
        // Route::get('/project-detail/{slug?}', 'projectDetail')->name('project-detail');
        Route::get('service-detail/{slug}', 'serviceDetail')->name('service-detail');
        Route::get('/careers', 'careers')->name('careers');
        Route::get('/contact', 'contact')->name('contact');
    });


Route::controller(JobController::class)
    ->name('jobs.')
    ->group(function () {
        Route::post('/upload-cv', 'uploadCv')->name('upload-cv');
        Route::delete('/revert-cv', 'revertCv')->name('revert-cv');
        Route::post('/jobs/apply', 'apply')->name('apply');
    });



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
