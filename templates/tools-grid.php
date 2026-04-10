<?php defined( 'ABSPATH' ) || exit;

$tools = array(
    array(
        'name'    => 'Articulate Storyline',
        'abbr'    => 'SL',
        'detail'  => 'Complex branching, simulations &amp; custom interactions',
        'color'   => '#E86E3E',
    ),
    array(
        'name'    => 'Articulate Rise',
        'abbr'    => 'AR',
        'detail'  => 'Rapid, responsive courses with a polished finish',
        'color'   => '#4AA8D8',
    ),
    array(
        'name'    => 'Adobe After Effects',
        'abbr'    => 'AE',
        'detail'  => 'Motion graphics, animated explainers &amp; video overlays',
        'color'   => '#9999FF',
    ),
    array(
        'name'    => 'Vyond',
        'abbr'    => 'VY',
        'detail'  => 'Character-led animated scenarios',
        'color'   => '#F5A623',
    ),
    array(
        'name'    => 'Audio Production',
        'abbr'    => 'AP',
        'detail'  => 'Professional studio-grade sounds',
        'color'   => '#D3D3D3',
    ),
    array(
        'name'    => 'Web Developement',
        'abbr'    => 'WD',
        'detail'  => 'Bespoke HTML, CSS, and JS elements for total customisation.',
        'color'   => '#F88379',
    ),
    array(
        'name'    => 'Professional Voiceover',
        'abbr'    => 'PV',
        'detail'  => 'Clear and engaging narration',
        'color'   => '#BE5103',
    ),
    array(
        'name'    => 'Camtasia',
        'abbr'    => 'CA',
        'detail'  => 'Screen capture, software demos &amp; video editing',
        'color'   => '#5EB55E',
    ),
    array(
        'name'    => 'xAPI &amp; SCORM',
        'abbr'    => 'xAPI',
        'detail'  => 'LRS-connected tracking for granular learner data',
        'color'   => '#D4A853',
    ),
    array(
        'name'    => 'LMS Integration',
        'abbr'    => 'LMS',
        'detail'  => 'Deploy and manage across Moodle, Totara, Canvas &amp; more',
        'color'   => '#7EC89B',
    ),
    array(
        'name'    => 'Adobe Premier Pro',
        'abbr'    => 'PR',
        'detail'  => 'Engaging video editing, and acessibility',
        'color'   => '#CC8899',
    ),
    array(
        'name'    => 'AI Integration',
        'abbr'    => 'AI',
        'detail'  => 'Custom workflows for scripting, rapid prototyping &amp; personalised content',
        'color'   => '#8B5CF6',
    ),
    array(
        'name'    => 'Adobe Illustrator',
        'abbr'    => 'AI',
        'detail'  => 'Custom, visually striking vector graphics',
        'color'   => '#FF9A00',
    ),
    array(
        'name'    => 'Authoring Tools',
        'abbr'    => 'AT',
        'detail'  => 'Lectora, DominKnow, Elucidat, I will use any tool',
        'color'   => '#FF0000',
    ),
    array(
        'name'    => 'Adobe Photoshop',
        'abbr'    => 'PS',
        'detail'  => 'Professional photo editing, and composite work',
        'color'   => '#40D0FB',
    ),
    array(
        'name'    => 'Automation',
        'abbr'    => 'AU',
        'detail'  => 'Enterprise-grade API integrations and custom workflow tools',
        'color'   => '#0BDA51',
    ),
);
?>

<section class="si-scope si-tools-grid" id="si-tools-grid" aria-labelledby="si-tools-heading">

    <div class="si-tools-grid__inner">

        <div class="si-tools-grid__header si-reveal">
            <p class="si-tools-grid__label">Tools &amp; Technologies</p>
            <h2 id="si-tools-heading" class="si-tools-grid__heading">The craft behind the content</h2>
        </div>

        <ul class="si-tools-grid__list si-reveal-group" role="list" aria-label="Tools and technologies">
            <?php foreach ( $tools as $i => $tool ) : ?>
            <li class="si-tool-item si-reveal"
                style="--tool-i: <?php echo esc_attr( $i ); ?>;"
                aria-label="<?php echo esc_attr( wp_strip_all_tags( $tool['name'] ) ); ?>">

                <div class="si-tool-item__badge"
                     style="--tool-color: <?php echo esc_attr( $tool['color'] ); ?>;"
                     aria-hidden="true">
                    <?php echo esc_html( $tool['abbr'] ); ?>
                </div>

                <div class="si-tool-item__info">
                    <span class="si-tool-item__name"><?php echo wp_kses( $tool['name'], array() ); ?></span>
                    <span class="si-tool-item__detail"><?php echo wp_kses( $tool['detail'], array() ); ?></span>
                </div>

            </li>
            <?php endforeach; ?>
        </ul>

    </div>

</section>
