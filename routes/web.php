<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Admin\PopupSettingController;
use App\Http\Controllers\Admin\AnalyticsController;

use App\Models\Analytics;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Admin Routes
Route::prefix('admin')->group(function () {
    // Auth Routes
    Route::get('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'login']);
    Route::get('/logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');

    // Protected Routes
    Route::middleware('auth.admin')->group(function () {
       
         Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

            Route::get('/admin/analytics/export-csv',
                    [AnalyticsController::class, 'exportCsv']
                )->name('admin.analytics.export.csv');

       Route::get('popup', [PopupSettingController::class, 'edit'])->name('popup.edit');
        Route::post('popup', [PopupSettingController::class, 'update'])->name('popup.update');

        Route::get('hero', [App\Http\Controllers\Admin\HeroController::class, 'edit'])
        ->name('admin.hero.edit');

        Route::put('hero/{hero}', [App\Http\Controllers\Admin\HeroController::class, 'update'])
        ->name('admin.hero.update');
            
        Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class)->names('admin.articles');
        // Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class)->names('admin.testimonials');
        Route::get('review-settings', [App\Http\Controllers\Admin\ReviewSettingController::class, 'index'])->name('admin.review-settings.index');
        Route::put('review-settings', [App\Http\Controllers\Admin\ReviewSettingController::class, 'update'])->name('admin.review-settings.update');
        
        Route::get('instagram-settings', [App\Http\Controllers\Admin\InstagramSettingController::class, 'index'])->name('admin.instagram-settings.index');
        Route::put('instagram-settings', [App\Http\Controllers\Admin\InstagramSettingController::class, 'update'])->name('admin.instagram-settings.update');
        Route::resource('doctors', App\Http\Controllers\Admin\DoctorController::class)->names('admin.doctors');
        Route::resource('services', App\Http\Controllers\Admin\ServiceController::class)->names('admin.services');
        Route::resource('promos', App\Http\Controllers\Admin\PromoController::class)->names('admin.promos');
        Route::resource('social-feeds', App\Http\Controllers\Admin\SocialFeedController::class)->names('admin.social-feeds');
        Route::resource('careers', App\Http\Controllers\Admin\CareerController::class)->names('admin.careers');
        Route::resource('faqs', App\Http\Controllers\Admin\FaqController::class)->names('admin.faqs');
        Route::resource('faq-categories', App\Http\Controllers\Admin\FaqCategoryController::class)->names('admin.faq-categories');
        Route::resource('job-applications', App\Http\Controllers\Admin\JobApplicationController::class)->except(['create', 'store', 'edit', 'update'])->names('admin.job-applications');
        Route::resource('insurances', App\Http\Controllers\Admin\InsuranceController::class)->names('admin.insurances');
        Route::resource('specializations', App\Http\Controllers\Admin\SpecializationController::class)->names('admin.specializations');
        Route::post('job-applications/{jobApplication}/reply', [App\Http\Controllers\Admin\JobApplicationController::class, 'reply'])->name('admin.job-applications.reply');
        Route::get('analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.settings.analytics');
        // Settings Routes
        Route::get('settings/mail', [App\Http\Controllers\Admin\SettingsController::class, 'mail'])->name('admin.settings.mail');
        Route::post('settings/mail', [App\Http\Controllers\Admin\SettingsController::class, 'updateMail'])->name('admin.settings.update-mail');
        
        Route::get('settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'general'])->name('admin.settings.general');
        Route::post('settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('admin.settings.update-general');

        Route::get('settings/footer', [App\Http\Controllers\Admin\SettingsController::class, 'footerIndex'])->name('admin.settings.footer');
        Route::get('settings/footer/{id}/items', [App\Http\Controllers\Admin\SettingsController::class, 'getFooterItems'])->name('admin.settings.footer.items');
        Route::post('settings/footer/{id}', [App\Http\Controllers\Admin\SettingsController::class, 'updateFooterSection'])->name('admin.settings.footer.update');

        Route::get('media', [App\Http\Controllers\Admin\MediaController::class, 'index'])->name('admin.media.index');
        Route::get('media/list', [App\Http\Controllers\Admin\MediaController::class, 'list'])->name('admin.media.list');
        Route::get('media/{id}/usage', [App\Http\Controllers\Admin\MediaController::class, 'usage'])->name('admin.media.usage');
        Route::delete('media/{id}', [App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('admin.media.destroy');
        
    });
});

Route::get('/admin/analytics/data', [\App\Http\Controllers\Admin\AnalyticsController::class, 'data'])
    ->name('admin.analytics.data');

Route::get('/run-migrate/fresh', function () {
    Artisan::call('migrate:fresh');
    return "DONE";
});
Route::get('/run-migrate/seed', function () {
    Artisan::call('db:seed');
    return "DONE";
});
Route::get('/run-migrate', function () {
    Artisan::call('migrate');
    return "DONE";
});
Route::get('/run-migrate/{table}', function ($table) {
    Artisan::call('migrate', ['--path' => "database/migrations/{$table}.php"]);
    return "DONE";
});
Route::get('/run-seed/{table}', function ($table) {
    Artisan::call('db:seed', ['--class' => "{$table}"]);
    return "DONE";
});
Route::get('/run-migrate/rollback/{table}', function ($table) {
    Artisan::call('migrate:rollback', ['--path' => "database/migrations/{$table}.php"]);
    return "DONE";
});
Route::get('/run-migrate/fresh/{table}', function ($table) {
    Artisan::call('migrate:fresh', ['--path' => "database/migrations/{$table}.php"]);
    return "DONE";
});
Route::get('/run-migrate/fresh/{table}/{seed}', function ($table, $seed) {
    Artisan::call('migrate:fresh', ['--path' => "database/migrations/{$table}.php"]);
    Artisan::call('db:seed', ['--class' => "{$seed}"]);
    return "DONE";
});

// storage:link
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return "DONE";
});

Route::get('/', [FrontController::class, 'landingPage'])->name('fe.landing-page');
Route::get('/services', [FrontController::class, 'services'])->name('fe.services.index');
Route::get('/careers', [FrontController::class, 'cariers'])->name('fe.cariers.index');
Route::get('/careers/{slug}', [FrontController::class, 'carier'])->name('fe.carier.show');
Route::post('/job-form', [FrontController::class, 'storeJobApplication'])->name('fe.job-application.store');
Route::get('/news', [FrontController::class, 'news'])->name('fe.news.index');
Route::get('/news/{slug}', [FrontController::class, 'articleDetail'])->name('fe.news.detail');
Route::get('/faq-search', [FrontController::class, 'faqSearch'])->name('fe.faq-search');
Route::get('/search', [App\Http\Controllers\Front\SearchController::class, 'search'])->name('fe.search');
Route::get('/search_news', [App\Http\Controllers\Front\SearchController::class, 'search_news'])->name('fe.search_news');
// Route::get('/articles', [FrontController::class, 'articles'])->name('fe.articles.index'); // Deprecated
Route::get('/doctors', [FrontController::class, 'doctors'])->name('fe.doctors.index');
Route::get('/doctor/{id}', [FrontController::class, 'doctor'])->name('fe.doctors.detail');
Route::get('/about', [FrontController::class, 'about'])->name('fe.about');
Route::get('/contact', [FrontController::class, 'contact'])->name('fe.contact');
Route::get('/promo/{slug}', [FrontController::class, 'detailPromo'])->name('fe.detail-promo');
Route::get('/job-form', [FrontController::class, 'jobForm'])->name('fe.job-form');
Route::get('/janji-temu', [FrontController::class, 'appointment'])->name('fe.appointment');
Route::get('/csr', [FrontController::class, 'csr'])->name('fe.csr');
Route::get('/investor', [FrontController::class, 'investor'])->name('fe.investor');
Route::get('/charities', [FrontController::class, 'charities'])->name('fe.charities');
Route::get('/emc', [FrontController::class, 'emc'])->name('fe.emc');
Route::get('/privacy', [FrontController::class, 'privacy'])->name('fe.privacy');
Route::get('/help_center', [FrontController::class, 'help_center'])->name('fe.help_center');
Route::get('/promosi', [FrontController::class, 'promosi'])->name('fe.promosi');


Route::get('/hvf', [FrontController::class, 'hvf'])->name('fe.hvf');
Route::get('/biometry', [FrontController::class, 'biometry'])->name('fe.biometry');
Route::get('/microskop', [FrontController::class, 'microskop'])->name('fe.microskop');
Route::get('/yag-laser', [FrontController::class, 'yag_laser'])->name('fe.yag-laser');
Route::get('/oct', [FrontController::class, 'oct'])->name('fe.oct');
Route::get('/green-laser', [FrontController::class, 'green_laser'])->name('fe.green-laser');
Route::get('/ark', [FrontController::class, 'ark'])->name('fe.ark');
Route::get('/nct', [FrontController::class, 'nct'])->name('fe.nct');
Route::get('/slit-lamp', [FrontController::class, 'slit_lamp'])->name('fe.slit-lamp');