<?php defined( 'ABSPATH' ) || exit;

/**
 * [si_pricing_estimator]
 *
 * "Build Sheet" project estimator. Services and complexity tiers are fully
 * admin-editable via the Pricing Builder CPTs (see class-si-cpts.php);
 * surrounding copy comes from Settings > SI Portfolio > Pricing Estimator.
 * All computation happens client-side in si-pricing-estimator.js, driven by
 * the JSON payload embedded below.
 */

$si_pricing_services = SI_CPTs::get_pricing_services();
$si_pricing_tiers     = SI_CPTs::get_pricing_tiers();

$si_pricing_eyebrow    = si_setting( 'pricing_eyebrow', 'SPEC &middot; 01 / PROJECT ESTIMATOR' );
$si_pricing_heading    = si_setting( 'pricing_heading', 'Build Sheet' );
$si_pricing_studio     = si_setting( 'pricing_studio_name', 'SHANE IVERS' );
$si_pricing_studio_sub = si_setting( 'pricing_studio_sub', 'LEARNING EXPERIENCE DESIGN' );
$si_pricing_intro      = si_setting( 'pricing_intro', 'Select the scope of work below to generate an indicative estimate. Rates reflect senior-level instructional design and delivery -- final quotes are confirmed after a short discovery call.' );
$si_pricing_complexity_label = si_setting( 'pricing_complexity_label', 'Project Complexity' );
$si_pricing_retainer_label   = si_setting( 'pricing_retainer_label', 'Retainer client' );
$si_pricing_retainer_desc    = si_setting( 'pricing_retainer_desc', 'Ongoing engagement discount' );
$si_pricing_retainer_percent = (float) si_setting( 'pricing_retainer_percent', '12' );
$si_pricing_note             = si_setting( 'pricing_note', 'Indicative only. Scope, timelines and final pricing are confirmed following a discovery call.' );
$si_pricing_email_subject    = si_setting( 'pricing_email_subject', 'Project estimate -- Learning Experience Design' );

$si_pricing_data = array(
    'services'        => $si_pricing_services,
    'tiers'           => $si_pricing_tiers,
    'retainerPercent' => $si_pricing_retainer_percent,
    'retainerLabel'   => $si_pricing_retainer_label,
    'retainerDesc'    => $si_pricing_retainer_desc,
    'complexityLabel' => $si_pricing_complexity_label,
    'emailSubject'    => $si_pricing_email_subject,
    'studioName'      => $si_pricing_studio,
);
?>

<section class="si-scope si-pricing" id="si-pricing" aria-labelledby="si-pricing-title">

    <div class="si-pricing__bg" aria-hidden="true"></div>

    <div class="si-pricing__inner">

        <header class="si-pricing__header">
            <div class="si-pricing__heading-block">
                <p class="si-pricing__eyebrow"><?php echo wp_kses( $si_pricing_eyebrow, array( 'span' => array() ) ); ?></p>
                <h1 id="si-pricing-title" class="si-pricing__title"><?php echo esc_html( $si_pricing_heading ); ?></h1>
            </div>
            <div class="si-pricing__studio">
                <span><?php echo esc_html( $si_pricing_studio ); ?></span>
                <span><?php echo esc_html( $si_pricing_studio_sub ); ?></span>
            </div>
        </header>

        <p class="si-pricing__intro"><?php echo esc_html( $si_pricing_intro ); ?></p>

        <?php if ( empty( $si_pricing_services ) ) : ?>

            <p class="si-pricing__empty-notice">
                <?php esc_html_e( 'No pricing services have been added yet. Go to Portfolio Projects > Pricing Services in the admin menu to add your first service.', 'si-portfolio' ); ?>
            </p>

        <?php else : ?>

            <?php if ( ! empty( $si_pricing_tiers ) ) : ?>
                <div class="si-pricing__complexity" id="si-pricing-complexity">
                    <div class="si-pricing__complexity-head">
                        <span class="si-pricing__complexity-label"><?php echo esc_html( $si_pricing_complexity_label ); ?></span>
                        <span class="si-pricing__complexity-tier" id="si-pricing-tier-label"></span>
                    </div>

                    <div class="si-pricing__dim-line" aria-hidden="true">
                        <span class="si-pricing__tick"></span>
                        <span class="si-pricing__rule"></span>
                        <span class="si-pricing__tick"></span>
                    </div>

                    <input
                        type="range"
                        id="si-pricing-tier-slider"
                        class="si-pricing__slider"
                        min="0"
                        max="<?php echo esc_attr( max( 0, count( $si_pricing_tiers ) - 1 ) ); ?>"
                        step="1"
                        value="0"
                        aria-describedby="si-pricing-tier-desc"
                    >

                    <div class="si-pricing__complexity-scale" aria-hidden="true">
                        <?php foreach ( $si_pricing_tiers as $t => $tier ) : ?>
                            <span><?php echo esc_html( $tier['label'] ); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <p class="si-pricing__complexity-desc" id="si-pricing-tier-desc"></p>
                </div>
            <?php endif; ?>

            <div class="si-pricing__grid">

                <div class="si-pricing__services" id="si-pricing-services"></div>

                <div class="si-pricing__summary-col">
                    <div class="si-pricing__panel">
                        <p class="si-pricing__panel-title"><?php esc_html_e( 'Estimate', 'si-portfolio' ); ?></p>

                        <div id="si-pricing-lines"></div>

                        <div class="si-pricing__subtotal-block">
                            <div class="si-pricing__subtotal-row">
                                <span><?php esc_html_e( 'Subtotal', 'si-portfolio' ); ?></span>
                                <span id="si-pricing-subtotal">&pound;0</span>
                            </div>
                            <div class="si-pricing__discount-row" id="si-pricing-discount-row" hidden>
                                <span><?php esc_html_e( 'Retainer discount', 'si-portfolio' ); ?></span>
                                <span id="si-pricing-discount">&pound;0</span>
                            </div>
                        </div>

                        <div class="si-pricing__total-wrap">
                            <div class="si-pricing__dim-line" aria-hidden="true">
                                <span class="si-pricing__tick"></span>
                                <span class="si-pricing__rule"></span>
                                <span class="si-pricing__tick"></span>
                            </div>
                            <div class="si-pricing__total-block">
                                <span class="si-pricing__total-label"><?php esc_html_e( 'Total', 'si-portfolio' ); ?></span>
                                <span class="si-pricing__total-amount" id="si-pricing-total" aria-live="polite">&pound;0</span>
                            </div>
                            <div class="si-pricing__dim-line" aria-hidden="true">
                                <span class="si-pricing__tick"></span>
                                <span class="si-pricing__rule"></span>
                                <span class="si-pricing__tick"></span>
                            </div>
                        </div>

                        <div class="si-pricing__actions">
                            <button type="button" class="si-pricing__action-btn" id="si-pricing-copy" disabled>
                                <?php esc_html_e( 'Copy', 'si-portfolio' ); ?>
                            </button>
                            <a class="si-pricing__action-btn si-pricing__action-btn--primary is-disabled" id="si-pricing-email">
                                <?php esc_html_e( 'Email', 'si-portfolio' ); ?>
                            </a>
                        </div>
                    </div>

                    <p class="si-pricing__note"><?php echo esc_html( $si_pricing_note ); ?></p>
                </div>

            </div>

        <?php endif; ?>

    </div>
</section>

<script type="application/json" id="si-pricing-data">
<?php echo wp_json_encode( $si_pricing_data ); ?>
</script>
