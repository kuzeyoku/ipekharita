<?php

if (!function_exists('__t')) {
    /**
     * Retrieve static site text from modular lang files or site.php with zero database queries.
     *
     * @param string $key
     * @param string $default
     * @param string $group
     * @param string|null $label
     * @return string
     */
    function __t($key, $default = '', $group = 'common', $label = null)
    {
        // 1. Check modular language file e.g. 'common.key', 'home.key', 'contact.key'
        $modularKey = "{$group}.{$key}";
        if (\Illuminate\Support\Facades\Lang::has($modularKey)) {
            $val = __($modularKey);
            if (is_string($val)) {
                return $val;
            }
        }

        // 2. Check nested site.php group e.g. 'site.header.topbar_slogan_title'
        $siteKey = "site.{$group}.{$key}";
        if (\Illuminate\Support\Facades\Lang::has($siteKey)) {
            $val = __($siteKey);
            if (is_string($val)) {
                return $val;
            }
        }

        return $default !== '' ? $default : $key;
    }
}

if (!function_exists('render_svg_icon')) {
    /**
     * Render high-performance inline SVG vector icon using Laravel Blade Icons (0 KB CDN).
     *
     * @param string|null $iconName
     * @param string $extraClass
     * @param string $extraStyle
     * @return string
     */
    function render_svg_icon(?string $iconName, string $extraClass = '', string $extraStyle = ''): string
    {
        if (empty($iconName)) {
            $iconName = 'house';
        }

        $rawKey = trim((string) $iconName);
        $cleanKey = strtolower($rawKey);
        
        // Determine prefix if fa-solid / fa-regular / fa-brands specified
        $prefix = 'fas-';
        if (str_contains($cleanKey, 'fa-regular') || str_contains($cleanKey, 'far ')) {
            $prefix = 'far-';
        } elseif (str_contains($cleanKey, 'fa-brands') || str_contains($cleanKey, 'fab ')) {
            $prefix = 'fab-';
        }

        $cleanKey = str_replace(['fa-solid', 'fa-regular', 'fa-brands', 'fa-line', 'fas ', 'far ', 'fab ', 'fa-'], '', $cleanKey);
        $cleanKey = trim($cleanKey);

        if ($cleanKey === 'home') $cleanKey = 'house';
        if ($cleanKey === 'edit') $cleanKey = 'pen-to-square';
        if ($cleanKey === 'trash') $cleanKey = 'trash-can';
        if ($cleanKey === 'search') $cleanKey = 'magnifying-glass';
        if ($cleanKey === 'map-location') $cleanKey = 'map-location-dot';

        $attrs = [];
        if (!empty($extraClass)) {
            $attrs['class'] = $extraClass;
        }
        if (!empty($extraStyle)) {
            $attrs['style'] = $extraStyle;
        }

        // Try rendering via Blade Icons package (owenvoke/blade-fontawesome)
        if (function_exists('svg')) {
            $candidates = [
                $prefix . $cleanKey,
                'fas-' . $cleanKey,
                'far-' . $cleanKey,
                'fab-' . $cleanKey
            ];

            foreach ($candidates as $cand) {
                try {
                    $bladeIcon = svg($cand, $extraClass, $attrs)->toHtml();
                    if (!empty($bladeIcon)) {
                        return $bladeIcon;
                    }
                } catch (\Throwable $e) {
                    // Try next candidate
                }
            }
        }

        // Fallback local SVG paths if package lookup is bypassed
        $styleAttr = $extraStyle ? ' style="' . e($extraStyle) . '"' : '';
        $classAttr = ' class="svg-icon-vector ' . e($extraClass) . '"';

        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="1em" height="1em" fill="currentColor"' . $classAttr . $styleAttr . '><path d="M57.7 193l9.4 16.4c8.3 14.5 21.9 25.2 38 29.8L248 278.4V464c0 26.5 21.5 48 48 48h16c26.5 0 48-21.5 48-48V278.4l142.9-40.8c16.1-4.6 29.7-15.3 38-29.8l9.4-16.4c12.2-21.3 4.8-48.4-16.5-60.6l-142-81.1c-15.8-9-35.3-9-51.2 0l-142 81.1c-21.3 12.2-28.7 39.3-16.5 60.6z"/></svg>';
    }
}

if (!function_exists('setting')) {
    /**
     * Retrieve site setting value dynamically.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }
}

if (!function_exists('render_flag_svg')) {
    /**
     * Render crisp SVG flag graphic for language switchers.
     *
     * @param string $code
     * @param string $extraClass
     * @return string
     */
    function render_flag_svg(string $code, string $extraClass = 'me-1 align-middle'): string
    {
        $code = strtolower(trim($code));
        if ($code === 'tr') {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800" width="18" height="12" class="rounded-1 shadow-sm d-inline-block ' . e($extraClass) . '" style="object-fit:cover;vertical-align:-1px;"><rect width="1200" height="800" fill="#E30A17"/><circle cx="425" cy="400" r="200" fill="#ffffff"/><circle cx="475" cy="400" r="160" fill="#E30A17"/><polygon fill="#ffffff" points="583.3,400 706.7,440 630.5,335.2 630.5,464.8 706.7,360"/></svg>';
        }
        if ($code === 'en' || $code === 'gb') {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" width="18" height="12" class="rounded-1 shadow-sm d-inline-block ' . e($extraClass) . '" style="object-fit:cover;vertical-align:-1px;"><rect width="60" height="30" fill="#012169"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#C8102E" stroke-width="4"/><path d="M30,0 V30 M0,15 H60" stroke="#fff" stroke-width="10"/><path d="M30,0 V30 M0,15 H60" stroke="#C8102E" stroke-width="6"/></svg>';
        }
        if ($code === 'de') {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5 3" width="18" height="12" class="rounded-1 shadow-sm d-inline-block ' . e($extraClass) . '" style="object-fit:cover;vertical-align:-1px;"><rect width="5" height="1" fill="#000"/><rect y="1" width="5" height="1" fill="#DD0000"/><rect y="2" width="5" height="1" fill="#FFCE00"/></svg>';
        }
        if ($code === 'fr') {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3 2" width="18" height="12" class="rounded-1 shadow-sm d-inline-block ' . e($extraClass) . '" style="object-fit:cover;vertical-align:-1px;"><rect width="1" height="2" fill="#002654"/><rect x="1" width="1" height="2" fill="#ffffff"/><rect x="2" width="1" height="2" fill="#ED2939"/></svg>';
        }
        if ($code === 'es') {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 750 500" width="18" height="12" class="rounded-1 shadow-sm d-inline-block ' . e($extraClass) . '" style="object-fit:cover;vertical-align:-1px;"><rect width="750" height="500" fill="#AA151B"/><rect y="125" width="750" height="250" fill="#F1BF00"/></svg>';
        }
        if ($code === 'it') {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3 2" width="18" height="12" class="rounded-1 shadow-sm d-inline-block ' . e($extraClass) . '" style="object-fit:cover;vertical-align:-1px;"><rect width="1" height="2" fill="#009246"/><rect x="1" width="1" height="2" fill="#ffffff"/><rect x="2" width="1" height="2" fill="#CE2B37"/></svg>';
        }
        if ($code === 'ru') {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3 2" width="18" height="12" class="rounded-1 shadow-sm d-inline-block ' . e($extraClass) . '" style="object-fit:cover;vertical-align:-1px;"><rect width="3" height="2" fill="#ffffff"/><rect y="0.66" width="3" height="1.34" fill="#0039A6"/><rect y="1.33" width="3" height="0.67" fill="#D52B1E"/></svg>';
        }
        return '<span class="' . e($extraClass) . '" style="font-size:12px;">🌐</span>';
    }
}
