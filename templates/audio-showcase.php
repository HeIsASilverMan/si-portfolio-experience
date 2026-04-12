<?php defined( 'ABSPATH' ) || exit;

$query = new WP_Query( array(
    'post_type'      => 'si_portfolio',
    'posts_per_page' => 20,
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

        <div class="si-audio-player si-reveal" id="si-audio-player">

            <!-- ── Featured Stage ─────────────────────────────── -->
            <div class="si-audio-stage" id="si-audio-stage">

                <!-- Blurred background (populated by JS from active track thumb) -->
                <div class="si-audio-stage__bg" id="si-stage-bg" aria-hidden="true"></div>

                <div class="si-audio-stage__body">

                    <!-- Left: genre tag + description/brief -->
                    <div class="si-audio-stage__meta">
                        <span class="si-audio-stage__genre" id="si-stage-genre"></span>
                        <p class="si-audio-stage__description" id="si-stage-desc"><?php esc_html_e( 'Choose a track from the list below to hear the work and read about the brief it was composed for.', 'si-portfolio' ); ?></p>
                    </div>

                    <!-- Right: waveform + controls -->
                    <div class="si-audio-stage__right">

                        <div class="si-audio-stage__waveform" id="si-stage-waveform" aria-hidden="true">
                            <?php
                            /* Static seed bars — 80 bars, JS replaces on load */
                            $seed_heights = array( 30,55,80,45,90,60,75,40,85,65,50,95,55,70,38,82,
                                                   60,72,48,88,62,44,78,56,70,46,92,58,76,40,52,84,
                                                   38,68,90,44,72,58,80,36,64,88,48,76,54,82,40,66,
                                                   35,72,50,88,60,42,78,55,80,45,90,62,48,75,38,84,
                                                   52,70,44,86,58,40,76,52,88,48,65,80,42,70,56,90 );
                            foreach ( $seed_heights as $h ) :
                            ?>
                            <span style="height: <?php echo esc_attr( $h ); ?>%"></span>
                            <?php endforeach; ?>
                        </div>

                        <div class="si-audio-stage__controls">

                            <button class="si-audio-stage__play-btn" id="si-stage-play" aria-label="<?php esc_attr_e( 'Play', 'si-portfolio' ); ?>">
                                <svg class="si-play-icon" viewBox="0 0 24 24" fill="currentColor" width="24" height="24" aria-hidden="true">
                                    <path d="M8 5.14v14l11-7-11-7z"/>
                                </svg>
                                <svg class="si-pause-icon" viewBox="0 0 24 24" fill="currentColor" width="24" height="24" aria-hidden="true">
                                    <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                                </svg>
                            </button>

                            <div class="si-audio-stage__scrub-wrap">
                                <div class="si-audio-stage__scrub" id="si-stage-scrub" role="slider" aria-label="<?php esc_attr_e( 'Playback position', 'si-portfolio' ); ?>" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" tabindex="0">
                                    <div class="si-audio-stage__scrub-fill" id="si-stage-fill"></div>
                                    <div class="si-audio-stage__scrub-thumb" id="si-stage-thumb"></div>
                                </div>
                                <div class="si-audio-stage__time">
                                    <span id="si-stage-current">0:00</span>
                                    <span id="si-stage-duration">--:--</span>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- /.si-audio-stage -->

            <!-- ── Track List ─────────────────────────────────── -->
            <div class="si-audio-tracklist" id="si-tracklist" role="list" aria-label="<?php esc_attr_e( 'Composition portfolio tracks', 'si-portfolio' ); ?>">

                <?php
                $track_num = 0;
                while ( $query->have_posts() ) :
                    $query->the_post();
                    $track_num++;
                    $audio_url   = get_post_meta( get_the_ID(), '_si_audio_file', true );
                    $client_name = get_post_meta( get_the_ID(), '_si_client_name', true );
                    $year        = get_post_meta( get_the_ID(), '_si_year', true );
                    $genre       = get_post_meta( get_the_ID(), '_si_project_genre', true );
                    $thumb_url   = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'medium' ) : '';
                    $description = get_post_meta( get_the_ID(), '_si_brief', true );
                    if ( ! $description ) {
                        $description = has_excerpt() ? get_the_excerpt() : '';
                    }
                    $num_str     = str_pad( $track_num, 2, '0', STR_PAD_LEFT );
                ?>
                <div class="si-track-item"
                     role="listitem"
                     tabindex="0"
                     data-title="<?php echo esc_attr( get_the_title() ); ?>"
                     data-client="<?php echo esc_attr( $client_name ); ?>"
                     data-year="<?php echo esc_attr( $year ); ?>"
                     data-genre="<?php echo esc_attr( $genre ); ?>"
                     data-thumb="<?php echo esc_url( $thumb_url ); ?>"
                     data-description="<?php echo esc_attr( $description ); ?>"
                     <?php if ( ! $audio_url ) : ?>data-no-audio="true"<?php endif; ?>
                     aria-label="<?php echo esc_attr( get_the_title() ); ?>">

                    <?php if ( $audio_url ) : ?>
                    <audio class="si-track-audio"
                           src="<?php echo esc_url( $audio_url ); ?>"
                           preload="none"
                           aria-hidden="true"></audio>
                    <?php endif; ?>

                    <span class="si-track-item__num" aria-hidden="true"><?php echo esc_html( $num_str ); ?></span>

                    <div class="si-track-item__info">
                        <span class="si-track-item__title"><?php the_title(); ?></span>
                        <?php if ( $description ) : ?>
                        <span class="si-track-item__brief"><?php echo esc_html( wp_trim_words( $description, 14, '&hellip;' ) ); ?></span>
                        <?php endif; ?>
                    </div>

                    <span class="si-track-item__dur" aria-label="Duration"></span>

                    <div class="si-track-item__indicator" aria-hidden="true">
                        <span></span><span></span><span></span><span></span>
                    </div>

                </div>
                <?php endwhile;
                wp_reset_postdata(); ?>

            </div><!-- /.si-audio-tracklist -->

        </div><!-- /.si-audio-player -->

        <?php else : ?>

        <div class="si-audio-showcase__empty si-reveal">
            <p>Audio samples coming soon &mdash; check back shortly.</p>
        </div>

        <?php endif; ?>

    </div>

</section>
