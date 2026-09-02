<?php defined( 'ABSPATH' ) || exit;

$tracks = array(
    array(
        'title' => 'Soviet Gulag Composition',
        'body'  => "Original composition built around sparse arrangement, folk elements, male chorus, and lyrics written from the character's perspective. The client discovered Shane through a catalogue track and arrived already convinced it fit their world.",
    ),
    array(
        'title' => 'Superhero Spy Jazz Game Soundtrack',
        'body'  => 'Main theme plus five looping level pieces across a range of styles. The game shipped with moderate Steam ratings, and the client returned for multiple further commissions.',
    ),
    array(
        'title' => 'Staldorn Suite',
        'body'  => 'A full cinematic suite moving through multiple character themes: atmospheric winds, ceremonial drums, tagelharpa melodies, cultist passages, sacred choral sections, solo violin, and a heroic culmination.',
    ),
    array(
        'title' => 'Conquer',
        'body'  => 'Medieval strings and Latin ecclesiastical choir leading into a full electronic drop with a searing lead line and epic drums. One of the most popular tracks in the catalogue.',
    ),
    array(
        'title' => 'Imperial China Cinematic',
        'body'  => 'A thematically specific composition rooted in Chinese musical identity and worldbuilding, one of the strongest-performing genres in the catalogue.',
    ),
);

// Match each track above to a real si_portfolio entry by exact title so the
// audio plays inline where a file has been attached; otherwise we fall back
// to a plain description so nothing here links out to a dead placeholder.
foreach ( $tracks as $i => $track ) {
    $tracks[ $i ]['audio_url'] = '';
    $tracks[ $i ]['ext_url']   = '';

    $candidates = get_posts( array(
        'post_type'      => 'si_portfolio',
        'post_status'    => 'publish',
        'posts_per_page' => 5,
        's'              => $track['title'],
    ) );
    foreach ( $candidates as $candidate ) {
        if ( 0 === strcasecmp( $candidate->post_title, $track['title'] ) ) {
            $tracks[ $i ]['audio_url'] = get_post_meta( $candidate->ID, '_si_audio_file', true );
            $tracks[ $i ]['ext_url']   = get_post_meta( $candidate->ID, '_si_external_url', true );
            break;
        }
    }
}
?>

<section class="si-scope si-thread-portfolio" id="si-thread-portfolio" aria-labelledby="si-thread-portfolio-heading">

    <div class="si-thread-portfolio__inner">

        <div class="si-thread-portfolio__header si-reveal">
            <p class="si-thread-portfolio__label"><?php esc_html_e( 'Portfolio', 'si-portfolio' ); ?></p>
            <h2 id="si-thread-portfolio-heading" class="si-thread-portfolio__heading"><?php esc_html_e( 'Hear the Work', 'si-portfolio' ); ?></h2>
        </div>

        <ol class="si-thread-portfolio__list" role="list">
            <?php foreach ( $tracks as $i => $track ) : ?>
            <li class="si-thread-portfolio__item si-reveal" style="--item-i: <?php echo esc_attr( $i ); ?>;">
                <span class="si-thread-portfolio__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
                <div class="si-thread-portfolio__content">
                    <h3 class="si-thread-portfolio__title"><?php echo esc_html( $track['title'] ); ?></h3>
                    <p class="si-thread-portfolio__desc"><?php echo wp_kses( $track['body'], array() ); ?></p>

                    <?php if ( $track['audio_url'] ) : ?>
                    <audio class="si-thread-portfolio__audio" controls preload="none" src="<?php echo esc_url( $track['audio_url'] ); ?>">
                        <?php esc_html_e( 'Your browser does not support the audio element.', 'si-portfolio' ); ?>
                    </audio>
                    <?php elseif ( $track['ext_url'] ) : ?>
                    <a class="si-thread-portfolio__link" href="<?php echo esc_url( $track['ext_url'] ); ?>" target="_blank" rel="noopener noreferrer">
                        <?php esc_html_e( 'Hear it in the catalogue', 'si-portfolio' ); ?>
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>

    </div>

</section>
