<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\SeoService;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __construct(
        protected SeoService $seoService
    ) {}

    /**
     * Return live, dynamic XML sitemap.
     */
    public function index(): Response
    {
        $xml = $this->seoService->generateSitemapXml();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'X-Robots-Tag' => 'noindex',
        ]);
    }
}
