<?php defined( 'ABSPATH' ) || exit;

$benefits = array(
    array(
        'text'   => 'Music that complements, never overpowers',
        'detail' => 'The score should serve your story &mdash; not compete with it. I compose with your project playing, not in isolation.',
    ),
    array(
        'text'   => 'Music that makes people remember your story',
        'detail' => 'The best scores are invisible in the moment and unforgettable afterwards. That&rsquo;s the target.',
    ),
    array(
        'text'   => 'Music that enhances professionalism',
        'detail' => 'Broadcast-ready masters in every format you need &mdash; stems, sync-ready mixes, the lot.',
    ),
    array(
        'text'   => 'Music that just sounds awesome',
        'detail' => 'Life&rsquo;s too short for music that&rsquo;s merely adequate.',
    ),
);
?>

<section class="si-scope si-benefits-list" aria-labelledby="si-benefits-heading">
    <?php $variant = 'subtle'; include SI_PLUGIN_DIR . 'templates/partials/stave-motif.php'; ?>

    <div class="si-benefits-list__inner">

        <div class="si-benefits-list__header si-reveal">
            <p class="si-benefits-list__label">What You Get</p>
            <h2 id="si-benefits-heading" class="si-benefits-list__heading">
                Music built for your project,<br>not borrowed from a library
            </h2>
        </div>

        <ol class="si-benefits-list__items" role="list">
            <?php foreach ( $benefits as $i => $b ) : ?>
            <li class="si-benefits-list__item si-reveal" style="--item-i: <?php echo esc_attr( $i ); ?>;">
                <div class="si-benefits-list__num" aria-hidden="true"><?php echo sprintf( '%02d', $i + 1 ); ?></div>
                <div class="si-benefits-list__content">
                    <p class="si-benefits-list__text"><?php echo wp_kses( $b['text'], array() ); ?></p>
                    <p class="si-benefits-list__detail"><?php echo wp_kses( $b['detail'], array() ); ?></p>
                </div>
                <div class="si-benefits-list__line" aria-hidden="true"></div>
            </li>
            <?php endforeach; ?>
        </ol>

    </div>

</section>
