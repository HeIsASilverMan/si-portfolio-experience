<?php defined( 'ABSPATH' ) || exit;

$steps = array(
    array(
        'title' => 'Discovery',
        'body'  => "You get in touch and tell me about the project. Once we're talking seriously about a commission, I send over the Thread Finder &mdash; a set of questions built to surface the thread, not just tick off a brief.",
    ),
    array(
        'title' => 'Locate the thread',
        'body'  => 'I tell you, in plain language, what I think the thread is before writing anything.',
    ),
    array(
        'title' => 'Concept track',
        'body'  => 'A short, rough sketch built entirely from that thread.',
    ),
    array(
        'title' => 'Sign-off',
        'body'  => 'We adjust or confirm before anything else moves forward.',
    ),
    array(
        'title' => 'Full production',
        'body'  => 'The whole soundtrack is built outward from the same thread.',
    ),
    array(
        'title' => 'Delivery',
        'body'  => 'Final mixes, stems, and everything in the stack.',
    ),
);
?>

<section class="si-scope si-thread-method" id="si-thread-method" aria-labelledby="si-thread-method-heading">

    <div class="si-thread-method__inner">

        <div class="si-thread-method__header si-reveal">
            <p class="si-thread-method__label"><?php esc_html_e( 'The Thread Method', 'si-portfolio' ); ?></p>
            <p class="si-thread-method__intro">
                <?php echo wp_kses( __( 'Every fictional world has one thing holding it together &mdash; a single thematic thread running under the plot, the characters, the setting. Most game scores get written scene by scene: a battle theme, a town theme, a boss theme, stitched together after the fact. They can be competent and still feel like a playlist rather than a world.', 'si-portfolio' ), array() ); ?>
            </p>
            <p class="si-thread-method__intro">
                <?php echo wp_kses( __( 'The Thread Method starts differently. Before writing a note, I find the thread &mdash; the one idea the whole score can be woven from &mdash; so that every track, however different in tempo or instrumentation, is recognisably part of the same world.', 'si-portfolio' ), array() ); ?>
            </p>
        </div>

        <ol class="si-thread-method__steps" role="list">
            <?php foreach ( $steps as $i => $step ) : ?>
            <li class="si-thread-method__step si-reveal" style="--step-i: <?php echo esc_attr( $i ); ?>;">
                <div class="si-thread-method__connector" aria-hidden="true">
                    <div class="si-thread-method__dot"></div>
                    <?php if ( $i < count( $steps ) - 1 ) : ?>
                    <div class="si-thread-method__line"></div>
                    <?php endif; ?>
                </div>
                <div class="si-thread-method__body">
                    <span class="si-thread-method__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
                    <h3 class="si-thread-method__title"><?php echo esc_html( $step['title'] ); ?></h3>
                    <p class="si-thread-method__desc"><?php echo wp_kses( $step['body'], array() ); ?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>

    </div>

</section>
