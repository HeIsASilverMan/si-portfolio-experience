<?php
/**
 * Plugin Name:       SI Portfolio Experience
 * Plugin URI:        https://shaneivers.com
 * Description:       Bespoke portfolio plugin for Shane Ivers - composer and learning designer.
 * Version:           1.9.6
 * Author:            Shane Ivers
 * Author URI:        https://shaneivers.com
 * Text Domain:       si-portfolio
 * GitHub Plugin URI: shaneivers/si-portfolio-experience
 * GitHub Branch:     main
 */

defined( 'ABSPATH' ) || exit;

define( 'SI_VERSION',    '1.9.6' );
define( 'SI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once SI_PLUGIN_DIR . 'includes/class-si-admin.php';
require_once SI_PLUGIN_DIR . 'includes/class-si-enqueue.php';
require_once SI_PLUGIN_DIR . 'includes/class-si-cpts.php';
require_once SI_PLUGIN_DIR . 'includes/class-si-shortcodes.php';
require_once SI_PLUGIN_DIR . 'includes/class-si-forms.php';

function si_boot() {
    SI_Admin::init();
    SI_Enqueue::init();
    SI_CPTs::init();
    SI_Shortcodes::init();
    SI_Forms::init();
}
add_action( 'plugins_loaded', 'si_boot' );

function si_render_header() {
    if ( ! empty( $GLOBALS['si_header_rendered'] ) ) {
        return;
    }
    $GLOBALS['si_header_rendered'] = true;
    $file = SI_PLUGIN_DIR . 'templates/site-header.php';
    if ( file_exists( $file ) ) {
        include $file;
    }
}
add_action( 'wp_body_open', 'si_render_header', 5 );
add_action( 'si_header',    'si_render_header' );

function si_render_footer() {
    if ( ! empty( $GLOBALS['si_footer_rendered'] ) ) {
        return;
    }
    $GLOBALS['si_footer_rendered'] = true;
    $file = SI_PLUGIN_DIR . 'templates/site-footer.php';
    if ( file_exists( $file ) ) {
        include $file;
    }
}
add_action( 'wp_footer', 'si_render_footer', 5 );
add_action( 'si_footer', 'si_render_footer' );

function si_body_classes( $classes ) {
    if ( is_admin() ) {
        return $classes;
    }
    global $post;
    if ( ! $post ) {
        $classes[] = 'si-prose-page';
        return $classes;
    }
    $si_shortcodes = array(
        'si_home_hero', 'si_marquee', 'si_dual_showcase', 'si_testimonials',
        'si_cta_band', 'si_composition_hero', 'si_benefits_list',
        'si_process_timeline', 'si_audio_showcase', 'si_portfolio_grid',
        'si_approach_cards', 'si_tools_grid', 'si_awards',
        'si_education_timeline', 'si_ld_hero', 'si_about_story', 'si_connect',
        'si_form_composition', 'si_form_learning_design', 'si_posts_list',
    );
    $is_prose = true;
    foreach ( $si_shortcodes as $code ) {
        if ( has_shortcode( $post->post_content, $code ) ) {
            $is_prose = false;
            break;
        }
    }
    if ( $is_prose ) {
        $classes[] = 'si-prose-page';
    }
    return $classes;
}
add_filter( 'body_class', 'si_body_classes' );
