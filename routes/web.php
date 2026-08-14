<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\Admin\EditorMediaController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReferenceController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SiteModalController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FaqController;

/*
|--------------------------------------------------------------------------
| Frontend Routes (English URLs)
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/services', [FrontendController::class, 'services'])->name('services');
Route::get('/service/{slug?}', [FrontendController::class, 'serviceDetail'])->name('services.detail');
Route::get('/projects', [FrontendController::class, 'projects'])->name('projects');
Route::get('/project/{slug?}', [FrontendController::class, 'projectDetail'])->name('projects.detail');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog/{slug?}', [FrontendController::class, 'blogDetail'])->name('blog.detail');
Route::post('/blog/{slug}/comment', [FrontendController::class, 'storeComment'])->name('blog.comment')->middleware('throttle:10,1');
Route::get('/page/{slug?}', [FrontendController::class, 'pageDetail'])->name('pages.detail');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/get-quote', [FrontendController::class, 'storeQuote'])->name('quote.submit')->middleware('throttle:10,1');
Route::post('/send-message', [FrontendController::class, 'storeMessage'])->name('contact.submit')->middleware('throttle:10,1');

Route::get('/lang/{locale}', function ($locale) {
    $locales = app(\App\Services\TranslationService::class)->getAvailableLocales();
    if (isset($locales[$locale])) {
        session(['locale' => $locale]);
        cookie()->queue('locale', $locale, 60 * 24 * 365);
    }
    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Admin Auth & Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Root Entry Redirect
    Route::get('/', function () {
        return Auth::check() ? redirect()->route('admin.dashboard') : redirect()->route('admin.login');
    });

    // Guest Auth Routes
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Protected Panel Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUDs
        Route::resource('categories', CategoryController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('blog', BlogController::class);
        Route::resource('pages', PageController::class);
        Route::resource('users', UserController::class);
        Route::resource('references', ReferenceController::class);
        Route::resource('comments', CommentController::class)->only(['index', 'destroy']);
        Route::post('/comments/{comment}/toggle-approve', [CommentController::class, 'toggleApprove'])->name('comments.toggle-approve');
        Route::resource('messages', MessageController::class)->only(['index', 'show', 'destroy']);
        Route::resource('site-modals', SiteModalController::class);
        Route::resource('menus', MenuItemController::class)->except(['create', 'show', 'edit']);

        // Unified Language & Translation Management
        Route::get('/translations', [TranslationController::class, 'index'])->name('translations.index');
        Route::post('/translations', [TranslationController::class, 'update'])->name('translations.update');
        Route::post('/translations/add-key', [TranslationController::class, 'addKey'])->name('translations.add-key');
        Route::post('/translations/delete-key', [TranslationController::class, 'deleteKey'])->name('translations.delete-key');
        Route::post('/translations/languages', [TranslationController::class, 'storeLanguage'])->name('translations.store-language');
        Route::post('/translations/delete-language', [TranslationController::class, 'destroyLanguage'])->name('translations.delete-language');

        // Settings & Utilities
        Route::post('/editor-upload', [EditorMediaController::class, 'upload'])->name('editor-upload');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::post('/settings/clear-cache', [SettingController::class, 'clearCache'])->name('settings.clear-cache');
        Route::post('/settings/run-migrations', [SettingController::class, 'runMigrations'])->name('settings.run-migrations');
        Route::post('/settings/storage-link', [SettingController::class, 'runStorageLink'])->name('settings.storage-link');
    });
});
