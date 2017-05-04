<?php
/**
 * @since 4.4 vendors initialization moved to hooks in autoload/vendors.
 *
 * Used to initialize plugin woocommerce vendor. (adds tons of woocommerce shortcodes and some fixes)
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	require_once vc_path_dir( 'VENDORS_DIR', 'plugins/class-vc-vendor-woocommerce.php' );
	$vendor = new Vc_Vendor_Woocommerce();
	$vendor->load();

}