<?php defined( 'ABSPATH' ) || exit;

$contact_url = si_setting( 'thread_contact_url', '/game-music-composition/contact/' );
?>

<section class="si-scope si-thread-cta" aria-label="<?php esc_attr_e( 'Call to action', 'si-portfolio' ); ?>">
    <?php $variant = 'glow'; include SI_PLUGIN_DIR . 'templates/partials/stave-motif.php'; ?>
    <div class="si-thread-cta__bars" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="si-thread-cta__inner si-reveal">
        <h2 class="si-thread-cta__heading"><?php esc_html_e( 'Ready to find your thread?', 'si-portfolio' ); ?></h2>
        <div class="si-thread-cta__actions">
            <a href="<?php echo esc_url( $contact_url ); ?>" class="si-btn si-btn--primary si-btn--magnetic">
                <?php esc_html_e( 'Get in touch', 'si-portfolio' ); ?>
                <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</section>
