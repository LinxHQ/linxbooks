<?php

add_action( 'wpcf7_admin_notices', 'wpcf7_jetpack_admin_notices' );

function wpcf7_jetpack_admin_notices() {
	global $wpdb;

	if ( ! class_exists( 'Jetpack' )
	|| ! Jetpack::is_module( 'contact-form' )
	|| ! in_array( 'contact-form', Jetpack::get_active_modules() ) ) {
		return;
	}

	$q = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_old_cf7_unit_id'";

	if ( ! $wpdb->get_var( $q ) ) {
		return;
	}

	$desc_link = wpcf7_link( __( 'http://contactform7.com/jetpack-overrides-contact-forms/', 'contact-form-7' ), __( 'Jetpack Overrides Contact Forms', 'contact-form-7' ) );

?>
<div class="notice notice-warning">
<p><?php echo sprintf( esc_html( __( 'Jetpack may cause problems for other plugins in certain cases. For more details, see %s.', 'contact-form-7' ) ), $desc_link ); ?></p>
</div>
<?php
}
