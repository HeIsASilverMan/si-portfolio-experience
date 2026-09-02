<?php defined( 'ABSPATH' ) || exit; ?>

<section class="si-scope si-thread-who" aria-labelledby="si-thread-who-heading">
    <?php $variant = 'subtle'; include SI_PLUGIN_DIR . 'templates/partials/stave-motif.php'; ?>

    <div class="si-thread-who__inner">

        <div class="si-thread-who__header si-reveal">
            <p class="si-thread-who__label"><?php esc_html_e( 'Is This For You?', 'si-portfolio' ); ?></p>
        </div>

        <div class="si-thread-who__body si-reveal">
            <p>
                <?php echo wp_kses( __( "You're building something with a genuine sense of place &mdash; a specific era, culture, or invented world that a generic stock track was never going to capture. Maybe you're holding a studio budget for the first time and you can't afford to get this call wrong. Maybe you've already searched stock libraries and forums and come up short.", 'si-portfolio' ), array() ); ?>
            </p>
            <p class="si-thread-who__closer">
                <?php echo wp_kses( __( 'If that&rsquo;s you, this is what I do.', 'si-portfolio' ), array() ); ?>
            </p>
        </div>

    </div>

</section>
