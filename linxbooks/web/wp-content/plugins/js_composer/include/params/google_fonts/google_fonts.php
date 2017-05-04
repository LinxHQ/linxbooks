<?php

/**
 * Class Vc_Google_Fonts
 * @since 4.3
 * vc_map examples:
 *      'params' => array(
 *          array(
 *                'type' => 'google_fonts',
 *                'param_name' => 'google_fonts',
 *                'value' => '',// Not recommended, this will override 'settings'. Example: 'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900 bold italic:900:italic'),
 *                'settings' => array(
 *                    //'no_font_style' // Method 1: To disable font style
 *                    //'no_font_style'=>true // Method 2: To disable font style
 *                    'fields'=>array(
 *                        'font_family'=>'Abril Fatface:regular',// 'Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic', Default font family and all available styles to fetch
 *                        'font_style'=>'400 regular:400:normal', // Default font style. Name:weight:style, example: "800 bold regular:800:normal"
 *                        'font_family_description' => __('Select font family.','js_composer'),
 *                        'font_style_description' => __('Select font styling.','js_composer')
 *                  )
 *                ),
 *                'description' => __( 'Description for this group', 'js_composer' ), // Description for field group
 *            ),
 *      )
 */
class Vc_Google_Fonts {

	/**
	 * @param $settings
	 * @param $value
	 *
	 * @since 4.3
	 * @return string
	 */
	public function render( $settings, $value ) {
		$fields = array();
		$values = array();
		$set = isset( $settings['settings'], $settings['settings']['fields'] ) ? $settings['settings']['fields'] : array();
		extract( $this->_vc_google_fonts_parse_attributes( $set, $value ) );
		ob_start();
		require_once vc_path_dir( 'TEMPLATES_DIR', 'params/google_fonts/template.php' );

		return ob_get_clean();
	}

	/**
	 * Load google fonts list for param
	 * To change this list use add_filters('vc_google_fonts_get_fonts_filter','your_custom_function'); and change array
	 * vc_filter: vc_google_fonts_get_fonts_filter
	 * @since 4.3
	 * @return array List of available fonts as array of objects. {"font_family":"Abril Fatface","font_styles":"regular","font_types":"400 regular:400:normal"}
	 */
	public function _vc_google_fonts_get_fonts() {
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		return apply_filters( 'vc_google_fonts_get_fonts_filter', json_decode( $wp_filesystem->get_contents( vc_path_dir( 'ASSETS_DIR', 'js/params/google_fonts.json' ) ) ) );
	}

	/**
	 * @param $attr
	 * @param $value
	 *
	 * @since 4.3
	 * @return array
	 */
	public function _vc_google_fonts_parse_attributes( $attr, $value ) {
		$fields = array();
		if ( is_array( $attr ) && ! empty( $attr ) ) {
			foreach ( $attr as $key => $val ) {
				if ( is_numeric( $key ) ) {
					$fields[ $val ] = "";
				} else {
					$fields[ $key ] = $val;
				}
			}
		}

		$values = vc_parse_multi_attribute( $value, array(
			'font_family' => isset( $fields['font_family'] ) ? $fields['font_family'] : '',
			'font_style' => isset( $fields['font_style'] ) ? $fields['font_style'] : '',
			'font_family_description' => isset( $fields['font_family_description'] ) ? $fields['font_family_description'] : '',
			'font_style_description' => isset( $fields['font_style_description'] ) ? $fields['font_style_description'] : '',
		) );

		return array( 'fields' => $fields, 'values' => $values );
	}
}

/**
 * Function for rendering param in edit form (add element)
 * Parse settings from vc_map and entered values.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.3
 * vc_filter: vc_google_fonts_render_filter
 * @return mixed|void rendered template for params in edit form
 *
 */
function vc_google_fonts_form_field( $settings, $value ) {
	$google_fonts = new Vc_Google_Fonts();

	return apply_filters( 'vc_google_fonts_render_filter', $google_fonts->render( $settings, $value ) );
}
