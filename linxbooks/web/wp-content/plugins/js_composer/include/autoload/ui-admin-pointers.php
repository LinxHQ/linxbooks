<?php
if ( is_admin() ) {
	add_action( 'admin_enqueue_scripts', 'vc_gitem_editor_pointer_load', 1000 );
}

function vc_gitem_editor_pointer_load( $hook_suffix ) {

	// Don't run on WP < 3.3
	if ( get_bloginfo( 'version' ) < '3.3' ) {
		return;
	}

	$screen = get_current_screen();
	$screen_id = $screen->id;

	// Get pointers for this screen
	$pointers = apply_filters( 'vc_ui-pointers-' . $screen_id, array() );

	if ( ! $pointers || ! is_array( $pointers ) ) {
		return;
	}

	// Get dismissed pointers
	$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	$valid_pointers = array();

	// Check pointers and remove dismissed ones.
	foreach ( $pointers as $pointer_id => $pointer ) {

		// Sanity check
		if ( in_array( $pointer_id, $dismissed ) || empty( $pointer ) || empty( $pointer_id ) || empty( $pointer['name'] )) {
			continue;
		}

		$pointer['pointer_id'] = $pointer_id;

		// Add the pointer to $valid_pointers array
		$valid_pointers['pointers'][] = $pointer;
	}

	// No valid pointers? Stop here.
	if ( empty( $valid_pointers ) ) {
		return;
	}

	// Add pointers style to queue.
	wp_enqueue_style( 'wp-pointer' );

	// Add pointers script to queue. Add custom script.
	wp_enqueue_script( 'vc_wp-pointer', vc_asset_url( 'js/backend/editor_pointer.js' ), array( 'wp-pointer', 'wpb_scrollTo_js' ) );

	// messages
	$valid_pointers['texts'] = array(
		'finish' => __( 'Finish', 'js_composer' ),
		'next' => __( 'Next', 'js_composer' ),
		'prev' => __( 'Prev', 'js_composer' ),
	);

	// Add pointer options to script.
	wp_localize_script( 'vc_wp-pointer', 'vcPointer', $valid_pointers );
}
