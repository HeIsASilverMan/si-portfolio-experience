<?php defined( 'ABSPATH' ) || exit;

$default_items = array(
    'Music is culture',
    'Learning should transform',
    'Obsessed with craft',
    'Bespoke, always',
    'Every project deserves its own sound',
    'Learning experiences that actually work',
);

if ( ! empty( $text ) ) {
    $items = array_map( 'trim', explode( '|', $text ) );
} else {
    $items = $default_items;
}
?>

<div class="si-scope si-marquee" aria-hidden="true">
    <div class="si-marquee-track">
        <?php foreach ( $items as $item ) : ?>
        <span class="si-marquee-item"><?php echo esc_html( $item ); ?></span>
        <span class="si-marquee-sep">&middot;</span>
        <?php endforeach; ?>
    </div>
</div>
