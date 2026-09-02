<?php defined( 'ABSPATH' ) || exit;

$magnet_slug = isset( $atts['magnet'] ) ? sanitize_key( $atts['magnet'] ) : 'default';
$uid         = 'si-lm-' . wp_unique_id();
?>

<section
    class="si-scope si-lead-magnet"
    data-magnet="<?php echo esc_attr( $magnet_slug ); ?>"
    aria-label="<?php esc_attr_e( 'Email signup', 'si-portfolio' ); ?>"
>

    <div class="si-lead-magnet__fields">

        <h2 class="si-lead-magnet__heading"><?php echo esc_html( $atts['heading'] ); ?></h2>
        <p class="si-lead-magnet__body"><?php echo esc_html( $atts['body'] ); ?></p>

        <div class="si-lead-magnet__row">

            <?php if ( 'true' === $atts['name_field'] ) : ?>
            <div class="si-form__field si-lead-magnet__field">
                <label class="si-form__label" for="<?php echo esc_attr( $uid ); ?>-name"><?php esc_html_e( 'Name', 'si-portfolio' ); ?></label>
                <input id="<?php echo esc_attr( $uid ); ?>-name" class="si-form__input" type="text" name="name" autocomplete="name">
            </div>
            <?php endif; ?>

            <div class="si-form__field si-lead-magnet__field">
                <label class="si-form__label" for="<?php echo esc_attr( $uid ); ?>-email"><?php esc_html_e( 'Email', 'si-portfolio' ); ?></label>
                <input id="<?php echo esc_attr( $uid ); ?>-email" class="si-form__input" type="email" name="email" required autocomplete="email" aria-describedby="<?php echo esc_attr( $uid ); ?>-error">
            </div>

            <button class="si-form__submit-btn si-lead-magnet__submit-btn" type="button">
                <?php echo esc_html( $atts['button_text'] ); ?>
                <span class="si-form__submit-spinner" aria-hidden="true"></span>
            </button>

        </div>

        <p class="si-form__error si-lead-magnet__error" id="<?php echo esc_attr( $uid ); ?>-error" aria-live="polite"></p>

        <!-- Honeypot (hidden from humans) -->
        <input
            class="si-form__honeypot"
            name="si_honeypot"
            type="text"
            tabindex="-1"
            autocomplete="off"
            aria-hidden="true"
            style="position:absolute;left:-9999px;opacity:0;pointer-events:none;"
        >

    </div>

    <p class="si-lead-magnet__success" role="status">
        <?php esc_html_e( 'Thanks! Check your inbox in a minute.', 'si-portfolio' ); ?>
    </p>

</section>
