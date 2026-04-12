<?php defined( 'ABSPATH' ) || exit; ?>

<section class="si-scope si-cta-band" aria-label="Call to action">
    <div class="si-cta-band__bars" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="si-cta-band__inner si-reveal">
        <h2 class="si-cta-band__heading"><?php echo esc_html( si_setting( 'cta_headline', "Let's create something extraordinary" ) ); ?></h2>
        <p class="si-cta-band__sub"><?php echo esc_html( si_setting( 'cta_sub', "Whether it's a score, a course, or something in between — get in touch." ) ); ?></p>
        <a href="mailto:<?php echo esc_attr( si_setting( 'contact_email', 'shane@shaneivers.com' ) ); ?>" class="si-btn si-btn--primary si-btn--magnetic">
            <?php echo esc_html( si_setting( 'cta_button_text', 'Get in Touch' ) ); ?>
            <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>
</section>
