<?php defined( 'ABSPATH' ) || exit;

$benefits = array(
    array(
        'text'   => SI_Settings::get( 'benefit_1_text' ),
        'detail' => SI_Settings::get( 'benefit_1_detail' ),
    ),
    array(
        'text'   => SI_Settings::get( 'benefit_2_text' ),
        'detail' => SI_Settings::get( 'benefit_2_detail' ),
    ),
    array(
        'text'   => SI_Settings::get( 'benefit_3_text' ),
        'detail' => SI_Settings::get( 'benefit_3_detail' ),
    ),
    array(
        'text'   => SI_Settings::get( 'benefit_4_text' ),
        'detail' => SI_Settings::get( 'benefit_4_detail' ),
    ),
);

$label   = SI_Settings::get( 'benefits_label' );
$heading = SI_Settings::get( 'benefits_heading' );
?>

<section class="si-scope si-benefits-list" aria-labelledby="si-benefits-heading">

    <div class="si-benefits-list__inner">

        <div class="si-benefits-list__header si-reveal">
            <p class="si-benefits-list__label"><?php echo esc_html( $label ); ?></p>
            <h2 id="si-benefits-heading" class="si-benefits-list__heading">
                <?php echo esc_html( $heading ); ?>
            </h2>
        </div>

        <ol class="si-benefits-list__items" role="list">
            <?php foreach ( $benefits as $i => $b ) : ?>
            <li class="si-benefits-list__item si-reveal" style="--item-i: <?php echo esc_attr( $i ); ?>;">
                <div class="si-benefits-list__num" aria-hidden="true"><?php echo sprintf( '%02d', $i + 1 ); ?></div>
                <div class="si-benefits-list__content">
                    <p class="si-benefits-list__text"><?php echo esc_html( $b['text'] ); ?></p>
                    <p class="si-benefits-list__detail"><?php echo esc_html( $b['detail'] ); ?></p>
                </div>
                <div class="si-benefits-list__line" aria-hidden="true"></div>
            </li>
            <?php endforeach; ?>
        </ol>

    </div>

</section>
