<?php
/**
 * @since 4.4 vendors initialization moved to hooks in autoload/vendors.
 *
 * Used to initialize plugin revslider vendor.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
if ( is_plugin_active( 'revslider/revslider.php' ) ) {
	require_once vc_path_dir( 'VENDORS_DIR', 'plugins/class-vc-vendor-revslider.php' );
	$vendor = new Vc_Vendor_Revslider();
	$vendor->load();

}