<?php
require_once vc_path_dir('EDITORS_DIR', 'popups/class-vc-add-element-box.php');

	/**
	 * Add element for VC editors with a list of mapped shortcodes for gri item constructor.
	 *
	 * @since 4.4
	 */
Class Vc_Add_Element_Box_Grid_Item extends  Vc_Add_Element_Box {
	/**
	 * Get shortcodes from param type vc_grid_item
	 * @return array|bool
	 */
	public function shortcodes() {
		$grid_item = new Vc_Grid_Item();
		return $grid_item->shortcodes();
	}
}