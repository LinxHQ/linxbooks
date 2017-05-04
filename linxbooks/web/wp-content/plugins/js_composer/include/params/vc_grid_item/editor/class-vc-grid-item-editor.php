<?php
/**
 * Manger for new post type for single grid item design with constructor
 *
 * @package WPBakeryVisualComposer
 * @since 4.4
 */
require_once vc_path_dir( 'EDITORS_DIR', 'class-vc-backend-editor.php' );

class Vc_Grid_Item_Editor extends Vc_Backend_Editor {
	protected static $post_type = 'vc_grid_item';
	protected $templates_editor = false;
	function __construct() {
		add_action( 'admin_print_scripts-post.php', array( &$this, 'printScriptsMessages' ) );
		add_action( 'admin_print_scripts-post-new.php', array( &$this, 'printScriptsMessages' ) );
		add_action( 'vc_templates_render_backend_template', array( &$this, 'loadPredefinedTemplate' ), 10, 2 );
		// add_action( 'vc_after_init', array(&$this, 'mapShortcodes'));
	}
	/*
	public function mapShortcodes() {
		if(vc_request_param('vc_grid_item_editor') === 'true') {
			require_once vc_path_dir( 'EDITORS_DIR', 'popups/class-vc-templates-editor-grid-item.php' );
			$templates_editor = new Vc_Templates_Editor_Grid_Item();
			$templates_editor->init();
		}
	}
	*/
	/**
	 * Create post type and new item in the admin menu.
	 * @return void
	 */
	public static function createPostType() {
		register_post_type( self::$post_type,
			array(
				'labels' => array(
					'add_new_item' => __( 'Add Grid Element', "js_composer" ),
					'name' => __( 'Grid Elements', "js_composer" ),
					'singular_name' => __( 'Grid Element', "js_composer" ),
					'edit_item' => __( 'Edit Grid Element', "js_composer" ),
					'view_item' => __( 'View Grid Element', "js_composer" ),
					'search_items' => __( 'Search Grid Elements', "js_composer" ),
					'not_found' => __( 'No grid elements found', "js_composer" ),
					'not_found_in_trash' => __( 'No grid elements found in Trash', "js_composer" ),
				),
				'public' => false,
				'has_archive' => false,
				'show_in_nav_menus' => false,
				'exclude_from_search' => true,
				'publicly_queryable' => false,
				'show_ui' => true,
				'query_var' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => null,
				'menu_icon' => vc_asset_url( 'vc/vc_grid_item_post_type_icon.png' ),
				'supports' => array( 'title', 'editor' ),
			)
		);
	}

	/**
	 * Rewrites validation for correct post_type of th post.
	 *
	 * @return bool
	 */
	public function isValidPostType() {
		return get_post_type() === $this->postType();
	}

	/**
	 * Get post type for Vc grid element editor.
	 *
	 * @static
	 * @return string
	 */
	public static function postType() {
		return self::$post_type;
	}

	/**
	 *    Calls add_meta_box to create Editor block.
	 *
	 * @access public
	 */
	public function addMetaBox() {
		add_meta_box( 'wpb_visual_composer',
			__( 'Grid Element Builder', "js_composer" ),
			array( &$this, 'renderEditor' ), $this->postType(), 'normal', 'high' );
	}

	/**
	 * Change order of the controls for shortcodes admin block.
	 * @return array
	 */
	public function shortcodesControls() {
		return array( 'delete', 'edit' );
	}

	/**
	 * Output html for backend editor meta box.
	 *
	 * @param null|int $post
	 *
	 * @return mixed|void
	 */
	public function renderEditor( $post = null ) {
		add_filter( 'vc_wpbakery_shortcode_get_controls_list', array( $this, 'shortcodesControls' ) );
		require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/class-vc-grid-item.php' );
		$this->post = $post;
		vc_include_template( 'params/vc_grid_item/editor/vc_grid_item_editor.tpl.php', array(
			'editor' => $this,
			'post' => $this->post
		) );
		add_action( 'admin_footer', array( &$this, 'renderEditorFooter' ) );
		do_action( 'vc_backend_editor_render' );
		do_action( 'vc_vc_grid_item_editor_render' );
	}

	public function showRulesValue() {
		return 'only';
	}

	/**
	 * Output required html and js content for VC editor.
	 *
	 * Here comes panels, modals and js objects with data for mapped shortcodes.
	 */
	public function renderEditorFooter() {
		vc_include_template( 'params/vc_grid_item/editor/partials/vc_grid_item_editor_footer.tpl.php', array(
			'editor' => $this,
			'post' => $this->post
		) );
		do_action( 'vc_backend_editor_footer_render' );
	}


	/**
	 *
	 */
	public function printScriptsMessages() {
		parent::printScriptsMessages();
		if ( $this->isValidPostType() ) {
			wp_register_script( 'vc_grid_item_editor',
				vc_asset_url( 'js/params/vc_grid_item/editor.js' ),
				array( 'wpb_js_composer_js_custom_views' ),
				WPB_VC_VERSION, true );

			wp_localize_script( 'vc_grid_item_editor', 'i18nLocaleGItem', array(
				'preview' => __( 'Preview', 'js_composer' ),
				'builder' => __( 'Builder', 'js_composer' ),
				'add_template_message' => __( 'If you add this template, all your current changes will be removed. Are you sure you want to add template?',
					'js_composer' )
			) );
			wp_enqueue_script( 'vc_grid_item_editor' );
		}
	}
	public function templatesEditor() {
		if(false === $this->templates_editor) {
			require_once vc_path_dir('PARAMS_DIR', 'vc_grid_item/editor/popups/class-vc-templates-editor-grid-item.php' );
			$this->templates_editor = new Vc_Templates_Editor_Grid_Item();
		}
		return $this->templates_editor;
	}

	public function loadPredefinedTemplate( $template_id, $template_type ) {
		if ( 'grid_templates' == $template_type ) {
			ob_start();
			$this->templatesEditor()->load( $template_id );
			return ob_get_clean();
		}

		return $template_id;
	}
}
