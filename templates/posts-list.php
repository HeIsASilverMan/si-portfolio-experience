<?php defined( 'ABSPATH' ) || exit;

$_count    = isset( $atts['count'] )    ? absint( $atts['count'] )    : 12;
$_category = isset( $atts['category'] ) ? sanitize_text_field( $atts['category'] ) : '';
$_label    = isset( $atts['label'] )    ? sanitize_text_field( $atts['label'] )    : 'Handy bits and bobs';
$_heading  = isset( $atts['heading'] )  ? sanitize_text_field( $atts['heading'] )  : 'Built to share';

$_palette = array(
    '#E86E3E', '#4AA8D8', '#9999FF', '#F5A623',
    '#5EB55E', '#D4A853', '#8B5CF6', '#F88379',
    '#7EC89B', '#CC8899', '#40D0FB', '#BE5103',
);

$_query_args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $_count,
    'orderby'        => 'date',
    'order'          => 'DESC',
);
if ( $_category ) {
    $_query_args['category_name'] = $_category;
}
$_posts = new WP_Query( $_query_args );
?>
<section class="si-scope si-posts-list" id="si-posts-list" aria-labelledby="si-posts-list-heading">
    <div class="si-posts-list__inner">

        <div class="si-posts-list__header si-reveal">
            <h1 class="si-tools__headline wp-block-heading" si-reveal="" is-visible"="">Tools</h1>
            <p class="si-posts-list__label"><?php echo esc_html( $_label ); ?></p>
            <h2 id="si-posts-list-heading" class="si-posts-list__heading"><?php echo esc_html( $_heading ); ?></h2>
        </div>

        <?php if ( $_posts->have_posts() ) : ?>
        <ul class="si-posts-list__grid si-reveal-group" role="list">
            <?php
            $_i    = 0;
            $_stop = array( 'a', 'an', 'the', 'to', 'for', 'of', 'in', 'on', 'at', 'by', 'and', 'or' );
            while ( $_posts->have_posts() ) :
                $_posts->the_post();
                $_title   = get_the_title();
                $_excerpt = get_the_excerpt();
                $_words   = preg_split( '/\s+/', trim( $_title ) );
                $_sig     = array();
                foreach ( $_words as $_w ) {
                    if ( strlen( $_w ) && ! in_array( strtolower( $_w ), $_stop, true ) ) {
                        $_sig[] = $_w;
                    }
                }
                $_abbr  = count( $_sig ) >= 2
                    ? strtoupper( substr( $_sig[0], 0, 1 ) . substr( $_sig[1], 0, 1 ) )
                    : strtoupper( substr( $_title, 0, 2 ) );
                $_color = $_palette[ get_the_ID() % count( $_palette ) ];
                $_num   = str_pad( $_i + 1, 2, '0', STR_PAD_LEFT );
            ?>
            <li class="si-post-card si-reveal"
                style="--post-color: <?php echo esc_attr( $_color ); ?>; --post-i: <?php echo esc_attr( $_i ); ?>;">
                <a href="<?php the_permalink(); ?>" class="si-post-card__link">
                    <div class="si-post-card__badge" aria-hidden="true">
                        <span class="si-post-card__num"><?php echo esc_html( $_num ); ?></span>
                        <span class="si-post-card__abbr"><?php echo esc_html( $_abbr ); ?></span>
                    </div>
                    <div class="si-post-card__body">
                        <h3 class="si-post-card__title"><?php echo esc_html( $_title ); ?></h3>
                        <?php if ( $_excerpt ) : ?>
                        <p class="si-post-card__excerpt"><?php echo esc_html( $_excerpt ); ?></p>
                        <?php endif; ?>
                        <span class="si-post-card__cta" aria-hidden="true">Read more &rarr;</span>
                    </div>
                </a>
            </li>
            <?php
            $_i++;
            endwhile;
            wp_reset_postdata();
            ?>
        </ul>
        <?php else : ?>
        <p class="si-posts-list__empty">No posts found.</p>
        <?php endif; ?>

    </div>
</section>
