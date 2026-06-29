<?php
/**
 * Banner Carousel widget — full-width hero slider.
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

class Banner_Carousel extends Widget_Base {

	use Slider_Controls;

	public function get_name(): string {
		return 'gnt_banner_carousel';
	}

	public function get_title(): string {
		return esc_html__( 'Greenate Banner Carousel', 'greenate' );
	}

	public function get_icon(): string {
		return 'eicon-slides';
	}

	public function get_categories(): array {
		return array( 'greenate' );
	}

	public function get_keywords(): array {
		return array( 'banner', 'hero', 'carousel', 'slider', 'greenate' );
	}

	public function get_style_depends(): array {
		return array( 'gnt-swiper', 'gnt-widgets' );
	}

	public function get_script_depends(): array {
		return array( 'gnt-swiper', 'gnt-init' );
	}

	protected function register_controls(): void {

		/* ----------------------------------------------------------------
		 * CONTENT: Slides
		 * ---------------------------------------------------------------- */
		$this->start_controls_section(
			'section_slides',
			array(
				'label' => esc_html__( 'Slides', 'greenate' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'bg_image',
			array(
				'label'   => esc_html__( 'Background Image', 'greenate' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => Utils::get_placeholder_image_src() ),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Heading', 'greenate' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'description' => esc_html__( 'Wrap any word in **double asterisks** to give it the green highlight band.', 'greenate' ),
				'default'     => '**Nourish** your body, sustain the **earth.**',
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'subtitle',
			array(
				'label'       => esc_html__( 'Subtitle', 'greenate' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => esc_html__( 'Every bite you take supports a healthier you and a greener planet.', 'greenate' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'greenate' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Learn More', 'greenate' ),
			)
		);

		$repeater->add_control(
			'button_link',
			array(
				'label'       => esc_html__( 'Button Link', 'greenate' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default'     => array( 'url' => '#' ),
			)
		);

		$this->add_control(
			'slides',
			array(
				'label'       => esc_html__( 'Banner Slides', 'greenate' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'title' => esc_html__( 'Nourish your body, sustain the earth.', 'greenate' ) ),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();

		/* ----------------------------------------------------------------
		 * CONTENT: Slider Settings (shared trait) — hero shows 1 at a time
		 * ---------------------------------------------------------------- */
		$this->register_slider_controls( 1, 1, 1 );

		/* ================================================================
		 * STYLE: Slide / Image
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_slide',
			array(
				'label' => esc_html__( 'Slide & Image', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'min_height',
			array(
				'label'      => esc_html__( 'Slide Height', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array( 'min' => 200, 'max' => 900 ),
					'vh' => array( 'min' => 20, 'max' => 100 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 460 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-banner__slide' => 'min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'radius',
			array(
				'label'      => esc_html__( 'Corner Radius', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 50 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-banner__slide' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'overlay_color',
			array(
				'label'     => esc_html__( 'Image Overlay', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.25)',
				'selectors' => array(
					'{{WRAPPER}} .gnt-banner__slide::before' => 'background: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/* ================================================================
		 * STYLE: Content Box  (position / spacing of the text block)
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content Box', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'content_vertical',
			array(
				'label'     => esc_html__( 'Vertical Position', 'greenate' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array( 'title' => esc_html__( 'Top', 'greenate' ), 'icon' => 'eicon-v-align-top' ),
					'center'     => array( 'title' => esc_html__( 'Middle', 'greenate' ), 'icon' => 'eicon-v-align-middle' ),
					'flex-end'   => array( 'title' => esc_html__( 'Bottom', 'greenate' ), 'icon' => 'eicon-v-align-bottom' ),
				),
				'default'   => 'flex-end',
				'selectors' => array(
					'{{WRAPPER}} .gnt-banner__slide' => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_horizontal',
			array(
				'label'     => esc_html__( 'Horizontal Position', 'greenate' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array( 'title' => esc_html__( 'Left', 'greenate' ), 'icon' => 'eicon-h-align-left' ),
					'center'     => array( 'title' => esc_html__( 'Center', 'greenate' ), 'icon' => 'eicon-h-align-center' ),
					'flex-end'   => array( 'title' => esc_html__( 'Right', 'greenate' ), 'icon' => 'eicon-h-align-right' ),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .gnt-banner__slide' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_text_align',
			array(
				'label'     => esc_html__( 'Text Align', 'greenate' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array( 'title' => esc_html__( 'Left', 'greenate' ), 'icon' => 'eicon-text-align-left' ),
					'center' => array( 'title' => esc_html__( 'Center', 'greenate' ), 'icon' => 'eicon-text-align-center' ),
					'right'  => array( 'title' => esc_html__( 'Right', 'greenate' ), 'icon' => 'eicon-text-align-right' ),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .gnt-banner__content' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_max_width',
			array(
				'label'      => esc_html__( 'Content Max Width', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 200, 'max' => 1100 ),
					'%'  => array( 'min' => 20, 'max' => 100 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 720 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-banner__content' => 'max-width: {{SIZE}}{{UNIT}}; width: 100%;',
				),
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'       => esc_html__( 'Content Padding', 'greenate' ),
				'description' => esc_html__( 'Nudge the text block — e.g. add bottom padding to lift it off the edge.', 'greenate' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', '%' ),
				'default'     => array(
					'top'      => 24,
					'right'    => 24,
					'bottom'   => 56,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'   => array(
					'{{WRAPPER}} .gnt-banner__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/* ================================================================
		 * STYLE: Heading
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_heading',
			array(
				'label' => esc_html__( 'Heading', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'selector'       => '{{WRAPPER}} .gnt-banner__title',
				// Defaults pulled straight from the Figma spec — fully editable.
				'fields_options' => array(
					'typography'     => array( 'default' => 'custom' ),
					'font_family'    => array( 'default' => 'Barrio' ),
					'font_weight'    => array( 'default' => '400' ),
					'font_size'      => array( 'default' => array( 'unit' => 'px', 'size' => 96 ) ),
					'line_height'    => array( 'default' => array( 'unit' => 'px', 'size' => 92.66 ) ),
					'letter_spacing' => array( 'default' => array( 'unit' => 'px', 'size' => 0 ) ),
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Text Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .gnt-banner__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'highlight_heading',
			array(
				'label'     => esc_html__( 'Highlight Band', 'greenate' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'highlight_help',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Wrap word(s) in **double asterisks** in the Heading field to apply the band. Example: **Nourish** your body.', 'greenate' ),
				'content_classes' => 'elementor-descriptor',
			)
		);

		$this->add_control(
			'title_highlight',
			array(
				'label'     => esc_html__( 'Band Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(118, 169, 80, 0.85)',
				'selectors' => array(
					'{{WRAPPER}} .gnt-banner__title .gnt-hl::before' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'highlight_height',
			array(
				'label'      => esc_html__( 'Band Height', 'greenate' ),
				'description' => esc_html__( 'In em — 0.5em is roughly half the font size.', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'em', 'px', '%' ),
				'range'      => array(
					'em' => array( 'min' => 0.1, 'max' => 1, 'step' => 0.01 ),
					'px' => array( 'min' => 4, 'max' => 100 ),
					'%'  => array( 'min' => 10, 'max' => 100 ),
				),
				'default'    => array( 'unit' => 'em', 'size' => 0.5 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-banner__title .gnt-hl::before' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'highlight_bottom',
			array(
				'label'      => esc_html__( 'Band Vertical Offset', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'em', 'px' ),
				'range'      => array(
					'em' => array( 'min' => -0.5, 'max' => 0.5, 'step' => 0.01 ),
					'px' => array( 'min' => -40, 'max' => 40 ),
				),
				'default'    => array( 'unit' => 'em', 'size' => 0.12 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-banner__title .gnt-hl::before' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'highlight_radius',
			array(
				'label'      => esc_html__( 'Band Radius', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 50 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 4 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-banner__title .gnt-hl::before' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'highlight_inset',
			array(
				'label'      => esc_html__( 'Band Side Extend', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'em', 'px' ),
				'range'      => array(
					'em' => array( 'min' => 0, 'max' => 0.5, 'step' => 0.01 ),
					'px' => array( 'min' => 0, 'max' => 40 ),
				),
				'default'    => array( 'unit' => 'em', 'size' => 0.08 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-banner__title .gnt-hl::before' => 'left: -{{SIZE}}{{UNIT}}; right: -{{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/* ================================================================
		 * STYLE: Subtitle
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_subtitle',
			array(
				'label' => esc_html__( 'Subtitle', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .gnt-banner__subtitle',
			)
		);

		$this->add_control(
			'subtitle_color',
			array(
				'label'     => esc_html__( 'Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .gnt-banner__subtitle' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/* ================================================================
		 * STYLE: Pagination
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_pagination',
			array(
				'label'     => esc_html__( 'Pagination', 'greenate' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array( 'show_pagination' => 'yes' ),
			)
		);

		$this->add_control(
			'pagination_position',
			array(
				'label'   => esc_html__( 'Position', 'greenate' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inside' => esc_html__( 'Inside Image', 'greenate' ),
					'below'  => esc_html__( 'Below Image', 'greenate' ),
				),
				'default' => 'inside',
			)
		);

		$this->add_responsive_control(
			'pagination_offset',
			array(
				'label'      => esc_html__( 'Distance From Bottom', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 16 ),
				'condition'  => array( 'pagination_position' => 'inside' ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-pg--inside .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'pagination_color',
			array(
				'label'     => esc_html__( 'Dot Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.5)',
				'selectors' => array(
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}; opacity: 1;',
				),
			)
		);

		$this->add_control(
			'pagination_active_color',
			array(
				'label'     => esc_html__( 'Active Dot Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pagination_size',
			array(
				'label'      => esc_html__( 'Dot Size', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 4, 'max' => 24 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 8 ),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'pagination_gap',
			array(
				'label'      => esc_html__( 'Dot Spacing', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 2, 'max' => 20 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 6 ),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$config = $this->build_slider_config( $settings );

		// Pagination position class (inside / below the image).
		$pg_pos        = in_array( $settings['pagination_position'] ?? 'inside', array( 'inside', 'below' ), true )
			? $settings['pagination_position']
			: 'inside';
		$wrap_classes  = 'gnt-banner gnt-swiper gnt-pg--' . sanitize_html_class( $pg_pos );
		?>
		<div class="<?php echo esc_attr( $wrap_classes ); ?>" data-gnt-swiper="<?php echo esc_attr( $config ); ?>">
			<div class="swiper">
				<div class="swiper-wrapper">
					<?php
					foreach ( $settings['slides'] as $slide ) :
						$bg      = ! empty( $slide['bg_image']['url'] ) ? $slide['bg_image']['url'] : Utils::get_placeholder_image_src();
						$has_btn = ! empty( $slide['button_text'] );

						$href   = ! empty( $slide['button_link']['url'] ) ? $slide['button_link']['url'] : '#';
						$target = ! empty( $slide['button_link']['is_external'] ) ? ' target="_blank"' : '';
						$rel    = ! empty( $slide['button_link']['nofollow'] ) ? ' rel="nofollow"' : '';
						?>
						<div class="swiper-slide">
							<div class="gnt-banner__slide" style="background-image:url('<?php echo esc_url( $bg ); ?>');">
								<div class="gnt-banner__content">
									<?php if ( ! empty( $slide['title'] ) ) : ?>
										<h2 class="gnt-banner__title"><?php echo $this->format_heading( $slide['title'] ); // already escaped in helper ?></h2>
									<?php endif; ?>

									<?php if ( ! empty( $slide['subtitle'] ) ) : ?>
										<p class="gnt-banner__subtitle"><?php echo esc_html( $slide['subtitle'] ); ?></p>
									<?php endif; ?>

									<?php if ( $has_btn ) : ?>
										<a class="gnt-banner__btn" href="<?php echo esc_url( $href ); ?>"<?php echo $target . $rel; // safe literal strings ?>>
											<?php echo esc_html( $slide['button_text'] ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
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
	 * Convert **marked** words in the heading into highlight spans.
	 *
	 * Security: the raw text is fully escaped with esc_html() FIRST, so any
	 * user markup is neutralised. Only then are the (static, safe) <span>
	 * wrappers injected around the chosen words. The asterisk markers survive
	 * esc_html untouched, which is what lets us target them afterwards.
	 *
	 * @param string $raw Raw heading text from the control.
	 * @return string Safe HTML.
	 */
	private function format_heading( string $raw ): string {
		$safe = esc_html( $raw );

		return preg_replace(
			'/\*\*(.+?)\*\*/s',
			'<span class="gnt-hl">$1</span>',
			$safe
		);
	}
}
