<?php
/**
 * @since 4.4 vendors initialization moved to hooks in autoload/vendors.
 *
 * Used to initialize plugin mqtranslate vendor
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
if ( is_plugin_active( 'mqtranslate/mqtranslate.php' ) ) {
	require_once vc_path_dir( 'VENDORS_DIR', 'plugins/class-vc-vendor-mqtranslate.php' );
	$vendor = new Vc_Vendor_Mqtranslate();
	$vendor->load();

}