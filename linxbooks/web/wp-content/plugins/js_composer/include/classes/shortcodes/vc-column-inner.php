<?php
require_once vc_path_dir('SHORTCODES_DIR', 'vc-column.php');
class WPBakeryShortCode_VC_Column_Inner extends WPBakeryShortCode_VC_Column {
	protected function getFileName() {
		return 'vc_column';
	}
}