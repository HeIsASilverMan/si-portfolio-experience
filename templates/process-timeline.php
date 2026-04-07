<?php defined( 'ABSPATH' ) || exit;

$steps = array(
    array(
        'label' => '01',
        'title' => SI_Settings::get( 'step_1_title' ),
        'body'  => SI_Settings::get( 'step_1_body' ),
    ),
    array(
        'label' => '02',
        'title' => SI_Settings::get( 'step_2_title' ),
        'body'  => SI_Settings::get( 'step_2_body' ),
    ),
    array(
        'label' => '03',
        'title' => SI_Settings::get( 'step_3_title' ),
        'body'  => SI_Settings::get( 'step_3_body' ),
    ),
    array(
        'label' => '04',
        'title' => SI_Settings::get( 'step_4_title' ),
        'body'  => SI_Settings::get( 'step_4_body' ),
    ),
    array(
        'label' => '05',
        'title' => SI_Settings::get( 'step_5_title' ),
        'body'  => SI_Settings::get( 'step_5_body' ),
    ),
);

$label   = SI_Settings::get( 'process_label' );
$heading = SI_Settings::get( 'process_heading' );
?>

<section class="si-scope si-process-timeline" id="si-process-timeline" aria-labelledby="si-process-heading">

    <div class="si-process-timeline__inner">

        <div class="si-process-timeline__header si-reveal">
            <p class="si-process-timeline__label"><?php echo esc_html( $label ); ?></p>
            <h2 id="si-process-heading" class="si-process-timeline__heading"><?php echo esc_html( $heading ); ?></h2>
        </div>

        <ol class="si-process-timeline__steps" role="list">
            <?php foreach ( $steps as $i => $step ) : ?>
            <li class="si-process-timeline__step si-reveal" style="--step-i: <?php echo esc_attr( $i ); ?>;">
                <div class="si-process-timeline__connector" aria-hidden="true">
                    <div class="si-process-timeline__dot"></div>
                    <?php if ( $i < count( $steps ) - 1 ) : ?>
                    <div class="si-process-timeline__line"></div>
                    <?php endif; ?>
                </div>
                <div class="si-process-timeline__body">
                    <span class="si-process-timeline__num" aria-hidden="true"><?php echo esc_html( $step['label'] ); ?></span>
                    <h3 class="si-process-timeline__title"><?php echo esc_html( $step['title'] ); ?></h3>
                    <p class="si-process-timeline__desc"><?php echo esc_html( $step['body'] ); ?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>

    </div>

</section>
