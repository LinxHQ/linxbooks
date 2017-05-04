<?php
include_once vc_path_dir( 'SHORTCODES_DIR', 'wordpress-widgets.php' );

add_filter( 'vc_edit_form_fields_attributes_vc_wp_text', array(
	'WPBakeryShortCode_VC_Wp_Text',
	'convertTextAttributeToContent'
) );