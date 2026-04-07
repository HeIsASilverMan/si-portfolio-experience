<?php defined( 'ABSPATH' ) || exit; ?>

<section class="si-scope si-composition-hero" aria-label="Composition services hero">

    <div class="si-composition-hero__bg" aria-hidden="true">
        <div class="si-composition-hero__lines"></div>
        <div class="si-composition-hero__vignette"></div>
        <div class="si-composition-hero__orb si-composition-hero__orb--left"></div>
        <div class="si-composition-hero__orb si-composition-hero__orb--right"></div>
        <div class="si-composition-hero__staff">
            <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                <span class="si-composition-hero__staff-line si-composition-hero__staff-line--<?php echo esc_attr( $i ); ?>"></span>
            <?php endfor; ?>
        </div>
    </div>

    <div class="si-composition-hero__inner">

        <p class="si-composition-hero__label si-reveal">
            <span class="si-composition-hero__label-rule" aria-hidden="true"></span>
            <?php esc_html_e( 'Bespoke Composition', 'si-portfolio' ); ?>
            <span class="si-composition-hero__label-rule" aria-hidden="true"></span>
        </p>

        <h1 class="si-composition-hero__headline si-reveal">
            <span class="si-composition-hero__word"><?php esc_html_e( 'Every Project Deserves', 'si-portfolio' ); ?></span>
            <br aria-hidden="true">
            <span class="si-composition-hero__word si-composition-hero__word--accent"><?php esc_html_e( 'Its Own Sound', 'si-portfolio' ); ?></span>
        </h1>

        <p class="si-composition-hero__sub si-reveal">
            <?php esc_html_e( 'No templates. No stock. Every piece composed from scratch &mdash; shaped to your story, your audience, and the feeling you need to leave behind.', 'si-portfolio' ); ?>
        </p>

        <div class="si-composition-hero__actions si-reveal">
            <a href="#si-audio-showcase" class="si-btn si-btn--primary si-btn--magnetic">
                <?php esc_html_e( 'Hear the Work', 'si-portfolio' ); ?>
                <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <a href="#si-process-timeline" class="si-btn si-btn--ghost">
                <?php esc_html_e( 'How it works', 'si-portfolio' ); ?>
            </a>
        </div>

        <div class="si-composition-hero__waveform si-reveal" aria-hidden="true">
            <?php for ( $i = 0; $i < 48; $i++ ) : ?>
                <span class="si-composition-hero__bar" style="--bar-i:<?php echo esc_attr( $i ); ?>"></span>
            <?php endfor; ?>
        </div>

    </div>

</section>
