<?php
defined( 'ABSPATH' ) || exit;

class SI_Enqueue {

    public static function init() {
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
    }

    public static function enqueue() {
        $url = SI_PLUGIN_URL . 'assets/';
        $v   = SI_VERSION;

        wp_enqueue_style( 'si-fonts-instrument',
            'https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&display=swap',
            array(), null );

        wp_enqueue_style( 'si-variables',  $url . 'css/si-variables.css',  array(),                  $v );
        wp_enqueue_style( 'si-base',       $url . 'css/si-base.css',       array('si-variables'),    $v );
        wp_enqueue_style( 'si-components', $url . 'css/si-components.css', array('si-base'),         $v );
        wp_enqueue_style( 'si-animations', $url . 'css/si-animations.css', array('si-base'),         $v );
        wp_enqueue_style( 'si-layout',     $url . 'css/si-layout.css',     array('si-components'),   $v );
        wp_enqueue_style( 'si-home',       $url . 'css/si-home.css',       array('si-components'),   $v );

        wp_enqueue_script( 'si-scroll-observer', $url . 'js/si-scroll-observer.js', array(), $v, true );
        wp_enqueue_script( 'si-counters',        $url . 'js/si-counters.js',        array(), $v, true );
        wp_enqueue_script( 'si-marquee',         $url . 'js/si-marquee.js',         array(), $v, true );
        wp_enqueue_script( 'si-magnetic',        $url . 'js/si-magnetic-button.js', array(), $v, true );
        wp_enqueue_script( 'si-nav',             $url . 'js/si-nav.js',             array(), $v, true );
    }
}
