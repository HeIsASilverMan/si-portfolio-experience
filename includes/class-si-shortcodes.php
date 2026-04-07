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
            // Phase 3
            'si_portfolio_grid'     => 'portfolio_grid',
            'si_approach_cards'     => 'approach_cards',
            'si_tools_grid'         => 'tools_grid',
            'si_awards'             => 'awards',
            'si_education_timeline' => 'education_timeline',
            // Phase 4
            'si_ld_hero'            => 'ld_hero',
            'si_about_story'        => 'about_story',
            'si_connect'            => 'connect',
        );
        foreach ( $codes as $tag => $method ) {
            add_shortcode( $tag, array( __CLASS__, $method ) );
        }
        // Wrapping shortcode registered separately (needs $content param)
        add_shortcode( 'si_section', array( __CLASS__, 'section_wrap' ) );
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

    /* ── Phase 3 ─────────────────────────────────────────── */

    public static function portfolio_grid( $atts ) {
        $atts = shortcode_atts( array( 'type' => 'learning_design' ), $atts, 'si_portfolio_grid' );
        return self::render( 'portfolio-grid', array( 'project_type' => $atts['type'] ) );
    }

    public static function approach_cards( $atts ) {
        return self::render( 'approach-cards' );
    }

    public static function tools_grid( $atts ) {
        return self::render( 'tools-grid' );
    }

    public static function awards( $atts ) {
        return self::render( 'awards' );
    }

    public static function education_timeline( $atts ) {
        return self::render( 'education-timeline' );
    }

    /* ── Phase 4 ─────────────────────────────────────────── */

    public static function ld_hero( $atts ) {
        return self::render( 'ld-hero' );
    }

    public static function about_story( $atts ) {
        return self::render( 'about-story' );
    }

    public static function connect( $atts ) {
        return self::render( 'connect' );
    }

    /* ── Utility: content wrapper ────────────────────────── */

    public static function section_wrap( $atts, $content = '' ) {
        $atts = shortcode_atts(
            array(
                'bg'      => 'dark',
                'width'   => '800',
                'align'   => 'left',
                'padding' => 'normal',
                'label'   => '',
                'title'   => '',
            ),
            $atts,
            'si_section'
        );
        return self::render(
            'section-wrap',
            array(
                'bg'      => $atts['bg'],
                'width'   => $atts['width'],
                'align'   => $atts['align'],
                'padding' => $atts['padding'],
                'label'   => $atts['label'],
                'title'   => $atts['title'],
                'content' => $content,
            )
        );
    }
}
