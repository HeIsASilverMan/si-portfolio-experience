<?php defined( 'ABSPATH' ) || exit;

$linkedin_url   = si_setting( 'linkedin_url' );
$spotify_url    = si_setting( 'spotify_url' );
$soundcloud_url = si_setting( 'soundcloud_url' );
$patreon_url    = si_setting( 'patreon_url' );
$contact_email  = si_setting( 'contact_email', 'shane@shaneivers.com' );
?>

<section class="si-scope si-connect" aria-label="Connect with Shane">

    <div class="si-connect__inner">

        <div class="si-connect__header si-reveal">
            <p class="si-connect__label"><?php esc_html_e( 'Connect', 'si-portfolio' ); ?></p>
            <h2 class="si-connect__heading"><?php esc_html_e( "Let's Work Together", 'si-portfolio' ); ?></h2>
            <p class="si-connect__sub"><?php esc_html_e( 'Currently based in Didcot, UK. Available for composition and learning design projects worldwide.', 'si-portfolio' ); ?></p>
        </div>

        <div class="si-connect__links si-reveal" role="list" aria-label="<?php esc_attr_e( 'Social and professional links', 'si-portfolio' ); ?>">

            <?php if ( $linkedin_url ) : ?>
            <a href="<?php echo esc_url( $linkedin_url ); ?>" class="si-connect__link" role="listitem" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'LinkedIn profile (opens in new tab)', 'si-portfolio' ); ?>">
                <span class="si-connect__link-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="2" y="9" width="4" height="12" rx="1" stroke="currentColor" stroke-width="1.5"/>
                        <circle cx="4" cy="4" r="2" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </span>
                <span class="si-connect__link-label"><?php esc_html_e( 'LinkedIn', 'si-portfolio' ); ?></span>
                <svg class="si-connect__link-arrow" width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <?php endif; ?>

            <?php if ( $spotify_url ) : ?>
            <a href="<?php echo esc_url( $spotify_url ); ?>" class="si-connect__link" role="listitem" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Spotify profile (opens in new tab)', 'si-portfolio' ); ?>">
                <span class="si-connect__link-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M8 14.5c2.5-1 5.5-1 8 0M7 11.5c3-1.2 7-1.2 10 0M8.5 8.5c2.5-.8 5.5-.8 8 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="si-connect__link-label"><?php esc_html_e( 'Spotify', 'si-portfolio' ); ?></span>
                <svg class="si-connect__link-arrow" width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <?php endif; ?>

            <?php if ( $soundcloud_url ) : ?>
            <a href="<?php echo esc_url( $soundcloud_url ); ?>" class="si-connect__link" role="listitem" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'SoundCloud profile (opens in new tab)', 'si-portfolio' ); ?>">
                <span class="si-connect__link-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M2 14.5c0-1.9 1.4-3.5 3.3-3.7C5.7 8.6 7.7 7 10 7c1.3 0 2.5.5 3.4 1.3M18 17H6a4 4 0 0 1 0-8 4 4 0 0 1 2.3.7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 17a4 4 0 0 0 4-4 4 4 0 0 0-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="si-connect__link-label"><?php esc_html_e( 'SoundCloud', 'si-portfolio' ); ?></span>
                <svg class="si-connect__link-arrow" width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <?php endif; ?>

            <?php if ( $patreon_url ) : ?>
            <a href="<?php echo esc_url( $patreon_url ); ?>" class="si-connect__link" role="listitem" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Patreon page (opens in new tab)', 'si-portfolio' ); ?>">
                <span class="si-connect__link-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <circle cx="14.5" cy="10.5" r="5.5" stroke="currentColor" stroke-width="1.5"/>
                        <rect x="4" y="3" width="3" height="18" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </span>
                <span class="si-connect__link-label"><?php esc_html_e( 'Patreon', 'si-portfolio' ); ?></span>
                <svg class="si-connect__link-arrow" width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <?php endif; ?>

            <?php if ( $contact_email ) : ?>
            <a href="mailto:<?php echo esc_attr( $contact_email ); ?>" class="si-connect__link" role="listitem" aria-label="<?php esc_attr_e( 'Send an email', 'si-portfolio' ); ?>">
                <span class="si-connect__link-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M2 7l10 7 10-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="si-connect__link-label"><?php echo esc_html( $contact_email ); ?></span>
                <svg class="si-connect__link-arrow" width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <?php endif; ?>

        </div>

        <div class="si-connect__cta si-reveal">
            <p class="si-connect__cta-text"><?php esc_html_e( 'Have a project in mind?', 'si-portfolio' ); ?></p>
            <div class="si-connect__cta-actions">
                <a href="/composition#si-process-timeline" class="si-btn si-btn--primary si-btn--magnetic">
                    <?php esc_html_e( 'Commission a Score', 'si-portfolio' ); ?>
                    <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="/learning-design#si-portfolio-grid" class="si-btn si-btn--ghost">
                    <?php esc_html_e( 'Discuss a Learning Project', 'si-portfolio' ); ?>
                </a>
            </div>
        </div>

    </div>

</section>
