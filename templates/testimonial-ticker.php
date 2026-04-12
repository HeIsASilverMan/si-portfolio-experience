<?php defined( 'ABSPATH' ) || exit;

$count = isset( $count ) ? intval( $count ) : 3;

$query = new WP_Query( array(
    'post_type'      => 'si_testimonial',
    'posts_per_page' => $count,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );

$items = array();

if ( $query->have_posts() ) {
    foreach ( $query->posts as $t ) {
        $items[] = array(
            'quote'  => get_the_content( null, false, $t ),
            'name'   => get_post_meta( $t->ID, '_si_client_name', true ),
            'credit' => get_post_meta( $t->ID, '_si_client_role', true ),
        );
    }
} else {
    $items[] = array(
        'quote'  => 'Shane\'s music transformed our project completely. The emotional depth he brought to every cue was extraordinary.',
        'name'   => 'Matthew Reynolds',
        'credit' => 'The Violet Fire',
    );
}
?>

<section class="si-scope si-testimonials" aria-label="Testimonials">
    <?php $variant = 'glow'; include SI_PLUGIN_DIR . 'templates/partials/stave-motif.php'; ?>
    <div class="si-testimonials__inner">
        <div
            class="si-testimonials__track"
            role="region"
            aria-label="Client testimonials"
            aria-live="polite"
        >
            <?php foreach ( $items as $i => $item ) : ?>
            <div
                class="si-testimonial-item<?php echo 0 === $i ? ' is-active' : ''; ?>"
                id="si-testimonial-<?php echo esc_attr( $i ); ?>"
                role="group"
                aria-label="Testimonial <?php echo esc_attr( $i + 1 ); ?>"
            >
                <blockquote class="si-testimonial-item__quote">
                    &ldquo;<?php echo esc_html( wp_strip_all_tags( $item['quote'] ) ); ?>&rdquo;
                </blockquote>
                <cite class="si-testimonial-item__cite">
                    <?php echo esc_html( $item['name'] ); ?>
                    <?php if ( $item['credit'] ) : ?>
                    &mdash; <?php echo esc_html( $item['credit'] ); ?>
                    <?php endif; ?>
                </cite>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if ( count( $items ) > 1 ) : ?>
        <div class="si-testimonials__dots" role="tablist" aria-label="Testimonial navigation">
            <?php foreach ( $items as $i => $item ) : ?>
            <button
                class="si-testimonials__dot<?php echo 0 === $i ? ' is-active' : ''; ?>"
                role="tab"
                aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
                aria-controls="si-testimonial-<?php echo esc_attr( $i ); ?>"
                data-index="<?php echo esc_attr( $i ); ?>"
                aria-label="Testimonial <?php echo esc_attr( $i + 1 ); ?>"
            ></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
(function () {
    var track    = document.querySelector('.si-testimonials__track');
    var dots     = document.querySelectorAll('.si-testimonials__dot');
    var items    = document.querySelectorAll('.si-testimonial-item');
    if (!items.length) return;

    var current  = 0;
    var timer    = null;

    function show(index) {
        items[current].classList.remove('is-active');
        dots.length && dots[current].classList.remove('is-active');
        dots.length && dots[current].setAttribute('aria-selected', 'false');

        current = index % items.length;

        items[current].classList.add('is-active');
        dots.length && dots[current].classList.add('is-active');
        dots.length && dots[current].setAttribute('aria-selected', 'true');
    }

    function autoPlay() {
        timer = setInterval(function () { show(current + 1); }, 5000);
    }

    autoPlay();

    if (track) {
        track.addEventListener('mouseenter', function () { clearInterval(timer); });
        track.addEventListener('mouseleave', autoPlay);
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            clearInterval(timer);
            show(parseInt(dot.dataset.index, 10));
            autoPlay();
        });
    });
}());
</script>
