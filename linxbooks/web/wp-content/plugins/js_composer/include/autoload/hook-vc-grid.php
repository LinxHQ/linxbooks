<?php
/**
 * Class Vc_Hooks_Vc_Grid
 * @since 4.4
 */
Class Vc_Hooks_Vc_Grid implements Vc_Vendor_Interface {

	/**
	 * Initializing hooks for grid element,
	 * Add actions to save appended shortcodes to post meta (for rendering in preview with shortcode id)
	 * And add action to hook request for grid data, to output it.
	 * @since 4.4
	 */
	public function load() {

		// Hook for set post settings meta with shortcodes data
		/**
		 * Filter called after page saved, used to append some post meta for post
		 * Used to save appended grid shortcodes to post meta with serialized array,
		 * @see Vc_Hooks_Vc_Grid::gridSavePostSettings (fetching shortcodes and return it data) and Vc_Hooks_Vc_Grid::get_shortcode_regex (search exact shortcode in content)
		 * @see Vc_Post_Admin::setSettings for filter info
		 */
		add_filter( 'vc_hooks_vc_post_settings', array(
			&$this,
			'gridSavePostSettings'
		), 10, 3 );
		/**
		 * Used to output shortcode data for ajax request. called on any page request.
		 */
		// add_action( 'template_redirect', array( &$this, 'getGridDataForAjax' ) );
		add_action( 'wp_ajax_vc_get_vc_grid_data', array( &$this, 'getGridDataForAjax' ) );
		add_action( 'wp_ajax_nopriv_vc_get_vc_grid_data', array( &$this, 'getGridDataForAjax' ) );
	}

	/**
	 * Shortcode regex from WP to TAKE only grid shortcodes from content
	 * @since 4.4
	 *
	 * @return string
	 */
	private function get_shortcode_regex() {
		$tagnames = array(
			'vc_basic_grid',
			'vc_masonry_grid',
			'vc_media_grid',
			'vc_masonry_media_grid'
		); // return only vc_adv_pager shortcodes
		$tagregexp = join( '|', array_map( 'preg_quote', $tagnames ) );

		// WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
		// Also, see shortcode_unautop() and shortcode.js.
		return
			'\\['                              // Opening bracket
			. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
			. "($tagregexp)"                     // 2: Shortcode name
			. '(?![\\w-])'                       // Not followed by word character or hyphen
			. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
			. '[^\\]\\/]*'                   // Not a closing bracket or forward slash
			. '(?:'
			. '\\/(?!\\])'               // A forward slash not followed by a closing bracket
			. '[^\\]\\/]*'               // Not a closing bracket or forward slash
			. ')*?'
			. ')'
			. '(?:'
			. '(\\/)'                        // 4: Self closing tag ...
			. '\\]'                          // ... and closing bracket
			. '|'
			. '\\]'                          // Closing bracket
			. '(?:'
			. '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
			. '[^\\[]*+'             // Not an opening bracket
			. '(?:'
			. '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
			. '[^\\[]*+'         // Not an opening bracket
			. ')*+'
			. ')'
			. '\\[\\/\\2\\]'             // Closing shortcode tag
			. ')?'
			. ')'
			. '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
	}

	/**
	 * Set page meta box values with vc_adv_pager shortcodes data
	 * @since 4.4
	 *
	 * @param array $settings
	 * @param $post_id
	 * @param $post
	 *
	 * @return array - shortcode settings to save.
	 */
	public function gridSavePostSettings( array $settings, $post_id, $post ) {
		$pattern = $this->get_shortcode_regex();
		preg_match_all( "/$pattern/", $post->post_content, $found ); // fetch only needed shortcodes
		$settings['vc_grid'] = array();
		if ( is_array( $found ) && ! empty( $found[0] ) ) {
			$to_save = array();
			foreach ( $found[3] as $key => $shortcode_atts ) {
				$atts = shortcode_parse_atts( $shortcode_atts );
				$data = array(
					'tag' => $found[2][ $key ],
					'atts' => $atts,
					'content' => $found[5][ $key ],
				);
				$hash = sha1( serialize( $data ) );
				$to_save[ $hash ] = $data;
			}
			if ( ! empty( $to_save ) ) {
				$settings['vc_grid'] = array( 'shortcodes' => $to_save );
			}
		}

		return $settings;
	}

	/**
	 * @since 4.4
	 *
	 * @output/@return string - grid data for ajax request.
	 */
	public function getGridDataForAjax() {
		// if ( vc_request_param( 'action' ) === 'vc_get_vc_grid_data' ) {
			if ( vc_request_param( 'tag' ) === 'vc_masonry_grid' ) {
				$settings = WPBMap::getShortCode( 'vc_masonry_grid' );
				require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-masonry-grid.php' );
				$vc_grid = new WPBakeryShortcode_VC_Masonry_Grid( $settings );
			} else if ( vc_request_param( 'tag' ) === 'vc_media_grid' ) {
				$settings = WPBMap::getShortCode( 'vc_media_grid' );
				require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-media-grid.php' );
				$vc_grid = new WPBakeryShortcode_VC_Media_Grid( $settings );
			} else if ( vc_request_param( 'tag' ) === 'vc_masonry_media_grid' ) {
				$settings = WPBMap::getShortCode( 'vc_masonry_media_grid' );
				require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-masonry-media-grid.php' );
				$vc_grid = new WPBakeryShortcode_VC_Masonry_Media_Grid( $settings );
			} else {
				$settings = WPBMap::getShortCode( 'vc_basic_grid' );
				require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-basic-grid.php' );
				$vc_grid = new WPBakeryShortcode_VC_Basic_Grid( $settings );
			}
			die( $vc_grid->renderAjax( vc_request_param( 'data' ) ) );
		// }
	}

}

/**
 * @since 4.4
 * @var Vc_Hooks_Vc_Grid $hook
 */
$hook = new Vc_Hooks_Vc_Grid();

// when visual composer initialized let's trigger Vc_Grid hooks.
add_action( 'vc_after_init', array( $hook, 'load' ) );