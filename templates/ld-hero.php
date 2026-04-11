<?php defined( 'ABSPATH' ) || exit; ?>

<section class="si-scope si-ld-hero" aria-label="Learning design services hero">

    <div class="si-ld-hero__bg" aria-hidden="true">
        <div class="si-ld-hero__grid"></div>
        <div class="si-ld-hero__vignette"></div>
        <div class="si-ld-hero__orb si-ld-hero__orb--tl"></div>
        <div class="si-ld-hero__orb si-ld-hero__orb--br"></div>
    </div>

    <div class="si-ld-hero__inner">

        <p class="si-ld-hero__label si-reveal">
            <span class="si-ld-hero__label-rule" aria-hidden="true"></span>
            <?php esc_html_e( 'Learning Design', 'si-portfolio' ); ?>
            <span class="si-ld-hero__label-rule" aria-hidden="true"></span>
        </p>

        <h1 class="si-ld-hero__headline si-reveal">
            <?php echo esc_html( si_setting( 'ld_hero_headline', 'Learning Experiences That Actually Work' ) ); ?>
        </h1>

        <p class="si-ld-hero__sub si-reveal">
            <?php echo esc_html( si_setting( 'ld_hero_sub', 'Blending instructional science with design craft to build e-learning, animation, and programmes that engage learners and deliver measurable outcomes.' ) ); ?>
        </p>

        <!-- Animated stat counters -->
        <div class="si-ld-hero__stats si-reveal" role="list" aria-label="<?php esc_attr_e( 'Key statistics', 'si-portfolio' ); ?>">

            <div class="si-ld-hero__stat" role="listitem">
                <span class="si-ld-hero__stat-num si-counter" data-target="10" data-suffix="+"><?php esc_html_e( '0', 'si-portfolio' ); ?></span>
                <span class="si-ld-hero__stat-label"><?php esc_html_e( 'Years Experience', 'si-portfolio' ); ?></span>
            </div>

            <span class="si-ld-hero__stat-divider" aria-hidden="true"></span>

            <div class="si-ld-hero__stat" role="listitem">
                <span class="si-ld-hero__stat-num si-counter" data-target="100" data-suffix="+"><?php esc_html_e( '0', 'si-portfolio' ); ?></span>
                <span class="si-ld-hero__stat-label"><?php esc_html_e( 'Projects Delivered', 'si-portfolio' ); ?></span>
            </div>

            <span class="si-ld-hero__stat-divider" aria-hidden="true"></span>

            <div class="si-ld-hero__stat" role="listitem">
                <span class="si-ld-hero__stat-num">&#127942;</span>
                <span class="si-ld-hero__stat-label"><?php esc_html_e( 'Gold Stevie Award', 'si-portfolio' ); ?></span>
            </div>

        </div>

        <!-- Tool badges -->
        <div class="si-ld-hero__tools si-reveal" role="list" aria-label="<?php esc_attr_e( 'Tools and platforms', 'si-portfolio' ); ?>">
            <?php
            $tools = array( 'Articulate Storyline', 'Articulate Rise', 'After Effects', 'Vyond', 'Camtasia', 'AI Integration' );
            foreach ( $tools as $tool ) :
            ?>
            <span class="si-ld-hero__tool" role="listitem"><?php echo esc_html( $tool ); ?></span>
            <?php endforeach; ?>
        </div>

        <div class="si-ld-hero__actions si-reveal">
            <a href="#si-portfolio-grid" class="si-btn si-btn--primary si-btn--magnetic">
                <?php esc_html_e( 'See the Portfolio', 'si-portfolio' ); ?>
                <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <a href="#si-approach-cards" class="si-btn si-btn--ghost">
                <?php esc_html_e( 'My Approach', 'si-portfolio' ); ?>
            </a>
        </div>

    </div><!-- /.si-ld-hero__inner -->

    <!-- Animated device mockup — decorative, desktop only -->
    <div class="si-ld-hero__device" aria-hidden="true">
        <div class="si-ld-hero__device-frame">
            <div class="si-ld-hero__device-bar">
                <span></span><span></span><span></span>
            </div>
            <div class="si-ld-hero__device-screen">
                <div class="si-ld-hero__screen si-ld-hero__screen--1">
                    <div class="si-ld-screen__progress-bar"><span style="width:72%"></span></div>
                    <div class="si-ld-screen__module si-ld-screen__module--active">
                        <span class="si-ld-screen__module-icon">&#9654;</span>
                        <span>Module 1: Introduction</span>
                        <span class="si-ld-screen__check">&#10003;</span>
                    </div>
                    <div class="si-ld-screen__module">
                        <span class="si-ld-screen__module-icon">&#9654;</span>
                        <span>Module 2: Core Concepts</span>
                        <span class="si-ld-screen__check">&#10003;</span>
                    </div>
                    <div class="si-ld-screen__module si-ld-screen__module--current">
                        <span class="si-ld-screen__module-icon">&#9654;</span>
                        <span>Module 3: Application</span>
                    </div>
                    <div class="si-ld-screen__module si-ld-screen__module--locked">
                        <span class="si-ld-screen__module-icon">&#128274;</span>
                        <span>Module 4: Assessment</span>
                    </div>
                    <div class="si-ld-screen__btn">Continue Learning &rarr;</div>
                </div>
                <div class="si-ld-hero__screen si-ld-hero__screen--2">
                    <div class="si-ld-screen__slide-header">Scenario: The Decision</div>
                    <div class="si-ld-screen__scene">
                        <div class="si-ld-screen__character"></div>
                        <div class="si-ld-screen__bubble">What would you do in this situation?</div>
                    </div>
                    <div class="si-ld-screen__choices">
                        <div class="si-ld-screen__choice">A. Escalate to manager</div>
                        <div class="si-ld-screen__choice si-ld-screen__choice--selected">B. Address it directly</div>
                        <div class="si-ld-screen__choice">C. Document and wait</div>
                    </div>
                </div>
                <div class="si-ld-hero__screen si-ld-hero__screen--3">
                    <div class="si-ld-screen__result-icon">&#127942;</div>
                    <div class="si-ld-screen__result-title">Assessment Complete</div>
                    <div class="si-ld-screen__score">
                        <span class="si-ld-screen__score-num">94</span>
                        <span class="si-ld-screen__score-pct">%</span>
                    </div>
                    <div class="si-ld-screen__result-label">Distinction</div>
                    <div class="si-ld-screen__bars">
                        <div class="si-ld-screen__bar-row"><span>Knowledge</span><div><span style="width:95%"></span></div></div>
                        <div class="si-ld-screen__bar-row"><span>Application</span><div><span style="width:90%"></span></div></div>
                        <div class="si-ld-screen__bar-row"><span>Analysis</span><div><span style="width:96%"></span></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
