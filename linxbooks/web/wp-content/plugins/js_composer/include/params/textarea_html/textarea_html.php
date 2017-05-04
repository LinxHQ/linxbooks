<?php
global $vc_html_editor_already_is_use;
$vc_html_editor_already_is_use = false;
/**
 * @param $settings
 * @param $value
 *
 * @since 4.2
 * @return string
 */
function vc_textarea_html_form_field( $settings, $value ) {
	global $vc_html_editor_already_is_use;
	$output = '';
	if ( $vc_html_editor_already_is_use !== false ) {
		$value = __( $value, "js_composer" );
		$output .= '<textarea name="'
		           . $settings['param_name']
		           . '" class="wpb_vc_param_value wpb-textarea '
		           . $settings['param_name'] . ' textarea">' . $value . '</textarea>';
		$output .= '<div class="updated"><p>'
		           . __( 'Field type is changed from `textarea_html` to `textarea`, because it is already used by `'
		                 . $vc_html_editor_already_is_use
		                 . '` field. Textarea_html field\'s type can be used only once per shortcode.', 'js_composer' )
		           . '</p></div>';
	} elseif ( function_exists( 'wp_editor' ) ) {
		$default_content = __( $value, "js_composer" );
		// WP 3.3+
		ob_start();
		wp_editor( '', 'wpb_tinymce_' . $settings['param_name'], array(
			'editor_class' => 'wpb-textarea visual_composer_tinymce '
			                  . $settings['param_name'] . ' ' . $settings['type']
		,
			'media_buttons' => true
		,
			'wpautop' => false
		) );
		$output_value = ob_get_contents();
		ob_end_clean();
		$output .= $output_value
		           . '<input type="hidden" name="' . $settings['param_name']
		           . '"  class="vc_textarea_html_content wpb_vc_param_value '
		           . $settings['param_name']
		           . '" value="' . htmlspecialchars( $default_content ) . '"/>';
		// $settings_line = '<textarea name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-textarea visual_composer_tinymce '.$settings['param_name'].' '.$settings['type'].' '.$settings['param_name'].'_tinymce"' . $dependency . '>'.$settings_value.'</textarea>';
		$vc_html_editor_already_is_use = $settings['param_name'];
	}

	return $output;
}