<?php
/**
 * SI Admin — Settings page registered as Settings > SI Portfolio.
 * All site-editable strings and URLs are stored in a single option:
 * `si_portfolio_settings` (serialised array).
 *
 * Usage in templates: si_setting( 'key', 'Default fallback text' )
 */
defined( 'ABSPATH' ) || exit;

class SI_Admin {

    const OPTION_KEY   = 'si_portfolio_settings';
    const OPTION_GROUP = 'si_portfolio_settings_group';

    public static function init() {
        add_action( 'admin_menu',    array( __CLASS__, 'add_page' ) );
        add_action( 'admin_init',    array( __CLASS__, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_styles' ) );
    }

    // -------------------------------------------------------
    // Menu
    // -------------------------------------------------------

    public static function add_page() {
        add_options_page(
            'SI Portfolio Settings',
            'SI Portfolio',
            'manage_options',
            'si-portfolio-settings',
            array( __CLASS__, 'render_page' )
        );
    }

    // -------------------------------------------------------
    // Register setting + sanitise
    // -------------------------------------------------------

    public static function register_settings() {
        register_setting(
            self::OPTION_GROUP,
            self::OPTION_KEY,
            array(
                'sanitize_callback' => array( __CLASS__, 'sanitize' ),
                'default'           => array(),
            )
        );
    }

    public static function sanitize( $input ) {
        if ( ! is_array( $input ) ) {
            return array();
        }
        $clean = array();

        // URL fields
        $url_fields = array(
            'linkedin_url', 'spotify_url', 'soundcloud_url', 'patreon_url',
        );
        foreach ( $url_fields as $f ) {
            $clean[ $f ] = isset( $input[ $f ] ) ? esc_url_raw( $input[ $f ] ) : '';
        }

        // Email fields
        $email_fields = array( 'contact_email', 'notify_email' );
        foreach ( $email_fields as $f ) {
            $clean[ $f ] = isset( $input[ $f ] ) ? sanitize_email( $input[ $f ] ) : '';
        }

        // Plain text / short strings
        $text_fields = array(
            'comp_hero_headline', 'comp_hero_sub',
            'ld_hero_headline',   'ld_hero_sub',
            'cta_headline',       'cta_sub',       'cta_button_text',
            'about_tagline',
            'form_comp_success',  'form_ld_success',
        );
        foreach ( $text_fields as $f ) {
            $clean[ $f ] = isset( $input[ $f ] ) ? sanitize_text_field( $input[ $f ] ) : '';
        }

        return $clean;
    }

    // -------------------------------------------------------
    // Inline admin styles (minimal — keeps mobile usable)
    // -------------------------------------------------------

    public static function admin_styles( $hook ) {
        if ( 'settings_page_si-portfolio-settings' !== $hook ) {
            return;
        }
        echo '<style>
            #si-settings-wrap { max-width: 780px; }
            #si-settings-wrap .si-section { margin: 2rem 0 0; padding: 1.5rem; background: #fff; border: 1px solid #ddd; border-radius: 4px; }
            #si-settings-wrap .si-section h2 { margin: 0 0 1.25rem; font-size: 1rem; border-bottom: 1px solid #eee; padding-bottom: .75rem; }
            #si-settings-wrap .si-row { margin-bottom: 1.1rem; }
            #si-settings-wrap .si-row label { display: block; font-weight: 600; margin-bottom: .3rem; font-size: 13px; }
            #si-settings-wrap .si-row .si-hint { display: block; color: #666; font-size: 11px; margin-top: .25rem; }
            #si-settings-wrap input[type=text],
            #si-settings-wrap input[type=url],
            #si-settings-wrap input[type=email] { width: 100%; max-width: 480px; }
            .si-save-bar { position: sticky; bottom: 0; background: #f0f0f1; border-top: 1px solid #ddd; padding: .75rem 1.5rem; margin: 0 -20px; display: flex; align-items: center; gap: 1rem; z-index: 10; }
        </style>';
    }

    // -------------------------------------------------------
    // Render page
    // -------------------------------------------------------

    public static function render_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $s = self::get_all();
        ?>
        <div class="wrap" id="si-settings-wrap">
            <h1><?php esc_html_e( 'SI Portfolio Settings', 'si-portfolio' ); ?></h1>

            <form method="post" action="options.php">
                <?php settings_fields( self::OPTION_GROUP ); ?>

                <!-- ── Social & Contact ─────────────────────────── -->
                <div class="si-section">
                    <h2><?php esc_html_e( 'Social &amp; Contact Links', 'si-portfolio' ); ?></h2>

                    <?php self::field_url( $s, 'linkedin_url',   'LinkedIn URL',   'https://linkedin.com/in/...' ); ?>
                    <?php self::field_url( $s, 'spotify_url',    'Spotify URL',    'https://open.spotify.com/artist/...' ); ?>
                    <?php self::field_url( $s, 'soundcloud_url', 'SoundCloud URL', 'https://soundcloud.com/...' ); ?>
                    <?php self::field_url( $s, 'patreon_url',    'Patreon URL',    'https://patreon.com/...' ); ?>

                    <?php self::field_email(
                        $s, 'contact_email', 'Contact / CTA Email',
                        'shane@shaneivers.com',
                        'Used for the mailto: link in the CTA band.'
                    ); ?>
                </div>

                <!-- ── Composition page ─────────────────────────── -->
                <div class="si-section">
                    <h2><?php esc_html_e( 'Composition Hero', 'si-portfolio' ); ?></h2>

                    <?php self::field_text(
                        $s, 'comp_hero_headline', 'Headline',
                        'Every Project Deserves Its Own Sound'
                    ); ?>
                    <?php self::field_text(
                        $s, 'comp_hero_sub', 'Sub-headline',
                        'No templates. No stock. Every piece composed from scratch.',
                        'Shown below the headline in smaller text.'
                    ); ?>
                </div>

                <!-- ── Learning Design page ─────────────────────── -->
                <div class="si-section">
                    <h2><?php esc_html_e( 'Learning Design Hero', 'si-portfolio' ); ?></h2>

                    <?php self::field_text(
                        $s, 'ld_hero_headline', 'Headline',
                        'Learning Experiences That Actually Work'
                    ); ?>
                    <?php self::field_text(
                        $s, 'ld_hero_sub', 'Sub-headline',
                        'Blending instructional science with design craft.',
                        'Shown below the headline.'
                    ); ?>
                </div>

                <!-- ── About page ───────────────────────────────── -->
                <div class="si-section">
                    <h2><?php esc_html_e( 'About Page', 'si-portfolio' ); ?></h2>

                    <?php self::field_text(
                        $s, 'about_tagline', 'Hero Tagline',
                        'Composer. Learning Designer. Obsessive Perfectionist.',
                        'The one-liner that appears below your name.'
                    ); ?>
                </div>

                <!-- ── CTA Band ──────────────────────────────────── -->
                <div class="si-section">
                    <h2><?php esc_html_e( 'CTA Band', 'si-portfolio' ); ?></h2>

                    <?php self::field_text(
                        $s, 'cta_headline', 'Headline',
                        "Let's create something extraordinary"
                    ); ?>
                    <?php self::field_text(
                        $s, 'cta_sub', 'Sub-text',
                        'Whether it\'s a score, a course, or something in between &mdash; get in touch.'
                    ); ?>
                    <?php self::field_text(
                        $s, 'cta_button_text', 'Button text',
                        'Get in Touch'
                    ); ?>
                </div>

                <!-- ── Form notifications ────────────────────────── -->
                <div class="si-section">
                    <h2><?php esc_html_e( 'Form Notifications', 'si-portfolio' ); ?></h2>

                    <?php self::field_email(
                        $s, 'notify_email', 'Notification email',
                        get_option( 'admin_email' ),
                        'Enquiry submissions are emailed here.'
                    ); ?>
                    <?php self::field_text(
                        $s, 'form_comp_success', 'Composition form — success message',
                        "You're in. Thanks for reaching out. I'll be in touch within 2 working days."
                    ); ?>
                    <?php self::field_text(
                        $s, 'form_ld_success', 'Learning design form — success message',
                        "You're in. Thanks for reaching out. I'll be in touch within 2 working days."
                    ); ?>
                </div>

                <!-- ── Sticky save bar ───────────────────────────── -->
                <div class="si-save-bar">
                    <?php submit_button( 'Save Settings', 'primary', 'submit', false ); ?>
                    <span class="si-save-note" style="color:#666;font-size:12px;">
                        <?php esc_html_e( 'Changes are live immediately after saving.', 'si-portfolio' ); ?>
                    </span>
                </div>

            </form>
        </div>
        <?php
    }

    // -------------------------------------------------------
    // Field helpers
    // -------------------------------------------------------

    private static function field_text( $s, $key, $label, $placeholder = '', $hint = '' ) {
        $id  = 'si_' . $key;
        $val = isset( $s[ $key ] ) ? $s[ $key ] : '';
        echo '<div class="si-row">';
        echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
        echo '<input type="text" id="' . esc_attr( $id ) . '" name="' . esc_attr( self::OPTION_KEY . '[' . $key . ']' ) . '"'
            . ' value="' . esc_attr( $val ) . '"'
            . ' placeholder="' . esc_attr( $placeholder ) . '">';
        if ( $hint ) {
            echo '<span class="si-hint">' . esc_html( $hint ) . '</span>';
        }
        echo '</div>';
    }

    private static function field_url( $s, $key, $label, $placeholder = '', $hint = '' ) {
        $id  = 'si_' . $key;
        $val = isset( $s[ $key ] ) ? $s[ $key ] : '';
        echo '<div class="si-row">';
        echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
        echo '<input type="url" id="' . esc_attr( $id ) . '" name="' . esc_attr( self::OPTION_KEY . '[' . $key . ']' ) . '"'
            . ' value="' . esc_attr( $val ) . '"'
            . ' placeholder="' . esc_attr( $placeholder ) . '">';
        if ( $hint ) {
            echo '<span class="si-hint">' . esc_html( $hint ) . '</span>';
        }
        echo '</div>';
    }

    private static function field_email( $s, $key, $label, $placeholder = '', $hint = '' ) {
        $id  = 'si_' . $key;
        $val = isset( $s[ $key ] ) ? $s[ $key ] : '';
        echo '<div class="si-row">';
        echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
        echo '<input type="email" id="' . esc_attr( $id ) . '" name="' . esc_attr( self::OPTION_KEY . '[' . $key . ']' ) . '"'
            . ' value="' . esc_attr( $val ) . '"'
            . ' placeholder="' . esc_attr( $placeholder ) . '">';
        if ( $hint ) {
            echo '<span class="si-hint">' . esc_html( $hint ) . '</span>';
        }
        echo '</div>';
    }

    // -------------------------------------------------------
    // Public helper — used by templates
    // -------------------------------------------------------

    /**
     * Retrieve a setting value, falling back to $default if not set.
     *
     * @param string $key     Setting key.
     * @param string $default Fallback value.
     * @return string
     */
    public static function get( $key, $default = '' ) {
        static $cache = null;
        if ( null === $cache ) {
            $cache = get_option( self::OPTION_KEY, array() );
        }
        if ( isset( $cache[ $key ] ) && '' !== $cache[ $key ] ) {
            return $cache[ $key ];
        }
        return $default;
    }

    /**
     * Retrieve all settings.
     */
    public static function get_all() {
        return get_option( self::OPTION_KEY, array() );
    }
}

/**
 * Global convenience wrapper so templates don't need to reference the class.
 * si_setting( 'comp_hero_headline', 'Default text' )
 */
function si_setting( $key, $default = '' ) {
    return SI_Admin::get( $key, $default );
}
