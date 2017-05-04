<?php
require_once vc_path_dir( 'EDITORS_DIR', 'popups/class-vc-templates-panel-editor.php' );
require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/class-vc-grid-item.php' );

class Vc_Templates_Editor_Grid_Item extends Vc_Templates_Panel_Editor {
	protected $vc_grid_item_param;

	protected $default_templates = array(); // this prevents for loading default templates

	public function __construct() {
		add_filter( 'vc_templates_render_category', array( &$this, 'renderTemplateBlock' ), 10, 2 );
		add_filter( 'vc_templates_render_template', array( &$this, 'renderTemplateWindowGrid' ), 10, 2 );
	}

	public function renderTemplateBlock( $category ) {
		if ( 'grid_templates' == $category['category'] ) {
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
			<ul class="vc_templates-list-grid_templates">';
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
		}

		return $category;
	}

	/** Output rendered template in modal dialog
	 * @since 4.4
	 *
	 * @param $template_name
	 * @param $template_data
	 *
	 * @return string
	 */
	public function renderTemplateWindowGrid( $template_name, $template_data ) {
		if ( $template_data['type'] == 'grid_templates' ) {
			return $this->renderTemplateWindowGridTemplate( $template_name, $template_data );
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
	protected function renderTemplateWindowGridTemplate( $template_name, $template_data ) {
		ob_start();
		?>
		<div class="vc_template-wrapper" data-template_id="<?php echo esc_attr( $template_data['unique_id'] ); ?>">
			<a data-template-handler="true" class="vc_template-display-title vc_form-control" href="javascript:;"><?php echo esc_html( $template_name ); ?></a></div>
		<?php
		return ob_get_clean();
	}

	public function load( $template_id = false ) {
		if ( ! $template_id ) {
			$template_id = vc_post_param( 'template_unique_id' );
		}
		if ( ! isset( $template_id ) || $template_id == "" ) {
			echo 'Error: TPL-02';
			die();
		}

		if ( false !== ( $predefined_template = Vc_Grid_Item::predefinedTemplate( $template_id ) ) ) {
			echo trim( $predefined_template['template'] );
		}
		die();
	}

	public function getAllTemplates() {
		$data = array();
		$grid_templates = $this->getGridTemplates();
		// this has only 'name' and 'template' key  and index 'key' is template id.
		if ( ! empty( $grid_templates ) ) {
			$arr_category = array(
				'category' => 'grid_templates',
				'category_name' => __('Grid Templates','js_composer'),
				'category_weight' => 10,
			);
			$category_templates = array();
			foreach ( $grid_templates as $template_id => $template_data ) {
				$category_templates[] = array(
					'unique_id' => $template_id,
					'name' => $template_data['name'],
					'type' => 'grid_templates', // for rendering in backend/frontend with ajax
				);
			}
			$arr_category['templates'] = $category_templates;
			$data[] = $arr_category;
		}

		// To get any other 3rd "Custom template" - do this by hook filter 'vc_get_all_templates'
		return apply_filters( 'vc_get_all_templates', $data );
	}

	public function getGridTemplates() {
		$list = Vc_Grid_Item::predefinedTemplates();

		return $list;
	}

}