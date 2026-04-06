<?php
defined( 'ABSPATH' ) || exit;

class SI_Shortcodes {

    public static function init() {
        $codes = array(
            'si_home_hero'    => 'home_hero',
            'si_marquee'      => 'marquee',
            'si_dual_showcase'=> 'dual_showcase',
            'si_testimonials' => 'testimonials',
            'si_cta_band'     => 'cta_band',
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
}
