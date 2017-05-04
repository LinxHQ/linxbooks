<?php

/**
 * Class Vc_Templates_Panel_Editor
 * @since 4.4
 */
Class Vc_Templates_Panel_Editor implements Vc_Render {
	/**
	 * @since 4.4
	 * @var string
	 */
	protected $option_name = 'wpb_js_templates';
	/**
	 * @since 4.4
	 * @var bool
	 */
	protected $default_templates = false;
	/**
	 * @since 4.4
	 * @var bool
	 */
	protected $initialized = false;

	/**
	 * @since 4.4
	 * Add ajax hooks, filters.
	 */
	public function init() {
		if ( $this->initialized ) {
			return;
		}
		$this->initialized = true;
		add_filter( 'vc_load_default_templates_welcome_block', array( &$this, 'loadDefaultTemplatesLimit' ) );

		add_filter( 'vc_templates_render_category', array( &$this, 'renderTemplateBlock' ), 10 );
		add_filter( 'vc_templates_render_template', array( &$this, 'renderTemplateWindow' ), 10, 2 );

		/**
		 * Ajax methods
		 *  'vc_save_template' -> saving content as template
		 *  'vc_backend_load_template' -> loading template content for backend
		 *  'vc_frontend_load_template' -> loading template content for frontend
		 *  'vc_delete_template' -> deleting template by index
		 */
		add_action( 'wp_ajax_vc_save_template', array( &$this, 'save' ) );
		add_action( 'wp_ajax_vc_backend_load_template', array( &$this, 'renderBackendTemplate' ) );
		add_action( 'wp_ajax_vc_frontend_load_template', array( &$this, 'renderFrontendTemplate' ) );
		add_action( 'wp_ajax_vc_delete_template', array( &$this, 'delete' ) );

	}

	public function renderTemplateBlock( $category ) {
		if ('my_templates' == $category['category'] ) {
			$category['output'] = '
				<div class="vc_column vc_col-sm-12">
					<div class="vc_element_label">' . esc_html( 'Save current layout as a template', 'js_composer' ) . '</div>
					<div class="vc_input-group">
						<input name="padding" class="vc_form-control wpb-textinput vc_panel-templates-name" type="text" value=""
						       placeholder="' . esc_attr( 'Template name', 'js_composer' ) . '">
						<span class="vc_input-group-btn"> <button class="vc_btn vc_btn-primary vc_btn-sm vc_template-save-btn">' . esc_html( 'Save template', 'js_composer' ) . '</button></span>
					</div>
					<span class="vc_description">' . esc_html( 'Save your layout and reuse it on different sections of your website', 'js_composer' ) . '</span>
				</div>';
			$category['output'] .= '<div class="vc_col-md-12">';
			if ( isset( $category['category_name'] ) ) {
				$category['output'] .= '<h3>' . esc_html( $category['category_name'] ) . '</h3>';
			}
			if ( isset( $category['category_description'] ) ) {
				$category['output'] .= '<p class="vc_description">' . esc_html( $category['category_description'] ) . '</p>';
			}
			$category['output'] .= '</div>';
			$category['output'] .= '
			<div class="vc_column vc_col-sm-12">
			<ul class="vc_templates-list-my_templates">';
			if ( ! empty( $category['templates'] ) ) {
				foreach ( $category['templates'] as $template ) {
					$name = isset( $template['name'] ) ? esc_html( $template['name'] ) : esc_html( __( 'No title', 'js_composer' ) );
					$type = isset( $template['type'] ) ? $template['type'] : 'custom';
					$custom_class = isset( $template['custom_class'] ) ? $template['custom_class'] : '';
					$unique_id = isset( $template['unique_id'] ) ? $template['unique_id'] : false; // You must provide unique_id otherwise it will be wrong in rendering
					// see hook filters in Vc_Templates_Panel_Editor::__construct
					$category['output'] .= '<li class="vc_col-sm-4 vc_template vc_templates-template-type-' . esc_attr( $type ) . ' ' . esc_attr( $custom_class ) . '"
									    data-category="' . esc_attr( $category['category'] ) . '"
									    data-template_unique_id="' . esc_attr( $unique_id ) . '"
									    data-template_type="' . esc_attr( $type ) . '">' . apply_filters( 'vc_templates_render_template', $name, $template ) . '</li>';
				}
			}
			$category['output'] .= '</ul></div>';
		} else if ( 'default_templates' == $category['category'] ) {
			$category['output'] = '<div class="vc_col-md-12">';
			if ( isset( $category['category_name'] ) ) {
				$category['output'] .= '<h3>' . esc_html( $category['category_name'] ) . '</h3>';
			}
			if ( isset( $category['category_description'] ) ) {
				$category['output'] .= '<p class="vc_description">' . esc_html( $category['category_description'] ) . '</p>';
			}
			$category['output'] .= '</div>';
			$category['output'] .= '
			<div class="vc_column vc_col-sm-12">
			<ul class="vc_templates-list-default_templates">';
			if ( ! empty( $category['templates'] ) ) {
				foreach ( $category['templates'] as $template ) {
					$name = isset( $template['name'] ) ? esc_html( $template['name'] ) : esc_html( __( 'No title', 'js_composer' ) );
					$type = isset( $template['type'] ) ? $template['type'] : 'custom';
					$custom_class = isset( $template['custom_class'] ) ? $template['custom_class'] : '';
					$unique_id = isset( $template['unique_id'] ) ? $template['unique_id'] : false; // You must provide unique_id otherwise it will be wrong in rendering
					// see hook filters in Vc_Templates_Panel_Editor::__construct
					$category['output'] .= '<li class="vc_col-sm-2 vc_template vc_templates-template-type-' . esc_attr( $type ) . ' ' . esc_attr( $custom_class ) . '"
									    data-category="' . esc_attr( $category['category'] ) . '"
									    data-template_unique_id="' . esc_attr( $unique_id ) . '"
									    data-template_type="' . esc_attr( $type ) . '">' . apply_filters( 'vc_templates_render_template', $name, $template ) . '</li>';
				}
			}
			$category['output'] .= '</ul></div>';
		}

		return $category;
	}
	/** Output rendered template in new panel dialog
	 * @since 4.4
	 *
	 * @param $template_name
	 * @param $template_data
	 *
	 * @return string
	 */
	function renderTemplateWindow( $template_name, $template_data ) {
		if ( $template_data['type'] == 'my_templates' ) {
			return $this->renderTemplateWindowMyTemplates( $template_name, $template_data );
		} else if ( $template_data['type'] == 'default_templates' ) {
			return $this->renderTemplateWindowDefaultTemplates( $template_name, $template_data );
		}

		return $template_name;

	}

	/**
	 * @since 4.4
	 *
	 * @param $template_name
	 * @param $template_data
	 *
	 * @return string
	 */
	public function renderTemplateWindowMyTemplates( $template_name, $template_data ) {
		ob_start();
		?>
		<div class="vc_template-wrapper vc_input-group" data-template_id="<?php echo esc_attr( $template_data['unique_id'] ); ?>">
			<a data-template-handler="true" class="vc_template-display-title vc_form-control" href="javascript:;"><?php echo esc_html( $template_name ); ?></a>
			<span class="vc_input-group-btn vc_template-icon vc_template-delete-icon" title="<?php esc_attr_e( 'Delete template', 'js_composer' ); ?>"
		      data-template_id="<?php echo esc_attr( $template_data['unique_id'] ); ?>"><i
				class="vc_icon"></i></span>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * @since 4.4
	 *
	 * @param $template_name
	 * @param $template_data
	 *
	 * @return string
	 */
	public function renderTemplateWindowDefaultTemplates( $template_name, $template_data ) {
		ob_start();
		?>
		<div class="vc_template-wrapper" data-template_id="<?php echo esc_attr( $template_data['unique_id'] ); ?>">
			<a data-template-handler="true" class="vc_template-display-content vc_form-control" href="javascript:;"><div
					class="vc_templates-image" <?php if ( isset( $template_data['image'] ) && strlen( trim( $template_data['image'] ) ) > 0 ): ?> style="background-image:url('<?php echo esc_attr( trim( $template_data['image'] ) ); ?>');"<?php endif; ?>>
				</div><span><?php echo esc_html( $template_name ); ?></span></a>
		</div>
		<?php

		return ob_get_clean();
	}

	/**
	 * @since 4.4
	 * vc_filter: vc_templates_render_frontend_template - called when unknown template received to render in frontend.
	 */
	function renderFrontendTemplate() {
		add_filter( 'vc_frontend_template_the_content', array( &$this, 'frontendDoTemplatesShortcodes' ) );
		$template_id = vc_post_param( 'template_unique_id' );
		$template_type = vc_post_param( 'template_type' );
		if ( $template_id == "" ) {
			die( 'Error: Vc_Templates_Panel_Editor::renderFrontendTemplate:1' );
		}
		if ( $template_type == 'my_templates' ) {
			$saved_templates = get_option( $this->option_name );
			vc_frontend_editor()->setTemplateContent( $saved_templates[ $template_id ]['template'] );
			vc_frontend_editor()->enqueueRequired();
			vc_include_template( 'editors/frontend_template.tpl.php', array(
				'editor' => vc_frontend_editor()
			) );
			die();
		} else if ( $template_type == 'default_templates' ) {
			$this->renderFrontendDefaultTemplate();
		} else {
			echo apply_filters( 'vc_templates_render_frontend_template', $template_id, $template_type );
			die();
		}
	}

	/**
	 * Load frontend default template content by index
	 * @since 4.4
	 */
	public function renderFrontendDefaultTemplate() {
		$template_index = (int) vc_post_param( 'template_unique_id' );
		$data = $this->getDefaultTemplate( $template_index );
		if ( ! $data ) {
			die( 'Error: Vc_Templates_Panel_Editor::renderFrontendDefaultTemplate:1' );
		}
		vc_frontend_editor()->setTemplateContent( trim( $data['content'] ) );
		vc_frontend_editor()->enqueueRequired();
		vc_include_template( 'editors/frontend_template.tpl.php', array(
			'editor' => vc_frontend_editor()
		) );
		die();
	}

	/**
	 * @since 4.4
	 * vc_filter: vc_templates_render_template - hook to override singe template rendering in panel window
	 */
	public function render() {
		vc_include_template( 'editors/popups/panel_templates.tpl.php', array(
			'box' => $this
		) );
	}

	/**
	 * @since 4.4
	 */
	public function save() {
		$template_name = vc_post_param( 'template_name' );
		$template = vc_post_param( 'template' );
		if ( ! isset( $template_name ) || trim( $template_name ) == "" || ! isset( $template ) || trim( $template ) == "" ) {
			die( 'Error: Vc_Templates_Panel_Editor::save:1' );
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
		echo $this->renderTemplateWindow( $template_arr['name'], array(
			'type' => 'my_templates',
			'unique_id' => $template_id,
		) );

		die();
	}

	/**
	 * Loading Any templates Shortcodes for backend by string $template_id from AJAX
	 * @since 4.4
	 * vc_filter: vc_templates_render_backend_template - called when unknown template requested to render in backend
	 */
	public function renderBackendTemplate() {
		$template_id = vc_post_param( 'template_unique_id' );
		$template_type = vc_post_param( 'template_type' );

		if ( ! isset( $template_id, $template_type ) || $template_id == "" || $template_type == "" ) {
			die( 'Error: Vc_Templates_Panel_Editor::renderBackendTemplate:1' );
		}
		if ( $template_type === 'my_templates' ) {
			$saved_templates = get_option( $this->option_name );

			$content = trim( $saved_templates[ $template_id ]['template'] );
			$content = str_replace( '\"', '"', $content );
			$pattern = get_shortcode_regex();
			$content = preg_replace_callback( "/{$pattern}/s", 'vc_convert_shortcode', $content );
			echo $content;
			die();
		} else if ( $template_type === 'default_templates' ) {
			$this->getBackendDefaultTemplate();
			die();
		} else {
			echo apply_filters( 'vc_templates_render_backend_template', $template_id, $template_type );
			die();
		}
	}

	/**
	 * @since 4.4
	 */
	public function delete() {
		$template_id = vc_post_param( 'template_id' );

		if ( ! isset( $template_id ) || $template_id == "" ) {
			die( 'Error: Vc_Templates_Panel_Editor::delete:1' );
		}

		$saved_templates = get_option( $this->option_name );
		unset( $saved_templates[ $template_id ] );
		if ( count( $saved_templates ) > 0 ) {
			update_option( $this->option_name, $saved_templates );
		} else {
			delete_option( $this->option_name );
		}
		die();
	}

	/**
	 * @since 4.4
	 *
	 * @param $templates
	 *
	 * vc_filter: vc_load_default_templates_limit_total - total items to show
	 * @return array
	 */
	public function loadDefaultTemplatesLimit( $templates ) {
		$start_index = 0;
		$total_templates_to_show = apply_filters( 'vc_load_default_templates_limit_total', 6 );

		return array_slice( $templates, $start_index, $total_templates_to_show );
	}

	/**
	 * Function to get all templates for display
	 *  - with image (optional preview image)
	 *  - with unique_id (required for do something for rendering.. )
	 *  - with name (required for display? )
	 *  - with type (required for requesting data in server)
	 *  - with category key (optional/required for filtering), if no category provided it will be displayed only in "All" category type
	 * vc_filter: vc_get_user_templates - hook to override "user My Templates"
	 * vc_filter: vc_get_all_templates - hook for override return array(all templates), hook to add/modify/remove more templates,
	 *  - this depends only to displaying in panel window (more layouts)
	 * @since 4.4
	 * @return array - all templates with name/unique_id/category_key(optional)/image
	 */
	public function getAllTemplates() {
		$data = array();
		// Here we go..
		if ( apply_filters('vc_show_user_templates',true) ) {
			// We need to get all "My Templates"
			$user_templates = apply_filters( 'vc_get_user_templates', get_option( $this->option_name ) );
			// this has only 'name' and 'template' key  and index 'key' is template id.
			$arr_category = array(
				'category' => 'my_templates',
				'category_name' => __( 'My Templates', 'js_composer' ),
				'category_description' => __( 'Append previously saved template to the current layout', 'js_composer' ),
				'category_weight' => 10,
			);
			$category_templates = array();
			if ( ! empty( $user_templates ) ) {
				foreach ( $user_templates as $template_id => $template_data ) {
					$category_templates[] = array(
						'unique_id' => $template_id,
						'name' => $template_data['name'],
						'type' => 'my_templates', // for rendering in backend/frontend with ajax
					);
				}
			}
			$arr_category['templates'] = $category_templates;
			$data[] = $arr_category;
		}

		// To get all "Default Templates"
		$default_templates = $this->getDefaultTemplates();
		// this has 'name', 'image_path', 'custom_class', and 'content' as template data
		if ( ! empty( $default_templates ) ) {
			$arr_category = array(
				'category' => 'default_templates',
				'category_name' => __( 'Default Templates', 'js_composer' ),
				'category_description' => __( 'Append default template to the current layout', 'js_composer' ),
				'category_weight' => 11,
			);
			$category_templates = array();
			foreach ( $default_templates as $template_id => $template_data ) {
				$category_templates[] = array(
					'unique_id' => $template_id,
					'name' => $template_data['name'],
					'type' => 'default_templates',
					// for rendering in backend/frontend with ajax
					'image' => isset( $template_data['image_path'] ) ? $template_data['image_path'] : false,
					// preview image
					'custom_class' => isset( $template_data['custom_class'] ) ? $template_data['custom_class'] : false,
				);
			}
			$arr_category['templates'] = $category_templates;
			$data[] = $arr_category;
		}

		// To get any other 3rd "Custom template" - do this by hook filter 'vc_get_all_templates'
		return apply_filters( 'vc_get_all_templates', $data );
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
	 * vc_filter: vc_load_default_templates - filter to override default templates array
	 * @since 4.4
	 * @return array
	 */
	public function loadDefaultTemplates() {
		if ( ! $this->initialized ) {
			$this->init(); // add hooks if not added already (fix for in frontend)
		}

		if ( ! is_array( $this->default_templates ) ) {
			require_once vc_path_dir( 'CONFIG_DIR', 'templates.php' );
			do_action( 'vc_load_default_templates_action' );
			$templates = apply_filters( 'vc_load_default_templates', $this->default_templates );
			$this->default_templates = $templates;
		}

		return $this->default_templates;
	}

	/**
	 * Alias for loadDefaultTemplates
	 * @since 4.4
	 * @return array - list of default templates
	 */
	public function getDefaultTemplates() {
		return $this->loadDefaultTemplates();
	}

	/**
	 * Get default template data by template index in array.
	 * @since 4.4
	 *
	 * @param number $template_index
	 *
	 * @return array|bool
	 */
	public function getDefaultTemplate( $template_index ) {
		$this->loadDefaultTemplates();
		if ( ! is_numeric( $template_index ) || ! is_array( $this->default_templates ) || ! isset( $this->default_templates[ $template_index ] ) ) {
			return false;
		}

		return $this->default_templates[ $template_index ];
	}

	/**
	 * Add custom template to default templates list ( at end of list )
	 * $data = array( 'name'=>'', 'image'=>'', 'content'=>'' )
	 * @since 4.4
	 *
	 * @param $data
	 *
	 * @return boolean true if added, false if failed
	 */
	public function addDefaultTemplates( $data ) {
		if ( is_array( $data ) && ! empty( $data ) && isset( $data['name'], $data['content'] ) ) {
			if ( ! is_array( $this->default_templates ) ) {
				$this->default_templates = array();
			}

			$this->default_templates[] = $data;

			return true;
		}

		return false;
	}

	/**
	 * Load default template content by index from ajax
	 * @since 4.4
	 *
	 * @param bool $return | should function return data or not
	 *
	 * @return string
	 */
	public function getBackendDefaultTemplate( $return = false ) {
		$template_index = (int) vc_post_param( 'template_unique_id' );
		$data = $this->getDefaultTemplate( $template_index );
		if ( ! $data ) {
			die( 'Error: Vc_Templates_Panel_Editor::getBackendDefaultTemplate:1' );
		}
		if ( $return ) {
			return trim( $data['content'] );
		} else {
			echo trim( $data['content'] );
			die();
		}
	}

	/**
	 * @since 4.4
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function sortTemplatesByCategories( array $data ) {
		$buffer = $data;
		usort( $buffer, array( &$this, 'cmpCategory' ) );

		return $buffer;
	}

	/**
	 * @since 4.4
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function sortTemplatesByNameWeight( array $data ) {
		$buffer = $data;
		usort( $buffer, array( &$this, 'cmpNameWeight' ) );

		return $buffer;
	}

	/**
	 * Function should return array of templates categories
	 * @since 4.4
	 *
	 * @param array $categories
	 *
	 * @return array - associative array of category key => and visible Name
	 */
	public function getAllCategoriesNames( array $categories ) {
		$categories_names = array();

		foreach ( $categories as $category ) {
			if ( isset( $category['category'] ) ) {
				$categories_names[ $category['category'] ] = isset( $category['category_name'] ) ? $category['category_name'] : $category['category'];
			}
		}

		return $categories_names;
	}

	/**
	 * @since 4.4
	 * @return array
	 */
	public function getAllTemplatesSorted() {
		$data = $this->getAllTemplates();
		// firstly we need to sort by categories
		$data = $this->sortTemplatesByCategories( $data );
		// secondly we need to sort templates by their weight or name
		foreach ( $data as $key => $category ) {
			$data[ $key ]['templates'] = $this->sortTemplatesByNameWeight( $category['templates'] );
		}

		return $data;
	}

	/**
	 * Used to compare two templates by category, category_weight
	 * If category weight is less template will appear in first positions
	 * @since 4.4
	 *
	 * @param array $a - template one
	 * @param array $b - second template to compare
	 *
	 * @return int
	 */
	protected function cmpCategory( $a, $b ) {
		$a_k = isset( $a['category'] ) ? $a['category'] : '*';
		$b_k = isset( $b['category'] ) ? $b['category'] : '*';
		$a_category_weight = isset( $a['category_weight'] ) ? $a['category_weight'] : 0;
		$b_category_weight = isset( $b['category_weight'] ) ? $b['category_weight'] : 0;

		return $a_category_weight == $b_category_weight ? strcmp( $a_k, $b_k ) : $a_category_weight - $b_category_weight;
	}

	/**
	 * @since 4.4
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	protected function cmpNameWeight( $a, $b ) {
		$a_k = isset( $a['name'] ) ? $a['name'] : '*';
		$b_k = isset( $b['name'] ) ? $b['name'] : '*';
		$a_weight = isset( $a['weight'] ) ? $a['weight'] : 0;
		$b_weight = isset( $b['weight'] ) ? $b['weight'] : 0;

		return $a_weight == $b_weight ? strcmp( $a_k, $b_k ) : $a_weight - $b_weight;
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
