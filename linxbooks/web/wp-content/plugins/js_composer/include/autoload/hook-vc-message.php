<?php
include_once vc_path_dir( 'SHORTCODES_DIR', 'vc-message.php' );

add_filter( 'vc_edit_form_fields_attributes_vc_message', array(
		'WPBakeryShortCode_VC_Message',
		'convertAttributesToMessageBox2'
	) );