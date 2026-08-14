# Pro Rules & Pre-Delivery Polish Checklist

Use this checklist before finalizing any UI, component, or layout changes.

## Pre-Delivery Verification Checklist

### 1. Visual Polish
- [ ] No raw unstyled default browser components (buttons, scrollbars, inputs).
- [ ] Typography scale is harmonious (headings, body, captions).
- [ ] Contrast ratios meet WCAG 2.2 AA standards (4.5:1 minimum for normal text).
- [ ] All icons are scalable inline SVGs with appropriate `width`, `height`, and `fill`/`stroke`.
- [ ] Active and hover states have smooth transitions (150ms–250ms).

### 2. Form & Interaction Reliability
- [ ] All inputs have associated labels and semantic input types (`email`, `tel`, `password`, `number`).
- [ ] Validation errors are clearly displayed in context with accessible error text.
- [ ] Submit buttons enter a loading/disabled state during async operations to prevent duplicate submissions.
- [ ] Modals and dropdowns can be closed via `Escape` key and outside click.

### 3. Responsive Quality
- [ ] Tested on 375px (Mobile), 768px (Tablet), 1024px (Laptop), 1440px (Desktop).
- [ ] No horizontal scrollbars appear on any screen size.
- [ ] Touch targets are at least 44×44px on mobile viewports.
- [ ] Navigation folds neatly into an accessible mobile drawer or dropdown.

### 4. Code & Architecture Cleanliness
- [ ] CSS tokens (variables or utility classes) are used instead of ad-hoc inline styles.
- [ ] Zero hardcoded localization strings in templates (always use `@setting()`, `__t()`, or `__()`).
- [ ] Clean semantic HTML elements (`<header>`, `<nav>`, `<main>`, `<article>`, `<aside>`, `<footer>`).
