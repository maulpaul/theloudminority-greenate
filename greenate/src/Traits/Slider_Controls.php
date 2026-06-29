<?php
/**
 * Shared slider controls + Swiper config builder.
 *
 * Keeps the Banner, Product, and Testimonial widgets DRY: each gets the same
 * autoplay / loop / pagination / navigation / responsive-columns options.
 *
 * @package Greenate
 */

namespace Greenate\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;

trait Slider_Controls {

	/**
	 * Register the common "Slider Settings" controls section.
	 *
	 * @param int $cols_desktop Default columns on desktop.
	 * @param int $cols_tablet  Default columns on tablet.
	 * @param int $cols_mobile  Default columns on mobile.
	 */
	protected function register_slider_controls( int $cols_desktop = 3, int $cols_tablet = 2, int $cols_mobile = 1 ): void {

		$this->start_controls_section(
			'section_slider',
			array(
				'label' => esc_html__( 'Slider Settings', 'greenate' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'cols_desktop',
			array(
				'label'   => esc_html__( 'Columns (Desktop)', 'greenate' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 6,
				'default' => $cols_desktop,
			)
		);

		$this->add_control(
			'cols_tablet',
			array(
				'label'   => esc_html__( 'Columns (Tablet)', 'greenate' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 4,
				'default' => $cols_tablet,
			)
		);

		$this->add_control(
			'cols_mobile',
			array(
				'label'   => esc_html__( 'Columns (Mobile)', 'greenate' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 2,
				'default' => $cols_mobile,
			)
		);

		$this->add_control(
			'space_between',
			array(
				'label'   => esc_html__( 'Gap Between Slides (px)', 'greenate' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 120,
				'default' => 24,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'greenate' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'greenate' ),
				'label_off'    => esc_html__( 'Off', 'greenate' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'autoplay_delay',
			array(
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'greenate' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 500,
				'default'   => 4000,
				'condition' => array( 'autoplay' => 'yes' ),
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'greenate' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array( 'autoplay' => 'yes' ),
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'        => esc_html__( 'Infinite Loop', 'greenate' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Transition Speed (ms)', 'greenate' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 3000,
				'step'    => 100,
				'default' => 600,
			)
		);

		$this->add_control(
			'show_pagination',
			array(
				'label'        => esc_html__( 'Show Pagination Dots', 'greenate' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_navigation',
			array(
				'label'        => esc_html__( 'Show Arrows', 'greenate' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Build the Swiper config as a JSON string for the data-gnt-swiper attribute.
	 * The frontend JS reads this and instantiates Swiper — no inline scripts.
	 *
	 * @param array $settings Widget settings (from get_settings_for_display()).
	 * @param array $extra    Extra Swiper options to merge in (e.g. centeredSlides).
	 */
	protected function build_slider_config( array $settings, array $extra = array() ): string {
		$config = array(
			'speed'         => isset( $settings['speed'] ) ? (int) $settings['speed'] : 600,
			'loop'          => ( 'yes' === ( $settings['loop'] ?? '' ) ),
			'spaceBetween'  => isset( $settings['space_between'] ) ? (int) $settings['space_between'] : 24,
			'slidesPerView' => max( 1, (int) ( $settings['cols_mobile'] ?? 1 ) ),
			'pagination'    => ( 'yes' === ( $settings['show_pagination'] ?? '' ) ),
			'navigation'    => ( 'yes' === ( $settings['show_navigation'] ?? '' ) ),
			'breakpoints'   => array(
				// Mobile-first: base config above covers the smallest screens.
				768  => array(
					'slidesPerView' => max( 1, (int) ( $settings['cols_tablet'] ?? 2 ) ),
				),
				1025 => array(
					'slidesPerView' => max( 1, (int) ( $settings['cols_desktop'] ?? 3 ) ),
				),
			),
		);

		if ( 'yes' === ( $settings['autoplay'] ?? '' ) ) {
			$config['autoplay'] = array(
				'delay'                => isset( $settings['autoplay_delay'] ) ? (int) $settings['autoplay_delay'] : 4000,
				'disableOnInteraction' => false,
				'pauseOnMouseEnter'    => ( 'yes' === ( $settings['pause_on_hover'] ?? '' ) ),
			);
		}

		if ( ! empty( $extra ) ) {
			$config = array_merge( $config, $extra );
		}

		return wp_json_encode( $config );
	}
}
