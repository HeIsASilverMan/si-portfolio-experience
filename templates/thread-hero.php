<?php defined( 'ABSPATH' ) || exit;

$contact_url = si_setting( 'thread_contact_url', '/game-music-composition/contact/' );
?>

<section class="si-scope si-thread-hero" aria-label="<?php esc_attr_e( 'Bespoke game music composition', 'si-portfolio' ); ?>">

    <div class="si-thread-hero__bg" aria-hidden="true">
        <div class="si-thread-hero__lines"></div>
        <div class="si-thread-hero__vignette"></div>
        <div class="si-thread-hero__orb si-thread-hero__orb--left"></div>
        <div class="si-thread-hero__orb si-thread-hero__orb--right"></div>
    </div>

    <div class="si-thread-hero__inner">

        <p class="si-thread-hero__label si-reveal">
            <span class="si-thread-hero__label-rule" aria-hidden="true"></span>
            <?php esc_html_e( 'Game Music Composition', 'si-portfolio' ); ?>
            <span class="si-thread-hero__label-rule" aria-hidden="true"></span>
        </p>

        <h1 class="si-thread-hero__headline si-reveal">
            <?php esc_html_e( "Bespoke game music for worlds stock libraries can't reach.", 'si-portfolio' ); ?>
        </h1>

        <p class="si-thread-hero__sub si-reveal">
            <?php esc_html_e( 'If your game has a specific time, place, or culture at its heart, generic background music was never going to fit it. I compose original soundtracks built around the one thread that holds your world together.', 'si-portfolio' ); ?>
        </p>

        <div class="si-thread-hero__actions si-reveal">
            <a href="<?php echo esc_url( $contact_url ); ?>" class="si-btn si-btn--primary si-btn--magnetic">
                <?php esc_html_e( 'Get in touch', 'si-portfolio' ); ?>
                <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <a href="#si-thread-portfolio" class="si-btn si-btn--ghost">
                <?php esc_html_e( 'Hear the work', 'si-portfolio' ); ?>
            </a>
        </div>

    </div>

    <div class="si-thread-credentials si-reveal" aria-label="<?php esc_attr_e( 'Credentials', 'si-portfolio' ); ?>">
        <p class="si-thread-credentials__line">
            <?php
            echo esc_html__( "Master's in Music (Electronic Composition)", 'si-portfolio' );
            echo ' <span aria-hidden="true">&middot;</span> ';
            echo esc_html__( 'Gold Stevie Award', 'si-portfolio' );
            echo ' <span aria-hidden="true">&middot;</span> ';
            echo esc_html__( 'Level 5 Diploma in Digital Learning Design', 'si-portfolio' );
            echo ' <span aria-hidden="true">&middot;</span> ';
            echo esc_html__( '10+ years composing professionally', 'si-portfolio' );
            ?>
        </p>
    </div>

</section>
