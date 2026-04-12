<?php defined( 'ABSPATH' ) || exit; ?>

<section class="si-scope si-cta-band" aria-label="Call to action">
    <?php $variant = 'glow'; include SI_PLUGIN_DIR . 'templates/partials/stave-motif.php'; ?>
    <div class="si-cta-band__bars" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="si-cta-band__inner si-reveal">
        <h2 class="si-cta-band__heading"><?php echo esc_html( si_setting( 'cta_headline', "Let's create something extraordinary" ) ); ?></h2>
        <p class="si-cta-band__sub"><?php echo esc_html( si_setting( 'cta_sub', "Whether it's a score, a course, or something in between — get in touch." ) ); ?></p>
        <div class="si-cta-band__actions">
            <a href="/composition/#si-form-composition" class="si-btn si-btn--primary si-btn--magnetic">
                <?php esc_html_e( 'Commission Music', 'si-portfolio' ); ?>
                <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <a href="/learning-design/#si-form-learning-design" class="si-btn si-btn--outline si-btn--magnetic">
                <?php esc_html_e( 'Start a Learning Project', 'si-portfolio' ); ?>
                <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</section>
