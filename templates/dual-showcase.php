<?php defined( 'ABSPATH' ) || exit;

// ── Composition: top 3 tracks with audio files ───────────
$comp_args = array(
    'post_type'      => 'si_portfolio',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'meta_query'     => array(
        'relation' => 'AND',
        array(
            'key'   => '_si_project_type',
            'value' => 'composition',
        ),
        array(
            'key'     => '_si_audio_file',
            'value'   => '',
            'compare' => '!=',
        ),
    ),
    'orderby' => 'menu_order date',
    'order'   => 'ASC',
);
$comp_query = new WP_Query( $comp_args );

// ── Learning Design: up to 9 posts ────────────────────────
$ld_args = array(
    'post_type'      => 'si_portfolio',
    'posts_per_page' => 9,
    'post_status'    => 'publish',
    'meta_query'     => array(
        array(
            'key'   => '_si_project_type',
            'value' => 'learning_design',
        ),
    ),
    'orderby' => 'menu_order date',
    'order'   => 'ASC',
);
$ld_query = new WP_Query( $ld_args );
?>

<section class="si-scope si-dual-showcase" aria-label="Featured Work">
    <?php $variant = 'subtle'; include SI_PLUGIN_DIR . 'templates/partials/stave-motif.php'; ?>
    <div class="si-dual-showcase__inner">

        <!-- ── Composition card ───────────────────────────── -->
        <article class="si-dual-showcase__card si-dual-showcase__card--comp si-reveal" aria-label="Composition">
            <div class="si-dual-showcase__body">

                <span class="si-dual-showcase__label"><?php esc_html_e( 'Composition', 'si-portfolio' ); ?></span>
                <h3 class="si-dual-showcase__title"><?php esc_html_e( 'Every project deserves its own sound', 'si-portfolio' ); ?></h3>
                <p class="si-dual-showcase__sub"><?php esc_html_e( 'No templates. No stock. Bespoke music for every brief.', 'si-portfolio' ); ?></p>

                <?php if ( $comp_query->have_posts() ) : ?>
                <div class="si-home-players">
                    <?php
                    $pi = 0;
                    while ( $comp_query->have_posts() ) :
                        $comp_query->the_post();
                        $c_audio = get_post_meta( get_the_ID(), '_si_audio_file', true );
                        $c_title = get_the_title();
                        if ( ! $c_audio ) { continue; }
                        $pi++;
                    ?>
                    <div class="si-home-player" data-si-home-player>

                        <audio data-si-home-audio
                               src="<?php echo esc_url( $c_audio ); ?>"
                               preload="none"
                               aria-hidden="true"></audio>

                        <button class="si-home-player__btn" data-si-home-play
                                aria-label="<?php echo esc_attr( sprintf( __( 'Play %s', 'si-portfolio' ), $c_title ) ); ?>">
                            <svg class="si-play-icon" viewBox="0 0 24 24" fill="currentColor" width="18" height="18" aria-hidden="true">
                                <path d="M8 5.14v14l11-7-11-7z"/>
                            </svg>
                            <svg class="si-pause-icon" viewBox="0 0 24 24" fill="currentColor" width="18" height="18" aria-hidden="true">
                                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                            </svg>
                        </button>

                        <div class="si-home-player__track">
                            <span class="si-home-player__title"><?php echo esc_html( $c_title ); ?></span>
                            <div class="si-home-player__bar" aria-hidden="true">
                                <div class="si-home-player__fill" data-si-home-fill></div>
                            </div>
                        </div>

                        <span class="si-home-player__time" data-si-home-time aria-live="off">0:00</span>

                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
                <?php endif; ?>

                <a href="/composition" class="si-btn si-btn--ghost si-dual-showcase__cta">
                    <?php esc_html_e( 'Hear the full portfolio', 'si-portfolio' ); ?>
                    <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>

            </div>
        </article>

        <!-- ── Learning Design card (entire card = link) ──── -->
        <a class="si-dual-showcase__card si-dual-showcase__card--ld si-reveal"
           href="/learning-design#si-portfolio-grid"
           aria-label="<?php esc_attr_e( 'Learning Design portfolio', 'si-portfolio' ); ?>">

            <div class="si-dual-showcase__body">

                <span class="si-dual-showcase__label"><?php esc_html_e( 'Learning Design', 'si-portfolio' ); ?></span>

                <?php if ( $ld_query->have_posts() ) : ?>
                <div class="si-dual-showcase__grid" aria-hidden="true">
                    <?php
                    $ld_count = 0;
                    while ( $ld_query->have_posts() && $ld_count < 9 ) :
                        $ld_query->the_post();
                        $ld_count++;
                        $ld_thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                    ?>
                    <div class="si-dual-showcase__grid-item">
                        <?php if ( $ld_thumb ) : ?>
                        <img src="<?php echo esc_url( $ld_thumb ); ?>" alt="" loading="lazy" decoding="async">
                        <?php endif; ?>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
                <?php endif; ?>

                <p class="si-dual-showcase__cta-line">
                    <?php esc_html_e( 'See the Portfolio', 'si-portfolio' ); ?>
                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </p>

            </div>
        </a>

    </div>
</section>
