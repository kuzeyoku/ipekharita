<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorStat;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorMiddleware
{
    /**
     * Handle an incoming request with near-zero overhead.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Track only GET requests to public front-end pages
        if (!$request->isMethod('GET')) {
            return $response;
        }

        $path = ltrim($request->path(), '/');
        if (
            str_starts_with($path, 'admin') ||
            str_starts_with($path, 'api') ||
            str_starts_with($path, 'assets') ||
            str_starts_with($path, 'storage') ||
            $path === 'favicon.ico'
        ) {
            return $response;
        }

        // Ignore common web crawlers / bots
        $userAgent = strtolower($request->header('User-Agent', ''));
        if (str_contains($userAgent, 'bot') || str_contains($userAgent, 'crawl') || str_contains($userAgent, 'spider')) {
            return $response;
        }

        $todayCookie = 'ipk_v_' . date('Ymd');
        $isUnique = false;

        if (!$request->hasCookie($todayCookie)) {
            $isUnique = true;
            if ($response instanceof Response) {
                $minutesTillMidnight = (int) ceil((strtotime('tomorrow') - time()) / 60);
                $response->headers->setCookie(cookie($todayCookie, '1', max(60, $minutesTillMidnight)));
            }
        }

        VisitorStat::recordHit($isUnique);

        return $response;
    }
}
