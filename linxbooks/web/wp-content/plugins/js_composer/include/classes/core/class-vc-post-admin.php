<?php

/**
 * Ability to interact with post data.
 *
 * @since 4.4
 */
Class Vc_Post_Admin {
	/**
	 * Add hooks required to save, update and manipulate post
	 */
	public function init() {
		add_action( 'edit_post', array( &$this, 'save' ) );
	}

	/**
	 * Save generated shortcodes, html and visual composer status in posts meta.
	 *
	 * @access public
	 * @since 4.4
	 *
	 * @param $post_id - current post id
	 *
	 * @return void
	 */
	public function save( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		$this->setJsStatus( $post_id );
		// $this->setInterfaceVersion($post_id);
		if ( ! ( isset( $_POST['wp-preview'] ) && 'dopreview' == $_POST['wp-preview'] ) ) {

			$this->setSettings( $post_id );
		}
	}

	/**
	 * Saves VC Backend editor meta box visibility status.
	 *
	 * If post param 'wpb_vc_js_status' set to true, then methods adds/updated post
	 * meta option with tag '_wpb_vc_js_status'.
	 * @since 4.4
	 *
	 * @param $post_id
	 */
	public function setJsStatus( $post_id ) {
		$value = vc_post_param( 'wpb_vc_js_status' );
		if ( $value !== null ) {
			// Add value
			if ( get_post_meta( $post_id, '_wpb_vc_js_status' ) == '' ) {
				add_post_meta( $post_id, '_wpb_vc_js_status', $value, true );
			} // Update value
			elseif ( $value != get_post_meta( $post_id, '_wpb_vc_js_status', true ) ) {
				update_post_meta( $post_id, '_wpb_vc_js_status', $value );
			} // Delete value
			elseif ( $value == '' ) {
				delete_post_meta( $post_id, '_wpb_vc_js_status', get_post_meta( $post_id, '_wpb_vc_js_status', true ) );
			}
		}
	}

	/**
	 * Saves VC interface version which is used for building post content.
	 * @since 4.4
	 *
	 * @param $post_id
	 */
	public function setInterfaceVersion( $post_id ) {
		if ( ( $value = vc_post_param( 'wpb_vc_js_interface_version' ) ) !== null ) {
			update_post_meta( $post_id, '_wpb_vc_js_interface_version', $value );
		}
	}

	/**
	 * Set Post Settings for VC.
	 *
	 * It is possible to add any data to post settings by adding filter with tag 'vc_hooks_vc_post_settings'.
	 * @since 4.4
	 * vc_filter: vc_hooks_vc_post_settings - hook to override post meta settings for visual composer (used in grid for example)
	 *
	 * @param $post_id
	 */
	public function setSettings( $post_id ) {
		$settings = array();
		$settings = apply_filters( 'vc_hooks_vc_post_settings', $settings, $post_id, get_post( $post_id ) );
		if ( is_array( $settings ) && ! empty( $settings ) ) {
			update_post_meta( $post_id, '_vc_post_settings', $settings );
		} else {
			delete_post_meta( $post_id, '_vc_post_settings' );
		}
	}
}