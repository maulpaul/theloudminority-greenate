<?php
/**
 * Main plugin orchestrator.
 *
 * @package Greenate
 */

namespace Greenate;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {

	/**
	 * @var Plugin|null
	 */
	private static $instance = null;

	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		if ( ! $this->is_elementor_ready() ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_elementor' ) );
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
	}

	/**
	 * Elementor active + version check.
	 */
	private function is_elementor_ready(): bool {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return false;
		}
		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, GNT_MIN_ELEMENTOR_VERSION, '<' ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Register (not enqueue) assets. Widgets pull them in on demand via get_*_depends().
	 *
	 * Swiper is loaded from a pinned CDN for a zero-config skeleton.
	 * NOTE: Elementor Free bundles Swiper under the handle `swiper`. To use Elementor's copy,
	 *       swap the dependency arrays in the widgets to `array( 'swiper' )` and drop the two
	 *       Swiper registrations below.
	 */
	public function register_assets(): void {
		wp_register_style(
			'gnt-swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
			array(),
			'11.0.0'
		);
		wp_register_script(
			'gnt-swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
			array(),
			'11.0.0',
			true
		);

		wp_register_style(
			'gnt-widgets',
			GNT_URL . 'assets/css/greenate.css',
			array(),
			GNT_VERSION
		);

		wp_register_script(
			'gnt-init',
			GNT_URL . 'assets/js/greenate.js',
			array( 'gnt-swiper' ),
			GNT_VERSION,
			true
		);
	}

	/**
	 * Dedicated panel category so all Greenate widgets group together.
	 */
	public function register_category( $elements_manager ): void {
		$elements_manager->add_category(
			'greenate',
			array(
				'title' => esc_html__( 'Greenate', 'greenate' ),
				'icon'  => 'fa fa-leaf',
			)
		);
	}

	/**
	 * Register the widgets with Elementor.
	 */
	public function register_widgets( $widgets_manager ): void {
		$widgets_manager->register( new Widgets\Banner_Carousel() );
		$widgets_manager->register( new Widgets\Product_Card_Grid() );
		$widgets_manager->register( new Widgets\Testimonial() );
	}

	public function admin_notice_missing_elementor(): void {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		printf(
			'<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
			esc_html__( 'Greenate requires Elementor 3.5 or higher to be installed and active.', 'greenate' )
		);
	}
}
