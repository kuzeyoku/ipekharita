<?php

declare(strict_types=1);

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Service;
use App\Models\MenuItem;
use App\Services\TranslationService;

class FrontendComposer
{
    public function __construct(protected TranslationService $translationService)
    {
    }

    /**
     * Bind data to the frontend views.
     */
    public function compose(View $view): void
    {
        $currentLocale = app()->getLocale();
        $activeLocales = $this->translationService->getAvailableLocales();

        $navServices = Cache::remember('cache_header_services_v5_' . $currentLocale, 86400, function () {
            return Service::with('translations')
                ->where('is_active', true)
                ->orderBy('order')
                ->get()
                ->map(function ($item) {
                    return [
                        'id'    => $item->id,
                        'title' => $item->title,
                        'slug'  => $item->slug,
                        'icon'  => $item->icon,
                    ];
                })
                ->toArray();
        });

        $headerMenuTree = MenuItem::getTree();

        $footerServices = Cache::remember('cache_footer_services_v5_' . $currentLocale, 86400, function () {
            return Service::with('translations')
                ->where('is_active', true)
                ->orderBy('order')
                ->take(6)
                ->get()
                ->map(function ($item) {
                    return [
                        'title' => $item->title,
                        'slug'  => $item->slug,
                    ];
                })
                ->toArray();
        });

        $view->with([
            'currentLocale'  => $currentLocale,
            'activeLocales'  => $activeLocales,
            'navServices'    => $navServices,
            'headerMenuTree' => $headerMenuTree,
            'footerServices' => $footerServices,
        ]);
    }
}
