<?php
/**
 * Testimonial Slider widget.
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
use Greenate\Traits\Slider_Controls;

class Testimonial extends Widget_Base {

	use Slider_Controls;

	public function get_name(): string {
		return 'gnt_testimonial';
	}

	public function get_title(): string {
		return esc_html__( 'Greenate Testimonials', 'greenate' );
	}

	public function get_icon(): string {
		return 'eicon-testimonial';
	}

	public function get_categories(): array {
		return array( 'greenate' );
	}

	public function get_keywords(): array {
		return array( 'testimonial', 'review', 'slider', 'greenate' );
	}

	public function get_style_depends(): array {
		return array( 'gnt-swiper', 'gnt-widgets' );
	}

	public function get_script_depends(): array {
		return array( 'gnt-swiper', 'gnt-init' );
	}

	protected function register_controls(): void {

		/* CONTENT: optional heading */
		$this->start_controls_section(
			'section_heading',
			array(
				'label' => esc_html__( 'Heading', 'greenate' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'section_title',
			array(
				'label'   => esc_html__( 'Section Title', 'greenate' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'What They Say', 'greenate' ),
			)
		);

		$this->end_controls_section();

		/* CONTENT: testimonials */
		$this->start_controls_section(
			'section_items',
			array(
				'label' => esc_html__( 'Testimonials', 'greenate' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'avatar',
			array(
				'label'   => esc_html__( 'Avatar', 'greenate' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => Utils::get_placeholder_image_src() ),
			)
		);

		$repeater->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Name', 'greenate' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Paula', 'greenate' ),
			)
		);

		$repeater->add_control(
			'role',
			array(
				'label'   => esc_html__( 'Role / Product', 'greenate' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Coconut Palm Sugar', 'greenate' ),
			)
		);

		$repeater->add_control(
			'rating',
			array(
				'label'   => esc_html__( 'Rating (0-5)', 'greenate' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 5,
				'step'    => 1,
				'default' => 5,
			)
		);

		$repeater->add_control(
			'quote',
			array(
				'label'   => esc_html__( 'Quote', 'greenate' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'greenate' ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Testimonials', 'greenate' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'name' => esc_html__( 'Paula', 'greenate' ) ),
					array( 'name' => esc_html__( 'David', 'greenate' ) ),
					array( 'name' => esc_html__( 'Diana', 'greenate' ) ),
				),
				'title_field' => '{{{ name }}}',
			)
		);

		$this->end_controls_section();

		// Shared slider settings — testimonials default 3 / 2 / 1.
		$this->register_slider_controls( 3, 2, 1 );

		/* STYLE — TODO: sync exact Figma values. */
		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__( 'Heading Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1b4332',
				'selectors' => array(
					'{{WRAPPER}} .gnt-testi__heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_bg',
			array(
				'label'     => esc_html__( 'Card Background', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d8e9c4',
				'selectors' => array(
					'{{WRAPPER}} .gnt-testi__card' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'star_color',
			array(
				'label'     => esc_html__( 'Star Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f5a623',
				'selectors' => array(
					'{{WRAPPER}} .gnt-testi__stars .gnt-star.is-on' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'star_empty_color',
			array(
				'label'     => esc_html__( 'Empty Star Color', 'greenate' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5c0',
				'selectors' => array(
					'{{WRAPPER}} .gnt-testi__stars .gnt-star' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'star_size',
			array(
				'label'      => esc_html__( 'Star Size', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 10, 'max' => 60 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 18 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-testi__stars' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'star_gap',
			array(
				'label'      => esc_html__( 'Star Spacing', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 16 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 2 ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-testi__stars' => 'letter-spacing: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/* ================================================================
		 * STYLE: Center Highlight (raised active card)
		 * ================================================================ */
		$this->start_controls_section(
			'section_style_center',
			array(
				'label' => esc_html__( 'Center Highlight', 'greenate' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'elevate_center',
			array(
				'label'        => esc_html__( 'Raise Active Card', 'greenate' ),
				'description'  => esc_html__( 'The center (active) card stays up while the side cards sit lower, so the middle looks raised. Animates smoothly as autoplay advances.', 'greenate' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'greenate' ),
				'label_off'    => esc_html__( 'Off', 'greenate' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_responsive_control(
			'elevate_amount',
			array(
				'label'      => esc_html__( 'Raise Amount', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 40 ),
				'condition'  => array( 'elevate_center' => 'yes' ),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-slide:not(.swiper-slide-active) .gnt-testi__card' => 'transform: translateY({{SIZE}}{{UNIT}});',
				),
			)
		);

		$this->add_control(
			'elevate_speed',
			array(
				'label'      => esc_html__( 'Animation Speed (ms)', 'greenate' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '' ),
				'range'      => array( '' => array( 'min' => 100, 'max' => 1500, 'step' => 50 ) ),
				'default'    => array( 'size' => 600 ),
				'condition'  => array( 'elevate_center' => 'yes' ),
				'selectors'  => array(
					'{{WRAPPER}} .gnt-testi__card' => 'transition-duration: {{SIZE}}ms;',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['items'] ) ) {
			return;
		}

		$extra = array();
		if ( 'yes' === ( $settings['elevate_center'] ?? '' ) ) {
			$extra['centeredSlides'] = true;
		}
		$config = $this->build_slider_config( $settings, $extra );
		?>
		<div class="gnt-testi">
			<?php if ( ! empty( $settings['section_title'] ) ) : ?>
				<h2 class="gnt-testi__heading"><?php echo esc_html( $settings['section_title'] ); ?></h2>
			<?php endif; ?>

			<div class="gnt-swiper" data-gnt-swiper="<?php echo esc_attr( $config ); ?>">
				<div class="swiper">
					<div class="swiper-wrapper">
						<?php
						foreach ( $settings['items'] as $item ) :
							$avatar = ! empty( $item['avatar']['url'] ) ? $item['avatar']['url'] : Utils::get_placeholder_image_src();
							$rating = isset( $item['rating'] ) ? (int) $item['rating'] : 0;
							?>
							<div class="swiper-slide">
								<article class="gnt-testi__card">
									<div class="gnt-testi__avatar">
										<img src="<?php echo esc_url( $avatar ); ?>" alt="<?php echo esc_attr( $item['name'] ?? '' ); ?>" loading="lazy" />
									</div>
									<?php if ( ! empty( $item['name'] ) ) : ?>
										<h3 class="gnt-testi__name"><?php echo esc_html( $item['name'] ); ?></h3>
									<?php endif; ?>
									<?php if ( ! empty( $item['role'] ) ) : ?>
										<p class="gnt-testi__role"><?php echo esc_html( $item['role'] ); ?></p>
									<?php endif; ?>

									<div class="gnt-testi__stars" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: rating */ __( '%d out of 5 stars', 'greenate' ), $rating ) ); ?>">
										<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
											<span class="gnt-star <?php echo $i <= $rating ? 'is-on' : ''; ?>" aria-hidden="true">&#9733;</span>
										<?php endfor; ?>
									</div>

									<?php if ( ! empty( $item['quote'] ) ) : ?>
										<p class="gnt-testi__quote"><?php echo esc_html( $item['quote'] ); ?></p>
									<?php endif; ?>
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
		</div>
		<?php
	}
}
