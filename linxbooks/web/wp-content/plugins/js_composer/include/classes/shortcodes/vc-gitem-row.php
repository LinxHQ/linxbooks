<?php
require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-row.php' );
Class WPBakeryShortCode_VC_Gitem_Row extends WPBakeryShortCode_VC_Row {
	public function getLayoutsControl() {
		global $vc_row_layouts;
		$controls_layout = '<span class="vc_row_layouts vc_control">';
		foreach ( array_slice($vc_row_layouts, 0, 4) as $layout ) {
			$controls_layout .= '<a class="vc_control-set-column set_columns ' . $layout['icon_class'] . '" data-cells="' . $layout['cells'] . '" data-cells-mask="' . $layout['mask'] . '" title="' . $layout['title'] . '"></a> ';
		}
		// $controls_layout .= '<br/><a class="vc_control-set-column set_columns custom_columns" data-cells="custom" data-cells-mask="custom" title="' . __( 'Custom layout', 'js_composer' ) . '">' . __( 'Custom', 'js_composer' ) . '</a> ';
		$controls_layout .= '</span>';
		return $controls_layout;
	}
}