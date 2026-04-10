<?php defined( 'ABSPATH' ) || exit;

$credentials = array(
    array(
        'qualification' => 'Level 5 Diploma in Digital Learning Design',
        'institution'   => 'Learning &amp; Performance Institute',
        'result'        => 'Distinction',
        'status'        => 'complete',
        'year'          => '2025',
        'note'          => 'The industry benchmark for professional learning designers. Distinction awarded for outstanding portfolio work and critical evaluation.',
    ),
    array(
        'qualification' => "Master's Degree in Electronic Music Composition",
        'institution'   => 'University of Liverpool',
        'result'        => 'Distinction',
        'status'        => 'complete',
        'year'          => '2014',
        'note'          => 'Developed the technical and creative foundations behind every piece of bespoke music I compose today.',
    ),
    array(
        'qualification' => 'ACMALT Membership',
        'institution'   => 'Association for Learning Technology',
        'result'        => 'Certified Member',
        'status'        => 'complete',
        'year'          => '2026',
        'note'          => 'A commitment to professional standards and continuous development in learning technology.',
    ),
);
?>

<section class="si-scope si-education-timeline" id="si-education-timeline" aria-labelledby="si-education-heading">

    <div class="si-education-timeline__inner">

        <div class="si-education-timeline__header si-reveal">
            <p class="si-education-timeline__label">Education &amp; Credentials</p>
            <h2 id="si-education-heading" class="si-education-timeline__heading">Built on solid foundations</h2>
        </div>

        <ol class="si-education-timeline__list" role="list">
            <?php foreach ( $credentials as $i => $cred ) : ?>
            <li class="si-edu-item si-reveal
                        si-edu-item--<?php echo esc_attr( $cred['status'] ); ?>"
                style="--edu-i: <?php echo esc_attr( $i ); ?>;">

                <div class="si-edu-item__connector" aria-hidden="true">
                    <div class="si-edu-item__dot"></div>
                    <?php if ( $i < count( $credentials ) - 1 ) : ?>
                    <div class="si-edu-item__line"></div>
                    <?php endif; ?>
                </div>

                <div class="si-edu-item__body">
                    <div class="si-edu-item__meta">
                        <span class="si-edu-item__year"><?php echo esc_html( $cred['year'] ); ?></span>
                        <?php if ( $cred['result'] ) : ?>
                        <span class="si-edu-item__result si-edu-item__result--<?php echo esc_attr( $cred['status'] ); ?>">
                            <?php echo esc_html( $cred['result'] ); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <h3 class="si-edu-item__qualification"><?php echo esc_html( $cred['qualification'] ); ?></h3>
                    <p class="si-edu-item__institution"><?php echo wp_kses( $cred['institution'], array() ); ?></p>
                    <?php if ( $cred['note'] ) : ?>
                    <p class="si-edu-item__note"><?php echo esc_html( $cred['note'] ); ?></p>
                    <?php endif; ?>
                </div>

            </li>
            <?php endforeach; ?>
        </ol>

    </div>

</section>
