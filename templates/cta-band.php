<?php defined( 'ABSPATH' ) || exit;

$heading = SI_Settings::get( 'cta_heading' );
$sub     = SI_Settings::get( 'cta_sub' );
$btn     = SI_Settings::get( 'cta_btn' );
$email   = SI_Settings::get( 'contact_email' );
?>

<section class="si-scope si-cta-band" aria-label="Call to action">
    <div class="si-cta-band__inner si-reveal">
        <h2 class="si-cta-band__heading"><?php echo esc_html( $heading ); ?></h2>
        <p class="si-cta-band__sub"><?php echo esc_html( $sub ); ?></p>
        <a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>" class="si-btn si-btn--primary si-btn--magnetic">
            <?php echo esc_html( $btn ); ?>
            <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>
</section>
