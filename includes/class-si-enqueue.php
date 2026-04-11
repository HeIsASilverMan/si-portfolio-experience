<?php
defined( 'ABSPATH' ) || exit;

class SI_Enqueue {

    public static function init() {
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
        add_action( 'wp_footer',          array( __CLASS__, 'preloader' ) );
    }

    public static function preloader() {
        ?>
        <div class="si-preloader" id="si-preloader" aria-hidden="true">
            <div class="si-preloader__inner">
                <svg class="si-preloader__logo" width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                    <circle cx="24" cy="24" r="22" stroke="#D4A853" stroke-width="1.5" opacity="0.4"/>
                    <text x="24" y="29" font-family="'Instrument Serif', Georgia, serif" font-size="18" fill="#D4A853" text-anchor="middle">SI</text>
                </svg>
                <div class="si-preloader__track" aria-hidden="true">
                    <div class="si-preloader__fill"></div>
                </div>
            </div>
        </div>
        <script>
        ( function () {
            var el = document.getElementById( 'si-preloader' );
            if ( ! el ) return;
            function done() {
                el.classList.add( 'is-done' );
                setTimeout( function () { el.style.display = 'none'; }, 600 );
            }
            if ( document.readyState === 'complete' ) {
                setTimeout( done, 200 );
            } else {
                window.addEventListener( 'load', function () { setTimeout( done, 200 ); } );
                setTimeout( done, 2000 ); // hard cap
            }
        } )();
        </script>
        <?php
    }

    public static function enqueue() {
        $url = SI_PLUGIN_URL . 'assets/';
        $v   = SI_VERSION;

        wp_enqueue_style( 'si-fonts-instrument',
            'https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@400;500&family=JetBrains+Mono:wght@400&display=swap',
            array(), null );

        wp_enqueue_style( 'si-variables',    $url . 'css/si-variables.css',    array(),                  $v );
        wp_enqueue_style( 'si-base',         $url . 'css/si-base.css',         array( 'si-variables' ),  $v );
        wp_enqueue_style( 'si-blocks',       $url . 'css/si-blocks.css',       array( 'si-base' ),       $v );
        wp_enqueue_style( 'si-components',   $url . 'css/si-components.css',   array( 'si-base' ),       $v );
        wp_enqueue_style( 'si-animations',   $url . 'css/si-animations.css',   array( 'si-base' ),       $v );
        wp_enqueue_style( 'si-layout',       $url . 'css/si-layout.css',       array( 'si-components' ), $v );
        wp_enqueue_style( 'si-home',         $url . 'css/si-home.css',         array( 'si-components' ), $v );
        wp_enqueue_style( 'si-composition',      $url . 'css/si-composition.css',      array( 'si-components' ), $v );
        wp_enqueue_style( 'si-learning-design',  $url . 'css/si-learning-design.css',  array( 'si-components' ), $v );
        wp_enqueue_style( 'si-about',            $url . 'css/si-about.css',            array( 'si-components' ), $v );
        wp_enqueue_style( 'si-forms',            $url . 'css/si-forms.css',            array( 'si-components' ), $v );

        wp_enqueue_script( 'si-scroll-observer', $url . 'js/si-scroll-observer.js', array(), $v, true );
        wp_enqueue_script( 'si-counters',        $url . 'js/si-counters.js',        array(), $v, true );
        wp_enqueue_script( 'si-marquee',         $url . 'js/si-marquee.js',         array(), $v, true );
        wp_enqueue_script( 'si-magnetic',        $url . 'js/si-magnetic-button.js', array(), $v, true );
        wp_enqueue_script( 'si-nav',             $url . 'js/si-nav.js',             array(), $v, true );
        wp_enqueue_script( 'si-audio-player',      $url . 'js/si-audio-player.js',      array(), $v, true );
        wp_enqueue_script( 'si-portfolio-filter',  $url . 'js/si-portfolio-filter.js',  array(), $v, true );
        wp_enqueue_script( 'si-project-modal',     $url . 'js/si-project-modal.js',     array(), $v, true );
        wp_enqueue_script( 'si-forms',             $url . 'js/si-forms.js',             array(), $v, true );
        wp_localize_script( 'si-forms', 'siFormsConfig', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'si_form_nonce' ),
        ) );
    }
}
