<?php
require_once vc_path_dir( 'EDITORS_DIR', 'navbar/class-vc-navbar.php' );

/**
 * Renders navigation bar for Editors.
 */
Class Vc_Navbar_Grid_Item extends Vc_Navbar {
	protected $controls = array(
		'templates',
		'save_backend',
		'preview_template',
		'animation_list',
		'preview_item_width',
		'edit'
	);

	public function getControlFrontend() {
		if ( !vc_enabled_frontend() ) {
			return '';
		}

		return '<li class="vc_pull-right">'
		       . '<a href="' . vc_frontend_editor()->getInlineUrl() . '" class="vc_btn vc_btn-primary vc_btn-sm vc_navbar-btn" id="wpb-edit-inline">' . __( 'Frontend', "js_composer" ) . '</a>'
		       . '</li>';
	}

	public function getControlPreviewTemplate() {
		if ( !vc_enabled_frontend() ) {
			return '';
		}

		return '<li class="vc_pull-right">'
		       . '<a href="#" class="vc_btn vc_btn-grey vc_btn-sm vc_navbar-btn" data-vc-navbar-control="preview">' . __( 'Preview', "js_composer" ) . '</a>'
		       . '</li>';
	}

	public function getControlEdit() {
		return '<li class="vc_pull-right">'
		       . '<a data-vc-navbar-control="edit" class="vc_icon-btn vc_post-settings" title="'
		       . __( 'Grid element settings', 'js_composer' ) . '">'
		       . '</a>'
		       . '</li>';
	}

	/**
	 * @return string
	 */
	public function getControlSaveBackend() {
		return '<li class="vc_pull-right vc_save-backend">'
		       . '<a class="vc_btn vc_btn-sm vc_navbar-btn vc_btn-primary vc_control-save" id="wpb-save-post">' . __( 'Update', "js_composer" ) . '</a>'
		       . '</li>';
	}

	/**
	 * @return string
	 */
	public function getControlPreviewItemWidth() {
		$output = '<li class="vc_pull-right vc_gitem-navbar-dropdown vc_gitem-navbar-preview-width" data-vc-grid-item="navbar_preview_width"><select data-vc-navbar-control="preview_width">';
		for ( $i = 1; $i <= 12; $i ++ ) {
			$output .= '<option value="' . esc_attr( $i ) . '">'
			           . __( $i . '/12 width', 'js_composer' ) . '</option>';
		}
		$output .= '</select></li>';
		return $output;
	}
	public function getControlAnimationList() {
		$output = '';
		require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-gitem-animated-block.php' );
		$animations = WPBakeryShortCode_VC_Gitem_Animated_Block::animations();
		if ( is_array( $animations ) ) {
			$output .= '<li class="vc_pull-right vc_gitem-navbar-dropdown">'
			          . '<select data-vc-navbar-control="animation">';
			foreach ( $animations as $value => $key ) {
				$output .= '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
			}
			$output .= '</select></li>';
		}
		return $output;
	}
}