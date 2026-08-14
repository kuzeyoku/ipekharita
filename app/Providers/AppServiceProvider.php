<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\FrontendComposer;
use App\Http\View\Composers\AdminComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (file_exists(app_path('helpers.php'))) {
            require_once app_path('helpers.php');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. View Composers for Clean MVC Separation
        View::composer(['frontend.layouts.master', 'frontend.*'], FrontendComposer::class);
        View::composer(['admin.layouts.master', 'admin.*'], AdminComposer::class);

        // 2. Blade Directive: @svg('name', 'class', 'style')
        Blade::directive('svg', function ($expression) {
            return "<?php echo render_svg_icon({$expression}); ?>";
        });

        // 3. Anonymous Blade Component: <x-icon name="map-location" class="fs-3" />
        Blade::component('icon', \App\View\Components\Icon::class);

        // 4. Custom Blade Directive: @setting('key', 'default')
        Blade::directive('setting', function ($expression) {
            return "<?php echo \App\Models\Setting::get({$expression}); ?>";
        });

        // 5. Global Bootstrap 5 Pagination Formatting
        \Illuminate\Pagination\Paginator::useBootstrapFive();
    }
}
