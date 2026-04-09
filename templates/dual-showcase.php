<?php defined( 'ABSPATH' ) || exit;

$comp_args = array(
    'post_type'      => 'si_portfolio',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'meta_query'     => array(
        array(
            'key'     => '_si_project_type',
            'value'   => 'composition',
            'compare' => '=',
        ),
    ),
);

$ld_args = array(
    'post_type'      => 'si_portfolio',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'meta_query'     => array(
        array(
            'key'     => '_si_project_type',
            'value'   => 'learning_design',
            'compare' => '=',
        ),
    ),
);

$comp_query = new WP_Query( $comp_args );
$ld_query   = new WP_Query( $ld_args );

$cards = array(
    array(
        'type'    => 'composition',
        'label'   => 'Composition',
        'post'    => $comp_query->have_posts() ? $comp_query->posts[0] : null,
        'default_title'   => 'Bespoke Music',
        'default_excerpt' => 'Music that complements, never overpowers. Hear the work.',
        'cta'     => 'Hear the Work',
        'url'     => '/composition',
    ),
    array(
        'type'    => 'learning_design',
        'label'   => 'Learning Design',
        'post'    => $ld_query->have_posts() ? $ld_query->posts[0] : null,
        'default_title'   => 'Learning Experiences',
        'default_excerpt' => 'Eight years. A Gold Stevie Award. Learning that actually works.',
        'cta'     => 'See the Project',
        'url'     => '/learning-design',
    ),
);
?>

<section class="si-scope si-dual-showcase" aria-label="Featured Work">
    <div class="si-dual-showcase__inner">

        <?php foreach ( $cards as $card ) :
            $post     = $card['post'];
            $raw_title = $post ? get_the_title( $post )   : $card['default_title'];
            $title     = wp_trim_words( $raw_title, 9, '&hellip;' );
            $excerpt   = $post ? get_the_excerpt( $post ) : $card['default_excerpt'];
            $thumb    = $post ? get_the_post_thumbnail_url( $post, 'large' ) : '';
            $link     = $post ? get_permalink( $post )    : $card['url'];
        ?>
        <article class="si-dual-showcase__card si-reveal" aria-label="<?php echo esc_attr( $card['label'] ); ?>">

            <div class="si-dual-showcase__thumb si-dual-showcase__thumb--<?php echo esc_attr( $card['type'] ); ?>">
                <?php if ( $thumb ) : ?>
                <img src="<?php echo esc_url( $thumb ); ?>" alt="" loading="lazy" decoding="async">
                <?php endif; ?>
                <div class="si-dual-showcase__thumb-overlay"></div>
            </div>

            <div class="si-dual-showcase__body">
                <span class="si-dual-showcase__label"><?php echo esc_html( $card['label'] ); ?></span>
                <h3 class="si-dual-showcase__title"><?php echo esc_html( $title ); ?></h3>
                <p class="si-dual-showcase__excerpt"><?php echo esc_html( $excerpt ); ?></p>
                <a href="<?php echo esc_url( $link ); ?>" class="si-btn si-btn--ghost si-dual-showcase__cta">
                    <?php echo esc_html( $card['cta'] ); ?>
                    <svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>

        </article>
        <?php endforeach; ?>

    </div>
</section>
