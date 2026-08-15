<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Service;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SeoService
{
    public function __construct(
        protected TranslationService $translationService
    ) {}

    /**
     * Generate Organization & EngineeringService Schema (JSON-LD).
     */
    public function generateOrganizationSchema(): array
    {
        $companyName = Setting::get('company_name', Setting::get('site_title', 'İpek Harita Mühendislik'));
        $phone       = Setting::get('phone', '+90 312 000 00 00');
        $email       = Setting::get('email', 'info@ipekmuhendislik.com.tr');
        $address     = Setting::get('address', 'Mustafa Kemal Mah. 2118. Cad. No: 4/B Çankaya / ANKARA');
        $baseUrl     = url('/');

        return [
            '@context'    => 'https://schema.org',
            '@type'       => 'EngineeringService',
            '@id'         => $baseUrl . '/#organization',
            'name'        => $companyName,
            'url'         => $baseUrl,
            'logo'        => asset('assets/img/logo/ipek_logo.png'),
            'image'       => asset('assets/img/hero/slide-2.png'),
            'description' => Setting::get('site_description', 'Büyük ölçekli 22/a kadastro yenileme, fotogrametri, 3D CBS ve LiDAR haritalama mühendislik çözümleri.'),
            'telephone'   => $phone,
            'email'       => $email,
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $address,
                'addressLocality' => 'Çankaya',
                'addressRegion'   => 'Ankara',
                'addressCountry'  => 'TR',
            ],
            'geo'         => [
                '@type'     => 'GeoCoordinates',
                'latitude'  => '39.9075',
                'longitude' => '32.7845',
            ],
            'priceRange'  => '$$$',
            'sameAs'      => array_filter([
                Setting::get('social_linkedin'),
                Setting::get('social_instagram'),
                Setting::get('social_facebook'),
                Setting::get('social_twitter'),
            ]),
        ];
    }

    /**
     * Generate Service Schema (JSON-LD).
     */
    public function generateServiceSchema(Service $service): array
    {
        $baseUrl = url('/');

        return [
            '@context'     => 'https://schema.org',
            '@type'        => 'Service',
            '@id'          => route('services.detail', $service->slug),
            'name'         => $service->title,
            'serviceType'  => 'Engineering & Cadastral Mapping',
            'provider'     => [
                '@id' => $baseUrl . '/#organization',
            ],
            'description'  => $service->summary ?: strip_tags((string) $service->description),
            'areaServed'   => [
                '@type' => 'Country',
                'name'  => 'Turkey',
            ],
            'url'          => route('services.detail', $service->slug),
        ];
    }

    /**
     * Generate Project / CreativeWork Schema (JSON-LD).
     */
    public function generateProjectSchema(Project $project): array
    {
        $baseUrl = url('/');

        return [
            '@context'    => 'https://schema.org',
            '@type'       => 'CreativeWork',
            '@id'         => route('projects.detail', $project->slug),
            'name'        => $project->title,
            'headline'    => $project->title,
            'description' => $project->summary ?: strip_tags((string) $project->description),
            'creator'     => [
                '@id' => $baseUrl . '/#organization',
            ],
            'locationCreated' => [
                '@type' => 'Place',
                'name'  => $project->location ?: 'Türkiye',
            ],
            'url'         => route('projects.detail', $project->slug),
        ];
    }

    /**
     * Generate BlogPosting Schema (JSON-LD).
     */
    public function generateBlogPostingSchema(BlogPost $post): array
    {
        $baseUrl = url('/');

        return [
            '@context'         => 'https://schema.org',
            '@type'            => 'BlogPosting',
            '@id'              => route('blog.detail', $post->slug),
            'headline'         => $post->title,
            'description'      => $post->summary ?: strip_tags((string) $post->content),
            'image'            => $post->image ? asset($post->image) : asset('assets/img/hero/slide-1.png'),
            'datePublished'    => $post->published_at ? $post->published_at->toIso8601String() : $post->created_at->toIso8601String(),
            'dateModified'     => $post->updated_at->toIso8601String(),
            'author'           => [
                '@id' => $baseUrl . '/#organization',
            ],
            'publisher'        => [
                '@id' => $baseUrl . '/#organization',
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id'   => route('blog.detail', $post->slug),
            ],
        ];
    }

    /**
     * Generate FAQPage Schema (JSON-LD).
     */
    public function generateFaqSchema($faqs): ?array
    {
        if (empty($faqs) || count($faqs) === 0) {
            return null;
        }

        $entities = [];
        foreach ($faqs as $faq) {
            if (empty($faq->question) || empty($faq->answer)) {
                continue;
            }
            $entities[] = [
                '@type'          => 'Question',
                'name'           => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => strip_tags((string) $faq->answer),
                ],
            ];
        }

        if (empty($entities)) {
            return null;
        }

        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $entities,
        ];
    }

    /**
     * Generate BreadcrumbList Schema (JSON-LD).
     */
    public function generateBreadcrumbSchema(array $breadcrumbs): array
    {
        $listItems = [];
        $position = 1;

        foreach ($breadcrumbs as $name => $url) {
            $listItems[] = [
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $name,
                'item'     => $url ?: url()->current(),
            ];
        }

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }

    /**
     * Generate dynamic hreflang alternate links for active locales.
     */
    public function generateHreflangTags(): array
    {
        $locales = $this->translationService->getAvailableLocales();
        $currentUrl = url()->current();
        $tags = [];

        foreach (array_keys($locales) as $locale) {
            $tags[$locale] = $currentUrl;
        }
        $tags['x-default'] = $currentUrl;

        return $tags;
    }

    /**
     * Build and return fully compliant XML Sitemap.
     */
    public function generateSitemapXml(): string
    {
        return Cache::remember('site_sitemap_xml', 3600, function () {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
            $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

            $locales = array_keys($this->translationService->getAvailableLocales());

            // 1. Static Pages
            $staticRoutes = [
                ['url' => route('home'), 'changefreq' => 'daily', 'priority' => '1.0'],
                ['url' => route('about'), 'changefreq' => 'monthly', 'priority' => '0.8'],
                ['url' => route('services'), 'changefreq' => 'weekly', 'priority' => '0.9'],
                ['url' => route('projects'), 'changefreq' => 'weekly', 'priority' => '0.9'],
                ['url' => route('blog'), 'changefreq' => 'daily', 'priority' => '0.8'],
                ['url' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ];

            foreach ($staticRoutes as $route) {
                $xml .= $this->formatSitemapEntry($route['url'], now()->toAtomString(), $route['changefreq'], $route['priority'], $locales);
            }

            // 2. Dynamic Services
            $services = Service::where('is_active', true)->get();
            foreach ($services as $service) {
                $url = route('services.detail', $service->slug);
                $updatedAt = $service->updated_at ? $service->updated_at->toAtomString() : now()->toAtomString();
                $xml .= $this->formatSitemapEntry($url, $updatedAt, 'weekly', '0.9', $locales);
            }

            // 3. Dynamic Projects
            $projects = Project::orderBy('order', 'asc')->get();
            foreach ($projects as $project) {
                $url = route('projects.detail', $project->slug);
                $updatedAt = $project->updated_at ? $project->updated_at->toAtomString() : now()->toAtomString();
                $xml .= $this->formatSitemapEntry($url, $updatedAt, 'weekly', '0.8', $locales);
            }

            // 4. Dynamic Blog Posts
            $posts = BlogPost::where('is_published', true)->get();
            foreach ($posts as $post) {
                $url = route('blog.detail', $post->slug);
                $updatedAt = $post->updated_at ? $post->updated_at->toAtomString() : now()->toAtomString();
                $xml .= $this->formatSitemapEntry($url, $updatedAt, 'monthly', '0.8', $locales);
            }

            // 5. Dynamic CMS Pages
            $pages = Page::where('is_active', true)->get();
            foreach ($pages as $page) {
                $url = route('pages.detail', $page->slug);
                $updatedAt = $page->updated_at ? $page->updated_at->toAtomString() : now()->toAtomString();
                $xml .= $this->formatSitemapEntry($url, $updatedAt, 'monthly', '0.6', $locales);
            }

            $xml .= '</urlset>';
            return $xml;
        });
    }

    /**
     * Helper to format a single sitemap URL entry with multilingual hreflang alternates.
     */
    protected function formatSitemapEntry(string $url, string $lastmod, string $changefreq, string $priority, array $locales): string
    {
        $entry = "  <url>\n";
        $entry .= "    <loc>" . htmlspecialchars($url, ENT_XML1, 'UTF-8') . "</loc>\n";
        $entry .= "    <lastmod>{$lastmod}</lastmod>\n";
        $entry .= "    <changefreq>{$changefreq}</changefreq>\n";
        $entry .= "    <priority>{$priority}</priority>\n";

        foreach ($locales as $locale) {
            $entry .= '    <xhtml:link rel="alternate" hreflang="' . $locale . '" href="' . htmlspecialchars($url, ENT_XML1, 'UTF-8') . '" />' . "\n";
        }
        $entry .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . htmlspecialchars($url, ENT_XML1, 'UTF-8') . '" />' . "\n";

        $entry .= "  </url>\n";
        return $entry;
    }
}
