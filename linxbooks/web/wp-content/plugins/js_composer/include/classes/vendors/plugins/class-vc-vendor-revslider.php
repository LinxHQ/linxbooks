<?php

/**
 * RevSlider loader.
 * @since 4.3
 */
class Vc_Vendor_Revslider implements Vc_Vendor_Interface {
	/**
	 * @since 4.3
	 * @var int - index of revslider
	 */
	protected static $instanceIndex = 1;

	/**
	 * Add shortcode to visual composer also add fix for frontend to regenerate id of revslider.
	 * @since 4.3
	 */
	public function load() {
		add_action( 'vc_after_mapping', array( &$this, 'buildShortcode' ) );

	}

	/**
	 * @since 4.3
	 */
	public function buildShortcode() {
		if ( class_exists( 'RevSlider' ) ) {

			$slider = new RevSlider();
			$arrSliders = $slider->getArrSliders();

			$revsliders = array();
			if ( $arrSliders ) {
				foreach ( $arrSliders as $slider ) {
					/** @var $slider RevSlider */
					$revsliders[ $slider->getTitle() ] = $slider->getAlias();
				}
			} else {
				$revsliders[ __( 'No sliders found', 'js_composer' ) ] = 0;
			}
			// add shortcode to visual composer
			$this->mapShortcode( $revsliders );
			// Add fixes for frontend editor to regenerate id
			if ( vc_is_frontend_ajax() || vc_is_frontend_editor() ) {
				add_filter( 'vc_revslider_shortcode', array( &$this, 'setId' ) );
			}
		}
	}

	/**
	 * @since 4.4
	 *
	 * @param array $revsliders
	 */
	public function mapShortcode( $revsliders = array() ) {
		vc_map( array(
			'base' => 'rev_slider_vc',
			'name' => __( 'Revolution Slider', 'js_composer' ),
			'icon' => 'icon-wpb-revslider',
			'category' => __( 'Content', 'js_composer' ),
			'description' => __( 'Place Revolution slider', 'js_composer' ),
			"params" => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Widget title', 'js_composer' ),
					'param_name' => 'title',
					'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Revolution Slider', 'js_composer' ),
					'param_name' => 'alias',
					'admin_label' => true,
					'value' => $revsliders,
					'description' => __( 'Select your Revolution Slider.', 'js_composer' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'js_composer' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
				)
			)
		) );
	}

	/**
	 * Replaces id of revslider for frontend editor.
	 * @since 4.3
	 *
	 * @param $output
	 *
	 * @return string
	 */
	public function setId( $output ) {
		return preg_replace( '/rev_slider_(\d+)_(\d+)/', 'rev_slider_$1_$2' . time() . '_' . self::$instanceIndex ++, $output );
	}

}