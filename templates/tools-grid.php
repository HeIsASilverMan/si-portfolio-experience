<?php defined( 'ABSPATH' ) || exit;

$categories = array(
    array(
        'label' => 'eLearning Authoring',
        'tools' => array(
            array(
                'name'   => 'Articulate Storyline',
                'abbr'   => 'SL',
                'detail' => 'Complex branching, simulations &amp; custom interactions',
                'color'  => '#E86E3E',
            ),
            array(
                'name'   => 'Articulate Rise',
                'abbr'   => 'AR',
                'detail' => 'Rapid, responsive courses with a polished finish',
                'color'  => '#4AA8D8',
            ),
            array(
                'name'   => 'Vyond',
                'abbr'   => 'VY',
                'detail' => 'Character-led animated scenarios',
                'color'  => '#F5A623',
            ),
            array(
                'name'   => 'Authoring Tools',
                'abbr'   => 'AT',
                'detail' => 'Lectora, DominKnow, Elucidat &amp; more &mdash; tool-agnostic by design',
                'color'  => '#E05A5A',
            ),
        ),
    ),
    array(
        'label' => 'Video &amp; Motion',
        'tools' => array(
            array(
                'name'   => 'Adobe After Effects',
                'abbr'   => 'AE',
                'detail' => 'Motion graphics, animated explainers &amp; video overlays',
                'color'  => '#9999FF',
            ),
            array(
                'name'   => 'Adobe Premiere Pro',
                'abbr'   => 'PR',
                'detail' => 'Engaging video editing with accessibility in mind',
                'color'  => '#CC8899',
            ),
            array(
                'name'   => 'Camtasia',
                'abbr'   => 'CA',
                'detail' => 'Screen capture, software demos &amp; video editing',
                'color'  => '#5EB55E',
            ),
        ),
    ),
    array(
        'label' => 'Audio',
        'tools' => array(
            array(
                'name'   => 'Audio Production',
                'abbr'   => 'AP',
                'detail' => 'Professional studio-grade sounds',
                'color'  => '#D3D3D3',
            ),
            array(
                'name'   => 'Professional Voiceover',
                'abbr'   => 'PV',
                'detail' => 'Clear and engaging narration',
                'color'  => '#BE5103',
            ),
        ),
    ),
    array(
        'label' => 'Design',
        'tools' => array(
            array(
                'name'   => 'Adobe Illustrator',
                'abbr'   => 'IL',
                'detail' => 'Custom, visually striking vector graphics',
                'color'  => '#FF9A00',
            ),
            array(
                'name'   => 'Adobe Photoshop',
                'abbr'   => 'PS',
                'detail' => 'Professional photo editing and composite work',
                'color'  => '#40D0FB',
            ),
        ),
    ),
    array(
        'label' => 'Standards &amp; LMS',
        'tools' => array(
            array(
                'name'   => 'xAPI &amp; SCORM',
                'abbr'   => 'xAPI',
                'detail' => 'LRS-connected tracking for granular learner data',
                'color'  => '#D4A853',
            ),
            array(
                'name'   => 'LMS Integration',
                'abbr'   => 'LMS',
                'detail' => 'Deploy and manage across Moodle, Totara, Canvas &amp; more',
                'color'  => '#7EC89B',
            ),
        ),
    ),
    array(
        'label' => 'Development &amp; Automation',
        'tools' => array(
            array(
                'name'   => 'Web Development',
                'abbr'   => 'WD',
                'detail' => 'Bespoke HTML, CSS, and JS elements for total customisation',
                'color'  => '#F88379',
            ),
            array(
                'name'   => 'AI Integration',
                'abbr'   => 'AI',
                'detail' => 'Custom workflows for scripting, rapid prototyping &amp; personalised content',
                'color'  => '#8B5CF6',
            ),
            array(
                'name'   => 'Automation',
                'abbr'   => 'AU',
                'detail' => 'Enterprise-grade API integrations and custom workflow tools',
                'color'  => '#0BDA51',
            ),
        ),
    ),
);

$total_tools = 0;
foreach ( $categories as $cat ) {
    $total_tools += count( $cat['tools'] );
}
?>

<section class="si-scope si-tools-grid" id="si-tools-grid" aria-labelledby="si-tools-heading">

    <div class="si-tools-grid__inner">

        <div class="si-tools-grid__header si-reveal">
            <p class="si-tools-grid__label">Tools &amp; Technologies</p>
            <h2 id="si-tools-heading" class="si-tools-grid__heading">The craft behind the content</h2>
            <p class="si-tools-grid__intro"><?php echo esc_html( $total_tools ); ?> tools across <?php echo esc_html( count( $categories ) ); ?> disciplines &mdash; chosen for quality, not volume.</p>
        </div>

        <div class="si-tools-grid__categories si-reveal-group">

            <?php
            $global_i = 0;
            foreach ( $categories as $cat_index => $cat ) :
                $cat_id = 'si-tools-cat-' . esc_attr( $cat_index );
            ?>

            <div class="si-tools-grid__category si-reveal">

                <h3 id="<?php echo esc_attr( $cat_id ); ?>" class="si-tools-grid__category-label">
                    <?php echo wp_kses( $cat['label'], array() ); ?>
                </h3>

                <ul class="si-tools-grid__list" role="list" aria-labelledby="<?php echo esc_attr( $cat_id ); ?>">

                    <?php foreach ( $cat['tools'] as $tool ) : ?>
                    <li class="si-tool-item si-reveal"
                        style="--tool-i: <?php echo esc_attr( $global_i ); ?>; --tool-color: <?php echo esc_attr( $tool['color'] ); ?>;">

                        <div class="si-tool-item__badge" aria-hidden="true">
                            <?php echo esc_html( $tool['abbr'] ); ?>
                        </div>

                        <div class="si-tool-item__info">
                            <span class="si-tool-item__name"><?php echo wp_kses( $tool['name'], array() ); ?></span>
                            <span class="si-tool-item__detail"><?php echo wp_kses( $tool['detail'], array() ); ?></span>
                        </div>

                    </li>
                    <?php
                    $global_i++;
                    endforeach;
                    ?>

                </ul>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>
