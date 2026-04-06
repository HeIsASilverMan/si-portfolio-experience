<?php defined( 'ABSPATH' ) || exit;

$steps = array(
    array(
        'title'  => 'Brief',
        'label'  => '01',
        'body'   => 'Tell me your vision, your audience, and the feeling you&rsquo;re after. The more I know, the better the music.',
    ),
    array(
        'title'  => 'Research',
        'label'  => '02',
        'body'   => 'I immerse myself in your project &mdash; watching cuts, studying references, absorbing the world you&rsquo;re building.',
    ),
    array(
        'title'  => 'Compose',
        'label'  => '03',
        'body'   => 'Iterative drafts with your feedback woven in. Nothing goes forward without your sign-off.',
    ),
    array(
        'title'  => 'Refine',
        'label'  => '04',
        'body'   => 'We tighten, polish, and finesse until the music feels inevitable &mdash; like it could never have been anything else.',
    ),
    array(
        'title'  => 'Deliver',
        'label'  => '05',
        'body'   => 'Master-quality files in every format you need: stems, mixes, sync-ready tracks, whatever the brief requires.',
    ),
);
?>

<section class="si-scope si-process-timeline" id="si-process-timeline" aria-labelledby="si-process-heading">

    <div class="si-process-timeline__inner">

        <div class="si-process-timeline__header si-reveal">
            <p class="si-process-timeline__label">The Process</p>
            <h2 id="si-process-heading" class="si-process-timeline__heading">How we get from brief to brilliant</h2>
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
                    <p class="si-process-timeline__desc"><?php echo wp_kses( $step['body'], array() ); ?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>

    </div>

</section>
