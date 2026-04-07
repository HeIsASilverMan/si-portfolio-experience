<?php defined( 'ABSPATH' ) || exit;

$label    = SI_Settings::get( 'comp_hero_label' );
$headline = SI_Settings::get( 'comp_hero_headline' );
$sub      = SI_Settings::get( 'comp_hero_sub' );
$cta1     = SI_Settings::get( 'comp_hero_cta1' );
$cta2     = SI_Settings::get( 'comp_hero_cta2' );
?>

<section class="si-scope si-composition-hero" aria-label="Composition services">

    <div class="si-composition-hero__bg" aria-hidden="true">
        <div class="si-composition-hero__lines"></div>
        <div class="si-composition-hero__orb"></div>
    </div>

    <div class="si-composition-hero__inner">

        <p class="si-composition-hero__label si-reveal"><?php echo esc_html( $label ); ?></p>

        <h1 class="si-composition-hero__headline si-reveal">
            <?php echo esc_html( $headline ); ?>
        </h1>

        <p class="si-composition-hero__sub si-reveal">
            <?php echo esc_html( $sub ); ?>
        </p>

        <div class="si-composition-hero__actions si-reveal">
            <a href="#si-audio-showcase" class="si-btn si-btn--primary si-btn--magnetic">
                <?php echo esc_html( $cta1 ); ?>
                <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <a href="#si-process-timeline" class="si-btn si-btn--ghost">
                <?php echo esc_html( $cta2 ); ?>
            </a>
        </div>

    </div>

</section>
