<?php
global $vc_params_preset_form_field_js_appended;
$vc_params_preset_form_field_js_appended = false;
/**
 * Params preset shortcode attribute type generator.
 *
 * Allows to set list of attributes which will be
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_params_preset_form_field( $settings, $value ) {
	global $vc_params_preset_form_field_js_appended;
	$output = '';
	$output .= '<select name="'
	           . $settings['param_name']
	           . '" class="wpb_vc_param_value vc_params-preset-select '
	           . $settings['param_name']
	           . ' ' . $settings['type']
	           . '">';
	foreach ( $settings['options'] as $option ) {
		$selected = '';
		if ( isset( $option['value'] ) ) {
			if ( $value !== '' && (string) $option['value'] === (string) $value ) {
				$selected = ' selected="selected"';
			}
			$output .= '<option class="vc_params-preset-' . $option['value']
			           . '" value="' . esc_attr( $option['value'] )
			           . '"' . $selected
			           . ' data-params="' . esc_attr( json_encode( $option['params'] ) ) . '">'
			           . esc_html( isset( $option['label'] ) ? $option['label'] : $option['value'] ) . '</option>';
		}
	}
	$output .= '</select>';
	if ( ! $vc_params_preset_form_field_js_appended ) {
		$output .= '<script type="text/javascript" src="' . vc_asset_url( 'js/params/params_preset.js' ) . '"></script>';
		$vc_params_preset_form_field_js_appended = true;
	}

	return $output;
}