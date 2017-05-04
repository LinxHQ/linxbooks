<?php
require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-column.php' );

Class WPBakeryShortCode_VC_Gitem_Col extends WPBakeryShortCode_VC_Column {
	public function mainHtmlBlockParams( $width, $i ) {
		return 'data-element_type="' . $this->settings["base"] . '" data-vc-column-width="'
		       . wpb_vc_get_column_width_indent( $width[ $i ] )
		       . '" class="wpb_vc_column wpb_' . $this->settings['base'] . ' wpb_sortable '
		       . $this->templateWidth() . ' wpb_content_holder"'
		       . $this->customAdminBlockParams();
	}

	public function outputEditorControlAlign() {
		$alignment = array(
			array( 'name' => 'left', 'label' => __( 'Left', 'js_composer' ) ),
			array( 'name' => 'center', 'label' => __( 'Center', 'js_composer' ) ),
			array( 'name' => 'right', 'label' => __( 'Right', 'js_composer' ) )
		);
		$output    = '<span class="vc_control vc_control-align"><span class="vc_control-wrap">';
		foreach ( $alignment as $data ) {
			$attr = esc_attr( $data['name'] );
			$output .= '<a href="#" data-vc-control-btn="align" data-vc-align="' . $attr . '" class="vc_control'
			           . ' vc_control-align-' . $attr . '" title="' . esc_html($data['label'])
			           . '"><i class="vc_icon vc_icon-align-'. $attr .'"></i></a>';
		}
		return $output . '</span></span>';
	}
}