<?php

/**
 * Class Vc_Pageable
 */
abstract class WPBakeryShortCodeVc_Pageable extends WPBakeryShortCode {

	/**
	 * @param $settings
	 */
	public function __construct( $settings ) {
		parent::__construct( $settings );
		$this->shortcodeScripts();
	}

	/**
	 * Register scripts and styles for pager
	 */
	public function shortcodeScripts() {
		wp_register_script( 'vc_pageable_owl-carousel', vc_asset_url( 'lib/owl-carousel2-dist/owl.carousel.js' ), array(
			'jquery',
		), WPB_VC_VERSION, true );
		wp_register_script( 'waypoints', vc_asset_url( 'lib/waypoints/waypoints.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true );
		//wp_register_script( 'waypoints-infinite', vc_asset_url( 'lib/jquery-waypoints/shortcuts/infinite-scroll/waypoints-infinite.js' ), array( 'jquery', 'waypoints' ), WPB_VC_VERSION, true );

		wp_register_style( 'vc_pageable_owl-carousel-css', vc_asset_url( 'lib/owl-carousel2-dist/assets/owl.carousel.css' ), array(), WPB_VC_VERSION, false );
		wp_register_style( 'vc_pageable_owl-carousel-css-theme', vc_asset_url( 'lib/owl-carousel2-dist/assets/owl.theme.default.css' ), array(), WPB_VC_VERSION, false );
		//wp_register_script( 'jquery-mousewheel', vc_asset_url( 'lib/jquery-mousewheel/jquery.mousewheel.js' ), array( 'jquery' ), WPB_VC_VERSION, false );
		wp_register_style( 'animate-css', vc_asset_url( 'lib/animate-css/animate.css' ), array(), WPB_VC_VERSION, false );
	}

	/**
	 * @param $grid_style
	 * @param $settings
	 * @param $content
	 *
	 * @return string
	 */
	protected function contentAll( $grid_style, $settings, $content ) {
		return '<div class="vc_pageable-slide-wrapper" data-vc-grid-content="true">' . $content . '</div>';
	}

	/**
	 * @param $grid_style
	 * @param $settings
	 * @param $content
	 *
	 * @return string
	 */
	protected function contentLoadMore( $grid_style, $settings, $content ) {
		return '<div class="vc_pageable-slide-wrapper" data-vc-grid-content="true">'
		       . $content
		       . '</div>'
		       . '<div class="vc_pageable-load-more-btn" data-vc-grid-load-more-btn="true">'
		       . do_shortcode( '[vc_button2 size="' . $settings['button_size'] . '" title="' . __( 'Load more', 'js_composer' ) . '" style="' . $settings['button_style'] . '" color="' . $settings['button_color'] . '" el_class="vc_grid-btn-load_more"]' )
		       . '</div>';
	}

	/**
	 * @param $grid_style
	 * @param $settings
	 * @param $content
	 *
	 * @return string
	 */
	protected function contentLazy( $grid_style, $settings, $content ) {
		return '<div class="vc_pageable-slide-wrapper" data-vc-grid-content="true">'
		       . $content
		       . '</div><div data-lazy-loading-btn="true" style="display: none;"><a href="' . get_permalink( $settings['page_id'] ) . '"></a></div>';
	}

	/**
	 * @param $grid_style
	 * @param $settings
	 * @param string $content
	 *
	 * @param string $css_class
	 *
	 * @return string
	 */
	public function renderPagination( $grid_style, $settings, $content = '', $css_class = '' ) {
		//if ( ! isset( $settings['shortcode_hash'] ) ) {
		//	throw new Exception( 'You must provide shortcode_hash' );
		//}
		$css_class .= empty( $css_class ) ? '' : ' ' . 'vc_pageable-wrapper vc_hook_hover';
		$content_method = vc_camel_case( 'content-' . $grid_style );
		$content = method_exists( $this, $content_method ) ? $this->$content_method( $grid_style, $settings, $content ) : $content;

		$output = '<div class="' . esc_attr( $css_class ) . '" data-vc-pageable-content="true">'
		          . $content . '</div>';

		return $output;

	}

	public function enqueueScripts() {
		wp_enqueue_script( 'vc_pageable_owl-carousel' );
		wp_enqueue_style( 'vc_pageable_owl-carousel-css' );
		wp_enqueue_style( 'vc_pageable_owl-carousel-css-theme' );
		wp_enqueue_style( 'animate-css' );
	}

	/**
	 * Find pager data for ajax, must be overwritten
	 *
	 * @param array $vc_request_param request param [data]
	 *
	 * @return string - rendered content for ajax
	 */
	abstract function renderAjax( $vc_request_param );
}