<?php

/**
 * Param 'colorpicker' field
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string
 */
function vc_colorpicker_form_field( $settings, $value ) {
	return '<div class="color-group">'
	       . '<input name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '_field vc_color-control" type="text" value="' . $value . '"/>'
	       . '</div>';
}