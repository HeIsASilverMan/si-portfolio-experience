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
            // Phase 5
            'si_form_composition'        => 'form_composition',
            'si_form_learning_design'    => 'form_learning_design',
        );
        foreach ( $codes as $tag => $method ) {
            add_shortcode( $tag, array( __CLASS__, $method ) );
        }
        // Wrapping shortcode registered separately (needs $content param)
        add_shortcode( 'si_section', array( __CLASS__, 'section_wrap' ) );
        add_shortcode( 'si_button',  array( __CLASS__, 'button' ) );
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

    /* ── Phase 5 ─────────────────────────────────────────── */

    public static function form_composition( $atts ) {
        return self::render( 'form-composition' );
    }

    public static function form_learning_design( $atts ) {
        return self::render( 'form-learning-design' );
    }

    /* ── Utility: CTA button ────────────────────────────── */

    /**
     * [si_button url="/page" text="Label" style="primary|ghost" size="normal|large"
     *            align="left|center|right" target="_self|_blank" magnetic="true|false"]
     */
    public static function button( $atts ) {
        $atts = shortcode_atts(
            array(
                'url'      => '#',
                'text'     => 'Get in Touch',
                'style'    => 'primary',   // primary | ghost
                'size'     => 'normal',    // normal | large
                'align'    => '',          // left | center | right — wraps in div when set
                'target'   => '_self',
                'magnetic' => 'false',
                'icon'     => 'true',      // show arrow icon
            ),
            $atts,
            'si_button'
        );

        $classes = array( 'si-btn' );

        if ( 'ghost' === $atts['style'] ) {
            $classes[] = 'si-btn--ghost';
        } else {
            $classes[] = 'si-btn--primary';
        }

        if ( 'large' === $atts['size'] ) {
            $classes[] = 'si-btn--large';
        }

        if ( 'true' === $atts['magnetic'] ) {
            $classes[] = 'si-btn--magnetic';
        }

        $rel    = '_blank' === $atts['target'] ? ' rel="noopener noreferrer"' : '';
        $target = in_array( $atts['target'], array( '_self', '_blank' ), true ) ? $atts['target'] : '_self';

        $icon_svg = '';
        if ( 'true' === $atts['icon'] ) {
            $icon_svg = '<svg class="si-btn__arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">'
                . '<path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>'
                . '</svg>';
        }

        $btn = '<a href="' . esc_url( $atts['url'] ) . '"'
            . ' class="' . esc_attr( implode( ' ', $classes ) ) . '"'
            . ' target="' . esc_attr( $target ) . '"'
            . $rel . '>'
            . esc_html( $atts['text'] )
            . $icon_svg
            . '</a>';

        if ( $atts['align'] ) {
            $safe_align = in_array( $atts['align'], array( 'left', 'center', 'right' ), true ) ? $atts['align'] : 'left';
            return '<div class="si-scope" style="text-align:' . esc_attr( $safe_align ) . ';padding:0.5rem 0;">' . $btn . '</div>';
        }

        return '<span class="si-scope">' . $btn . '</span>';
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
