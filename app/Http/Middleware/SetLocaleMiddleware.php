<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleMiddleware
{
    /**
     * Supported locales.
     */
    protected array $supportedLocales = ['tr', 'en'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', $request->cookie('locale', config('app.locale', 'tr')));

        if (in_array($locale, $this->supportedLocales)) {
            App::setLocale($locale);
        } else {
            App::setLocale('tr');
        }

        return $next($request);
    }
}
