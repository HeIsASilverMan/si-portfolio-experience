<?php defined( 'ABSPATH' ) || exit; ?>

<section class="si-scope si-thread-guarantee" aria-label="<?php esc_attr_e( 'The Concept Guarantee', 'si-portfolio' ); ?>">
    <?php $variant = 'glow'; include SI_PLUGIN_DIR . 'templates/partials/stave-motif.php'; ?>

    <div class="si-thread-guarantee__inner si-reveal">
        <p class="si-thread-guarantee__label"><?php esc_html_e( 'The Concept Guarantee', 'si-portfolio' ); ?></p>
        <blockquote class="si-thread-guarantee__quote">
            <p>
                <?php echo wp_kses( __( "Every track begins with a concept. I'll revise it at no additional cost until you're satisfied it captures your world &mdash; before a single note of full production is written. Nothing moves forward without your sign-off.", 'si-portfolio' ), array() ); ?>
            </p>
        </blockquote>
    </div>

</section>
