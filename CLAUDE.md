# SI Portfolio Experience — Claude Instructions

Full design spec is in `shaneivers-plugin-plan.md`. Read it before starting any phase.

## Current Phase Status

| Phase | Status | Scope |
|-------|--------|-------|
| 1 | Complete | Scaffold, CPTs, design system, home hero, marquee, dual showcase, testimonials, CTA band, header, footer |
| 2 | Next | Composition page: hero, benefits list, process timeline, audio player, audio showcase |
| 3 | Pending | Learning Design: portfolio grid, project modal, tools grid, awards, approach cards |
| 4 | Pending | About page, connect section, polish |
| 5 | Pending | Multi-step contact forms, AJAX, enquiry admin |

## Deployment

Shane is often on **mobile**. Deliver files via GitHub commits — he pulls updates via Git Updater in WP Admin. Do not suggest FTP or the Plugin File Editor.

## Critical PHP Rules — Never Break These

### 1. No short array syntax in template files
```php
// WRONG — in templates/
$args = [ 'post_type' => 'si_portfolio' ];

// CORRECT — in templates/
$args = array( 'post_type' => 'si_portfolio' );
```
Short array syntax `[]` is fine in `includes/` class files only.

### 2. No raw Unicode characters in any PHP file
```php
// WRONG
<span>→</span>
<span>🎵</span>

// CORRECT
<span>&rarr;</span>
<span>&#127925;</span>
```

### 3. No smart/curly quotes in PHP strings
Always use straight ASCII quotes. Curly apostrophes in strings cause fatal parse errors.

## Code Standards

- No jQuery — vanilla JS only
- No build tools — plain CSS and JS files
- All CSS/JS loaded via `wp_enqueue_style()` / `wp_enqueue_script()` in `class-si-enqueue.php`
- All interactive elements need keyboard support and ARIA labels
- All animations must respect `prefers-reduced-motion: reduce`
- All `<img>` tags use `loading="lazy"`
- User-facing strings wrapped in `esc_html_e()` / `__()` with domain `si-portfolio`

## Design Tokens (quick ref)

```
Background:   #0D0D0F  (deep) / #161619 (surface) / #1E1E22 (elevated)
Gold accent:  #D4A853  (primary) / #E8C675 (hover/glow)
Text:         #F0EDE6  (primary) / #9B978E (secondary) / #5C5A54 (dim)
Border:       #2A2A2E
Fonts:        'Instrument Serif' (display) / 'DM Sans' (body) / 'JetBrains Mono' (labels)
Ease:         cubic-bezier(0.16, 1, 0.3, 1)
```

## File Structure

```
si-portfolio-experience/
├── si-portfolio-experience.php   # Main plugin file
├── includes/
│   ├── class-si-enqueue.php      # All asset registration
│   ├── class-si-cpts.php         # CPTs + meta boxes
│   └── class-si-shortcodes.php   # Shortcode registration
├── assets/
│   ├── css/                      # si-variables, si-base, si-components,
│   │                             # si-animations, si-layout, si-home, etc.
│   ├── js/                       # si-scroll-observer, si-nav, si-marquee, etc.
│   └── svg/                      # shane-ivers-logo.svg
└── templates/                    # One PHP file per shortcode
```

## Shortcode Status

| Shortcode | Template | Status |
|-----------|----------|--------|
| `[si_home_hero]` | home-hero.php | Done |
| `[si_marquee]` | marquee.php | Done |
| `[si_dual_showcase]` | dual-showcase.php | Done |
| `[si_testimonials]` | testimonial-ticker.php | Done |
| `[si_cta_band]` | cta-band.php | Done |
| `[si_composition_hero]` | composition-hero.php | Phase 2 |
| `[si_benefits_list]` | benefits-list.php | Phase 2 |
| `[si_process_timeline]` | process-timeline.php | Phase 2 |
| `[si_audio_showcase]` | audio-showcase.php | Phase 2 |
| `[si_portfolio_grid]` | portfolio-grid.php | Phase 3 |
| `[si_approach_cards]` | approach-cards.php | Phase 3 |
| `[si_tools_grid]` | tools-grid.php | Phase 3 |
| `[si_awards]` | awards.php | Phase 3 |
| `[si_education_timeline]` | education-timeline.php | Phase 3 |
| `[si_about_story]` | about-story.php | Phase 4 |
| `[si_connect]` | connect.php | Phase 4 |
| `[si_form_composition]` | form-composition.php | Phase 5 |
| `[si_form_learning_design]` | form-learning-design.php | Phase 5 |
