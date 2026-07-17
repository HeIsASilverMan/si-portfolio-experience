<?php defined( 'ABSPATH' ) || exit;

/**
 * [si_interactive_cv]
 *
 * Shane's CV reimagined as an interactive learning module, restyled into the
 * SI "Studio Warmth" system. A fixed course-player HUD tracks progress through
 * the module, roles expand, the toolkit tabs, and the closing knowledge check
 * marks the module complete.
 */

$si_cv_contact_email = si_setting( 'contact_email', 'shaneivers@gmail.com' );

// -- Lesson 01: profile stat cards -----------------------------------------
$si_cv_stats = array(
    array(
        'target' => '8',
        'suffix' => '+',
        'label'  => 'years in instructional &amp; learning experience design',
    ),
    array(
        'target' => '30',
        'suffix' => '+',
        'label'  => 'e-learning modules &amp; programmes shipped at The Works',
    ),
    array(
        'target' => '95',
        'suffix' => '%',
        'label'  => 'average completion rate across delivered modules',
    ),
    array(
        'target' => '8',
        'suffix' => 'k',
        'label'  => 'weekly users on my own music platform, running since 2014',
    ),
);

// -- Lesson 02: experience timeline ----------------------------------------
$si_cv_jobs = array(
    array(
        'open'    => true,
        'title'   => 'Learning Experience Specialist',
        'org'     => 'The Works Stores Ltd',
        'meta'    => 'Birmingham &middot; July 2021 &ndash; Present',
        'award'   => '',
        'points'  => array(
            'Created and delivered 30+ e-learning modules and face-to-face programmes across retail operations, leadership development, and compliance &mdash; 95%+ average completion rates',
            'Designed full induction and onboarding experiences, owning the learner journey from day one to role competency',
            'Led company-wide LMS implementation from vendor selection through rollout, migrating all learning content and establishing scalable delivery',
            'Redesigned existing learning processes with teams across the business, improving usability and learner experience &mdash; not just content quality',
            'Partnered with senior stakeholders in retail operations, HR, and compliance to align learning solutions to business objectives',
        ),
    ),
    array(
        'open'    => false,
        'title'   => 'Composer &amp; Digital Content Creator',
        'org'     => 'Silverman Sound Studios',
        'meta'    => 'silvermansound.com &middot; June 2014 &ndash; Present',
        'award'   => '',
        'points'  => array(
            'Created and published 200+ original royalty-free music tracks under Creative Commons &mdash; sustained creative output at scale for over a decade',
            'Built and maintain a web platform reaching 8,000 weekly users through SEO and digital marketing',
            'Develop custom WordPress plugins and tooling for content delivery, downloads, and platform administration',
        ),
    ),
    array(
        'open'    => false,
        'title'   => 'Multimedia Developer',
        'org'     => 'Raytheon Professional Services',
        'meta'    => 'Milton Keynes &middot; November 2019 &ndash; July 2021',
        'award'   => 'Gold Stevie',
        'points'  => array(
            'Designed the CHATS behavioural change programme &mdash; winner of a Gold Stevie Award for Innovation in Learning',
            'Developed e-learning solutions for Fortune 500 clients across financial services, automotive, and technology',
            'Earned direct recognition from client C-suite executives for creative problem-solving and high-impact results',
            'Became the team&apos;s go-to creative problem-solver for complex learning challenges',
        ),
    ),
    array(
        'open'    => false,
        'title'   => 'Digital Learning Designer',
        'org'     => 'Bigrock',
        'meta'    => 'Buckingham &middot; January 2017 &ndash; November 2019',
        'award'   => '',
        'points'  => array(
            'Produced digital learning content integrating video, animation, graphics, audio, and interactivity for corporate clients across diverse industries',
            'Contributed to the successful launch of a digital coaching platform',
        ),
    ),
);

// -- Lesson 03: toolkit tabs ------------------------------------------------
$si_cv_toolkit = array(
    array(
        'id'     => 'elearning',
        'label'  => 'E-Learning Development',
        'lede'   => 'Authoring, standards, and the frameworks that make learning stick.',
        'skills' => array(
            'Articulate Storyline 360', 'Articulate Rise 360', 'DominKnow', 'Elucidat',
            'Lectora', 'LMS administration', 'SCORM / xAPI', 'WCAG 2.1',
            'Instructional design frameworks',
        ),
    ),
    array(
        'id'     => 'production',
        'label'  => 'Creative Production',
        'lede'   => 'Everything a module needs to look and sound professional &mdash; produced in-house.',
        'skills' => array(
            'Adobe Photoshop', 'Illustrator', 'Premiere Pro', 'After Effects', 'InDesign',
            'Video production &amp; editing', 'Animation', 'Audio production &amp; mastering',
            'Voiceover recording', 'Logic Pro', 'Graphic design',
        ),
    ),
    array(
        'id'     => 'web',
        'label'  => 'Digital &amp; Web',
        'lede'   => 'Web skills that turn learning ideas into working products.',
        'skills' => array(
            'HTML / CSS', 'JavaScript', 'WordPress development', 'Responsive design',
            'API integration', 'SEO', 'Google Analytics', 'Browser DevTools',
        ),
    ),
    array(
        'id'     => 'core',
        'label'  => 'Core Competencies',
        'lede'   => 'The consultancy skills that make the technical ones land.',
        'skills' => array(
            'AI-augmented development', 'Instructional writing &amp; copywriting',
            'Stakeholder management', 'Project management', 'Learning needs analysis',
            'Accessibility &amp; inclusive design', 'Adult learning principles',
            'Client presentation',
        ),
    ),
);

// -- Lesson 04: credentials -------------------------------------------------
$si_cv_creds = array(
    array(
        'award'  => true,
        'title'  => 'Gold Stevie Award &mdash; Innovation in Learning',
        'note'   => 'For the CHATS behavioural change programme at Raytheon Professional Services.',
    ),
    array(
        'award'  => false,
        'title'  => 'Level 5 Digital Learning Design Apprenticeship',
        'note'   => 'Distinction',
    ),
    array(
        'award'  => false,
        'title'  => 'MMus Music (Electronic Composition)',
        'note'   => 'Distinction &mdash; University of Liverpool',
    ),
    array(
        'award'  => false,
        'title'  => 'BA Music (Popular Music)',
        'note'   => 'First Class Honours',
    ),
    array(
        'award'  => false,
        'title'  => 'BTEC National Diploma in Music',
        'note'   => 'Triple Distinction',
    ),
);

// Lesson markers shared between the module and the fixed HUD.
$si_cv_lessons = array(
    array( 'id' => 'si-cv-lesson-1', 'n' => '01', 'name' => 'Profile' ),
    array( 'id' => 'si-cv-lesson-2', 'n' => '02', 'name' => 'Experience' ),
    array( 'id' => 'si-cv-lesson-3', 'n' => '03', 'name' => 'Toolkit' ),
    array( 'id' => 'si-cv-lesson-4', 'n' => '04', 'name' => 'Credentials' ),
    array( 'id' => 'si-cv-lesson-5', 'n' => '05', 'name' => 'Knowledge check' ),
);
?>

<section class="si-scope si-cv" id="si-cv" aria-labelledby="si-cv-title">

    <div class="si-cv__bg" aria-hidden="true">
        <div class="si-cv__grid"></div>
        <div class="si-cv__orb si-cv__orb--gold"></div>
        <div class="si-cv__orb si-cv__orb--deep"></div>
        <div class="si-cv__staff">
            <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                <span class="si-cv__staff-line"></span>
            <?php endfor; ?>
        </div>
    </div>

    <div class="si-cv__inner">

        <!-- ===================== MODULE COVER ===================== -->
        <header class="si-cv__cover">

            <p class="si-cv__eyebrow si-reveal">
                <span class="si-cv__eyebrow-rule" aria-hidden="true"></span>
                <?php esc_html_e( 'Interactive CV', 'si-portfolio' ); ?>
                <span aria-hidden="true">&middot;</span>
                <?php esc_html_e( 'Learning Experience Design', 'si-portfolio' ); ?>
            </p>

            <p class="si-cv__badge si-reveal" aria-hidden="true">
                <span class="si-cv__badge-dot"></span>
                MODULE &middot; SHANE_IVERS.CV &middot; EST. 5 MIN
            </p>

            <h1 id="si-cv-title" class="si-cv__title si-reveal">
                Learning experiences,
                <span class="si-cv__hl">engineered end-to-end.</span>
            </h1>

            <p class="si-cv__lead si-reveal">
                I&apos;m <strong>Shane Ivers</strong> &mdash; a Gold Stevie Award-winning Learning
                Experience Specialist. Rather than tell you I design engaging learning, I built this
                CV as one. Scroll to start the module &mdash; there&apos;s a knowledge check at the end.
            </p>

            <div class="si-cv__chips si-reveal">
                <a class="si-cv__chip" href="mailto:<?php echo esc_attr( $si_cv_contact_email ); ?>">
                    <i class="fa-solid fa-envelope" aria-hidden="true"></i><?php echo esc_html( $si_cv_contact_email ); ?>
                </a>
                <a class="si-cv__chip" href="tel:+447837995350">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>+44 7837 995350
                </a>
                <span class="si-cv__chip">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>Didcot, Oxfordshire
                </span>
                <a class="si-cv__chip" href="/learning-design/">
                    <i class="fa-solid fa-link" aria-hidden="true"></i>shaneivers.com/learning-design
                </a>
            </div>

            <div class="si-cv__cover-actions si-reveal">
                <a href="#si-cv-lesson-1" class="si-btn si-btn--primary si-btn--magnetic si-cv__start">
                    <?php esc_html_e( 'Start module', 'si-portfolio' ); ?>
                    <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M8 3v10M4 9l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="<?php echo esc_url( SI_PLUGIN_URL . 'assets/Shane-Ivers-CV.pdf' ); ?>" class="si-btn si-btn--ghost" download>
                    <i class="fa-solid fa-file-arrow-down" aria-hidden="true"></i>
                    <?php esc_html_e( 'Download PDF version', 'si-portfolio' ); ?>
                </a>
            </div>

            <div class="si-cv__cover-wave si-reveal" aria-hidden="true">
                <?php for ( $i = 0; $i < 56; $i++ ) : ?>
                    <span class="si-cv__wave-bar" style="--bar-i:<?php echo esc_attr( $i ); ?>"></span>
                <?php endfor; ?>
            </div>

        </header>

        <!-- ===================== LESSON 01 &mdash; PROFILE ===================== -->
        <article class="si-cv-lesson" id="si-cv-lesson-1" data-lesson="1" aria-labelledby="si-cv-l1-heading">
            <p class="si-cv-lesson__tag si-reveal">
                <span class="si-cv-lesson__num">Lesson 01</span>
                <span class="si-cv-lesson__name">Profile</span>
            </p>
            <h2 id="si-cv-l1-heading" class="si-cv-lesson__heading si-reveal">
                Design that changes behaviour, not just ticks boxes
            </h2>

            <div class="si-cv-profile">
                <div class="si-cv-profile__copy si-reveal">
                    <p><strong>Eight years designing learning that moves the needle</strong> &mdash; digital
                        modules, face-to-face programmes, and full induction journeys across corporate,
                        retail, and technology sectors.</p>
                    <p>What makes me unusual is range: strategic instructional design paired with genuine
                        production craft &mdash; graphic design, video, animation, audio engineering, and
                        web development. I can take a programme from needs analysis to polished deployment
                        without handing anything off.</p>
                    <p>I&apos;m a systems builder at heart. I don&apos;t just make content &mdash; I build the
                        platforms, processes, and infrastructure that make good learning scale.</p>
                </div>

                <div class="si-cv-profile__stats">
                    <?php foreach ( $si_cv_stats as $stat ) : ?>
                        <div class="si-cv-stat si-reveal">
                            <span class="si-cv-stat__n">
                                <span class="si-counter" data-target="<?php echo esc_attr( $stat['target'] ); ?>" data-suffix="<?php echo esc_attr( $stat['suffix'] ); ?>">0<?php echo esc_html( $stat['suffix'] ); ?></span>
                            </span>
                            <span class="si-cv-stat__l"><?php echo wp_kses( $stat['label'], array() ); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </article>

        <!-- ===================== LESSON 02 &mdash; EXPERIENCE ===================== -->
        <article class="si-cv-lesson" id="si-cv-lesson-2" data-lesson="2" aria-labelledby="si-cv-l2-heading">
            <p class="si-cv-lesson__tag si-reveal">
                <span class="si-cv-lesson__num">Lesson 02</span>
                <span class="si-cv-lesson__name">Experience</span>
            </p>
            <h2 id="si-cv-l2-heading" class="si-cv-lesson__heading si-reveal">
                Where I&apos;ve done it
                <span class="si-cv-lesson__hint">&mdash; tap a role to expand</span>
            </h2>

            <div class="si-cv-timeline">
                <?php foreach ( $si_cv_jobs as $j => $job ) : ?>
                    <?php $panel_id = 'si-cv-job-' . $j; ?>
                    <div class="si-cv-job si-reveal<?php echo $job['open'] ? ' is-open' : ''; ?>">
                        <div class="si-cv-job__marker" aria-hidden="true"></div>
                        <div class="si-cv-job__card">
                            <button type="button" class="si-cv-job__head" aria-expanded="<?php echo $job['open'] ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $panel_id ); ?>">
                                <span class="si-cv-job__headings">
                                    <span class="si-cv-job__title">
                                        <?php echo wp_kses( $job['title'], array() ); ?>
                                        <span class="si-cv-job__at"><?php echo wp_kses( $job['org'], array() ); ?></span>
                                        <?php if ( $job['award'] ) : ?>
                                            <span class="si-cv-job__badge">
                                                <i class="fa-solid fa-trophy" aria-hidden="true"></i><?php echo esc_html( $job['award'] ); ?>
                                            </span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="si-cv-job__meta"><?php echo wp_kses( $job['meta'], array() ); ?></span>
                                </span>
                                <span class="si-cv-job__toggle" aria-hidden="true">
                                    <span></span><span></span>
                                </span>
                            </button>
                            <div class="si-cv-job__body" id="<?php echo esc_attr( $panel_id ); ?>">
                                <ul class="si-cv-job__list">
                                    <?php foreach ( $job['points'] as $point ) : ?>
                                        <li><?php echo wp_kses( $point, array() ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </article>

        <!-- ===================== LESSON 03 &mdash; TOOLKIT ===================== -->
        <article class="si-cv-lesson" id="si-cv-lesson-3" data-lesson="3" aria-labelledby="si-cv-l3-heading">
            <p class="si-cv-lesson__tag si-reveal">
                <span class="si-cv-lesson__num">Lesson 03</span>
                <span class="si-cv-lesson__name">Toolkit</span>
            </p>
            <h2 id="si-cv-l3-heading" class="si-cv-lesson__heading si-reveal">
                The full stack, in one designer
            </h2>

            <div class="si-cv-toolkit si-reveal">
                <div class="si-cv-toolkit__tabs" role="tablist" aria-label="Skill categories">
                    <?php foreach ( $si_cv_toolkit as $t => $group ) : ?>
                        <button type="button"
                                class="si-cv-toolkit__tab<?php echo 0 === $t ? ' is-active' : ''; ?>"
                                role="tab"
                                id="si-cv-tab-<?php echo esc_attr( $group['id'] ); ?>"
                                aria-selected="<?php echo 0 === $t ? 'true' : 'false'; ?>"
                                aria-controls="si-cv-panel-<?php echo esc_attr( $group['id'] ); ?>"
                                tabindex="<?php echo 0 === $t ? '0' : '-1'; ?>">
                            <?php echo wp_kses( $group['label'], array() ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <?php foreach ( $si_cv_toolkit as $t => $group ) : ?>
                    <div class="si-cv-toolkit__panel<?php echo 0 === $t ? ' is-active' : ''; ?>"
                         id="si-cv-panel-<?php echo esc_attr( $group['id'] ); ?>"
                         role="tabpanel"
                         aria-labelledby="si-cv-tab-<?php echo esc_attr( $group['id'] ); ?>"
                         <?php echo 0 === $t ? '' : 'hidden'; ?>>
                        <p class="si-cv-toolkit__lede"><?php echo wp_kses( $group['lede'], array() ); ?></p>
                        <div class="si-cv-toolkit__skills">
                            <?php foreach ( $group['skills'] as $skill ) : ?>
                                <span class="si-cv-skill"><?php echo wp_kses( $skill, array() ); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </article>

        <!-- ===================== LESSON 04 &mdash; CREDENTIALS ===================== -->
        <article class="si-cv-lesson" id="si-cv-lesson-4" data-lesson="4" aria-labelledby="si-cv-l4-heading">
            <p class="si-cv-lesson__tag si-reveal">
                <span class="si-cv-lesson__num">Lesson 04</span>
                <span class="si-cv-lesson__name">Credentials</span>
            </p>
            <h2 id="si-cv-l4-heading" class="si-cv-lesson__heading si-reveal">
                Qualifications &amp; recognition
            </h2>

            <div class="si-cv-creds">
                <?php foreach ( $si_cv_creds as $cred ) : ?>
                    <div class="si-cv-cred si-reveal<?php echo $cred['award'] ? ' si-cv-cred--award' : ''; ?>">
                        <?php if ( $cred['award'] ) : ?>
                            <span class="si-cv-cred__medal" aria-hidden="true">
                                <i class="fa-solid fa-trophy"></i>
                            </span>
                        <?php endif; ?>
                        <h3 class="si-cv-cred__title<?php echo $cred['award'] ? ' si-shimmer' : ''; ?>">
                            <?php echo wp_kses( $cred['title'], array() ); ?>
                        </h3>
                        <p class="si-cv-cred__note"><?php echo wp_kses( $cred['note'], array() ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </article>

        <!-- ===================== LESSON 05 &mdash; KNOWLEDGE CHECK ===================== -->
        <article class="si-cv-lesson si-cv-lesson--quiz" id="si-cv-lesson-5" data-lesson="5" aria-labelledby="si-cv-l5-heading">
            <div class="si-cv-quiz si-reveal">
                <p class="si-cv-lesson__tag si-cv-lesson__tag--quiz">
                    <span class="si-cv-lesson__num">Lesson 05</span>
                    <span class="si-cv-lesson__name">Knowledge check</span>
                </p>
                <h2 id="si-cv-l5-heading" class="si-cv-quiz__heading">Quick assessment</h2>
                <p class="si-cv-quiz__q">Based on this module, what&apos;s the best next step?</p>

                <div class="si-cv-quiz__opts" role="group" aria-label="Knowledge check options">
                    <button type="button" class="si-cv-quiz__opt">
                        <span class="si-cv-quiz__key">A</span> Invite Shane to interview
                    </button>
                    <button type="button" class="si-cv-quiz__opt">
                        <span class="si-cv-quiz__key">B</span> Email Shane about the role
                    </button>
                    <button type="button" class="si-cv-quiz__opt">
                        <span class="si-cv-quiz__key">C</span> Both of the above, immediately
                    </button>
                </div>

                <div class="si-cv-quiz__result" id="si-cv-quiz-result" role="status" aria-live="polite" hidden>
                    <span class="si-cv-quiz__stamp">
                        <i class="fa-solid fa-check" aria-hidden="true"></i> Correct &mdash; module complete
                    </span>
                    <p>Trick question &mdash; every answer was right. That&apos;s the difference between
                        assessment as a hurdle and assessment as reinforcement. Let&apos;s talk about what
                        I could build for your learners.</p>
                    <a class="si-btn si-btn--primary si-btn--magnetic" href="mailto:<?php echo esc_attr( $si_cv_contact_email ); ?>?subject=Your%20interactive%20CV%20worked">
                        <?php esc_html_e( 'Get in touch', 'si-portfolio' ); ?>
                        <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </article>

        <footer class="si-cv__colophon si-reveal">
            <span>&copy; Shane Ivers &middot; Designed &amp; built by me, naturally</span>
            <span>SHANE_IVERS.CV &middot; v2026.07</span>
        </footer>

    </div>

</section>

<!-- ===================== FIXED COURSE-PLAYER HUD ===================== -->
<div class="si-scope si-cv-hud" id="si-cv-hud" data-target="#si-cv" hidden>
    <div class="si-cv-hud__inner">
        <span class="si-cv-hud__badge" aria-hidden="true">
            <span class="si-cv-hud__dot"></span>
            <span class="si-cv-hud__module">SHANE_IVERS.CV</span>
        </span>

        <nav class="si-cv-hud__markers" aria-label="Module lessons">
            <?php foreach ( $si_cv_lessons as $lesson ) : ?>
                <a class="si-cv-hud__marker" href="#<?php echo esc_attr( $lesson['id'] ); ?>" data-lesson="<?php echo esc_attr( $lesson['n'] ); ?>">
                    <span class="si-cv-hud__marker-dot" aria-hidden="true"></span>
                    <span class="si-cv-hud__marker-label"><?php echo esc_html( $lesson['name'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="si-cv-hud__progress">
            <div class="si-cv-hud__track" aria-hidden="true">
                <div class="si-cv-hud__fill" id="si-cv-hud-fill"></div>
            </div>
            <span class="si-cv-hud__pct" id="si-cv-hud-pct" aria-hidden="true">0%</span>
        </div>
    </div>
</div>
