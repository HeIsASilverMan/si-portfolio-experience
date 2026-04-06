<?php
defined( 'ABSPATH' ) || exit;

class SI_Shortcodes {

    public static function init() {
        $codes = array(
            'si_home_hero'          => 'home_hero',
            'si_marquee'            => 'marquee',
            'si_dual_showcase'      => 'dual_showcase',
            'si_testimonials'       => 'testimonials',
            'si_cta_band'           => 'cta_band',
            // Phase 2
            'si_composition_hero'   => 'composition_hero',
            'si_benefits_list'      => 'benefits_list',
            'si_process_timeline'   => 'process_timeline',
            'si_audio_showcase'     => 'audio_showcase',
        );
        foreach ( $codes as $tag => $method ) {
            add_shortcode( $tag, array( __CLASS__, $method ) );
        }
    }

    public static function render( $template, $data = array() ) {
        $file = SI_PLUGIN_DIR . 'templates/' . $template . '.php';
        if ( ! file_exists( $file ) ) {
            return '';
        }
        if ( ! empty( $data ) ) {
            extract( $data, EXTR_SKIP );
        }
        ob_start();
        include $file;
        return ob_get_clean();
    }

    /* ── Phase 1 ─────────────────────────────────────────── */

    public static function home_hero( $atts ) {
        return self::render( 'home-hero' );
    }

    public static function marquee( $atts ) {
        $atts = shortcode_atts( array( 'text' => '' ), $atts, 'si_marquee' );
        return self::render( 'marquee', array( 'text' => $atts['text'] ) );
    }

    public static function dual_showcase( $atts ) {
        return self::render( 'dual-showcase' );
    }

    public static function testimonials( $atts ) {
        $atts = shortcode_atts( array( 'count' => 3 ), $atts, 'si_testimonials' );
        return self::render( 'testimonial-ticker', array( 'count' => intval( $atts['count'] ) ) );
    }

    public static function cta_band( $atts ) {
        return self::render( 'cta-band' );
    }

    /* ── Phase 2 ─────────────────────────────────────────── */

    public static function composition_hero( $atts ) {
        return self::render( 'composition-hero' );
    }

    public static function benefits_list( $atts ) {
        return self::render( 'benefits-list' );
    }

    public static function process_timeline( $atts ) {
        return self::render( 'process-timeline' );
    }

    public static function audio_showcase( $atts ) {
        return self::render( 'audio-showcase' );
    }
}
