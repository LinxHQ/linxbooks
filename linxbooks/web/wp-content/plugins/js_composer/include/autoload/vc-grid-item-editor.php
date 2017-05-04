<?php
/**
 * Creates new post type for grid_editor.
 *
 * @since 4.4
 */
function vc_grid_item_editor_create_post_type() {
	if ( is_admin() ) {
		require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/editor/class-vc-grid-item-editor.php' );
		Vc_Grid_Item_Editor::createPostType();
	}
}

/**
 * Set required objects to render editor for grid item
 *
 * @since 4.4
 */
function vc_grid_item_editor_init() {
	require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/editor/class-vc-grid-item-editor.php' );
	$vc_grid_item_editor = new Vc_Grid_Item_Editor();
	if ( vc_request_param( 'vc_grid_item_editor' ) === 'true' ) {
		require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/class-vc-grid-item.php' );
		$grid_item = new Vc_Grid_Item();
		$grid_item->mapShortcodes();
	}
	$vc_grid_item_editor->addMetaBox();
}

/**
 *  Render preview for grid item
 * @since 4.4
 */
function vc_grid_item_render_preview() {
	require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/class-vc-grid-item.php' );
	$grid_item = new Vc_Grid_Item();
	$grid_item->mapShortcodes();
	require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/editor/class-vc-grid-item-preview.php' );
	$vcGridPreview = new Vc_Grid_Item_Preview();
	add_filter( 'vc_gitem_template_attribute_post_image_background_image_css_value', array(
		$vcGridPreview,
		'addCssBackgroundImage'
	) );
	add_filter( 'vc_gitem_template_attribute_post_image_url_value', array( $vcGridPreview, 'addImageUrl' ) );
	add_filter( 'vc_gitem_template_attribute_post_image_html', array( $vcGridPreview, 'addImage' ) );
	$vcGridPreview->render();
	die();
}

/**
 * Adds grid item post type into the list of excluded post types for VC editors.
 *
 * @param array $list
 *
 * @since 4.4
 * @deprecated
 * @return array
 */
function vc_grid_item_vc_settings_exclude( array $list ) {
	require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/editor/class-vc-grid-item-editor.php' );
	$vc_grid_item_editor = new Vc_Grid_Item_Editor();
	$list[] = $vc_grid_item_editor->postType();

	return $list;
}

/**
 * add action in admin for vc grid item editor manager
 */
add_action( 'init', 'vc_grid_item_editor_create_post_type' );
add_action( 'admin_init', 'vc_grid_item_editor_init' );
/**
 * Call preview as ajax request is called.
 */
add_action( 'wp_ajax_vc_gitem_preview', 'vc_grid_item_render_preview', 5 );
/**
 * Add vc grid item to the list of the excluded post types for enabling Vc editor.
 *
 * Called with with 'vc_settings_exclude_post_type' action.
 * @deprecated
 */
if ( vc_mode() === 'admin_settings_page' ) {
	add_filter( 'vc_settings_exclude_post_type', 'vc_grid_item_vc_settings_exclude' );
}
/**
 * Add WP ui pointers in grid element editor.
 */
if ( is_admin() ) {
	add_filter( 'vc_ui-pointers-vc_grid_item', 'vc_grid_item_register_pointer' );
}

function vc_grid_item_register_pointer( $p ) {
	$screen = get_current_screen();
	if('add' === $screen->action) {
		$p['vc_grid_item____'] = array(
			'name' => 'vcPointer',
			'messages' => array(
				array(
					'target' => '#vc_templates-editor-button',
					'options' => array(
						'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
							__( 'Start Here!', 'js_composer' ),
							__('Start easy - use predefined template as a starting point and modify it.', 'js_composer')
						),
						'position' => array( 'edge' => 'left', 'align' => 'center'),
					)
				),
				array(
					'target' => '[data-vc-navbar-control="animation"]',
					'options' => array(
						'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
							__( 'Use Animations', 'js_composer' ),
							__('Select animation preset for grid element. "Hover" state will be added next to the "Normal" state tab.', 'js_composer')
						),
						'position' => array( 'edge' => 'right', 'align' => 'center'),
					)
				),
				array(
					'target' => '.vc_gitem_animated_block-shortcode',
					'options' => array(
						'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
							__( 'Style Design Options', 'js_composer' ),
							__('Edit "Normal" state to set "Featured image" as a background, control zone sizing proportions and other design options (Height mode: Select "Original" to scale image without cropping).', 'js_composer')
						),
						'position' => array( 'edge' => 'bottom', 'align' => 'center'),
					)
				),
				array(
					'target' => '[data-vc-gitem="add-c"][data-vc-position="top"]',
					'options' => array(
						'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
							__( 'Extend Element', 'js_composer' ),
							__('Additional content zone can be added to grid element edges (Note: This zone can not be animated).', 'js_composer')
						) . '<p><img src="'.vc_asset_url( 'vc/gb_additional_content.png' ).'" alt="" /></p>',
						'position' => array( 'edge' => 'right', 'align' => 'center'),
					)
				),
				array(
					'target' => '#wpadminbar',
					'options' => array(
						'content' => sprintf( '<h3> %s </h3> %s',
							__( 'Watch Video Tutorial', 'js_composer' ),
							'<p>'.__('Have a look how easy it is to work with grid element builder.'
								, 'js_composer') . '</p>'
							. '<iframe width="500" height="281" src="//www.youtube.com/embed/sBvEiIL6Blo" frameborder="0" allowfullscreen></iframe>'
						),
						'position' => array( 'edge' => 'top', 'align' => 'center'),
						'pointerClass' => 'vc_gitem-animated-block-pointer-video',
						'pointerWidth' => '530',
					)
				),
			),
		);
	}
	return $p;
}

