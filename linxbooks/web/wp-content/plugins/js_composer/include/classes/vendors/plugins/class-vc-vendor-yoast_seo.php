<?php

/**
 * Class Vc_Vendor_YoastSeo
 * @since 4.4
 */
Class Vc_Vendor_YoastSeo implements Vc_Vendor_Interface {

	/**
	 * Add filter for yoast.
	 * @since 4.4
	 */
	public function load() {
		/*if ( class_exists( 'WPSEO_Metabox' ) && vc_mode() == 'admin_page' ) {

			add_filter( 'wpseo_pre_analysis_post_content', array(
				&$this,
				'filterResults'
			) );

		}*/ // removed due to woocommerce fatal error :do_shortcode in is_admin() mode =  fatal error
	}

	/**
	 * Properly parse content to detect images/text keywords.
	 * @since 4.4
	 *
	 * @param $content
	 *
	 * @return array
	 */
	public function filterResults( $content ) {
		$content = do_shortcode( shortcode_unautop( $content ) );

		return $content;
	}

}