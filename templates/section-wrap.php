<?php
/**
 * Template: section-wrap.php
 * Shortcode: [si_section bg="dark|surface|elevated" width="800" align="left|center"
 *             padding="small|normal|large" label="" title=""]...[/si_section]
 *
 * A general-purpose content wrapper that applies the plugin design system
 * to arbitrary page content placed outside other shortcodes.
 */
defined( 'ABSPATH' ) || exit;

$bg_map = array(
    'dark'     => '#0D0D0F',
    'surface'  => '#161619',
    'elevated' => '#1E1E22',
);
$bg_color = isset( $bg_map[ $bg ] ) ? $bg_map[ $bg ] : '#0D0D0F';

$pad_map = array(
    'none'   => '0',
    'small'  => '3rem',
    'normal' => '6rem',
    'large'  => '10rem',
);
$pad = isset( $pad_map[ $padding ] ) ? $pad_map[ $padding ] : '6rem';

$safe_align = in_array( $align, array( 'left', 'center', 'right' ), true ) ? $align : 'left';
$max_width_px = absint( $width ) . 'px';
?>
<section class="si-scope si-section" style="background:<?php echo esc_attr( $bg_color ); ?> !important; padding:<?php echo esc_attr( $pad ); ?> 2rem;">
    <div class="si-section__inner" style="max-width:<?php echo esc_attr( $max_width_px ); ?>; margin:0 auto; text-align:<?php echo esc_attr( $safe_align ); ?>;">

        <?php if ( $label ) : ?>
            <p class="si-section__label"><?php echo esc_html( $label ); ?></p>
        <?php endif; ?>

        <?php if ( $title ) : ?>
            <h2 class="si-section__title si-reveal"><?php echo esc_html( $title ); ?></h2>
        <?php endif; ?>

        <div class="si-section__content">
            <?php echo wp_kses_post( do_shortcode( $content ) ); ?>
        </div>

    </div>
</section>
