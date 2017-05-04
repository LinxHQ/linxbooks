<?php
/**
 * WPBakery Visual Composer shortcode default attributes functions for rendering.
 *
 * @package WPBakeryVisualComposer
 * @since 4.4
 */
/**
 * Textfield shortcode attribute type generator.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_textfield_form_field( $settings, $value ) {
	$value = __( $value, "js_composer" );
	$value = htmlspecialchars( $value );

	//$value = $param_value;
	return '<input name="' . $settings['param_name']
	       . '" class="wpb_vc_param_value wpb-textinput '
	       . $settings['param_name'] . ' ' . $settings['type']
	       . '" type="text" value="' . $value . '"/>';
}

/**
 * Dropdown(select with options) shortcode attribute type generator.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_dropdown_form_field( $settings, $value ) {
	$output = '';
	$css_option = vc_get_dropdown_option( $settings, $value );
	$output .= '<select name="'
	           . $settings['param_name']
	           . '" class="wpb_vc_param_value wpb-input wpb-select '
	           . $settings['param_name']
	           . ' ' . $settings['type']
	           . ' ' . $css_option
	           . '" data-option="' . $css_option . '">';
	if ( is_array( $value ) ) {
		$value = isset( $value['value'] ) ? $value['value'] : array_shift( $value );
	}
	foreach ( $settings['value'] as $index => $data ) {
		if ( is_numeric( $index ) && ( is_string( $data ) || is_numeric( $data ) ) ) {
			$option_label = $data;
			$option_value = $data;
		} elseif ( is_numeric( $index ) && is_array( $data ) ) {
			$option_label = isset( $data['label'] ) ? $data['label'] : array_pop( $data );
			$option_value = isset( $data['value'] ) ? $data['value'] : array_pop( $data );
		} else {
			$option_value = $data;
			$option_label = $index;
		}
		$option_label = __( $option_label, "js_composer" );
		//$val = strtolower(str_replace(array(" "), array("_"), $val));
		//$val = strtolower(str_replace(array(" "), array("_"), $val)); //issue #464 github
		$selected = '';
		if ( $value !== '' && (string) $option_value === (string) $value ) {
			$selected = ' selected="selected"';
		}
		$output .= '<option class="' . $option_value . '" value="' . $option_value . '"' . $selected . '>'
		           . htmlspecialchars( $option_label ) . '</option>';
	}
	$output .= '</select>';

	return $output;
}

/**
 * Checkbox shortcode attribute type generator.
 *
 * @param $settings
 * @param string $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_checkbox_form_field( $settings, $value ) {
	$output = '';
	if ( is_array( $value ) ) {
		$value = ''; // fix #1239
	}
	$current_value = strlen( $value ) > 0 ? explode( ",", $value ) : array();
	$values = is_array( $settings['value'] ) ? $settings['value'] : array();
	foreach ( $values as $label => $v ) {
		$checked = count( $current_value ) > 0 && in_array( $v, $current_value ) ? ' checked="checked"' : '';
		$output .= ' <label class="vc_checkbox-label"><input id="'
		           . $settings['param_name'] . '-' . $v . '" value="'
		           . $v . '" class="wpb_vc_param_value '
		           . $settings['param_name'] . ' ' . $settings['type'] . '" type="checkbox" name="'
		           . $settings['param_name'] . '"'
		           . $checked . '> ' . __( $label, "js_composer" ) . '</label>';
	}

	return $output;
}

/**
 * Checkbox shortcode attribute type generator.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_posttypes_form_field( $settings, $value ) {
	$output = '';
	$args = array(
		'public' => true
	);
	$post_types = get_post_types( $args );
	foreach ( $post_types as $post_type ) {
		$checked = "";
		if ( $post_type != 'attachment' ) {
			if ( in_array( $post_type, explode( ",", $value ) ) ) {
				$checked = ' checked="checked"';
			}
			$output .= ' <label class="vc_checkbox-label"><input id="'
			           . $settings['param_name'] . '-' . $post_type . '" value="'
			           . $post_type . '" class="wpb_vc_param_value '
			           . $settings['param_name']
			           . ' ' . $settings['type']
			           . '" type="checkbox" name="'
			           . $settings['param_name'] . '"' . $checked . '> '
			           . $post_type . '</label>';
		}
	}

	return $output;
}

/**
 * Taxonomies shortcode attribute type generator.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_taxonomies_form_field( $settings, $value ) {
	$output = '';
	$post_types = get_post_types( array( 'public' => false, 'name' => 'attachment' ), 'names', 'NOT' );
	foreach ( $post_types as $type ) {
		$taxonomies = get_object_taxonomies( $type, '' );
		foreach ( $taxonomies as $tax ) {
			$checked = "";
			if ( in_array( $tax->name, explode( ",", $value ) ) ) {
				$checked = ' checked="checked"';
			}
			$output .= ' <label class="vc_checkbox-label" data-post-type="'
			           . $type . '"><input id="'
			           . $settings['param_name'] . '-' . $tax->name
			           . '" value="' . $tax->name
			           . '" data-post-type="' . $type
			           . '" class="wpb_vc_param_value '
			           . $settings['param_name']
			           . ' ' . $settings['type']
			           . '" type="checkbox" name="' . $settings['param_name'] . '"' . $checked . '> '
			           . $tax->label . '</label>';
		}
	}

	return $output;
}

/**
 * @deprecated
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string
 */
function vc_taxomonies_form_field( $settings, $value ) {
	return vc_taxonomies_form_field( $settings, $value );
}

/**
 * Exploded textarea shortcode attribute type generator.
 *
 * Data saved and coma-separated values are merged with line breaks and returned in a textarea.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_exploded_textarea_form_field( $settings, $value ) {
	$value = str_replace( ",", "\n", $value );

	return '<textarea name="'
	       . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textarea '
	       . $settings['param_name'] . ' ' . $settings['type'] . '">' . $value . '</textarea>';
}

/**
 * Textarea raw html shortcode attribute type generator.
 *
 * This attribute type allows safely add custom html to your post/page.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_textarea_raw_html_form_field( $settings, $value ) {
	return '<textarea name="'
	       . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textarea_raw_html '
	       . $settings['param_name'] . ' ' . $settings['type'] . '" rows="16">'
	       . htmlentities( rawurldecode( base64_decode( $value ) ), ENT_COMPAT, 'UTF-8' ) . '</textarea>';
}

/**
 * Safe Textarea shortcode attribute type generator.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_textarea_safe_form_field( $settings, $value ) {
	return '<textarea name="'
	       . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textarea_raw_html '
	       . $settings['param_name'] . ' ' . $settings['type'] . '">'
	       . vc_value_from_safe( $value, true ) . '</textarea>';

}

/**
 * Textarea shortcode attribute type generator.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_textarea_form_field( $settings, $value ) {
	$value = __( $value, "js_composer" );

	return '<textarea name="' .
	       $settings['param_name'] . '" class="wpb_vc_param_value wpb-textarea '
	       . $settings['param_name'] . ' ' . $settings['type'] . '">' . $value . '</textarea>';
}

/**
 * Attach images shortcode attribute type generator.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 *
 * @param $tag
 * @param bool $single
 *
 * @return string - html string.
 */
function vc_attach_images_form_field( $settings, $value, $tag, $single = false ) {
	$output = '';
	$param_value = wpb_removeNotExistingImgIDs( $value );
	$output .= '<input type="hidden" class="wpb_vc_param_value gallery_widget_attached_images_ids '
	           . $settings['param_name'] . ' '
	           . $settings['type'] . '" name="' . $settings['param_name'] . '" value="' . $value . '"/>';
	$output .= '<div class="gallery_widget_attached_images">';
	$output .= '<ul class="gallery_widget_attached_images_list">';
	$output .= ( $param_value != '' ) ? fieldAttachedImages( explode( ",", $value ) ) : '';
	$output .= '</ul>';
	$output .= '</div>';
	$output .= '<div class="gallery_widget_site_images">';
	// $param_line .= siteAttachedImages(explode(",", $param_value));
	$output .= '</div>';
	if ( $single === true ) {
		$output .= '<a class="gallery_widget_add_images" href="#" use-single="true" title="'
		           . __( 'Add image', "js_composer" ) . '">' . __( 'Add image', "js_composer" ) . '</a>'; //class: button
	} else {
		$output .= '<a class="gallery_widget_add_images" href="#" title="'
		           . __( 'Add images', "js_composer" ) . '">' . __( 'Add images', "js_composer" ) . '</a>'; //class: button
	}

	//$param_line .= '<div class="wpb_clear"></div>';
	return $output;
}

/**
 * Attach image shortcode attribute type generator.
 *
 * @param $settings
 * @param $value
 *
 * @param $tag
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_attach_image_form_field( $settings, $value, $tag ) {
	return vc_attach_images_form_field( $settings, $value, $tag, true );
}

/**
 * Widgetised sidebars shortcode attribute type generator.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function vc_widgetised_sidebars_form_field( $settings, $value ) {
	$output = '';
	$sidebars = $GLOBALS['wp_registered_sidebars'];

	$output .= '<select name="' . $settings['param_name']
	           . '" class="wpb_vc_param_value dropdown wpb-input wpb-select '
	           . $settings['param_name'] . ' '
	           . $settings['type'] . '">';
	foreach ( $sidebars as $sidebar ) {
		$selected = '';
		if ( $sidebar["id"] == $value ) {
			$selected = ' selected="selected"';
		}
		$sidebar_name = __( $sidebar["name"], "js_composer" );
		$output .= '<option value="' . $sidebar["id"] . '"' . $selected . '>' . $sidebar_name . '</option>';
	}
	$output .= '</select>';

	return $output;
}