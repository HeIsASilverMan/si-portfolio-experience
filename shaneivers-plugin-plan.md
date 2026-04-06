# Shane Ivers Portfolio Plugin — Design & Build Plan

## Plugin Name: `si-portfolio-experience`

---

## 1. Site Audit — Current State

### Home Page (shaneivers.com)
- Simple tagline: "Bespoke music and scores, lovingly crafted to your exact requirements"
- CTA: "Get beautiful bespoke pieces!"
- **Problems:** Feels like a placeholder. No personality, no motion, no visual identity. Doesn't communicate the dual career (composition + learning design). No navigation storytelling.

### Composition Page (/composition)
- Sales copy about bespoke composition services
- Testimonial from Matthew Reynolds (The Violet Fire)
- Personal bio section
- **Problems:** Wall of text. No audio samples or embeds. No visual hierarchy. The testimonial sits inline with no visual distinction. The "I hate to toot my own trumpet" section is charming but buried.

### Learning Design Page (/learning-design)
- Portfolio grid with project cards (Articulate Storyline, Rise, After Effects, compliance courses)
- About/intro section with credentials
- **Problems:** Portfolio items are static image cards with text descriptions. No filtering, no hover states, no project detail views. Intro text duplicates between sections.

### General Issues
- **No unified visual identity** — feels like a default theme with content dropped in
- **No motion or delight** — completely static experience
- **No personality** — Shane's voice is warm and witty in copy but the design doesn't match
- **Navigation doesn't tell a story** — no clear journey between the two disciplines
- **No responsive micro-interactions** — hover states, scroll reveals, transitions all absent
- **Missing an About page** — bio content scattered across other pages
- **No contact/CTA flow** — "get in touch" moments aren't designed

---

## 2. Design Philosophy

### Aesthetic Direction: **"Studio Warmth"**
A refined, dark-toned editorial aesthetic that feels like stepping into a well-loved creative studio. Think vinyl record sleeves meeting modern editorial design. Warm amber/gold accents against deep charcoal. Typography that has character without being gimmicky.

### Key Principles
- **Two worlds, one person** — Composition and Learning Design are presented as complementary disciplines, not separate silos
- **Show, don't tell** — Audio should play. Animations should demonstrate. Portfolio pieces should be interactive.
- **Personality-forward** — Shane's warm, self-deprecating, passionate voice should be amplified by design, not flattened
- **Progressive revelation** — Don't dump everything at once. Reward scrolling and exploration.

### Colour Palette
```
--si-bg-deep:        #0D0D0F;        /* Near-black background */
--si-bg-surface:     #161619;        /* Card/section surfaces */
--si-bg-elevated:    #1E1E22;        /* Elevated elements */
--si-accent-warm:    #D4A853;        /* Warm gold — primary accent */
--si-accent-glow:    #E8C675;        /* Lighter gold for hovers */
--si-text-primary:   #F0EDE6;        /* Warm off-white */
--si-text-secondary: #9B978E;        /* Muted warm grey */
--si-text-dim:       #5C5A54;        /* Subtle labels */
--si-border:         #2A2A2E;        /* Subtle borders */
--si-success:        #7EC89B;        /* Green for LD section accents */
--si-code:           #5B9BD5;        /* Blue for tech/tools callouts */
```

### Typography
- **Display/Headings:** `"Instrument Serif"` (Google Fonts) — elegant, warm serif with personality
- **Body:** `"Satoshi"` (Fontshare) — clean geometric sans with warmth, avoids the Inter/Roboto trap
- **Mono/Labels:** `"JetBrains Mono"` — for tool names, tech labels, small caps details
- **Pull quotes:** `"Instrument Serif"` italic at large sizes

### Motion System
```css
--si-ease-out:     cubic-bezier(0.16, 1, 0.3, 1);
--si-ease-in-out:  cubic-bezier(0.65, 0, 0.35, 1);
--si-duration-fast: 200ms;
--si-duration-med:  400ms;
--si-duration-slow: 800ms;
--si-stagger:       80ms;   /* Delay between staggered items */
```

---

## 3. Page-by-Page Feature Plan

### 3.1 HOME PAGE — "The Overture"

**Hero Section: Split-identity reveal**
- Full viewport. Dark background with subtle animated grain/noise texture
- Shane's name in large `Instrument Serif`, initially centred
- On scroll (or after 2s), the hero splits into two halves:
  - **Left:** Waveform/audio visualiser motif → "Composer" label fades in
  - **Right:** Geometric grid/blueprint motif → "Learning Designer" label fades in
- Both halves are clickable, leading to their respective sections
- A subtle CSS animation keeps the waveform gently pulsing and the grid subtly shifting
- **Scroll indicator:** Minimal animated chevron at bottom

**Philosophy Strip**
- A single-line horizontal scrolling marquee (CSS only, `@keyframes`) with key phrases:
  - "Music is culture" · "Learning should transform" · "Obsessed with craft" · "Bespoke, always"
- Gold text on dark, with subtle opacity fade at edges

**Dual Showcase Section**
- Two large cards side by side (stack on mobile)
- **Composition card:**
  - Background: subtle waveform SVG pattern
  - Mini audio player with a signature track (custom-styled `<audio>` element)
  - "Hear the work →" CTA
  - On hover: card lifts with box-shadow, waveform animates
- **Learning Design card:**
  - Background: subtle isometric grid pattern
  - Animated counter: "8+ years · 50+ projects · 1 Gold Stevie Award"
  - "See the portfolio →" CTA
  - On hover: grid lines illuminate sequentially

**Testimonial Ticker**
- Auto-rotating testimonial with crossfade animation
- Large pull-quote in `Instrument Serif` italic
- Attribution with project name in gold
- Dot navigation, pause on hover

**CTA Footer Band**
- Full-width gold gradient strip
- "Let's create something extraordinary" + contact button
- Button has magnetic hover effect (follows cursor slightly)

---

### 3.2 COMPOSITION PAGE — "The Score"

**Hero: Cinematic Opening**
- Full-bleed section with dark overlay on a subtle background texture (sheet music pattern, very faded)
- Headline: "Every Project Deserves Its Own Sound" in large serif
- Subtitle fades in on scroll: Shane's "I follow all the latest trends..." intro, but truncated elegantly
- Optional: If Shane can provide a 15-30s showreel audio clip, auto-play with visualiser

**What You Get — Animated List**
- Each benefit reveals on scroll with a staggered slide-up animation:
  - 🎵 "Music that complements, never overpowers"
  - 🎵 "Music that makes people remember your story"
  - 🎵 "Music that enhances professionalism"
  - 🎵 "Music that just sounds awesome"
- Each line gets a subtle gold underline animation on reveal
- Use custom SVG icons instead of emoji in final build

**Process Timeline**
- Horizontal scrolling timeline (or vertical on mobile) showing the composition workflow:
  1. **Brief** — "Tell me your vision"
  2. **Research** — "I immerse myself in your project"
  3. **Compose** — "Iterative drafts with your feedback"
  4. **Refine** — "Polish until it's perfect"
  5. **Deliver** — "Master-quality files, all formats"
- Each step has a subtle icon and expands on click/hover to show more detail
- Connected by an animated line that draws as you scroll

**Portfolio / Showreel Section**
- Grid of past projects with:
  - Project thumbnail (film still, game screenshot, etc.)
  - Inline play button that triggers a custom audio player
  - Genre tag pills (Cinematic, Electronic, Ambient, etc.)
  - On hover: thumbnail subtly zooms, overlay with project details fades in
- **Custom audio player component** (critical feature):
  - Waveform visualisation (pre-rendered, not live — use a canvas or SVG)
  - Scrubber with gold accent
  - Track title and project credit
  - Persists at bottom of page while browsing (mini-player bar)

**Testimonials**
- Redesigned from current inline text to:
  - Large quote marks as decorative elements (SVG, gold, semi-transparent)
  - Quote in serif italic
  - Client photo (or initials avatar) + name + project
  - Card with subtle glass-morphism effect on dark background

**About the Composer**
- Two-column layout: photo of Shane (or studio) + bio text
- Bio text has key phrases highlighted in gold
- Credentials listed as subtle pill badges: "Master's — Electronic Composition" etc.
- Spotify/SoundCloud/Patreon links as icon row

---

### 3.3 LEARNING DESIGN PAGE — "The Blueprint"

**Hero: Data-Driven Opening**
- Animated counters rolling up on load:
  - "8+ Years" · "Gold Stevie Award Winner" · "Articulate · After Effects · Vyond · Rise"
- Subtle background: animated blueprint/wireframe grid pattern (CSS `repeating-linear-gradient` with animation)
- Headline: "Learning Experiences That Actually Work"

**Portfolio Grid — The Main Event**
This is the centrepiece and needs serious attention:

- **Filterable masonry grid** with animated layout transitions
- Filter pills across top: "All · Storyline · Rise · Animation · Compliance · Gamification"
- Each project card:
  - Large thumbnail image
  - Title + one-line description
  - Tool badges (small icons for Storyline, Rise, AE, etc.)
  - Hover state: image zooms slightly, overlay slides up with "View Project →"
  - Click opens a **project detail modal/lightbox** (not a new page)

- **Project Detail Modal:**
  - Full-width image/carousel at top
  - Structured content:
    - **Challenge** — What problem was being solved?
    - **Approach** — Tools, methodology, learning theory applied
    - **Outcome** — Results, engagement data if available
    - **Tools Used** — Icon badges
  - If project is hosted (Articulate 360, etc.), embed iframe or "Launch Project →" button
  - Close button + keyboard (Esc) support
  - Prev/Next navigation between projects

**My Approach Section**
- Three-column feature cards (stack on mobile):
  - **Research & Strategy** — "Understanding the learner before building anything"
  - **Design & Develop** — "Blending aesthetics with cognitive science"
  - **Measure & Iterate** — "Data-driven refinement"
- Each card has a subtle animated icon (CSS-only where possible)
- On hover: card border shifts to gold, icon animates

**Tools & Technologies**
- Visual grid/cloud of tool logos with hover tooltips:
  - Articulate Storyline, Articulate Rise, After Effects, Vyond, Camtasia, etc.
- Arranged in a hexagonal or offset grid pattern
- On hover: tool logo scales up, tooltip shows experience level or notable project

**Awards & Recognition**
- Gold Stevie Award featured prominently:
  - Award badge/icon (SVG illustration)
  - "Gold Stevie Award for Innovation in Learning — CHATS Programme, Raytheon"
  - Brief description of the achievement
- Subtle shimmer/glow animation on the award icon

**Education & Credentials**
- Timeline or card layout:
  - Level 5 Digital Learning Design Apprenticeship — Distinction
  - Master's in Electronic Composition — University of Liverpool
  - ACMALT (in progress)
- Each with institution name and subtle connecting line

---

### 3.4 ABOUT PAGE — "The Human"

**Hero: Personal & Warm**
- Large portrait/studio photo with parallax scroll effect
- Name in display serif, role beneath in sans
- A short, punchy line: "Composer. Learning Designer. Obsessive perfectionist."

**The Story**
- Long-form bio in elegant two-column layout (narrow measure for readability)
- Key moments highlighted with gold left-border pull-outs
- Embedded quotes from Shane's existing "about" copy — the art gallery childhood, the student loan on equipment, etc.
- Timeline dots in the margin showing career progression

**Two Disciplines, One Mind**
- Visual Venn diagram or interleaving section showing how composition and learning design overlap:
  - "Storytelling" · "Emotional engagement" · "Technical precision" · "User empathy"
- Animated on scroll

**Connect**
- Social links row (Spotify, SoundCloud, LinkedIn, Patreon)
- Contact form or mailto CTA
- "Currently based in Didcot, UK" with a subtle map pin icon

---

### 3.5 CONTACT FORMS — "Typeform-Style Multi-Step"

Two distinct forms, both built as full-screen or modal multi-step experiences with smooth transitions between questions. No visible form fields dumped on a page — one question at a time, keyboard-navigable, with progress indication.

**Shared UX Pattern:**
- Each question slides in from the right, previous slides out left (CSS `transform` + `opacity`)
- Large, clear question text in `Instrument Serif`
- Input fields are minimal — just a bottom border on dark background, gold on focus
- Progress bar at top: thin gold line that grows with each step
- Keyboard: Enter to advance, Shift+Enter for textareas, Tab between options
- Final step: summary review before submit
- Submit triggers a subtle success animation (gold checkmark draws itself via SVG `stroke-dashoffset`)
- Sends via AJAX to WordPress `admin-ajax.php` or REST API, with email notification

**Form A: Composition Commission** `[si_form_composition]`

| Step | Question | Input Type |
|---|---|---|
| 1 | "What's your project?" | Card select: Film · Game · Podcast · Commercial · Other |
| 2 | "Tell me about it" | Textarea: brief, mood, tone |
| 3 | "Any reference tracks or inspiration?" | Textarea (optional, skip button) |
| 4 | "How long does the piece need to be?" | Radio: Under 1 min · 1–3 min · 3–5 min · 5+ min · Not sure |
| 5 | "What's your timeline?" | Radio: ASAP · 2–4 weeks · 1–2 months · Flexible |
| 6 | "Budget range?" | Radio: Under £500 · £500–£1k · £1k–£2.5k · £2.5k+ · Let's discuss |
| 7 | "Your details" | Name + Email + optional phone |
| 8 | Review & Submit | Summary card with edit buttons per section |

**Form B: Learning Design Enquiry** `[si_form_learning_design]`

| Step | Question | Input Type |
|---|---|---|
| 1 | "What do you need?" | Multi-select cards: E-Learning Course · Animation/Video · Consultation · Full Programme Design · Other |
| 2 | "What tools/platforms are you using?" | Multi-select: Articulate 360 · Rise · LMS (specify) · No preference · Not sure |
| 3 | "Tell me about the project" | Textarea: audience, topic, goals |
| 4 | "How many learners will this reach?" | Radio: Under 50 · 50–500 · 500–5k · 5k+ · Not sure |
| 5 | "Timeline?" | Radio: ASAP · 2–4 weeks · 1–2 months · Flexible |
| 6 | "Budget range?" | Radio: Under £2k · £2k–£5k · £5k–£10k · £10k+ · Let's discuss |
| 7 | "Your details" | Name + Email + Company/Organisation + Role |
| 8 | Review & Submit | Summary card with edit buttons |

**CSS Techniques for Forms:**
```css
/* Question transition */
.si-form-step {
  position: absolute;
  inset: 0;
  opacity: 0;
  transform: translateX(60px);
  transition: opacity 0.5s var(--si-ease-out), transform 0.5s var(--si-ease-out);
  pointer-events: none;
}
.si-form-step.active {
  opacity: 1;
  transform: translateX(0);
  pointer-events: auto;
}
.si-form-step.exiting {
  opacity: 0;
  transform: translateX(-60px);
}

/* Minimal input styling */
.si-form-input {
  background: transparent;
  border: none;
  border-bottom: 2px solid var(--si-border);
  color: var(--si-text-primary);
  font-family: 'Satoshi', sans-serif;
  font-size: 1.25rem;
  padding: 0.75rem 0;
  width: 100%;
  transition: border-color 0.3s;
}
.si-form-input:focus {
  outline: none;
  border-bottom-color: var(--si-accent-warm);
}

/* Card-select options */
.si-form-option {
  padding: 1rem 1.5rem;
  border: 1px solid var(--si-border);
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.25s var(--si-ease-out);
}
.si-form-option:hover {
  border-color: var(--si-accent-warm);
  background: rgba(212, 168, 83, 0.06);
}
.si-form-option.selected {
  border-color: var(--si-accent-warm);
  background: rgba(212, 168, 83, 0.12);
  box-shadow: 0 0 0 1px var(--si-accent-warm);
}

/* Progress bar */
.si-form-progress {
  height: 3px;
  background: var(--si-border);
}
.si-form-progress-bar {
  height: 100%;
  background: var(--si-accent-warm);
  transition: width 0.5s var(--si-ease-out);
}

/* SVG checkmark draw animation on success */
@keyframes draw-check {
  to { stroke-dashoffset: 0; }
}
.si-form-success svg path {
  stroke-dasharray: 80;
  stroke-dashoffset: 80;
  animation: draw-check 0.6s 0.3s var(--si-ease-out) forwards;
}
```

**Backend:**
- Form submissions stored as a custom post type `si_enquiry` (private, admin-only)
- Email notification via `wp_mail()`
- Honeypot spam protection (hidden field) + transient-based rate limiting (3 per IP per hour)
- AJAX endpoint with nonce verification
- Admin list view showing enquiry type, date, name, email, status (New / Replied / Closed)

---

## 4. Plugin Architecture

### 4.1 File Structure
```
si-portfolio-experience/
├── si-portfolio-experience.php          # Main plugin file
├── includes/
│   ├── class-si-enqueue.php             # Script/style registration
│   ├── class-si-portfolio-cpt.php       # Custom Post Type: Portfolio Projects
│   ├── class-si-testimonials-cpt.php    # Custom Post Type: Testimonials
│   ├── class-si-shortcodes.php          # All shortcode registrations
│   ├── class-si-audio-player.php        # Custom audio player logic
│   ├── class-si-forms.php               # Multi-step form rendering + AJAX handlers
│   ├── class-si-enquiries-cpt.php       # Custom Post Type: Enquiries (admin-only)
│   └── class-si-admin.php              # Admin settings page
├── assets/
│   ├── css/
│   │   ├── si-variables.css             # CSS custom properties (colours, fonts, spacing)
│   │   ├── si-base.css                  # Reset, typography, global styles
│   │   ├── si-components.css            # Reusable components (cards, buttons, badges)
│   │   ├── si-animations.css            # All keyframe animations
│   │   ├── si-home.css                  # Home page specifics
│   │   ├── si-composition.css           # Composition page specifics
│   │   ├── si-learning-design.css       # Learning design page specifics
│   │   ├── si-about.css                 # About page specifics
│   │   └── si-forms.css                 # Multi-step form styles
│   ├── js/
│   │   ├── si-scroll-observer.js        # IntersectionObserver for scroll reveals
│   │   ├── si-audio-player.js           # Custom audio player
│   │   ├── si-portfolio-filter.js       # Masonry filter + layout
│   │   ├── si-project-modal.js          # Project detail lightbox
│   │   ├── si-counters.js               # Animated number counters
│   │   ├── si-marquee.js                # Horizontal scroll marquee
│   │   ├── si-magnetic-button.js        # Magnetic hover effect
│   │   └── si-forms.js                  # Multi-step form logic, validation, AJAX submit
│   ├── svg/
│   │   ├── waveform-pattern.svg
│   │   ├── grid-pattern.svg
│   │   ├── quote-marks.svg
│   │   └── tool-icons/                  # Storyline, Rise, AE, etc.
│   └── fonts/                           # Self-hosted if not using Google Fonts CDN
├── templates/
│   ├── home-hero.php                    # [si_home_hero]
│   ├── dual-showcase.php                # [si_dual_showcase]
│   ├── composition-hero.php             # [si_composition_hero]
│   ├── process-timeline.php             # [si_process_timeline]
│   ├── audio-showcase.php               # [si_audio_showcase]
│   ├── portfolio-grid.php               # [si_portfolio_grid]
│   ├── project-modal.php                # AJAX-loaded modal template
│   ├── testimonial-ticker.php           # [si_testimonials]
│   ├── tools-grid.php                   # [si_tools_grid]
│   ├── about-story.php                  # [si_about_story]
│   ├── cta-band.php                     # [si_cta_band]
│   ├── form-composition.php             # [si_form_composition]
│   └── form-learning-design.php         # [si_form_learning_design]
└── README.md
```

### 4.2 Custom Post Types

**Portfolio Projects** (`si_project`)
- Title, featured image, content (for detail modal)
- Custom fields (ACF or built-in meta boxes):
  - `project_type`: composition | learning_design
  - `tools_used`: multi-select (Storyline, Rise, AE, Vyond, etc.)
  - `categories`: taxonomy (Gamification, Compliance, Cinematic, etc.)
  - `challenge`: textarea
  - `approach`: textarea
  - `outcome`: textarea
  - `external_url`: URL to live project
  - `audio_file`: media upload (for composition projects)
  - `client_name`: text
  - `year`: number

**Testimonials** (`si_testimonial`)
- Quote text
- Client name
- Client role/project
- Client photo (optional)
- Related project (relationship to si_project)

### 4.3 Shortcode Reference

| Shortcode | Page | Description |
|---|---|---|
| `[si_home_hero]` | Home | Split-identity hero with scroll animation |
| `[si_marquee text="..."]` | Home | Horizontal scrolling text strip |
| `[si_dual_showcase]` | Home | Composition + LD preview cards |
| `[si_testimonials count="3"]` | Any | Rotating testimonial display |
| `[si_cta_band]` | Any | Full-width gold CTA strip |
| `[si_composition_hero]` | Comp | Cinematic hero with optional audio |
| `[si_benefits_list]` | Comp | Animated scroll-reveal benefit list |
| `[si_process_timeline]` | Comp | Step-by-step composition workflow |
| `[si_audio_showcase]` | Comp | Audio portfolio with custom player |
| `[si_portfolio_grid type="learning_design"]` | LD | Filterable masonry project grid |
| `[si_approach_cards]` | LD | Three-column methodology cards |
| `[si_tools_grid]` | LD | Tool logos with hover details |
| `[si_awards]` | LD/About | Awards display with shimmer effect |
| `[si_education_timeline]` | LD/About | Credentials timeline |
| `[si_about_story]` | About | Two-column narrative bio |
| `[si_connect]` | About | Social links + contact CTA |
| `[si_form_composition]` | Comp | Typeform-style multi-step commission enquiry |
| `[si_form_learning_design]` | LD | Typeform-style multi-step LD project enquiry |

### 4.4 Admin Settings
Simple options page under Settings → SI Portfolio:
- **Contact email** — used by CTA buttons
- **Social links** — Spotify, SoundCloud, LinkedIn, Patreon URLs
- **Audio showreel** — Upload for home/composition hero
- **Accent colour override** — Default gold, customisable
- **Google Fonts toggle** — Load from CDN or use system fonts

---

## 5. CSS Techniques & Tricks Inventory

### Scroll-Triggered Reveals
```css
.si-reveal {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.8s var(--si-ease-out), transform 0.8s var(--si-ease-out);
}
.si-reveal.visible {
  opacity: 1;
  transform: translateY(0);
}
/* Stagger children */
.si-reveal-group .si-reveal:nth-child(1) { transition-delay: 0ms; }
.si-reveal-group .si-reveal:nth-child(2) { transition-delay: 80ms; }
.si-reveal-group .si-reveal:nth-child(3) { transition-delay: 160ms; }
/* etc. — JS adds .visible via IntersectionObserver */
```

### Grain/Noise Texture Overlay
```css
.si-grain::after {
  content: '';
  position: fixed;
  inset: 0;
  background-image: url("data:image/svg+xml,..."); /* tiny noise SVG */
  opacity: 0.03;
  pointer-events: none;
  z-index: 9999;
  mix-blend-mode: overlay;
}
```

### Gold Shimmer Effect (for awards)
```css
@keyframes shimmer {
  0%   { background-position: -200% center; }
  100% { background-position: 200% center; }
}
.si-shimmer {
  background: linear-gradient(
    110deg,
    var(--si-accent-warm) 0%,
    var(--si-accent-glow) 45%,
    #FFF8E7 50%,
    var(--si-accent-glow) 55%,
    var(--si-accent-warm) 100%
  );
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: shimmer 3s ease-in-out infinite;
}
```

### Magnetic Button
```js
// Button follows cursor within a threshold
button.addEventListener('mousemove', (e) => {
  const rect = button.getBoundingClientRect();
  const x = e.clientX - rect.left - rect.width / 2;
  const y = e.clientY - rect.top - rect.height / 2;
  button.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
});
button.addEventListener('mouseleave', () => {
  button.style.transform = 'translate(0, 0)';
});
```

### Horizontal Scrolling Marquee (CSS only)
```css
@keyframes marquee {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}
.si-marquee-track {
  display: flex;
  width: max-content;
  animation: marquee 30s linear infinite;
}
.si-marquee:hover .si-marquee-track {
  animation-play-state: paused;
}
```

### Glass-morphism Cards
```css
.si-glass {
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 16px;
}
```

### Animated Underline Links
```css
.si-link {
  position: relative;
  text-decoration: none;
}
.si-link::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 0;
  height: 2px;
  background: var(--si-accent-warm);
  transition: width 0.4s var(--si-ease-out);
}
.si-link:hover::after {
  width: 100%;
}
```

### Portfolio Filter Transitions
```css
.si-project-card {
  transition: opacity 0.4s, transform 0.4s;
}
.si-project-card.hidden {
  opacity: 0;
  transform: scale(0.9);
  pointer-events: none;
  position: absolute; /* Collapse space */
}
```

### Custom Audio Player Styling
- Override `<audio>` with a fully custom UI
- Canvas-based or SVG waveform (pre-generated from audio file)
- Gold progress bar on dark track
- Play/pause with morphing icon animation (CSS `clip-path` transition)

### Parallax Scroll (CSS only, subtle)
```css
.si-parallax {
  background-attachment: fixed;
  background-size: cover;
}
/* Or for more control with transform: */
.si-parallax-layer {
  will-change: transform;
  /* JS applies translateY based on scroll position */
}
```

### Counter Animation
```js
// IntersectionObserver triggers counting from 0 to target
// Uses requestAnimationFrame with easing for smooth count-up
// Duration: ~2s with ease-out curve
```

---

## 6. Implementation Priorities

### Phase 1 — Foundation (Build first)
1. Plugin scaffolding, CPT registration, enqueue system
2. CSS variables, base typography, global styles
3. IntersectionObserver scroll-reveal system
4. Home page hero + dual showcase
5. Basic responsive framework

### Phase 2 — Composition Page
6. Composition hero with benefits animation
7. Process timeline component
8. Custom audio player
9. Audio showcase grid
10. Testimonials component (reusable)

### Phase 3 — Learning Design Page
11. Portfolio grid with filtering
12. Project detail modal/lightbox
13. Tools grid
14. Awards section with shimmer
15. Approach cards

### Phase 4 — About & Polish
16. About page story layout
17. Connect section
18. CTA band component
19. Marquee component
20. Final animation polish, performance audit, mobile QA

### Phase 5 — Contact Forms
21. Multi-step form engine (shared JS/CSS)
22. Composition commission form (steps, validation, AJAX)
23. Learning design enquiry form
24. Enquiry CPT + admin list view
25. Email notifications via wp_mail()
26. Spam protection (honeypot + rate limiting)

---

## 7. Technical Notes for Sonnet

- **No build tools required** — vanilla CSS and JS, no Webpack/Vite. Keep it WordPress-native.
- **No jQuery dependency** — use vanilla JS throughout.
- **Enqueue properly** — `wp_enqueue_style()` / `wp_enqueue_script()` with versioning.
- **Google Fonts** — load `Instrument Serif` and `Satoshi` via `wp_enqueue_style` with Google Fonts CDN URL. Satoshi is on Fontshare — either self-host or use Google's `DM Sans` as a fallback with similar warmth.
- **Accessibility** — all interactive elements need keyboard support, ARIA labels, reduced-motion media query support (`prefers-reduced-motion: reduce` disables animations).
- **Images** — use `loading="lazy"` on all images. Portfolio thumbnails should use WordPress's built-in responsive image sizes.
- **Audio** — use HTML5 `<audio>` under the hood, styled with custom UI. No Flash, no external players.
- **Modal** — trap focus inside modal when open, restore on close. Close on Esc and backdrop click.
- **Performance** — CSS animations over JS where possible. Use `will-change` sparingly. Debounce scroll handlers.

---

## 8. Content Shane Needs to Prepare

- [ ] Professional headshot or studio photo
- [ ] 3-5 audio clips for composition showcase (30-60s each)
- [ ] Project thumbnails for learning design portfolio (if not already in WordPress)
- [ ] For each LD project: challenge, approach, outcome text
- [ ] Social media profile URLs
- [ ] Contact email or form preference
- [ ] Any additional testimonials
- [ ] Optional: short audio showreel clip for home hero (15-30s)
