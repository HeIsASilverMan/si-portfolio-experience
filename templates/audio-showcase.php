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

$bar_heights = array( 30, 55, 80, 45, 90, 60, 75, 40, 85, 65, 50, 95, 55, 70, 38, 82, 60, 72, 48, 88, 62, 44, 78, 56, 70, 46, 92, 58, 76, 40 );
?>

<section class="si-scope si-audio-showcase" id="si-audio-showcase" aria-labelledby="si-audio-heading">

    <div class="si-audio-showcase__inner">

        <div class="si-audio-showcase__header si-reveal">
            <p class="si-audio-showcase__label">Portfolio</p>
            <h2 id="si-audio-heading" class="si-audio-showcase__heading">Hear the Work</h2>
            <p class="si-audio-showcase__sub">Original compositions across film, games, e-learning and commercial projects.</p>
        </div>

        <?php if ( $query->have_posts() ) : ?>

        <div class="si-audio-showcase__grid si-reveal-group">
            <?php while ( $query->have_posts() ) : $query->the_post();
                $audio_url   = get_post_meta( get_the_ID(), '_si_audio_file', true );
                $client_name = get_post_meta( get_the_ID(), '_si_client_name', true );
                $year        = get_post_meta( get_the_ID(), '_si_year', true );
                $genre       = get_post_meta( get_the_ID(), '_si_project_genre', true );
                $has_thumb   = has_post_thumbnail();
                $thumb_url   = $has_thumb ? get_the_post_thumbnail_url( get_the_ID(), 'medium' ) : '';
            ?>
            <article class="si-audio-card si-reveal" aria-label="<?php echo esc_attr( get_the_title() ); ?>">

                <?php if ( $audio_url ) : ?>
                <audio class="si-audio-card__audio"
                       src="<?php echo esc_url( $audio_url ); ?>"
                       preload="none"
                       aria-label="<?php echo esc_attr( get_the_title() ); ?>"></audio>
                <?php endif; ?>

                <!-- Top row: optional thumb + title/meta + play btn -->
                <div class="si-audio-card__header">

                    <?php if ( $thumb_url ) : ?>
                    <div class="si-audio-card__thumb" aria-hidden="true">
                        <img src="<?php echo esc_url( $thumb_url ); ?>" alt="" loading="lazy" decoding="async">
                    </div>
                    <?php endif; ?>

                    <div class="si-audio-card__info">
                        <h3 class="si-audio-card__title"><?php the_title(); ?></h3>
                        <?php if ( $client_name || $year ) : ?>
                        <p class="si-audio-card__credit">
                            <?php if ( $client_name ) : ?><span><?php echo esc_html( $client_name ); ?></span><?php endif; ?>
                            <?php if ( $client_name && $year ) : ?><span class="si-audio-card__sep" aria-hidden="true">&middot;</span><?php endif; ?>
                            <?php if ( $year ) : ?><span class="si-audio-card__year"><?php echo esc_html( $year ); ?></span><?php endif; ?>
                        </p>
                        <?php endif; ?>
                        <?php if ( has_excerpt() ) : ?>
                        <p class="si-audio-card__description"><?php echo esc_html( get_the_excerpt() ); ?></p>
                        <?php endif; ?>
                        <?php if ( $genre ) : ?>
                        <span class="si-audio-card__genre"><?php echo esc_html( $genre ); ?></span>
                        <?php endif; ?>
                    </div>

                    <button class="si-audio-card__play-btn"
                            aria-label="<?php echo esc_attr( get_the_title() ); ?>"
                            <?php if ( ! $audio_url ) : ?>disabled aria-disabled="true"<?php endif; ?>>
                        <svg class="si-play-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" width="20" height="20">
                            <path d="M8 5.14v14l11-7-11-7z"/>
                        </svg>
                        <svg class="si-pause-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" width="20" height="20">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                        </svg>
                    </button>

                </div>

                <!-- Bottom row: waveform + scrubber + time -->
                <div class="si-audio-card__track">

                    <div class="si-audio-card__waveform" aria-hidden="true">
                        <?php foreach ( $bar_heights as $h ) : ?>
                        <span class="si-audio-card__bar" style="height: <?php echo esc_attr( $h ); ?>%"></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="si-audio-card__progress-bg" role="slider" aria-label="Playback position" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" tabindex="0">
                        <div class="si-audio-card__progress-bar"></div>
                    </div>

                    <div class="si-audio-card__time" aria-live="off">
                        <span class="si-audio-card__current">0:00</span>
                        <span class="si-audio-card__duration">--:--</span>
                    </div>

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
