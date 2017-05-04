<?php
require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-gitem-animated-block.php' );
global $vc_column_width_list;
global $vc_add_css_animation;
$zone_params = array(
	array(
		'type' => 'dropdown',
		'heading' => __( 'Add link', 'js_composer' ),
		'param_name' => 'link',
		'value' => array(
			__( 'None', 'js_composer' ) => 'none',
			__( 'Post link', 'js_composer' ) => 'post_link',
			__( 'Large image', 'js_composer' ) => 'image',
			__( 'Large image (prettyPhoto)', 'js_composer' ) => 'image_lightbox',
			__( 'Custom', 'js_composer' ) => 'custom',
		),
		'description' => __( 'Select link option.', 'js_composer' ),
	),
	array(
		'type' => 'vc_link',
		'heading' => __( 'URL (Link)', 'js_composer' ),
		'param_name' => 'url',
		'dependency' => array(
			'element' => 'link',
			'value' => array( 'custom' )
		),
		'description' => __( 'Add custom link.', 'js_composer' ),
	),
	array(
		'type' => 'checkbox',
		'heading' => __( 'Use featured image on background?', 'js_composer' ),
		'param_name' => 'featured_image',
		'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
		'description' => __( 'Note: Featured image overwrites background image and color from "Design options".', 'js_composer' ),
	),
	array(
		'type' => 'css_editor',
		'heading' => __( 'Css', 'js_composer' ),
		'param_name' => 'css',
		// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
		'group' => __( 'Design options', 'js_composer' )
	),
	array(
		'type' => 'textfield',
		'heading' => __( 'Extra class name', 'js_composer' ),
		'param_name' => 'el_class',
		'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
	),
);
$post_data_params = array(
	array(
		'type' => 'dropdown',
		'heading' => __( 'Add link', 'js_composer' ),
		'param_name' => 'link',
		'value' => array(
			__( 'None', 'js_composer' ) => 'none',
			__( 'Post link', 'js_composer' ) => 'post_link',
			__( 'Large image', 'js_composer' ) => 'image',
			__( 'Large image (prettyPhoto)', 'js_composer' ) => 'image_lightbox',
			__( 'Custom', 'js_composer' ) => 'custom',
		),
		'description' => __( 'Select link option.', 'js_composer' ),
	),
	array(
		'type' => 'vc_link',
		'heading' => __( 'URL (Link)', 'js_composer' ),
		'param_name' => 'url',
		'description' => __( 'Button link.', 'js_composer' ),
		'dependency' => array(
			'element' => 'link',
			'value' => array( 'custom' )
		),
		'description' => __( 'Add custom link.', 'js_composer' ),
	),
	/*
	array(
		'type'        => 'textarea',
		'heading'     => __( 'Text', 'js_composer' ),
		'param_name'  => 'text',
		'admin_label' => true,
		'value'       => __( 'This is custom heading element with Google Fonts', 'js_composer' ),
		'description' => __( 'Enter your content. If you are using non-latin characters be sure to activate them under Settings/Visual Composer/General Settings.', 'js_composer' ),
		'dependency'  => array(
			'element' => 'data_source',
			'value'   => array( '_custom_' ),
			//'callback' => 'vc_grid_include_dependency_callback',
		),
	),
	*/
	array(
		'type' => 'css_editor',
		'heading' => __( 'Css', 'js_composer' ),
		'param_name' => 'css',
		// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
		'group' => __( 'Design options', 'js_composer' )
	),
);
$custom_fonts_params = array(
	array(
		'type' => 'font_container',
		'param_name' => 'font_container',
		'value' => '',
		'settings' => array(
			'fields' => array(
				'tag' => 'div', // default value h2
				'text_align',
				//'font_style_italic'
				//'font_style_bold'
				//'font_family'

				'tag_description' => __( 'Select element tag.', 'js_composer' ),
				'text_align_description' => __( 'Select text alignment.', 'js_composer' ),
				'font_size_description' => __( 'Enter font size.', 'js_composer' ),
				'line_height_description' => __( 'Enter line height.', 'js_composer' ),
				'color_description' => __( 'Select color for your element.', 'js_composer' ),
				//'font_style_description' => __('Put your description here','js_composer'),
				//'font_family_description' => __('Put your description here','js_composer'),
			),
		),
	),
	array(
		'type' => 'checkbox',
		'heading' => __( 'Use custom fonts?', 'js_composer' ),
		'param_name' => 'use_custom_fonts',
		'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
		'description' => __( 'Enable Google fonts.', 'js_composer' ),
	),
	array(
		'type' => 'font_container',
		'param_name' => 'block_container',
		'value' => '',
		'settings' => array(
			'fields' => array(
				'font_size',
				'line_height',
				'color',
				//'font_style_italic'
				//'font_style_bold'
				//'font_family'

				'tag_description' => __( 'Select element tag.', 'js_composer' ),
				'text_align_description' => __( 'Select text alignment.', 'js_composer' ),
				'font_size_description' => __( 'Enter font size.', 'js_composer' ),
				'line_height_description' => __( 'Enter line height.', 'js_composer' ),
				'color_description' => __( 'Select color for your element.', 'js_composer' ),
				//'font_style_description' => __('Put your description here','js_composer'),
				//'font_family_description' => __('Put your description here','js_composer'),
			),
		),
		'group' => __( 'Custom fonts', 'js_composer' ),
		'dependency' => array(
			'element' => 'use_custom_fonts',
			'value' => array( 'yes' )
		),
	),
	array(
		'type' => 'google_fonts',
		'param_name' => 'google_fonts',
		'value' => '',
		// Not recommended, this will override 'settings'. 'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900 bold italic:900:italic'),
		'settings' => array(
			//'no_font_style' // Method 1: To disable font style
			//'no_font_style'=>true // Method 2: To disable font style
			'fields' => array(
				//'font_family' => 'Abril Fatface:regular',
				//'Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic',// Default font family and all available styles to fetch
				//'font_style' => '400 regular:400:normal',
				// Default font style. Name:weight:style, example: "800 bold regular:800:normal"
				'font_family_description' => __( 'Select font family.', 'js_composer' ),
				'font_style_description' => __( 'Select font styling.', 'js_composer' )
			)
		),
		// 'description' => __( '', 'js_composer' ),
		'group' => __( 'Custom fonts', 'js_composer' ),
		'dependency' => array(
			'element' => 'use_custom_fonts',
			'value' => array( 'yes' )
		),
	),
);
$list = array(
	'vc_gitem' => array(
		'name' => __( 'Grid item', 'js_composer' ),
		'base' => 'vc_gitem',
		'is_container' => true,
		'icon' => 'icon-wpb-gitem',
		'content_element' => false,
		'show_settings_on_create' => false,
		'category' => __( 'Content', 'js_composer' ),
		'description' => __( 'Main grid item', 'js_composer' ),
		'params' => array(
			array(
				'type' => 'css_editor',
				'heading' => __( 'Css', 'js_composer' ),
				'param_name' => 'css',
				// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
		),
		'js_view' => 'VcGitemView'
	),
	'vc_gitem_animated_block' => array(
		'base' => 'vc_gitem_animated_block',
		'name' => __( 'A/B block', 'js_composer' ),
		'content_element' => false,
		'is_container' => true,
		'show_settings_on_create' => false,
		'icon' => 'icon-wpb-gitem-block',
		'category' => __( 'Content', 'js_composer' ),
		'controls' => array(),
		'as_parent' => array( 'only' => array( 'vc_gitem_zone_a', 'vc_gitem_zone_b' ) ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Animation', 'js_composer' ),
				'param_name' => 'animation',
				'value' => WPBakeryShortCode_VC_Gitem_Animated_Block::animations(),
				'description' => __( '', 'js_composer' ),
			),
		),
		'js_view' => 'VcGitemAnimatedBlockView',
	),
	'vc_gitem_zone' => array(
		'name' => __( 'Zone', 'js_composer' ),
		'base' => 'vc_gitem_zone',
		'content_element' => false,
		'is_container' => true,
		'show_settings_on_create' => false,
		'icon' => 'icon-wpb-gitem-zone',
		'category' => __( 'Content', 'js_composer' ),
		'controls' => array( 'edit' ),
		'as_parent' => array( 'only' => 'vc_gitem_row' ),
		'js_view' => 'VcGitemZoneView',
		'params' => $zone_params,
	),
	'vc_gitem_zone_a' => array(
		'name' => __( 'Normal', 'js_composer' ),
		'base' => 'vc_gitem_zone_a',
		'content_element' => false,
		'is_container' => true,
		'show_settings_on_create' => false,
		'icon' => 'icon-wpb-gitem-zone',
		'category' => __( 'Content', 'js_composer' ),
		'controls' => array( 'edit' ),
		'as_parent' => array( 'only' => 'vc_gitem_row' ),
		'js_view' => 'VcGitemZoneView',
		'params' => array_merge( array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Height mode', 'js_composer' ),
				'param_name' => 'height_mode',
				'value' => array(
					__( '1:1', 'js_composer' ) => '1-1',
					__( 'Original', 'js_composer' ) => 'original',
					__( '4:3', 'js_composer' ) => '4-3',
					__( '3:4', 'js_composer' ) => '3-4',
					__( '16:9', 'js_composer' ) => '16-9',
					__( '9:16', 'js_composer' ) => '9-16',
					__( 'Custom', 'js_composer' ) => 'custom',
				),
				'description' => __( 'Sizing proportions for height and width. Select "Original" to scale image without cropping.', 'js_composer' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Height', 'js_composer' ),
				'param_name' => 'height',
				'description' => __( '', 'js_composer' ),
				'dependency' => array(
					'element' => 'height_mode',
					'value' => array( 'custom' )
				),
				'description' => __( 'Enter custom height.', 'js_composer' ),
			),
		), $zone_params )
	),
	'vc_gitem_zone_b' => array(
		'name' => __( 'Hover', 'js_composer' ),
		'base' => 'vc_gitem_zone_b',
		'content_element' => false,
		'is_container' => true,
		'show_settings_on_create' => false,
		'icon' => 'icon-wpb-gitem-zone',
		'category' => __( 'Content', 'js_composer' ),
		'controls' => array( 'edit' ),
		'as_parent' => array( 'only' => 'vc_gitem_row' ),
		'js_view' => 'VcGitemZoneView',
		'params' => $zone_params
	),
	'vc_gitem_zone_c' => array(
		'name' => __( 'Additional Block', 'js_composer' ),
		'base' => 'vc_gitem_zone_c',
		'content_element' => false,
		'is_container' => true,
		'show_settings_on_create' => false,
		'icon' => 'icon-wpb-gitem-zone',
		'category' => __( 'Content', 'js_composer' ),
		'controls' => array( 'move', 'delete', 'edit' ),
		'as_parent' => array( 'only' => 'vc_gitem_row' ),
		'js_view' => 'VcGitemZoneCView',
		'params' => array(
			array(
				'type' => 'css_editor',
				'heading' => __( 'Css', 'js_composer' ),
				'param_name' => 'css',
				// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
				// 'group'      => __( 'Design options', 'js_composer' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
		)
	),
	'vc_gitem_row' => array(
		'name' => __( 'Row', 'js_composer' ),
		'base' => 'vc_gitem_row',
		'content_element' => false,
		'is_container' => true,
		'icon' => 'icon-wpb-row',
		'show_settings_on_create' => false,
		'controls' => array( 'layout', 'delete' ),
		'allowed_container_element' => 'vc_gitem_col',
		'category' => __( 'Content', 'js_composer' ),
		'description' => __( 'Place content elements inside the row', 'js_composer' ),
		'params' => array(
			/*
			array(
				'type' => 'dropdown',
				'heading' => __( 'Position', 'js_composer' ),
				'param_name' => 'position',
				'value' => array(
					__( 'Top', 'js_composer' ) => 'top',
					__( 'Middle', 'js_composer' ) => 'center',
					__( 'Bottom', 'js_composer' ) => 'bottom',
					__( 'Full', 'js_composer' ) => 'full',
				),
				'description' => __( '', 'js_composer' ),
			),
			*/
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
		),
		'js_view' => 'VcGitemRowView',
	),
	'vc_gitem_col' => array(
		'name' => __( 'Column', 'js_composer' ),
		'base' => 'vc_gitem_col',
		'is_container' => true,
		'allowed_container_element' => false,
		'content_element' => false,
		'controls' => array( 'edit' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Width', 'js_composer' ),
				'param_name' => 'width',
				'value' => $vc_column_width_list,
				'description' => __( 'Select column width.', 'js_composer' ),
				'std' => '1/1'
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Use featured image on background?', 'js_composer' ),
				'param_name' => 'featured_image',
				'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'description' => __( 'Note: Featured image overwrites background image and color from "Design options".', 'js_composer' ),
				// 'group' => __( 'Design options', 'js_composer' )
			),
			array(
				'type' => 'css_editor',
				'heading' => __( 'Css', 'js_composer' ),
				'param_name' => 'css',
				// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
				'group' => __( 'Design options', 'js_composer' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
			/*
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Align', 'js_composer' ),
				'param_name'  => 'align',
				'value'       => array(
					__( 'Left', 'js_composer' )   => 'left',
					__( 'Center', 'js_composer' ) => 'center',
					__( 'Right', 'js_composer' )  => 'right',
				),
				'description' => __( '', 'js_composer' ),
			)
			*/
		),
		'js_view' => 'VcGitemColView',
	),
	'vc_gitem_post_data' => array(
		'name' => __( 'Post data', 'js_composer' ),
		'base' => 'vc_gitem_post_data',
		'content_element' => false,
		'category' => __( 'Post', 'js_composer' ),
		'params' => array_merge( array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Post data source', 'js_composer' ),
				'param_name' => 'data_source',
				'value' => 'ID',
				'description' => __( '', 'js_composer' ),
			)
		), $post_data_params, $custom_fonts_params, array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
		) ),
	),
	'vc_gitem_post_title' => array(
		'name' => __( 'Post Title', 'js_composer' ),
		'base' => 'vc_gitem_post_title',
		'icon' => 'vc_icon-vc-gitem-post-title',
		'category' => __( 'Post', 'js_composer' ),
		'description' => __( 'Title of current post', 'js_composer' ),
		'params' => array_merge( $post_data_params, $custom_fonts_params, array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
		) ),
	),
	'vc_gitem_post_excerpt' => array(
		'name' => __( 'Post Excerpt', 'js_composer' ),
		'base' => 'vc_gitem_post_excerpt',
		'icon' => 'vc_icon-vc-gitem-post-excerpt',
		'category' => __( 'Post', 'js_composer' ),
		'description' => __( 'Excerpt or manual excerpt', 'js_composer' ),
		'params' => array_merge( $post_data_params, $custom_fonts_params, array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
		) ),
	),
	'vc_gitem_image' => array(
		'name' => __( 'Post Image', 'js_composer' ),
		'base' => 'vc_gitem_image',
		'icon' => 'vc_icon-vc-gitem-image',
		'category' => __( 'Post', 'js_composer' ),
		'description' => __( 'Featured image', 'js_composer' ),
		'params' => array_merge( $post_data_params, array(
			array(
				'type' => 'font_container',
				'param_name' => 'font_container',
				'value' => '',
				'settings' => array(
					'fields' => array(
						'text_align',
						'text_align_description' => __( 'Select alignment.', 'js_composer' ),
						//'font_style_description' => __('Put your description here','js_composer'),
						//'font_family_description' => __('Put your description here','js_composer'),
					),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
		) ),
	),
	'vc_gitem_post_date' => array(
		'name' => __( 'Post Date', 'js_composer' ),
		'base' => 'vc_gitem_post_date',
		'icon' => 'vc_icon-vc-gitem-post-date',
		'category' => __( 'Post', 'js_composer' ),
		'description' => __( 'Post publish date', 'js_composer' ),
		'params' => array_merge( $post_data_params, $custom_fonts_params, array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
		) ),
	),
	'vc_gitem_post_meta' => array(
		'name' => __( 'Custom field', 'js_composer' ),
		'base' => 'vc_gitem_post_meta',
		'icon' => 'vc_icon-vc-gitem-post-meta',
		'category' => array(
			__( 'Elements', 'js_composer' )
		),
		'description' => __( 'Custom fields data from meta values of the post.', 'js_composer' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Field key name', 'js_composer' ),
				'param_name' => 'key',
				'description' => __( 'Custom field name to retrieve meta data value.', 'js_composer' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Label', 'js_composer' ),
				'param_name' => 'label',
				'description' => __( 'Enter label to display before key value.', 'js_composer' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Align', 'js_composer' ),
				'param_name' => 'align',
				'value' => array(
					__( 'left', 'js_composer' ) => 'left',
					__( 'right', 'js_composer' ) => 'right',
					__( 'center', 'js_composer' ) => 'center',
					__( 'justify', 'js_composer' ) => 'justify',
				),
				'description' => __( 'Select alignment.', 'js_composer' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			),
		)
	),
);
$shortcode_vc_column_text = WPBMap::getShortCode( 'vc_column_text' );
if ( is_array( $shortcode_vc_column_text ) && isset( $shortcode_vc_column_text['base'] ) ) {
	$list['vc_column_text'] = $shortcode_vc_column_text;
}
$shortcode_vc_separator = WPBMap::getShortCode( 'vc_separator' );
if ( is_array( $shortcode_vc_separator ) && isset( $shortcode_vc_separator['base'] ) ) {
	$list['vc_separator'] = $shortcode_vc_separator;
}
$shortcode_vc_text_separator = WPBMap::getShortCode( 'vc_text_separator' );
if ( is_array( $shortcode_vc_text_separator ) && isset( $shortcode_vc_text_separator['base'] ) ) {
	$list['vc_text_separator'] = $shortcode_vc_text_separator;
}
$shortcode_vc_icon = WPBMap::getShortCode( 'vc_icon' );
if ( is_array( $shortcode_vc_icon ) && isset( $shortcode_vc_icon['base'] ) ) {
	$list['vc_icon'] =  $shortcode_vc_icon;
}
$list['vc_single_image'] = array(
	'name' => __( 'Single Image', 'js_composer' ),
	'base' => 'vc_single_image',
	'icon' => 'icon-wpb-single-image',
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'Simple image with CSS animation', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'js_composer' ),
			'param_name' => 'image',
			'value' => '',
			'description' => __( 'Select image from media library.', 'js_composer' )
		),
		$vc_add_css_animation,
		array(
			'type' => 'textfield',
			'heading' => __( 'Image size', 'js_composer' ),
			'param_name' => 'img_size',
			'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Image alignment', 'js_composer' ),
			'param_name' => 'alignment',
			'value' => array(
				__( 'Align left', 'js_composer' ) => '',
				__( 'Align right', 'js_composer' ) => 'right',
				__( 'Align center', 'js_composer' ) => 'center'
			),
			'description' => __( 'Select image alignment.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Image style', 'js_composer' ),
			'param_name' => 'style',
			'value' => getVcShared( 'single image styles' ),
			'description' => __( 'Select display style.', 'js_comopser' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Border color', 'js_composer' ),
			'param_name' => 'border_color',
			'value' => getVcShared( 'colors' ),
			'std' => 'grey',
			'dependency' => array(
				'element' => 'style',
				'value' => array( 'vc_box_border', 'vc_box_border_circle', 'vc_box_outline', 'vc_box_outline_circle' )
			),
			'description' => __( 'Border color.', 'js_composer' ),
			'param_holder_class' => 'vc_colored-dropdown'
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		)
	)
);
$shortcode_vc_button2 = WPBMap::getShortCode( 'vc_button2' );
if ( is_array( $shortcode_vc_button2 ) && isset( $shortcode_vc_button2['base'] ) ) {
	$list['vc_button2'] =  $shortcode_vc_button2;
}
$shortcode_vc_custom_heading = WPBMap::getShortCode( 'vc_custom_heading' );
if ( is_array( $shortcode_vc_custom_heading ) && isset( $shortcode_vc_custom_heading['base'] ) ) {
	$list['vc_custom_heading'] =  $shortcode_vc_custom_heading;
}
$shortcode_vc_empty_space = WPBMap::getShortCode( 'vc_empty_space' );
if ( is_array( $shortcode_vc_empty_space ) && isset( $shortcode_vc_empty_space['base'] ) ) {
	$list['vc_empty_space'] =  $shortcode_vc_empty_space;
}
foreach ( array( 'vc_icon', 'vc_button2', 'vc_custom_heading', 'vc_single_image' ) as $key ) {
	if ( isset( $list[ $key ] ) && 'vc_button2' === $key ) {
		$list[ $key ]['params'][0] = array(
			'type' => 'vc_link',
			'heading' => __( 'URL (Link)', 'js_composer' ),
			'param_name' => 'url',
			'description' => __( 'Button link.', 'js_composer' ),
			'dependency' => array(
				'element' => 'link',
				'value' => array( 'custom' )
			),
			'description' => __( 'Add custom link.', 'js_composer' ),
		);
	} elseif ( isset( $list[ $key ] ) ) {
		array_unshift( $list[ $key ]['params'], array(
			'type' => 'vc_link',
			'heading' => __( 'URL (Link)', 'js_composer' ),
			'param_name' => 'url',
			'description' => __( 'Button link.', 'js_composer' ),
			'dependency' => array(
				'element' => 'link',
				'value' => array( 'custom' )
			),
			'description' => __( 'Add custom link.', 'js_composer' ),
		) );
	}

	array_unshift( $list[ $key ]['params'], array(
		'type' => 'dropdown',
		'heading' => __( 'Add link', 'js_composer' ),
		'param_name' => 'link',
		'value' => array(
			__( 'None', 'js_composer' ) => 'none',
			__( 'Post link', 'js_composer' ) => 'post_link',
			__( 'Large image', 'js_composer' ) => 'image',
			__( 'Large image (prettyPhoto)', 'js_composer' ) => 'image_lightbox',
			__( 'Custom', 'js_composer' ) => 'custom',
		),
		'description' => __( 'Select link option.', 'js_composer' )
	) );

}

return $list;