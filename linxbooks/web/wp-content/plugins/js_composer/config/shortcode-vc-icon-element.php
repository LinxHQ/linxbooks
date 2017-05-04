<?php
global $vc_add_css_animation;
/*
 * Icon Element
 * @since 4.4
 */
vc_map( array(
	'name' => __( 'Icon', 'js_composer' ),
	'base' => 'vc_icon',
	'icon' => 'icon-wpb-vc_icon',
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'Icon from icon library', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon library', 'js_composer' ),
			'value' => array(
				__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
				__( 'Open Iconic', 'js_composer' ) => 'openiconic',
				__( 'Typicons', 'js_composer' ) => 'typicons',
				__( 'Entypo', 'js_composer' ) => 'entypo',
				__( 'Linecons', 'js_composer' ) => 'linecons',
			),
			'admin_label' => true,
			'param_name' => 'type',
			'description' => __( 'Select icon library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_fontawesome',
			'value' => 'fa fa-adjust', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'dependency' => array(
				'element' => 'type',
				'value' => 'fontawesome',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_openiconic',
			'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'openiconic',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'type',
				'value' => 'openiconic',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_typicons',
			'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'typicons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'type',
				'value' => 'typicons',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_entypo',
			'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'entypo',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'type',
				'value' => 'entypo',
			),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_linecons',
			'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'linecons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'type',
				'value' => 'linecons',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Color', 'js_composer' ),
			'param_name' => 'color',
			'value' => array_merge( getVcShared( 'colors' ), array( __( 'Custom color', 'js_composer' ) => 'custom' ) ),
			'description' => __( 'Icon color.', 'js_composer' ),
			'param_holder_class' => 'vc_colored-dropdown',
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom Icon Color', 'js_composer' ),
			'param_name' => 'custom_color',
			'description' => __( 'Select custom icon color.', 'js_composer' ),
			'dependency' => array(
				'element' => 'color',
				'value' => 'custom',
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Background Style', 'js_composer' ),
			'param_name' => 'background_style',
			'value' => array(
				__( 'None', 'js_composer' ) => '',
				__( 'Circle', 'js_composer' ) => 'rounded',
				__( 'Square', 'js_composer' ) => 'boxed',
				__( 'Rounded', 'js_composer' ) => 'rounded-less',
				__( 'Outline Circle', 'js_composer' ) => 'rounded-outline',
				__( 'Outline Square', 'js_composer' ) => 'boxed-outline',
				__( 'Outline Rounded', 'js_composer' ) => 'rounded-less-outline',
			),
			'description' => __( 'Background style for icon.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Background Color', 'js_composer' ),
			'param_name' => 'background_color',
			'value' => getVcShared( 'colors' ),
			'std' => 'grey',
			'description' => __( 'Background Color.', 'js_composer' ),
			'param_holder_class' => 'vc_colored-dropdown',
			'dependency' => array(
				'element' => 'background_style',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Size', 'js_composer' ),
			'param_name' => 'size',
			'value' => array_merge( getVcShared( 'sizes' ), array( 'Extra Large' => 'xl' ) ),
			'std' => 'md',
			'description' => __( 'Icon size.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon alignment', 'js_composer' ),
			'param_name' => 'align',
			'value' => array(
				__( 'Align left', 'js_composer' ) => 'left',
				__( 'Align right', 'js_composer' ) => 'right',
				__( 'Align center', 'js_composer' ) => 'center',
			),
			'description' => __( 'Select icon alignment.', 'js_composer' ),
		),
		array(
			'type' => 'vc_link',
			'heading' => __( 'URL (Link)', 'js_composer' ),
			'param_name' => 'link',
			'description' => __( 'Add link to icon.', 'js_composer' )
		),
		$vc_add_css_animation,
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		),

	),
	'js_view' => 'VcIconElementView_Backend',
) );