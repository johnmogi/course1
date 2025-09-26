<?php
/**
 * Plugin Name: WP Courses Lite
 * Plugin URI:  https://course1.local/
 * Description: Lightweight courses plugin with WooCommerce enrollment integration.
 * Version:     0.1.0
 * Author:      john
 * Author URI:  https://course1.local/
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-courses-lite
 */

define( 'WCL_PLUGIN_FILE', __FILE__ );
define( 'WCL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WCL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

autoload_wcl();

/**
 * Load Composer autoloader if available.
 *
 * @return void
 */
function autoload_wcl() {
	$autoload = WCL_PLUGIN_DIR . 'vendor/autoload.php';

	if ( file_exists( $autoload ) ) {
		require_once $autoload;
	}
}

add_action( 'plugins_loaded', static function () {
	if ( ! class_exists( '\\WCL\\Plugin' ) ) {
		return;
	}

	\WCL\Plugin::boot();
} );

register_activation_hook( WCL_PLUGIN_FILE, static function () {
	if ( class_exists( '\\WCL\\Plugin' ) ) {
		\WCL\Plugin::activate();
	}
} );

register_deactivation_hook( WCL_PLUGIN_FILE, static function () {
	if ( class_exists( '\\WCL\\Plugin' ) ) {
		\WCL\Plugin::deactivate();
	}
} );
