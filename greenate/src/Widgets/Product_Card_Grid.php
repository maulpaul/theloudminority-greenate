<?php
/**
 * Product Card Slider widget.
 *
 * @package Greenate
 */

namespace Greenate\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Greenate\Traits\Slider_Controls;

class Product_Card_Grid extends Widget_Base {

	use Slider_Controls;

	public function get_name(): string {
		return 'gnt_product_cards';
	}

	public function get_title(): string {
		return esc_html__( 'Greenate Product Cards', 'greenate' );
	}

	public function get_icon(): string {
		return 'eicon-products';
	}

	public function get_categories(): array {
		return array( 'greenate' );
	}

	public function get_keywords(): array {
		return array( 'product', 'card', 'shop', 'slider', 'greenate' );
	}

	public function get_style_depends(): array {
		return array( 'gnt-swiper', 'gnt-widgets' );
	}

	public function get_script_depends(): array {
		return array( 'gnt-swiper', 'gnt-init' );
	}

	protected function register_controls(): void {

		/* ================================================================
		 * CONTENT: Products
		 * ================================================================ */
		$this->start_controls_section(
			'section_products',
			array(
				'label' => esc_html__( 'Products', 'greenate' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Product Image', 'greenate' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => Utils::get_placeholder_image_src() ),
			)
		);

		$repeater->add_control(
			'badge',
			array(
				'label'   => esc_html__( 'Badge — Main Text', 'greenate' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '100%', 'greenate' ),
			)
		);

		$repeater->add_control(
			'badge_sub',
			array(
				'label'   => esc_html__( 'Badge — Subtext', 'greenate' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Organic', 'greenate' ),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Product Name', 'greenate' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Coconut Palm Sugar', 'greenate' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'greenate' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => esc_html__( 'Low glycemic, healthy sugar 680gr', 'greenate' ),
			)
		);

		$repeater->add_control(
			'btn1_text',
			array(
				'label'   => esc_html__( 'Button 1 Text', 'greenate' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Add to Cart', 'greenate' ),
			)
		);

		$repeater->add_control(
			'btn1_link',
			array(
				'label'   => esc_html__( 'Button 1 Link', 'greenate' ),
				'type'    => Controls_Manager::URL,
				'default' => array( 'url' => '#' ),
			)
		);

		$repeater->add_control(
			'btn2_text',
			array(
				'label'   => esc_html__( 'Button 2 Text', 'greenate' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Buy Now', 'greenate' ),
			)
		);

		$repeater->add_control(
			'btn2_link',
			array(
				'label'   => esc_html__( 'Button 2 Link', 'greenate' ),
				'type'    => Controls_Manager::URL,
				'default' => array( 'url' => '#' ),
			)
		);

		$this->add_control(
			'products',
			array(
				'label'       => esc_html__( 'Products', 'greenate' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'title' => esc_html__( 'Coconut Palm Sugar', 'greenate' ) ),
					array( 'title' => esc_html__( 'Virgin Coconut Oil', 'greenate' ) ),
					array( 'title' => esc_html__( 'Spinach Trottole', 'greenate' ) ),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();

		// Shared slider settings — products default 3 / 2 / 1.
		$this->register_slider_controls( 3, 2, 1 );

		/* ================================================================
		 * STYLE: Card
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => esc_html__( 'Card', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_base',
			array(
				'label' => esc_html__( 'Base Container', 'greenate' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'card_max_width',
			array(
				'label'       => esc_html__( 'Card Max Width', 'greenate' ),
				'description' => esc_html__( 'Caps each card so it stays slim on wide screens (centered in its slide).', 'greenate' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'range'       => array(
					'px' => array( 'min' => 200, 'max' => 600 ),
					'%'  => array( 'min' => 40, 'max' => 100 ),
				),
				'default'     => array( 'unit' => 'px', 'size' => 380 ),
				'selectors'   => array(
					'{{WRAPPER}} .gnt-card' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'base_bg',
			array(
				'label'     => esc_html__( 'Background', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .gnt-card' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'base_radius',
			array(
				'label'      => esc_html__( 'Radius (per corner)', 'greenate' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => 31,
					'right'    => 31,
					'bottom'   => 31,
					'left'     => 31,
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'base_padding',
			array(
				'label'      => esc_html__( 'Padding', 'greenate' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'      => 10,
					'right'    => 10,
					'bottom'   => 10,
					'left'     => 10,
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'box_gap',
			array(
				'label'      => esc_html__( 'Gap Between Inner Boxes', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 12 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_image_box',
			array(
				'label'     => esc_html__( 'Image Box', 'greenate' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'card_top_bg',
			array(
				'label'     => esc_html__( 'Background', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .gnt-card__media' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_info_box',
			array(
				'label'     => esc_html__( 'Info Box', 'greenate' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'content_align',
			array(
				'label'     => esc_html__( 'Content Alignment', 'greenate' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array( 'title' => esc_html__( 'Left', 'greenate' ), 'icon' => 'eicon-text-align-left' ),
					'center' => array( 'title' => esc_html__( 'Center', 'greenate' ), 'icon' => 'eicon-text-align-center' ),
					'right'  => array( 'title' => esc_html__( 'Right', 'greenate' ), 'icon' => 'eicon-text-align-right' ),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .gnt-card__body'    => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .gnt-card__actions' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_bg',
			array(
				'label'     => esc_html__( 'Background', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d8e9c4',
				'selectors' => array(
					'{{WRAPPER}} .gnt-card__body' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'body_radius',
			array(
				'label'      => esc_html__( 'Info Box Radius (per corner)', 'greenate' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => 16,
					'right'    => 16,
					'bottom'   => 16,
					'left'     => 16,
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card__body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'body_padding',
			array(
				'label'      => esc_html__( 'Info Box Padding', 'greenate' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'      => 20,
					'right'    => 20,
					'bottom'   => 22,
					'left'     => 20,
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/* ================================================================
		 * STYLE: Product Image
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_image',
			array(
				'label' => esc_html__( 'Product Image', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => esc_html__( 'Image Height', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 80, 'max' => 400 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 180 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card__img' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_max_width',
			array(
				'label'      => esc_html__( 'Image Max Width', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 60, 'max' => 400 ),
					'%'  => array( 'min' => 20, 'max' => 100 ),
				),
				'default'    => array( 'unit' => '%', 'size' => 100 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card__img' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'image_fit',
			array(
				'label'     => esc_html__( 'Image Fit', 'greenate' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'contain' => esc_html__( 'Contain', 'greenate' ),
					'cover'   => esc_html__( 'Cover', 'greenate' ),
				),
				'default'   => 'contain',
				'selectors' => array(
					'{{WRAPPER}} .gnt-card__img' => 'object-fit: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'media_padding',
			array(
				'label'      => esc_html__( 'Image Area Padding', 'greenate' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'      => 24,
					'right'    => 24,
					'bottom'   => 24,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card__media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'media_radius',
			array(
				'label'       => esc_html__( 'Image Area Radius (per corner)', 'greenate' ),
				'description' => esc_html__( 'Radius for the white image box — independent of the info box below.', 'greenate' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', '%' ),
				'default'     => array(
					'top'      => 16,
					'right'    => 16,
					'bottom'   => 16,
					'left'     => 16,
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'   => array(
					'{{WRAPPER}} .gnt-card__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/* ================================================================
		 * STYLE: Badge
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_badge',
			array(
				'label' => esc_html__( 'Badge', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'badge_help',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'The badge sits at the bottom-right corner of the product image area. Use the offsets to nudge it.', 'greenate' ),
				'content_classes' => 'elementor-descriptor',
			)
		);

		$this->add_control(
			'badge_bg',
			array(
				'label'     => esc_html__( 'Background', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4f7942',
				'selectors' => array(
					'{{WRAPPER}} .gnt-card__badge' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'badge_color',
			array(
				'label'     => esc_html__( 'Text Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .gnt-card__badge' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_padding',
			array(
				'label'      => esc_html__( 'Padding', 'greenate' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'top'      => 6,
					'right'    => 12,
					'bottom'   => 6,
					'left'     => 12,
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card__badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'badge_radius',
			array(
				'label'      => esc_html__( 'Radius (per corner)', 'greenate' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => 8,
					'right'    => 8,
					'bottom'   => 8,
					'left'     => 8,
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card__badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_offset_x',
			array(
				'label'      => esc_html__( 'Offset From Right', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 16 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card__badge' => 'right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_offset_y',
			array(
				'label'       => esc_html__( 'Offset From Image Bottom', 'greenate' ),
				'description' => esc_html__( 'Negative values let the badge straddle the image/body edge.', 'greenate' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'range'       => array( 'px' => array( 'min' => -40, 'max' => 40 ) ),
				'default'     => array( 'unit' => 'px', 'size' => -14 ),
				'selectors'   => array(
					'{{WRAPPER}} .gnt-card__badge' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'badge_main_typography',
				'label'          => esc_html__( 'Main Text Typography', 'greenate' ),
				'selector'       => '{{WRAPPER}} .gnt-card__badge-main',
				'fields_options' => array(
					'typography'  => array( 'default' => 'custom' ),
					'font_size'   => array( 'default' => array( 'unit' => 'px', 'size' => 18 ) ),
					'font_weight' => array( 'default' => '700' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'badge_sub_typography',
				'label'          => esc_html__( 'Subtext Typography', 'greenate' ),
				'selector'       => '{{WRAPPER}} .gnt-card__badge-sub',
				'fields_options' => array(
					'typography'  => array( 'default' => 'custom' ),
					'font_size'   => array( 'default' => array( 'unit' => 'px', 'size' => 10 ) ),
					'font_weight' => array( 'default' => '600' ),
				),
			)
		);

		$this->end_controls_section();

		/* ================================================================
		 * STYLE: Title
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Title', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1b4332',
				'selectors' => array(
					'{{WRAPPER}} .gnt-card__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'selector'       => '{{WRAPPER}} .gnt-card__title',
				// Figma uses "Baloo Bhai" — superseded on Google Fonts by "Baloo Bhai 2".
				'fields_options' => array(
					'typography'  => array( 'default' => 'custom' ),
					'font_family' => array( 'default' => 'Baloo Bhai 2' ),
					'font_weight' => array( 'default' => '600' ),
					'font_size'   => array( 'default' => array( 'unit' => 'px', 'size' => 20 ) ),
				),
			)
		);

		$this->add_control(
			'title_note',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Figma font "Baloo Bhai" is deprecated on Google Fonts; "Baloo Bhai 2" is its official replacement and matches visually.', 'greenate' ),
				'content_classes' => 'elementor-descriptor',
			)
		);

		$this->end_controls_section();

		/* ================================================================
		 * STYLE: Description
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_desc',
			array(
				'label' => esc_html__( 'Description', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2f3a2f',
				'selectors' => array(
					'{{WRAPPER}} .gnt-card__desc' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .gnt-card__desc',
			)
		);

		$this->end_controls_section();

		/* ================================================================
		 * STYLE: Buttons
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_buttons',
			array(
				'label' => esc_html__( 'Buttons', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .gnt-card__btn',
			)
		);

		$this->add_control(
			'btn_radius',
			array(
				'label'      => esc_html__( 'Radius', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 8 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card__btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'btn_padding',
			array(
				'label'      => esc_html__( 'Padding', 'greenate' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'      => 9,
					'right'    => 12,
					'bottom'   => 9,
					'left'     => 12,
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-card__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		/* ---- Button 1 (Add to Cart / ghost) ---- */
		$this->add_control(
			'heading_btn1',
			array(
				'label'     => esc_html__( 'Button 1 — Add to Cart', 'greenate' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_btn1' );

		$this->start_controls_tab( 'tab_btn1_normal', array( 'label' => esc_html__( 'Normal', 'greenate' ) ) );
		$this->add_control(
			'btn1_bg',
			array(
				'label'     => esc_html__( 'Background', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .gnt-card__btn--ghost' => 'background: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn1_color',
			array(
				'label'     => esc_html__( 'Text Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2f3a2f',
				'selectors' => array( '{{WRAPPER}} .gnt-card__btn--ghost' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn1_border',
			array(
				'label'     => esc_html__( 'Border Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d8e0d0',
				'selectors' => array( '{{WRAPPER}} .gnt-card__btn--ghost' => 'border-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_btn1_hover', array( 'label' => esc_html__( 'Hover', 'greenate' ) ) );
		$this->add_control(
			'btn1_bg_h',
			array(
				'label'     => esc_html__( 'Background', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2f3a2f',
				'selectors' => array( '{{WRAPPER}} .gnt-card__btn--ghost:hover' => 'background: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn1_color_h',
			array(
				'label'     => esc_html__( 'Text Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .gnt-card__btn--ghost:hover' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn1_border_h',
			array(
				'label'     => esc_html__( 'Border Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2f3a2f',
				'selectors' => array( '{{WRAPPER}} .gnt-card__btn--ghost:hover' => 'border-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		/* ---- Button 2 (Buy Now / primary) ---- */
		$this->add_control(
			'heading_btn2',
			array(
				'label'     => esc_html__( 'Button 2 — Buy Now', 'greenate' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_btn2' );

		$this->start_controls_tab( 'tab_btn2_normal', array( 'label' => esc_html__( 'Normal', 'greenate' ) ) );
		$this->add_control(
			'btn2_bg',
			array(
				'label'     => esc_html__( 'Background', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2f3a2f',
				'selectors' => array( '{{WRAPPER}} .gnt-card__btn--primary' => 'background: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn2_color',
			array(
				'label'     => esc_html__( 'Text Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .gnt-card__btn--primary' => 'color: {{VALUE}};' ),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_btn2_hover', array( 'label' => esc_html__( 'Hover', 'greenate' ) ) );
		$this->add_control(
			'btn2_bg_h',
			array(
				'label'     => esc_html__( 'Background', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#46563f',
				'selectors' => array( '{{WRAPPER}} .gnt-card__btn--primary:hover' => 'background: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn2_color_h',
			array(
				'label'     => esc_html__( 'Text Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .gnt-card__btn--primary:hover' => 'color: {{VALUE}};' ),
			)
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['products'] ) ) {
			return;
		}

		$config = $this->build_slider_config( $settings );
		?>
		<div class="gnt-products gnt-swiper" data-gnt-swiper="<?php echo esc_attr( $config ); ?>">
			<div class="swiper">
				<div class="swiper-wrapper">
					<?php
					foreach ( $settings['products'] as $product ) :
						$img = ! empty( $product['image']['url'] ) ? $product['image']['url'] : Utils::get_placeholder_image_src();
						?>
						<div class="swiper-slide">
							<article class="gnt-card">
								<div class="gnt-card__media">
									<img class="gnt-card__img" src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $product['title'] ?? '' ); ?>" loading="lazy" />
									<?php if ( ! empty( $product['badge'] ) || ! empty( $product['badge_sub'] ) ) : ?>
										<span class="gnt-card__badge">
											<?php if ( ! empty( $product['badge'] ) ) : ?>
												<span class="gnt-card__badge-main"><?php echo esc_html( $product['badge'] ); ?></span>
											<?php endif; ?>
											<?php if ( ! empty( $product['badge_sub'] ) ) : ?>
												<span class="gnt-card__badge-sub"><?php echo esc_html( $product['badge_sub'] ); ?></span>
											<?php endif; ?>
										</span>
									<?php endif; ?>
								</div>
								<div class="gnt-card__body">
									<?php if ( ! empty( $product['title'] ) ) : ?>
										<h3 class="gnt-card__title"><?php echo esc_html( $product['title'] ); ?></h3>
									<?php endif; ?>
									<?php if ( ! empty( $product['description'] ) ) : ?>
										<p class="gnt-card__desc"><?php echo esc_html( $product['description'] ); ?></p>
									<?php endif; ?>

									<div class="gnt-card__actions">
										<?php
										$this->render_button( $product, 'btn1', 'gnt-card__btn gnt-card__btn--ghost' );
										$this->render_button( $product, 'btn2', 'gnt-card__btn gnt-card__btn--primary' );
										?>
									</div>
								</div>
							</article>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ( 'yes' === ( $settings['show_pagination'] ?? '' ) ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>

				<?php if ( 'yes' === ( $settings['show_navigation'] ?? '' ) ) : ?>
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render a single safe button from a repeater item.
	 */
	private function render_button( array $item, string $key, string $class ): void {
		$text = $item[ $key . '_text' ] ?? '';
		if ( '' === $text ) {
			return;
		}
		$link   = $item[ $key . '_link' ] ?? array();
		$href   = ! empty( $link['url'] ) ? $link['url'] : '#';
		$target = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
		$rel    = ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';
		printf(
			'<a class="%1$s" href="%2$s"%3$s%4$s>%5$s</a>',
			esc_attr( $class ),
			esc_url( $href ),
			$target, // safe literal
			$rel,    // safe literal
			esc_html( $text )
		);
	}
}
