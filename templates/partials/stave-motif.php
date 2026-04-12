<?php
/**
 * Musical stave motif — reusable background decoration.
 * Include inside a section with position: relative; overflow: hidden;
 *
 * @param string $variant  'default', 'subtle', or 'glow'
 */
defined( 'ABSPATH' ) || exit;

$variant = isset( $variant ) ? $variant : 'default';
$glow_class = ( 'glow' === $variant ) ? ' si-stave-motif__group--glow' : '';
$base_opacity = ( 'subtle' === $variant ) ? ' style="opacity:0.02"' : '';
?>
<div class="si-stave-motif" aria-hidden="true"<?php echo $base_opacity; ?>>
    <div class="si-stave-motif__group si-stave-motif__group--a<?php echo $glow_class; ?>">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="si-stave-motif__group si-stave-motif__group--b<?php echo $glow_class; ?>">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="si-stave-motif__group si-stave-motif__group--c<?php echo $glow_class; ?>">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
</div>
