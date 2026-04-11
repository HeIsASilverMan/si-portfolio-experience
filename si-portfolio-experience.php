<?php
/**
 * Plugin Name:       SI Portfolio Experience
 * Plugin URI:        https://shaneivers.com
 * Description:       Bespoke portfolio plugin for Shane Ivers - composer and learning designer.
 * Version:           1.6.0
 * Author:            Shane Ivers
 * Author URI:        https://shaneivers.com
 * Text Domain:       si-portfolio
 * GitHub Plugin URI: shaneivers/si-portfolio-experience
 * GitHub Branch:     main
 */

defined( 'ABSPATH' ) || exit;

define( 'SI_VERSION',    '1.6.0' );
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
    $file = SI_PLUGIN_DIR . 'templates/site-header.php';
    if ( file_exists( $file ) ) {
        include $file;
    }
}
add_action( 'si_header', 'si_render_header' );

function si_render_footer() {
    $file = SI_PLUGIN_DIR . 'templates/site-footer.php';
    if ( file_exists( $file ) ) {
        include $file;
    }
}
add_action( 'si_footer', 'si_render_footer' );
