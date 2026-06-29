<?php
/**
 * Plugin Name:       Greenate
 * Description:        Custom Elementor widgets — Banner Carousel, Product Card Slider, and Testimonial Slider — for the Greenate landing page.
 * Version:           1.0.0
 * Author:            Maulana Zakaria
 * Author URI:        https://maulanazakaria.web.id
 * Text Domain:       greenate
 * Requires at least: 6.0
 * Requires PHP:      7.4
 *
 * Requires Elementor 3.5+ (uses the modern widget registration API).
 *
 * @package Greenate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'GNT_VERSION', '1.0.0' );
define( 'GNT_FILE', __FILE__ );
define( 'GNT_PATH', plugin_dir_path( __FILE__ ) );
define( 'GNT_URL', plugin_dir_url( __FILE__ ) );
define( 'GNT_MIN_ELEMENTOR_VERSION', '3.5.0' );

/**
 * Lightweight PSR-4 style autoloader — works with ZERO build step.
 * The reviewer does not need to run `composer install`.
 */
spl_autoload_register(
	function ( $class ) {
		$prefix   = 'Greenate\\';
		$base_dir = GNT_PATH . 'src/';

		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class, $len ) !== 0 ) {
			return;
		}

		$relative = substr( $class, $len );
		$file     = $base_dir . str_replace( '\\', '/', $relative ) . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

/**
 * Boot once all plugins are loaded so Elementor can be safely detected.
 */
add_action(
	'plugins_loaded',
	function () {
		\Greenate\Plugin::instance();
	}
);
