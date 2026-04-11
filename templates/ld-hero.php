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

</section>

</section>
