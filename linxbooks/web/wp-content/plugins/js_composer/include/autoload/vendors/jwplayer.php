<?php
/**
 * @since 4.4 vendors initialization moved to hooks in autoload/vendors.
 *
 * Used to initialize plugin jwplayer vendor for frontend editor.
 */
if ( class_exists( 'JWP6_Plugin' ) ) {
	require_once vc_path_dir( 'VENDORS_DIR', 'plugins/class-vc-vendor-jwplayer.php' );
	$vendor = new Vc_Vendor_Jwplayer();
	$vendor->load();

}