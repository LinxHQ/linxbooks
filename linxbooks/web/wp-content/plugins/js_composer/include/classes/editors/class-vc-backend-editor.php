<?php
/**
 * WPBakery Visual Composer admin editor
 *
 * @package WPBakeryVisualComposer
 *
 */

/**
 * VC backend editor.
 *
 * This editor is available on default Wp post/page admin edit page. ON admin_init callback adds meta box to
 * edit page.
 *
 * @since 4.2
 */
class Vc_Backend_Editor implements Vc_Editor_Interface {

	/**
	 * @var
	 */
	protected $layout;
	/**
	 * @var
	 */
	public $post_custom_css;
	/**
	 * @var bool|string $post - stores data about post.
	 */
	public $post = false;
	/**
	 * This method is called by Vc_Manager to register required action hooks for VC backend editor.
	 *
	 * @since  4.2
	 * @access public
	 */
	public function addHooksSettings() {
		add_action( 'wp_ajax_wpb_get_element_backend_html', array( &$this, 'elementBackendHtml' ) );
		// load backend editor
		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'post-thumbnails' );
		}
		add_post_type_support( 'page', 'excerpt' );
		add_action( 'admin_init', array( &$this, 'render' ), 5 );
		add_action( 'admin_print_scripts-post.php', array( &$this, 'printScriptsMessages' ) );
		add_action( 'admin_print_scripts-post-new.php', array( &$this, 'printScriptsMessages' ) );

		/**
		 * Load required vendors classes;
		 * @deprecated since 4.4 due to autoload logic
		 */
		visual_composer()->vendorsManager()->load();
	}

	/**
	 *    Calls add_meta_box to create Editor block. Block is rendered by WPBakeryVisualComposerLayout.
	 *
	 * @see WPBakeryVisualComposerLayout
	 * @since  4.2
	 * @access public
	 */
	public function render() {
		$post_types = vc_editor_post_types();
		foreach ( $post_types as $type ) {
			add_meta_box( 'wpb_visual_composer', __( 'Visual Composer', "js_composer" ), Array(
					&$this,
					'renderEditor'
				), $type, 'normal', 'high' );
		}
	}

	/**
	 * Output html for backend editor meta box.
	 *
	 * @param null|Wp_Post $post
	 *
	 * @return mixed|void
	 */
	public function renderEditor( $post = null ) {
		/**
		 * @todo setter/getter for $post
		 */
		$this->post = $post;
		$this->post_custom_css = get_post_meta( $post->ID, '_wpb_post_custom_css', true );
		vc_include_template( 'editors/backend_editor.tpl.php', array(
			'editor' => $this,
			'post' => $this->post
		) );
		add_action( 'admin_footer', array( &$this, 'renderEditorFooter' ) );
		do_action( 'vc_backend_editor_render' );
	}

	/**
	 * Output required html and js content for VC editor.
	 *
	 * Here comes panels, modals and js objects with data for mapped shortcodes.
	 */
	public function renderEditorFooter() {
		vc_include_template( 'editors/partials/backend_editor_footer.tpl.php', array(
			'editor' => $this,
			'post' => $this->post
		) );
		do_action( 'vc_backend_editor_footer_render' );
	}
	/**
	 * Check is post type is valid for rendering VC backend editor.
	 *
	 * @return bool
	 */
	public function isValidPostType() {
		return in_array( get_post_type(), vc_editor_post_types() );
	}
	/**
	 * Enqueue required javascript libraries and css files.
	 *
	 * This method also setups reminder about license activation.
	 *
	 * @since  4.2
	 * @access public
	 */
	public function printScriptsMessages() {
		if ($this->isValidPostType()) {
			vc_license()->setupReminder();
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'farbtastic' );
			wp_enqueue_style( 'ui-custom-theme' );
			wp_enqueue_style( 'isotope-css' );
			wp_enqueue_style( 'animate-css' );
			wp_enqueue_style( 'font-awesome' );
			wp_enqueue_style( 'js_composer' );
			wp_enqueue_style( 'wpb_jscomposer_autosuggest' );
			WPBakeryShortCodeFishBones::enqueueCss();

			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-droppable' );
			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( 'jquery-ui-accordion' );
			wp_enqueue_script( 'jquery-ui-autocomplete' );
			wp_enqueue_script( 'farbtastic' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'vc_bootstrap_js', vc_asset_url( 'lib/bootstrap3/dist/js/bootstrap.min.js' ), array( 'jquery' ), '3.0.2', true );
			wp_enqueue_script( 'wpb_scrollTo_js' );
			wp_enqueue_script( 'wpb_php_js' );
			wp_enqueue_script( 'wpb_js_composer_js_sortable' );
			wp_enqueue_script( 'wpb_json-js' );
			wp_enqueue_style( 'js_composer_settings', vc_asset_url( 'css/js_composer_settings.css' ), array(), WPB_VC_VERSION, false );
			wp_enqueue_script( 'ace-editor' );
			wp_enqueue_script( 'webfont', '//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js' ); // Google Web Font CDN
			wp_enqueue_script( 'wpb_js_composer_js_tools' );
			wp_enqueue_script( 'wpb_js_composer_js_storage' );
			wp_enqueue_script( 'wpb_js_composer_js_models' );
			wp_enqueue_script( 'wpb_js_composer_js_view' );
			wp_enqueue_script( 'wpb_js_composer_js_custom_views' );
			/**
			 * Enqueue deprecated
			 * @since 4.4 removed
			 */
			//wp_enqueue_script( 'vc_js_composer_js_backend_deprecated', vc_asset_url( 'js/backend/deprecated.js' ), array( 'wpb_js_composer_js_view' ), WPB_VC_VERSION, true );
			wp_enqueue_script( 'wpb_js_composer_js_backbone' );
			wp_enqueue_script( 'wpb_jscomposer_composer_js' );
			wp_enqueue_script( 'wpb_jscomposer_shortcode_js' );
			wp_enqueue_script( 'wpb_jscomposer_modal_js' );
			wp_enqueue_script( 'wpb_jscomposer_templates_js' );
			wp_enqueue_script( 'wpb_jscomposer_stage_js' );
			wp_enqueue_script( 'wpb_jscomposer_layout_js' );
			wp_enqueue_script( 'wpb_jscomposer_row_js' );
			wp_enqueue_script( 'wpb_jscomposer_settings_js' );
			wp_enqueue_script( 'wpb_jscomposer_media_editor_js' );
			wp_enqueue_script( 'wpb_jscomposer_autosuggest_js' );
			// }}
			wp_enqueue_script( 'wpb_js_composer_js' );
			/**
			 * @since 4.4
			 */
			do_action( 'vc_backend_editor_enqueue_js_css' );
			WPBakeryShortCodeFishBones::enqueueJs();
		}
	}

	/**
	 * Save generated shortcodes, html and visual composer status in posts meta.
	 *
	 * @deprecated since 4.4
	 * @since  3.0
	 * @access public
	 *
	 * @param $post_id - current post id
	 *
	 * @return void
	 */
	public function save( $post_id ) {
		visual_composer()->postAdmin()->save( $post_id );
	}

	/**
	 * Create shortcode's string.
	 *
	 * @since  3.0
	 * @access public
	 * @deprecated
	 */
	public function elementBackendHtml() {
		global $current_user;
		get_currentuserinfo();
		$data_element = vc_post_param( 'data_element' );
		/** @var $settings - get use group access rules */
		$settings = WPBakeryVisualComposerSettings::get( 'groups_access_rules' );
		$role = $current_user->roles[0];

		if ( $data_element == 'vc_column' && vc_post_param( 'data_width' ) !== null ) {
			$output = do_shortcode( '[vc_column width="' . vc_post_param( 'data_width' ) . '"]' );
			echo $output;
		} elseif ( $data_element == 'vc_row' || $data_element == 'vc_row_inner' ) {
			$output = do_shortcode( '[' . $data_element . ']' );
			echo $output;
		} elseif ( ! isset( $settings[ $role ]['shortcodes'] ) || ( isset( $settings[ $role ]['shortcodes'][ $data_element ] ) && (int) $settings[ $role ]['shortcodes'][ $data_element ] == 1 ) ) {
			$output = do_shortcode( '[' . $data_element . ']' );
			echo $output;
		}
		die();
	}

	/**
	 * @return string
	 */
	public function showRulesValue() {
		global $current_user;
		get_currentuserinfo();
		/** @var $settings - get use group access rules */
		$settings = vc_settings()->get( 'groups_access_rules' );
		$role = is_object( $current_user ) && isset( $current_user->roles[0] ) ? $current_user->roles[0] : '';
		return isset( $settings[ $role ]['show'] ) ? $settings[ $role ]['show'] : '';
	}
}
