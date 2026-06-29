/**
 * Greenate — generic Swiper initialiser.
 *
 * Each slider widget outputs a `.gnt-swiper` wrapper with a `data-gnt-swiper`
 * attribute holding its JSON config. No inline scripts, no hardcoded settings.
 */
( function () {
	'use strict';

	function initSlider( el ) {
		if ( ! el || el.dataset.gntInit === '1' || typeof Swiper === 'undefined' ) {
			return;
		}

		var raw = el.getAttribute( 'data-gnt-swiper' ) || '{}';
		var cfg;
		try {
			cfg = JSON.parse( raw );
		} catch ( e ) {
			cfg = {};
		}

		var container = el.querySelector( '.swiper' );
		if ( ! container ) {
			return;
		}

		var options = {
			slidesPerView: cfg.slidesPerView || 1,
			spaceBetween: typeof cfg.spaceBetween === 'number' ? cfg.spaceBetween : 24,
			speed: cfg.speed || 600,
			breakpoints: cfg.breakpoints || {},
			watchOverflow: true,
			grabCursor: true
		};

		// Infinite loop only works when there are MORE slides than are visible.
		// With <= visible slides, Swiper's loop breaks the layout, so we disable it.
		var slideCount = container.querySelectorAll( '.swiper-wrapper > .swiper-slide' ).length;
		var maxPerView = Number( options.slidesPerView ) || 1;
		if ( cfg.breakpoints ) {
			Object.keys( cfg.breakpoints ).forEach( function ( bp ) {
				var v = Number( cfg.breakpoints[ bp ] && cfg.breakpoints[ bp ].slidesPerView );
				if ( v && v > maxPerView ) {
					maxPerView = v;
				}
			} );
		}

		options.loop = !! cfg.loop && slideCount > maxPerView;
		if ( options.loop ) {
			options.loopAdditionalSlides = 2;
		}

		if ( cfg.autoplay ) {
			options.autoplay = cfg.autoplay;
		}

		if ( cfg.pagination ) {
			options.pagination = {
				el: container.querySelector( '.swiper-pagination' ),
				clickable: true
			};
		}

		if ( cfg.navigation ) {
			options.navigation = {
				prevEl: container.querySelector( '.swiper-button-prev' ),
				nextEl: container.querySelector( '.swiper-button-next' )
			};
		}

		if ( cfg.centeredSlides ) {
			options.centeredSlides = true;
		}

		// eslint-disable-next-line no-new
		new Swiper( container, options );
		el.dataset.gntInit = '1';
	}

	function initAll( scope ) {
		var root = scope || document;
		var nodes = root.querySelectorAll( '.gnt-swiper' );
		Array.prototype.forEach.call( nodes, initSlider );
	}

	// Front-end.
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function () {
			initAll();
		} );
	} else {
		initAll();
	}

	// Elementor editor live-preview: re-init when a widget is (re)rendered.
	window.addEventListener( 'elementor/frontend/init', function () {
		if ( ! window.elementorFrontend ) {
			return;
		}
		var handler = function ( $scope ) {
			initAll( $scope && $scope[ 0 ] ? $scope[ 0 ] : undefined );
		};
		elementorFrontend.hooks.addAction( 'frontend/element_ready/gnt_banner_carousel.default', handler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/gnt_product_cards.default', handler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/gnt_testimonial.default', handler );
	} );
} )();
