<?php
defined( 'ABSPATH' ) || exit;

class SI_Enqueue {

    public static function init() {
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ), 100 );
        add_action( 'wp_footer',          array( __CLASS__, 'preloader' ) );
    }

    public static function preloader() {
        ?>
        <div class="si-preloader" id="si-preloader" aria-hidden="true">
            <div class="si-preloader__inner">
                <svg class="si-preloader__logo" viewBox="0 0 127.3 127.3" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect class="si-preloader__box" x="3" y="3" width="121.3" height="121.3"
                        fill="none" stroke="currentColor" stroke-width="6"
                        stroke-dasharray="486" stroke-dashoffset="486"/>
                    <g class="si-preloader__mark si-preloader__mark--s">
                        <path fill-rule="evenodd" fill="currentColor"
                            d="M54.34,71.54C38.76,49.86,38.02,21.96,50.12,0H0v127.3h45.65c17.57-13.05,21.5-37.92,8.69-55.76Z"/>
                    </g>
                    <g class="si-preloader__mark si-preloader__mark--bridge">
                        <path fill-rule="evenodd" fill="currentColor"
                            d="M93.66,127.3c0-42.43,0-84.86,0-127.3h-8.67c-17.73,13.01-21.74,37.99-8.88,55.89,15.54,21.63,16.31,49.46,4.3,71.4h13.24Z"/>
                    </g>
                    <g class="si-preloader__mark si-preloader__mark--bar" style="--bar-i:0">
                        <path fill-rule="evenodd" fill="currentColor"
                            d="M99.45,0h-2.89c0,42.43,0,84.86,0,127.3h2.89V0Z"/>
                    </g>
                    <g class="si-preloader__mark si-preloader__mark--bar" style="--bar-i:1">
                        <path fill-rule="evenodd" fill="currentColor"
                            d="M105.25,127.3h-2.89c0-42.43,0-84.86,0-127.3h2.89v127.3Z"/>
                    </g>
                    <g class="si-preloader__mark si-preloader__mark--bar" style="--bar-i:2">
                        <path fill-rule="evenodd" fill="currentColor"
                            d="M111.05,0h-2.89c0,42.43,0,84.86,0,127.3h2.89V0Z"/>
                    </g>
                    <g class="si-preloader__mark si-preloader__mark--bar" style="--bar-i:3">
                        <path fill-rule="evenodd" fill="currentColor"
                            d="M116.84,0h-2.89c0,42.43,0,84.86,0,127.3h2.89V0Z"/>
                    </g>
                    <g class="si-preloader__mark si-preloader__mark--bar" style="--bar-i:4">
                        <path fill-rule="evenodd" fill="currentColor"
                            d="M119.75,0c0,42.43,0,84.86,0,127.3h7.55V0h-7.55Z"/>
                    </g>
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
                setTimeout( done, 2000 );
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

        wp_enqueue_style( 'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            array(), null );

        wp_enqueue_style( 'si-variables',        $url . 'css/si-variables.css',        array(),                                   $v );
        wp_enqueue_style( 'si-base',             $url . 'css/si-base.css',             array( 'si-variables' ),                   $v );
        wp_enqueue_style( 'si-blocks',           $url . 'css/si-blocks.css',           array( 'si-base' ),                        $v );
        wp_enqueue_style( 'si-components',       $url . 'css/si-components.css',       array( 'si-base' ),                        $v );
        wp_enqueue_style( 'si-animations',       $url . 'css/si-animations.css',       array( 'si-base' ),                        $v );
        wp_enqueue_style( 'si-layout',           $url . 'css/si-layout.css',           array( 'si-components' ),                  $v );
        wp_enqueue_style( 'si-home',             $url . 'css/si-home.css',             array( 'si-components' ),                  $v );
        wp_enqueue_style( 'si-composition',      $url . 'css/si-composition.css',      array( 'si-components' ),                  $v );
        wp_enqueue_style( 'si-learning-design',  $url . 'css/si-learning-design.css',  array( 'si-components' ),                  $v );
        wp_enqueue_style( 'si-about',            $url . 'css/si-about.css',            array( 'si-components' ),                  $v );
        wp_enqueue_style( 'si-forms',            $url . 'css/si-forms.css',            array( 'si-components' ),                  $v );
        wp_enqueue_style( 'si-fixes',            $url . 'css/si-fixes.css',            array( 'si-blocks', 'si-learning-design' ), $v );
        wp_enqueue_style( 'si-tools',            $url . 'css/si-tools.css',            array( 'si-fixes', 'si-learning-design' ), $v );
        wp_enqueue_style( 'si-posts',            $url . 'css/si-posts.css',            array( 'si-components' ),                  $v );

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
