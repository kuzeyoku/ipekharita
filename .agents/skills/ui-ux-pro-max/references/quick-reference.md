# Quick Reference — Full Rule Set (all 10 categories)

Load this file when doing a UI review/audit pass, or when you need the full checklist for a category beyond the priority table in SKILL.md.

## 1. Accessibility (CRITICAL)
- `color-contrast` - Minimum 4.5:1 ratio for normal text (large text 3:1); Material Design & WCAG 2.2
- `focus-states` - Visible focus rings on interactive elements (2–4px offset)
- `alt-text` - Descriptive alt text for meaningful images; decorative images `aria-hidden="true"`
- `aria-labels` - aria-label for icon-only buttons (`<button aria-label="Arama yap">`)
- `icon-context` - Semantics depend on use: decorative icons beside visible text are hidden from screen readers; meaningful icons require text alternatives
- `keyboard-nav` - Tab order matches visual DOM order; full keyboard navigation support
- `form-labels` - Use `<label for="id">` for every form input
- `skip-links` - Skip to main content link for keyboard and screen reader users
- `heading-hierarchy` - Sequential h1 → h6, never skip heading levels
- `color-not-only` - Don't convey status/error by color alone; pair with icon and descriptive text
- `reduced-motion` - Respect `@media (prefers-reduced-motion: reduce)`; disable or soften animations

## 2. Touch & Interaction (CRITICAL)
- `touch-target-size` - Min 44×44px hit target area
- `touch-spacing` - Minimum 8px gap between clickable elements
- `hover-vs-tap` - Never rely solely on hover for essential features; tap/click must trigger action
- `loading-buttons` - Disable button and show spinner/progress indicator on async submit
- `error-feedback` - Clear inline error messages directly under affected inputs
- `cursor-pointer` - Interactive elements must exhibit `cursor: pointer`

## 3. Performance (HIGH)
- `image-optimization` - Modern formats (WebP/AVIF), responsive `srcset`, lazy load non-hero media
- `image-dimension` - Explicit `width` and `height` attributes or `aspect-ratio` to prevent CLS
- `font-loading` - Use `font-display: swap` to avoid invisible text (FOIT)
- `progressive-loading` - Skeletons / shimmer placeholders instead of jarring layout shifts

## 4. Style Selection (HIGH)
- `style-match` - Cohesive design system matched to product identity
- `consistency` - Unified border radius, shadow palette, and typography across all views
- `no-emoji-icons` - Always use crisp inline SVG vector icons instead of emoji
- `state-clarity` - Clearly distinct hover, focus, active, and disabled states

## 5. Layout & Responsive (HIGH)
- `viewport-meta` - `<meta name="viewport" content="width=device-width, initial-scale=1">`
- `mobile-first` - Responsive grid scaling from mobile viewport upwards
- `horizontal-scroll` - Prevent accidental horizontal scroll overflow on mobile
- `spacing-scale` - Strict adherence to 4px / 8px incremental spacing scale
