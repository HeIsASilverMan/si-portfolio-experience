<?php defined( 'ABSPATH' ) || exit;

$query = new WP_Query( array(
    'post_type'      => 'si_portfolio',
    'posts_per_page' => 12,
    'meta_query'     => array(
        array(
            'key'   => '_si_project_type',
            'value' => 'composition',
        ),
    ),
    'orderby' => 'menu_order date',
    'order'   => 'ASC',
) );
?>

<section class="si-scope si-audio-showcase" id="si-audio-showcase" aria-labelledby="si-audio-heading">

    <div class="si-audio-showcase__inner">

        <div class="si-audio-showcase__header si-reveal">
            <p class="si-audio-showcase__label">Portfolio</p>
            <h2 id="si-audio-heading" class="si-audio-showcase__heading">Hear the Work</h2>
        </div>

        <?php if ( $query->have_posts() ) : ?>

        <div class="si-audio-showcase__grid">
            <?php while ( $query->have_posts() ) : $query->the_post();
                $audio_url   = get_post_meta( get_the_ID(), '_si_audio_file', true );
                $client_name = get_post_meta( get_the_ID(), '_si_client_name', true );
                $year        = get_post_meta( get_the_ID(), '_si_year', true );
                $player_id   = 'si-player-' . get_the_ID();
            ?>
            <article class="si-audio-card si-reveal" aria-label="<?php echo esc_attr( get_the_title() ); ?>">

                <div class="si-audio-card__player" data-player-id="<?php echo esc_attr( $player_id ); ?>">

                    <?php if ( $audio_url ) : ?>
                    <audio class="si-audio-card__audio"
                           src="<?php echo esc_url( $audio_url ); ?>"
                           preload="none"
                           aria-label="<?php echo esc_attr( get_the_title() ); ?>"></audio>
                    <?php endif; ?>

                    <button class="si-audio-card__play-btn"
                            aria-label="Play <?php echo esc_attr( get_the_title() ); ?>"
                            <?php if ( ! $audio_url ) : ?>disabled aria-disabled="true"<?php endif; ?>>
                        <svg class="si-play-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" width="22" height="22">
                            <path d="M8 5.14v14l11-7-11-7z"/>
                        </svg>
                        <svg class="si-pause-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" width="22" height="22">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                        </svg>
                    </button>

                    <div class="si-audio-card__waveform" aria-hidden="true">
                        <?php
                        $bar_heights = array( 40, 60, 80, 55, 90, 70, 45, 85, 65, 50, 75, 95, 55, 70, 40, 85, 60, 75, 50, 88, 65, 45, 80, 58, 72, 48, 90, 62, 78, 42 );
                        foreach ( $bar_heights as $h ) :
                        ?>
                        <span class="si-audio-card__bar" style="height: <?php echo esc_attr( $h ); ?>%"></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="si-audio-card__progress-wrap">
                        <div class="si-audio-card__progress-bg">
                            <div class="si-audio-card__progress-bar"></div>
                        </div>
                        <div class="si-audio-card__time">
                            <span class="si-audio-card__current">0:00</span>
                            <span class="si-audio-card__duration">--:--</span>
                        </div>
                    </div>

                </div>

                <div class="si-audio-card__meta">
                    <?php if ( $client_name || $year ) : ?>
                    <p class="si-audio-card__credit">
                        <?php if ( $client_name ) : ?>
                        <span><?php echo esc_html( $client_name ); ?></span>
                        <?php endif; ?>
                        <?php if ( $year ) : ?>
                        <span class="si-audio-card__year"><?php echo esc_html( $year ); ?></span>
                        <?php endif; ?>
                    </p>
                    <?php endif; ?>
                    <p class="si-audio-card__description"><?php echo esc_html( has_excerpt() ? get_the_excerpt() : get_the_title() ); ?></p>
                </div>

            </article>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>

        <?php else : ?>

        <div class="si-audio-showcase__empty si-reveal">
            <p>Audio samples coming soon &mdash; check back shortly.</p>
        </div>

        <?php endif; ?>

    </div>

</section>
