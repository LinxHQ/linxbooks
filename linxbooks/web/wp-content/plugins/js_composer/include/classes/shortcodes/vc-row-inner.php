<?php
require_once vc_path_dir('SHORTCODES_DIR', 'vc-row.php');

class WPBakeryShortCode_VC_Row_Inner extends WPBakeryShortCode_VC_Row {
	protected function getFileName() {
		return 'vc_row';
	}

	public function template( $content = '' ) {
		return $this->contentAdmin( $this->atts );
	}
}