---
name: ui-ux-pro-max
description: >-
  UI/UX design intelligence for web, mobile, and desktop. Use this skill when designing,
  building, reviewing, or refactoring user interfaces, including pages, components,
  design systems, accessibility (WCAG 2.2 AA/AAA), interaction patterns, responsive layouts,
  typography, color palettes, micro-animations, glassmorphism, bento grids, and stack-specific UI implementation.
---

# UI/UX Pro Max — Design Intelligence

Comprehensive UI/UX design intelligence containing 79 searchable styles (glassmorphism, bento grid, neo-brutalism, minimal clean, claymorphism, etc.), 192 curated product color palettes, 74 font pairings, 119 UX guidelines, and accessibility standards.

---

## When to Apply

Use this skill when the task involves **UI structure, visual design decisions, interaction patterns, or user experience quality control**:
- Designing or refactoring modern web/mobile pages & layouts
- Creating reusable, accessible UI components
- Establishing design tokens (colors, typography, spacing, elevations, radii)
- Auditing UI for UX, WCAG 2.2 accessibility, and responsiveness
- Implementing micro-animations, transitions, and hover/focus/active states
- Elevating perceived product value, brand feel, and aesthetics

---

## Core Priority Rules (1 → 10)

| Priority | Category | Impact | Key Checks (Must Have) | Anti-Patterns (Avoid) |
|---|---|---|---|---|
| **1** | **Accessibility (A11y)** | CRITICAL | Contrast 4.5:1 (normal text) / 3:1 (large), Alt text, visible focus rings, `aria-label` for icon-only buttons, keyboard navigation | Removing focus outlines (`outline: none`), icon buttons without labels, color-only state indication |
| **2** | **Touch & Interaction** | CRITICAL | Min touch target 44×44px, 8px+ spacing between targets, loading spinners on async submit, clear error feedback | Hover-only dependencies, instant state changes without transition (0ms), ambiguous click targets |
| **3** | **Performance & Core Web Vitals** | HIGH | WebP/AVIF images, explicit width/height or aspect-ratio (CLS < 0.1), lazy-loading below fold, optimized fonts | Layout shifts (CLS), uncompressed raw assets, blocking JS |
| **4** | **Style & Visual Identity** | HIGH | Cohesive design system (e.g. Glassmorphism, Bento Grid, Modern Enterprise), SVG icons (never raw emoji for icons) | Inconsistent border radii, mixing conflicting aesthetic styles, raw emoji as interface icons |
| **5** | **Layout & Responsiveness** | HIGH | Mobile-first breakpoints, `viewport` meta tag, no horizontal overflow, 4px/8px grid spacing | Horizontal scroll on mobile, hardcoded px container widths, disabled zoom |
| **6** | **Typography & Color Hierarchy** | MEDIUM | Base font >= 16px, line-height 1.5-1.6, semantic color tokens (primary, surface, border, text-muted) | Body text < 14px, low-contrast gray on gray, raw unorganized hex colors |
| **7** | **Animation & Motion** | MEDIUM | Purposeful micro-interactions (150ms-300ms easing), `prefers-reduced-motion` compliance, GPU-accelerated transforms | Over-animated elements, animating `width`/`height` instead of `transform`/`opacity`, sluggish transitions |
| **8** | **Forms & User Feedback** | MEDIUM | Floating or persistent labels, inline error validation, clear helper text, disabled/loading states | Placeholder-only labels, hiding error context, unhelpful generic error popups |
| **9** | **Navigation & Wayfinding** | HIGH | Clear active states, sticky header with backdrop blur, breadcrumbs on deep pages, predictable mobile drawer/menu | Cluttered navigation, hidden core actions, broken back button behavior |
| **10** | **Data & Visual Presentation** | LOW | Distinct chart color palettes, tooltips, responsive data tables with horizontal scroll indicators | Unlabeled data points, reliance on color alone to differentiate data |

---

## Design System Tokens Reference

### 1. Spacing & Grid (8-Point System)
- `xs`: 4px (tight gaps, badge padding)
- `sm`: 8px (icon gaps, compact buttons)
- `md`: 16px (standard component padding, form gaps)
- `lg`: 24px (card padding, grid gaps)
- `xl`: 32px (section spacing mobile)
- `2xl`: 48px – 64px (section spacing desktop)

### 2. Glassmorphism & Elevation Standard
```css
/* Glassmorphism Surface Token */
.glass-surface {
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border: 1px solid rgba(255, 255, 255, 0.12);
  box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.18);
}

/* Dark Modern Card Elevation */
.card-elevation {
  background: #1e222d;
  border: 1px solid rgba(255, 255, 255, 0.06);
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.25);
  transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.card-elevation:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 30px -4px rgba(0, 0, 0, 0.35);
  border-color: rgba(255, 255, 255, 0.15);
}
```

---

## Detailed References
- For comprehensive guideline checklists, see [quick-reference.md](./references/quick-reference.md).
- For pro polish rules and WCAG verification checklist, see [pro-rules.md](./references/pro-rules.md).
