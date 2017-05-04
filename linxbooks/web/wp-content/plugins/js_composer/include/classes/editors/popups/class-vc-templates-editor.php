<?php

/**
 * The templates manager for VC.
 *
 * The templates manager provides ability to copy and reuse existing pages. Save templates for later use.
 * @deprecated since 4.4 use Vc_Templates_Panel_Editor::_construct
 * @since 4.2
 */
class Vc_Templates_Editor implements Vc_Render {
	/**
	 * @var string
	 */
	protected $option_name = 'wpb_js_templates';
	/**
	 * @var bool
	 */
	protected $default_templates = false;
	/**
	 * @var bool
	 */
	protected $initialized = false;
	/**
	 * @var
	 */
	public $template_id;

	/**
	 * Add ajax hooks.
	 * @deprecated since 4.4 use Vc_Templates_Panel_Editor::init
	 */
	public function init() {
		if ( $this->initialized ) {
			return;
		}
		$this->initialized = true;
		add_filter( 'vc_frontend_template_the_content', array( $this, 'frontendDoTemplatesShortcodes' ) );
		add_action( 'wp_ajax_wpb_save_template', array( &$this, 'save' ) );
		add_action( 'wp_ajax_vc_backend_template', array( &$this, 'load' ) );
		add_action( 'wp_ajax_wpb_load_template_shortcodes', array( &$this, 'loadTemplateShortcodes' ) );
		add_action( 'wp_ajax_vc_backend_default_template', array( &$this, 'getBackendDefaultTemplate' ) );
		add_action( 'wp_ajax_wpb_delete_template', array( &$this, 'delete' ) );
	}

	/**
	 * Used in Vc_Frontend_Editor::loadShortcodes, action 'vc_frontend_template'
	 * @deprecated since 4.4 will be removed, use action 'vc_frontend_template_panel'
	 */
	function renderFrontendTemplate() {
		add_filter( 'vc_frontend_template_the_content', array( &$this, 'frontendDoTemplatesShortcodes' ) );
		$this->template_id = vc_post_param( 'template_id' );
		if ( empty( $this->template_id ) ) {
			die( '0' );
		}
		$saved_templates = get_option( $this->option_name );
		vc_frontend_editor()->setTemplateContent( $saved_templates[ $this->template_id ]['template'] );
		vc_frontend_editor()->enqueueRequired();
		vc_include_template( 'editors/frontend_template.tpl.php', array(
			'editor' => vc_frontend_editor()
		) );
		die();
	}

	/**
	 * @deprecated since 4.4 and will be removed, use Vc_Templates_Panel_Editor::save
	 */
	public function save() {
		$template_name = vc_post_param( 'template_name' );
		$template = vc_post_param( 'template' );
		if ( ! isset( $template_name ) || trim( $template_name ) == "" || ! isset( $template ) || trim( $template ) == "" ) {
			echo 'Error: TPL-01';
			die();
		}

		$template_arr = array( "name" => stripslashes( $template_name ), "template" => stripslashes( $template ) );

		$saved_templates = get_option( $this->option_name );

		$template_id = sanitize_title( $template_name ) . "_" . rand();
		if ( $saved_templates === false ) {
			$deprecated = '';
			$autoload = 'no';
			$new_template = array();
			$new_template[ $template_id ] = $template_arr;
			add_option( $this->option_name, $new_template, $deprecated, $autoload );
		} else {
			$saved_templates[ $template_id ] = $template_arr;
			update_option( $this->option_name, $saved_templates );
		}
		$this->renderMenu( true );
		die();
	}

	/**
	 * @deprecated since 4.4 and will be removed, use Vc_Templates_Panel_Editor::renderBackendTemplate
	 */
	public function load() {
		$template_id = vc_post_param( 'template_id' );

		if ( ! isset( $template_id ) || $template_id == "" ) {
			echo 'Error: TPL-02';
			die();
		}

		$saved_templates = get_option( $this->option_name );

		$content = trim( $saved_templates[ $template_id ]['template'] );
		$content = str_replace( '\"', '"', $content ); // if not used causes a #1360 bug.
		//echo $content;
		$pattern = get_shortcode_regex();
		$content = preg_replace_callback( "/{$pattern}/s", 'vc_convert_shortcode', $content );
		echo $content;
		//echo do_shortcode( $content );

		die();
	}

	/**
	 * @deprecated and will not used anymore
	 */
	public function loadInline() {
		echo $this->renderMenu();
		die();
	}

	/**
	 * @deprecated and will not used anymore
	 */
	public function loadTemplateShortcodes() {
		$template_id = vc_post_param( 'template_id' );

		if ( ! isset( $template_id ) || $template_id == "" ) {
			echo 'Error: TPL-02';
			die();
		}

		$saved_templates = get_option( $this->option_name );

		$content = trim( $saved_templates[ $template_id ]['template'] );
		$content = str_replace( '\"', '"', $content ); // if not used causes a #1360 bug.
		$pattern = get_shortcode_regex();
		$content = preg_replace_callback( "/{$pattern}/s", 'vc_convert_shortcode', $content );
		echo $content;
		die();
	}

	/**
	 * @deprecated since 4.4 and will be removed, use Vc_Templates_Panel_Editor::delete
	 */
	public function delete() {
		$template_id = vc_post_param( 'template_id' );

		if ( ! isset( $template_id ) || $template_id == "" ) {
			echo 'Error: TPL-03';
			die();
		}

		$saved_templates = get_option( $this->option_name );
		unset( $saved_templates[ $template_id ] );
		if ( count( $saved_templates ) > 0 ) {
			update_option( $this->option_name, $saved_templates );
		} else {
			delete_option( $this->option_name );
		}
		echo $this->renderMenu( true );
		die();
	}

	/**
	 * Add custom template to default templates list ( at end of list )
	 * $data = array( 'name'=>'', 'image'=>'', 'content'=>'' )
	 *
	 * @param $data
	 *
	 * @deprecated, since 4.4 use Vc_Templates_Panel_Editor::addDefaultTemplates, will be removed
	 * @moved to Vc_Templates_Panel_Editor::addDefaultTemplates
	 * @return boolean true if added, false if failed
	 */
	public function addDefaultTemplates( $data ) {
		return visual_composer()->templatesPanelEditor()->addDefaultTemplates( $data );
	}

	/**
	 * Load default templates list and initialize variable
	 * To modify you should use add_filter('vc_load_default_templates','your_custom_function');
	 * Argument is array of templates data like:
	 *      array(
	 *          array(
	 *              'name'=>__('My custom template','my_plugin'),
	 *              'image_path'=> preg_replace( '/\s/', '%20', plugins_url( 'images/my_image.png', __FILE__ ) ), // always use preg replace to be sure that "space" will not break logic
	 *              'custom_class'=>'my_custom_class', // if needed
	 *              'content'=>'[my_shortcode]yeah[/my_shortcode]', // Use HEREDoc better to escape all single-quotes and double quotes
	 *          ),
	 *          ...
	 *      );
	 * Also see filters 'vc_load_default_templates_panels' and 'vc_load_default_templates_welcome_block' to modify templates in panels tab and/or in welcome block.
	 * @deprecated since 4.4 and moved to Vc_Templates_Panel_Editor::loadDefaultTemplates(), will be removed
	 * @moved to Vc_Templates_Panel_Editor
	 * @return array
	 */
	public function loadDefaultTemplates() {
		return visual_composer()->templatesPanelEditor()->loadDefaultTemplates();
	}

	/**
	 * Alias for loadDefaultTemplates
	 * @deprecated since 4.4 moved to Vc_Templates_Panel_Editor::getDefaultTemplates(), will be removed
	 * @moved to Vc_Templates_Panel_Editor
	 * @return array - list of default templates
	 */
	public function getDefaultTemplates() {
		return visual_composer()->templatesPanelEditor()->getDefaultTemplates();
	}

	/**
	 * Get default template data by template index in array.
	 *
	 * @deprecated since 4.4 moved to Vc_Templates_Panel_Editor::getDefaultTemplate(), will be removed
	 * @moved to Vc_Templates_Panel_Editor
	 *
	 * @param number $template_index
	 *
	 * @return array|bool
	 */
	public function getDefaultTemplate( $template_index ) {
		return visual_composer()->templatesPanelEditor()->getDefaultTemplate( $template_index );
	}

	/**
	 * Load default template content by index from ajax
	 * @deprecated since 4.4 moved to Vc_Templates_Panel_Editor::getBackendDefaultTemplate(), will be removed
	 * @moved to Vc_Templates_Panel_Editor
	 *
	 * @param bool $return | should function return data or not
	 *
	 * @return string
	 */
	public function getBackendDefaultTemplate( $return = false ) {
		return visual_composer()->templatesPanelEditor()->getBackendDefaultTemplate( $return );
	}

	/**
	 * @deprecated since 4.4 and will be removed, use Vc_Templates_Panel_Editor::render
	 */
	public function render() {
		vc_include_template( 'editors/popups/panel_templates_editor.tpl.php', array(
			'box' => $this
		) );
	}

	/**
	 * @deprecated and will not used anymore
	 *
	 * @param $id
	 * @param $params
	 *
	 * @return string
	 */
	public function outputMenuButton( $id, $params ) {
		if ( empty( $params ) ) {
			return '';
		}
		$output = '<li class="wpb_template_li"><a data-template_id="' . $id . '" href="#">' . htmlspecialchars( __( $params['name'], "js_composer" ) ) . '</a> <span class="wpb_remove_template" title="' . __( "Delete template", "js_composer" ) . '" rel="' . $id . '"><i class="icon wpb_template_delete_icon"> </i></span></li>';

		return $output;
	}

	/**
	 * @deprecated since 4.4, and will not used anymore
	 *
	 * @param bool $only_list
	 *
	 * @return string
	 */
	public function renderMenu( $only_list = false ) {
		$templates = get_option( $this->option_name );
		$output = '';
		if ( $only_list === false ) {
			$output .= '<li><ul>
                        <li id="wpb_save_template"><a href="#" id="wpb_save_template_button" class="button">' . __( 'Save current page as a Template', "js_composer" ) . '</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">' . __( 'Load Template', "js_composer" ) . '</li>
                        </ul></li>
                        <li>
                        <ul class="wpb_templates_list">';
		}
		if ( empty( $templates ) ) {
			$output .= '<li class="wpb_no_templates"><span>' . __( 'No custom templates yet.', "js_composer" ) . '</span></li></ul></li>';
			echo $output;

			return '';
		}
		$templates_arr = $templates;
		foreach ( $templates as $id => $template ) {
			if ( is_array( $template ) && isset( $template['name'], $template['template'] ) && strlen( trim( $template['name'] ) ) > 0 && strlen( trim( $template['template'] ) ) > 0 ) {
				$output .= $this->outputMenuButton( $id, $template );
			} else {
				/* This will delete exists "Wrong" templates */
				unset( $templates_arr[ $id ] );
				if ( count( $templates_arr ) > 0 ) {
					update_option( $this->option_name, $templates_arr );
				} else {
					delete_option( $this->option_name );
				}
			}
		}
		// $output .= '</ul></li>';
		echo $output;

		return '';
	}

	/**
	 * Load frontend default template content by index
	 * Used in Vc_Frontend_Editor::loadShortcodes action 'vc_frontend_default_template'
	 * @deprecated since 4.4 and will be removed,  use action 'vc_frontend_default_template_panel' instead and Vc_Templates_Panel_Editor::renderFrontendDefaultTemplate
	 */
	public function renderFrontendDefaultTemplate() {
		$template_index = vc_post_param( 'template_name' );
		$data = $this->getDefaultTemplate( $template_index );
		! $data && die( '0' );
		vc_frontend_editor()->setTemplateContent( trim( $data['content'] ) );
		vc_frontend_editor()->enqueueRequired();
		vc_include_template( 'editors/frontend_template.tpl.php', array(
			'editor' => vc_frontend_editor()
		) );
		die();
	}

	/**
	 * Calls do_shortcode for templates.
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public function frontendDoTemplatesShortcodes( $content ) {
		return do_shortcode( $content );
	}
}