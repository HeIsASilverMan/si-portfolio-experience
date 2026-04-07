<?php defined( 'ABSPATH' ) || exit;

$cards = array(
    array(
        'title' => 'Research &amp; Strategy',
        'body'  => 'I start by understanding your learners &mdash; their context, motivations, and what genuine understanding looks like for them. Only then does design begin.',
        'icon'  => '<svg width="36" height="36" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="16" cy="16" r="10"/><path d="M24 24l6 6"/><path d="M13 16h6M16 13v6"/></svg>',
    ),
    array(
        'title' => 'Design &amp; Develop',
        'body'  => 'Blending cognitive science with visual craft, I build experiences that respect learners&rsquo; time and reward genuine effort &mdash; not just clicks.',
        'icon'  => '<svg width="36" height="36" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="4" y="4" width="28" height="28" rx="4"/><path d="M12 18l4 4 8-8"/></svg>',
    ),
    array(
        'title' => 'Measure &amp; Iterate',
        'body'  => 'Completion rates and quiz scores tell part of the story. I look for evidence of behaviour change, and use that data to refine until it&rsquo;s right.',
        'icon'  => '<svg width="36" height="36" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M6 28l7-8 6 4 11-14"/><circle cx="6" cy="28" r="2" fill="currentColor"/><circle cx="13" cy="20" r="2" fill="currentColor"/><circle cx="19" cy="24" r="2" fill="currentColor"/><circle cx="30" cy="10" r="2" fill="currentColor"/></svg>',
    ),
);
?>

<section class="si-scope si-approach-cards" id="si-approach-cards" aria-labelledby="si-approach-heading">

    <div class="si-approach-cards__inner">

        <div class="si-approach-cards__header si-reveal">
            <p class="si-approach-cards__label">My Approach</p>
            <h2 id="si-approach-heading" class="si-approach-cards__heading">How I design learning that works</h2>
        </div>

        <ul class="si-approach-cards__grid si-reveal-group" role="list">
            <?php foreach ( $cards as $i => $card ) : ?>
            <li class="si-approach-card si-reveal" style="--card-i: <?php echo esc_attr( $i ); ?>;">

                <div class="si-approach-card__icon" aria-hidden="true">
                    <?php echo $card['icon']; ?>
                </div>

                <h3 class="si-approach-card__title"><?php echo wp_kses( $card['title'], array() ); ?></h3>
                <p class="si-approach-card__body"><?php echo wp_kses( $card['body'], array() ); ?></p>

            </li>
            <?php endforeach; ?>
        </ul>

    </div>

</section>
