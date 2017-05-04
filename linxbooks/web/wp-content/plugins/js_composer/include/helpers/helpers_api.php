<?php
/**
 * @param $attributes
 *
 * @since 4.2
 */
function vc_map( $attributes ) {
	if ( ! isset( $attributes['base'] ) ) {
		trigger_error( __( "Wrong vc_map object. Base attribute is required", 'js_composer' ), E_USER_ERROR );
		die();
	}
	WPBMap::map( $attributes['base'], $attributes );
}

/* Backwards compatibility  **/
/**
 * @param $attributes
 *
 * @deprecated, use vc_map instead
 */
function wpb_map( $attributes ) {
	vc_map( $attributes );
}

/**
 * @param $shortcode
 *
 * @since 4.2
 */
function vc_remove_element( $shortcode ) {
	WPBMap::dropShortcode( $shortcode );
}

/* Backwards compatibility  **/
/**
 * @param $shortcode
 *
 * @since 4.2
 * @deprecated use vc_remove_element instead
 */
function wpb_remove( $shortcode ) {
	vc_remove_element( $shortcode );
}

/**
 * Add new shortcode param.
 *
 * @since 4.2
 *
 * @param $shortcode - tag for shortcode
 * @param $attributes - attribute settings
 */
function vc_add_param( $shortcode, $attributes ) {
	WPBMap::addParam( $shortcode, $attributes );
}

/**
 * Mass shortcode params adding function
 *
 * @since 4.3
 *
 * @param $shortcode - tag for shortcode
 * @param $attributes - list of attributes arrays
 */
function vc_add_params( $shortcode, $attributes ) {
	foreach ( $attributes as $attr ) {
		vc_add_param( $shortcode, $attr );
	}
}

/**
 * Backwards compatibility
 *
 * @param $shortcode
 * @param $attributes
 *
 * @since 4.2
 * @deprecated
 */
function wpb_add_param( $shortcode, $attributes ) {
	vc_add_param( $shortcode, $attributes );
}

/**
 * Shorthand function for WPBMap::modify
 *
 * @param $name
 * @param $setting
 * @param string $value
 *
 * @since 4.2
 * @return array|bool
 */
function vc_map_update( $name = '', $setting = '', $value = '' ) {
	return WPBMap::modify( $name, $setting, $value );
}

/**
 * Shorthand function for WPBMap::mutateParam
 *
 * @param $name
 * @param array $attribute
 *
 * @since 4.2
 * @return bool
 */
function vc_update_shortcode_param( $name, $attribute = Array() ) {
	return WPBMap::mutateParam( $name, $attribute );
}

/**
 * Shorthand function for WPBMap::dropParam
 *
 * @param $name
 * @param $attribute_name
 *
 * @since 4.2
 * @return bool
 */
function vc_remove_param( $name = '', $attribute_name = '' ) {
	return WPBMap::dropParam( $name, $attribute_name );
}

if ( ! function_exists( 'vc_set_as_theme' ) ) {
	/**
	 * Sets plugin as theme plugin.
	 *
	 * @param bool $disable_updater - If value is true disables auto updater options.
	 *
	 * @since 4.2
	 */
	function vc_set_as_theme( $disable_updater = false ) {
		vc_manager()->setIsAsTheme( true );
//    	$composer = WPBakeryVisualComposer::getInstance();
//    	$composer->setSettingsAsTheme();
//    	if($disable_updater) $composer->disableUpdater(); TODO: disable update
		$disable_updater && vc_manager()->disableUpdater();
	}
}
if ( ! function_exists( 'vc_is_as_theme' ) ) {
	/**
	 * Is VC as-theme-plugin.
	 * @since 4.2
	 * @return bool
	 */
	function vc_is_as_theme() {
		return vc_manager()->isAsTheme();
	}
}
if ( ! function_exists( 'vc_is_updater_disabled' ) ) {
	/**
	 * @since 4.2
	 * @return bool
	 */
	function vc_is_updater_disabled() {
		return vc_manager()->isUpdaterDisabled();

	}
}
if ( ! function_exists( 'vc_default_editor_post_types' ) ) {
	/**
	 * Returns list of default post type.
	 * @since 4.2
	 * @return bool
	 */
	function vc_default_editor_post_types() {
		return vc_manager()->editorDefaultPostTypes();
	}
}
if ( ! function_exists( 'vc_set_default_editor_post_types' ) ) {
	/**
	 * Set post types for VC editor.
	 * @since 4.2
	 *
	 * @param array $list - list of valid post types to set
	 */
	function vc_set_default_editor_post_types( array $list ) {
		vc_manager()->setEditorDefaultPostTypes( $list );
	}
}
if ( ! function_exists( ( 'vc_editor_post_types' ) ) ) {
	/**
	 * Returns list of post types where VC editor is enabled.
	 * @since 4.2
	 * @return array
	 */
	function vc_editor_post_types() {
		return vc_manager()->editorPostTypes();
	}
}
if ( ! function_exists( ( 'vc_editor_post_types' ) ) ) {
	/**
	 * Set list of post types where VC editor is enabled.
	 * @since 4.4
	 *
	 * @param array $post_types
	 *
	 * @return array
	 */
	function vc_editor_set_post_types( array $post_types ) {
		vc_manager()->setEditorPostTypes( $post_types );
	}
}
if ( ! function_exists( 'vc_mode' ) ) {
	/**
	 * Return current VC mode.
	 * @since 4.2
	 * @see Vc_Mapper::$mode
	 * @return string
	 */
	function vc_mode() {
		return vc_manager()->mode();
	}
}
if ( ! function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
	/**
	 * Sets directory where Visual Composer should look for template files for content elements.
	 * @since 4.2
	 *
	 * @param string - full directory path to new template directory with trailing slash
	 */
	function vc_set_shortcodes_templates_dir( $dir ) {
		vc_manager()->setCustomUserShortcodesTemplateDir( $dir );
	}
}
if ( ! function_exists( 'vc_shortcodes_theme_templates_dir' ) ) {
	/**
	 * Get custom theme template path
	 * @since 4.2
	 *
	 * @param $template - filename for template
	 *
	 * @return string
	 */
	function vc_shortcodes_theme_templates_dir( $template ) {
		return vc_manager()->getShortcodesTemplateDir( $template );
	}
}
if ( ! function_exists( 'vc_set_template_dir' ) ) {
	/**
	 * Sets directory where Visual Composer should look for template files for content elements.
	 * @since 4.2
	 * @deprecated 4.2
	 *
	 * @param string - full directory path to new template directory with trailing slash
	 */
	function vc_set_template_dir( $dir ) {
		vc_set_shortcodes_templates_dir( $dir );
	}
}
/**
 * @param bool $value
 *
 * @since 4.3
 */
function set_vc_is_inline( $value = true ) {
	global $vc_is_inline;
	$vc_is_inline = $value;
}

/**
 * New Vc now called Frontend editor
 * @deprecated
 * @return Vc_Frontend_Editor
 * @since 4.3
 */
function new_vc() {
	return vc_frontend_editor();
}

/**
 * Disable frontend editor for VC
 * @since 4.3
 *
 * @param bool $disable
 */
function vc_disable_frontend( $disable = true ) {
	vc_frontend_editor()->disableInline( $disable );
}

/**
 * Check is front end enabled.
 * @since 4.3
 * @return bool
 */
function vc_enabled_frontend() {
	return vc_frontend_editor()->inlineEnabled();
}

if ( ! function_exists( 'vc_add_default_templates' ) ) {
	/**
	 * Add custom template in default templates list
	 *
	 * @param array $data | template data (name, content, custom_class, image_path)
	 *
	 * @since 4.3
	 * @return bool
	 */
	function vc_add_default_templates( $data ) {
		return visual_composer()->templatesPanelEditor()->addDefaultTemplates( $data );
	}
}