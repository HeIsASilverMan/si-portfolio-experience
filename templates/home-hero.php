<?php defined( 'ABSPATH' ) || exit;

$tagline = si_setting(
    'home_tagline',
    'Bespoke music and scores, lovingly crafted to your exact requirements. Learning experiences that actually work.'
);
?>

<section class="si-scope si-home-hero" aria-label="Introduction">

    <!-- Ambient background orbs -->
    <div class="si-home-hero__bg" aria-hidden="true">
        <div class="si-home-hero__orb si-home-hero__orb--left"></div>
        <div class="si-home-hero__orb si-home-hero__orb--right"></div>
    </div>

    <!-- Split identity panels — appear after 2s, purely decorative -->
    <div class="si-home-hero__split" aria-hidden="true">
        <div class="si-home-hero__half si-home-hero__half--left">
            <span class="si-home-hero__half-label">Composition</span>
        </div>
        <div class="si-home-hero__half si-home-hero__half--right">
            <span class="si-home-hero__half-label">Learning Design</span>
        </div>
    </div>

    <div class="si-home-hero__inner">

        <!-- Animated SI mark logo -->
        <div class="si-hero-logo-wrap" aria-label="Shane Ivers" role="img">
            <svg class="si-hero-logo" viewBox="0 0 127.3 127.3" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">

                <!-- Box outline draws first -->
                <rect class="si-logo-box"
                    x="3" y="3" width="121.3" height="121.3"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="6"
                    stroke-dasharray="486"
                    stroke-dashoffset="486"/>

                <!-- S curve - left organic shape -->
                <g class="si-logo-part si-logo-s">
                    <path fill-rule="evenodd" fill="currentColor"
                        d="M54.34,71.54C38.76,49.86,38.02,21.96,50.12,0H0v127.3h45.65c17.57-13.05,21.5-37.92,8.69-55.76Z"/>
                </g>

                <!-- S bridge - right organic shape -->
                <g class="si-logo-part si-logo-bridge">
                    <path fill-rule="evenodd" fill="currentColor"
                        d="M93.66,127.3c0-42.43,0-84.86,0-127.3h-8.67c-17.73,13.01-21.74,37.99-8.88,55.89,15.54,21.63,16.31,49.46,4.3,71.4h13.24Z"/>
                </g>

                <!-- Vertical bars - staggered left to right -->
                <g class="si-logo-part si-logo-bar" style="--bar-i:0;">
                    <path fill-rule="evenodd" fill="currentColor"
                        d="M99.45,0h-2.89c0,42.43,0,84.86,0,127.3h2.89V0Z"/>
                </g>

                <g class="si-logo-part si-logo-bar" style="--bar-i:1;">
                    <path fill-rule="evenodd" fill="currentColor"
                        d="M105.25,127.3h-2.89c0-42.43,0-84.86,0-127.3h2.89v127.3Z"/>
                </g>

                <g class="si-logo-part si-logo-bar" style="--bar-i:2;">
                    <path fill-rule="evenodd" fill="currentColor"
                        d="M111.05,0h-2.89c0,42.43,0,84.86,0,127.3h2.89V0Z"/>
                </g>

                <g class="si-logo-part si-logo-bar" style="--bar-i:3;">
                    <path fill-rule="evenodd" fill="currentColor"
                        d="M116.84,0h-2.89c0,42.43,0,84.86,0,127.3h2.89V0Z"/>
                </g>

                <g class="si-logo-part si-logo-bar" style="--bar-i:4;">
                    <path fill-rule="evenodd" fill="currentColor"
                        d="M119.75,0c0,42.43,0,84.86,0,127.3h7.55V0h-7.55Z"/>
                </g>

            </svg>
        </div>

        <!-- Name — centrepiece -->
        <h1 class="si-home-hero__name">Shane Ivers</h1>

        <p class="si-home-hero__tagline">
            <?php echo esc_html( $tagline ); ?>
        </p>

        <div class="si-home-hero__actions">
            <a href="/composition" class="si-btn si-btn--primary si-btn--magnetic">
                <?php echo esc_html( si_setting( 'home_btn_primary', 'Hear the Work' ) ); ?>
                <!-- quaver / eighth note -->
                <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M10 2v7.27A2.5 2.5 0 1 1 8 7V2h2z" fill="currentColor"/>
                    <rect x="10" y="2" width="4" height="1.5" rx="0.5" fill="currentColor"/>
                </svg>
            </a>
            <a href="/learning-design" class="si-btn si-btn--ghost">
                <?php echo esc_html( si_setting( 'home_btn_secondary', 'See the Portfolio' ) ); ?>
                <!-- lightbulb -->
                <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M8 1a4.5 4.5 0 0 0-2 8.54V11h4V9.54A4.5 4.5 0 0 0 8 1z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                    <path d="M6 11h4v1a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-1z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                    <line x1="8" y1="3.5" x2="8" y2="4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
            </a>
            <a href="/tools" class="si-btn si-btn--outline">
                <?php esc_html_e( 'Use the Tools', 'si-portfolio' ); ?>
                <!-- wrench -->
                <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M11.5 2a3.5 3.5 0 0 0-3.36 4.47L2.5 12.1a1.41 1.41 0 1 0 2 2l5.62-5.65A3.5 3.5 0 0 0 11.5 2zm0 1.5a2 2 0 1 1 0 4 2 2 0 0 1 0-4z" fill="currentColor"/>
                </svg>
            </a>
        </div>

    </div>

</section>

<script>
( function () {
    var hero = document.querySelector( '.si-home-hero' );
    if ( ! hero ) { return; }
    if ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
        hero.classList.add( 'is-split' );
        return;
    }
    setTimeout( function () { hero.classList.add( 'is-split' ); }, 2200 );
} )();
</script>
