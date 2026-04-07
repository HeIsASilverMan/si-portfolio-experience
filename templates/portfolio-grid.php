<?php defined( 'ABSPATH' ) || exit;

/*
 * Variables available from shortcode:
 *   $project_type  (string) – 'learning_design' or 'composition'
 */
if ( ! isset( $project_type ) ) {
    $project_type = 'learning_design';
}

$query = new WP_Query( array(
    'post_type'      => 'si_portfolio',
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'   => '_si_project_type',
            'value' => sanitize_text_field( $project_type ),
        ),
    ),
    'orderby' => 'menu_order date',
    'order'   => 'ASC',
) );

// Collect all taxonomy terms used by these posts for filter pills.
$filter_terms = array();
if ( $query->have_posts() ) {
    foreach ( $query->posts as $p ) {
        $terms = get_the_terms( $p->ID, 'si_portfolio_cat' );
        if ( $terms && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $filter_terms[ $term->slug ] = $term->name;
            }
        }
    }
}
?>

<section class="si-scope si-portfolio-grid-section" id="si-portfolio-grid" aria-labelledby="si-portfolio-heading">

    <div class="si-portfolio-grid-section__inner">

        <div class="si-portfolio-grid-section__header si-reveal">
            <p class="si-portfolio-grid-section__label">Portfolio</p>
            <h2 id="si-portfolio-heading" class="si-portfolio-grid-section__heading">Learning Experiences That Stick</h2>
        </div>

        <?php if ( ! empty( $filter_terms ) ) : ?>
        <div class="si-portfolio-filter" role="group" aria-label="Filter projects by category">
            <button class="si-portfolio-filter__pill si-portfolio-filter__pill--active"
                    data-filter="all"
                    aria-pressed="true">All</button>
            <?php foreach ( $filter_terms as $slug => $name ) : ?>
            <button class="si-portfolio-filter__pill"
                    data-filter="<?php echo esc_attr( $slug ); ?>"
                    aria-pressed="false"><?php echo esc_html( $name ); ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ( $query->have_posts() ) : ?>

        <div class="si-portfolio-grid" id="si-portfolio-grid-cards">
            <?php
            $post_ids = array();
            while ( $query->have_posts() ) :
                $query->the_post();
                $post_id    = get_the_ID();
                $post_ids[] = $post_id;
                $tools_raw  = get_post_meta( $post_id, '_si_tools_used', true );
                $tools_arr  = $tools_raw ? array_map( 'trim', explode( ',', $tools_raw ) ) : array();
                $client     = get_post_meta( $post_id, '_si_client_name', true );
                $year       = get_post_meta( $post_id, '_si_year', true );
                $ext_url    = get_post_meta( $post_id, '_si_external_url', true );

                // Taxonomy terms for this post (for data-cats attribute).
                $post_terms     = get_the_terms( $post_id, 'si_portfolio_cat' );
                $post_term_slugs = '';
                if ( $post_terms && ! is_wp_error( $post_terms ) ) {
                    $slugs           = wp_list_pluck( $post_terms, 'slug' );
                    $post_term_slugs = implode( ' ', $slugs );
                }

                $thumb_url = '';
                if ( has_post_thumbnail() ) {
                    $thumb_url = get_the_post_thumbnail_url( $post_id, 'large' );
                }
            ?>
            <article class="si-project-card si-reveal"
                     data-modal-target="si-modal-<?php echo esc_attr( $post_id ); ?>"
                     data-cats="<?php echo esc_attr( $post_term_slugs ); ?>"
                     tabindex="0"
                     role="button"
                     aria-label="View project: <?php echo esc_attr( get_the_title() ); ?>">

                <div class="si-project-card__thumb">
                    <?php if ( $thumb_url ) : ?>
                    <img src="<?php echo esc_url( $thumb_url ); ?>"
                         alt="<?php echo esc_attr( get_the_title() ); ?>"
                         loading="lazy"
                         class="si-project-card__img">
                    <?php else : ?>
                    <div class="si-project-card__thumb-placeholder" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                            <rect width="48" height="48" rx="8" fill="currentColor" opacity="0.1"/>
                            <path d="M12 36l9-12 7 9 5-6 8 9H12z" fill="currentColor" opacity="0.3"/>
                            <circle cx="32" cy="18" r="4" fill="currentColor" opacity="0.3"/>
                        </svg>
                    </div>
                    <?php endif; ?>
                    <div class="si-project-card__overlay" aria-hidden="true">
                        <span class="si-project-card__cta">View Project &rarr;</span>
                    </div>
                </div>

                <div class="si-project-card__body">
                    <h3 class="si-project-card__title"><?php the_title(); ?></h3>
                    <?php if ( has_excerpt() ) : ?>
                    <p class="si-project-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $tools_arr ) ) : ?>
                    <ul class="si-project-card__tools" aria-label="Tools used" role="list">
                        <?php foreach ( $tools_arr as $tool ) : ?>
                        <li class="si-project-card__tool-badge"><?php echo esc_html( $tool ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>

            </article>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>

        <?php else : ?>
        <div class="si-portfolio-grid__empty si-reveal">
            <p>Portfolio projects coming soon &mdash; check back shortly.</p>
        </div>
        <?php endif; ?>

    </div>

</section>

<?php
// ── Pre-rendered modal content (hidden) ─────────────────────────
// Re-run the query to render hidden content divs for JS to clone into the modal.
$query->rewind_posts();
if ( $query->have_posts() ) :
    while ( $query->have_posts() ) :
        $query->the_post();
        $post_id    = get_the_ID();
        $challenge  = get_post_meta( $post_id, '_si_challenge', true );
        $approach   = get_post_meta( $post_id, '_si_approach', true );
        $outcome    = get_post_meta( $post_id, '_si_outcome', true );
        $tools_raw  = get_post_meta( $post_id, '_si_tools_used', true );
        $tools_arr  = $tools_raw ? array_map( 'trim', explode( ',', $tools_raw ) ) : array();
        $client     = get_post_meta( $post_id, '_si_client_name', true );
        $year       = get_post_meta( $post_id, '_si_year', true );
        $ext_url    = get_post_meta( $post_id, '_si_external_url', true );
        $thumb_url  = has_post_thumbnail() ? get_the_post_thumbnail_url( $post_id, 'full' ) : '';

        $post_terms      = get_the_terms( $post_id, 'si_portfolio_cat' );
        $post_term_names = array();
        if ( $post_terms && ! is_wp_error( $post_terms ) ) {
            $post_term_names = wp_list_pluck( $post_terms, 'name' );
        }
?>
<div id="si-modal-<?php echo esc_attr( $post_id ); ?>" class="si-modal-data" hidden aria-hidden="true">

    <?php if ( $thumb_url ) : ?>
    <div class="si-modal-data__image">
        <img src="<?php echo esc_url( $thumb_url ); ?>"
             alt="<?php echo esc_attr( get_the_title() ); ?>"
             loading="lazy">
    </div>
    <?php endif; ?>

    <div class="si-modal-data__content">

        <?php if ( ! empty( $post_term_names ) ) : ?>
        <ul class="si-modal-data__cats" aria-label="Categories" role="list">
            <?php foreach ( $post_term_names as $term_name ) : ?>
            <li class="si-modal-data__cat"><?php echo esc_html( $term_name ); ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <h2 class="si-modal-data__title"><?php the_title(); ?></h2>

        <?php if ( $client || $year ) : ?>
        <p class="si-modal-data__meta">
            <?php if ( $client ) : ?>
            <span><?php echo esc_html( $client ); ?></span>
            <?php endif; ?>
            <?php if ( $year ) : ?>
            <span class="si-modal-data__year"><?php echo esc_html( $year ); ?></span>
            <?php endif; ?>
        </p>
        <?php endif; ?>

        <?php if ( $challenge ) : ?>
        <div class="si-modal-data__section">
            <h3 class="si-modal-data__section-heading">The Challenge</h3>
            <div class="si-modal-data__section-body"><?php echo wpautop( esc_html( $challenge ) ); ?></div>
        </div>
        <?php endif; ?>

        <?php if ( $approach ) : ?>
        <div class="si-modal-data__section">
            <h3 class="si-modal-data__section-heading">The Approach</h3>
            <div class="si-modal-data__section-body"><?php echo wpautop( esc_html( $approach ) ); ?></div>
        </div>
        <?php endif; ?>

        <?php if ( $outcome ) : ?>
        <div class="si-modal-data__section">
            <h3 class="si-modal-data__section-heading">The Outcome</h3>
            <div class="si-modal-data__section-body"><?php echo wpautop( esc_html( $outcome ) ); ?></div>
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $tools_arr ) ) : ?>
        <div class="si-modal-data__section">
            <h3 class="si-modal-data__section-heading">Tools Used</h3>
            <ul class="si-modal-data__tools" role="list">
                <?php foreach ( $tools_arr as $tool ) : ?>
                <li class="si-modal-data__tool"><?php echo esc_html( $tool ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ( $ext_url ) : ?>
        <div class="si-modal-data__actions">
            <a href="<?php echo esc_url( $ext_url ); ?>"
               class="si-btn si-btn--primary"
               target="_blank"
               rel="noopener noreferrer">
                Launch Project <span class="si-btn__arrow" aria-hidden="true">&rarr;</span>
            </a>
        </div>
        <?php endif; ?>

    </div>

</div>
<?php
    endwhile;
    wp_reset_postdata();
endif;
?>

<!-- ── Modal Shell ────────────────────────────────────────────── -->
<div class="si-scope si-project-modal"
     id="si-project-modal"
     role="dialog"
     aria-modal="true"
     aria-labelledby="si-modal-title"
     aria-hidden="true"
     hidden>

    <div class="si-project-modal__backdrop" id="si-modal-backdrop" aria-hidden="true"></div>

    <div class="si-project-modal__box" role="document">

        <button class="si-project-modal__close"
                id="si-modal-close"
                aria-label="Close project modal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>

        <div class="si-project-modal__body" id="si-modal-body">
            <!-- JS populates this from the hidden .si-modal-data divs -->
        </div>

        <div class="si-project-modal__nav" aria-label="Project navigation">
            <button class="si-project-modal__nav-btn si-project-modal__nav-btn--prev"
                    id="si-modal-prev"
                    aria-label="Previous project">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
                <span>Previous</span>
            </button>
            <button class="si-project-modal__nav-btn si-project-modal__nav-btn--next"
                    id="si-modal-next"
                    aria-label="Next project">
                <span>Next</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
        </div>

    </div>

</div>
