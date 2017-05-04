<?php
/**
 * WPBakery Visual Composer Shortcodes main
 *
 * @package WPBakeryVisualComposer
 *
 */

/* abstract VisualComposer class to create structural object of any type */
if ( ! class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
	/**
	 * Class WPBakeryVisualComposerAbstract
	 */
	abstract class WPBakeryVisualComposerAbstract {
		/**
		 * @var
		 */
		public static $config;
		/**
		 * @var bool
		 */
		protected $is_plugin = true;
		/**
		 * @var bool
		 */
		protected $is_theme = false;
		/**
		 * @var bool
		 */
		protected $disable_updater = false;
		/**
		 * @var bool
		 */
		protected $settings_as_theme = false;
		/**
		 * @var bool
		 */
		protected $as_network_plugin = false;
		/**
		 * @var bool
		 */
		protected $is_init = false;
		/**
		 * @var string
		 */
		protected $controls_css_settings = 'cc';
		/**
		 * @var array
		 */
		protected $controls_list = array( 'edit', 'clone', 'delete' );

		/**
		 * @var string
		 */
		protected $shortcode_content = '';

		/**
		 *
		 */
		public function __construct() {
		}

		/**
		 * @param $settings
		 */
		public function init( $settings ) {
			self::$config = (array) $settings;
		}

		/**
		 * @param $action
		 * @param $method
		 * @param int $priority
		 */
		public function addAction( $action, $method, $priority = 10 ) {
			add_action( $action, array( &$this, $method ), $priority );
		}

		/**
		 * @param $action
		 * @param $method
		 * @param int $priority
		 *
		 * @return bool
		 */
		public function removeAction( $action, $method, $priority = 10 ) {
			return remove_action( $action, array( $this, $method ), $priority );
		}

		/**
		 * @param $filter
		 * @param $method
		 * @param int $priority
		 *
		 * @return bool|void
		 */
		public function addFilter( $filter, $method, $priority = 10 ) {
			return add_filter( $filter, array( &$this, $method ), $priority );
		}

		/**
		 * @param $filter
		 * @param $method
		 * @param int $priority
		 */
		public function removeFilter( $filter, $method, $priority = 10 ) {
			remove_filter( $filter, array( &$this, $method ), $priority );
		}

		/* Shortcode methods */
		/**
		 * @param $tag
		 * @param $func
		 */
		public function addShortCode( $tag, $func ) {
			add_shortcode( $tag, $func );
		}

		/**
		 * @param $content
		 */
		public function doShortCode( $content ) {
			do_shortcode( $content );
		}

		/**
		 * @param $tag
		 */
		public function removeShortCode( $tag ) {
			remove_shortcode( $tag );
		}

		/**
		 * @param $param
		 *
		 * @return null
		 */
		public function post( $param ) {
			return isset( $_POST[ $param ] ) ? $_POST[ $param ] : null;
		}

		/**
		 * @param $param
		 *
		 * @return null
		 */
		public function get( $param ) {
			return isset( $_GET[ $param ] ) ? $_GET[ $param ] : null;
		}

		/**
		 * @deprecated
		 *
		 * @param $asset
		 *
		 * @return string
		 */
		public function assetURL( $asset ) {
			return vc_asset_url( $asset );
		}

		/**
		 * @param $asset
		 *
		 * @return string
		 */
		public function assetPath( $asset ) {
			return self::$config['APP_ROOT'] . self::$config['ASSETS_DIR'] . $asset;
		}

		/**
		 * @param $name
		 *
		 * @return null
		 */
		public static function config( $name ) {
			return isset( self::$config[ $name ] ) ? self::$config[ $name ] : null;
		}
	}
}

/**
 *
 */
define( 'VC_SHORTCODE_CUSTOMIZE_PREFIX', 'vc_theme_' );
/**
 *
 */
define( 'VC_SHORTCODE_BEFORE_CUSTOMIZE_PREFIX', 'vc_theme_before_' );
/**
 *
 */
define( 'VC_SHORTCODE_AFTER_CUSTOMIZE_PREFIX', 'vc_theme_after_' );
/**
 *
 */
define( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG', 'vc_shortcodes_css_class' );
if ( ! class_exists( 'WPBakeryShortCode' ) ) {
	/**
	 * Class WPBakeryShortCode
	 */
	abstract class WPBakeryShortCode extends WPBakeryVisualComposerAbstract {

		/**
		 * @var
		 */
		protected $shortcode;
		/**
		 * @var
		 */
		protected $html_template;

		/**
		 * @var
		 */
		/**
		 * @var
		 */
		protected $atts, $settings;
		/**
		 * @var int
		 */
		protected static $enqueue_index = 0;
		/**
		 * @var array
		 */
		protected static $js_scripts = array();
		/**
		 * @var array
		 */
		protected static $css_scripts = array();
		/**
		 * @var string
		 */
		protected $shortcode_string = '';
		/**
		 * @var string
		 */
		protected $controls_template_file = 'editors/partials/backend_controls.tpl.php';

		/**
		 * @param $settings
		 */
		public function __construct( $settings ) {
			$this->settings  = $settings;
			$this->shortcode = $this->settings['base'];

			$this->addAction( 'admin_init', 'enqueueAssets' );
			$this->addAction( 'admin_head', 'printIconStyles' );
			// if($this->isAdmin() || !shortcode_exists($this->shortcode)) $this->addShortCode($this->shortcode, Array($this, 'output'));
		}

		/**
		 * @param $content
		 *
		 * @return string
		 */
		public function addInlineAnchors( $content ) {
			return ( $this->isInline() || $this->isEditor() && $this->settings( 'is_container' ) === true ? '<span class="vc_container-anchor"></span>' : '' ) . $content;
		}

		/**
		 *
		 */
		public function enqueueAssets() {
			if ( ! empty( $this->settings['admin_enqueue_js'] ) ) {
				$this->registerJs( $this->settings['admin_enqueue_js'] );
			}
			if ( ! empty( $this->settings['admin_enqueue_css'] ) ) {
				$this->registerCss( $this->settings['admin_enqueue_css'] );
			}
		}

		/**
		 * Prints out the styles needed to render the element icon for the back end interface.
		 * Only performed if the 'icon' setting is a valid URL.
		 *
		 * @return void
		 * @since  4.2
		 * @modified 4.4
		 * @author Benjamin Intal
		 */
		public function printIconStyles() {
			if ( ! filter_var( $this->settings( 'icon' ), FILTER_VALIDATE_URL ) ) {
				return;
			}
			echo "
            <style>
                .vc_el-container #" . esc_attr( $this->settings['base'] ) . " .vc_element-icon,
                .wpb_" . esc_attr( $this->settings['base'] ) . " .wpb_element_title .vc_element-icon,
                .vc_el-container > #" . esc_attr( $this->settings['base'] ) . " > .vc_element-icon,
                .vc_el-container > #" . esc_attr( $this->settings['base'] ) . " > .vc_element-icon[data-is-container=\"true\"],
                .compose_mode .vc_helper.vc_helper-" . esc_attr( $this->settings['base'] ) . " > .vc_element-icon,
                .vc_helper.vc_helper-" . esc_attr( $this->settings['base'] ) . " > .vc_element-icon,
                .compose_mode .vc_helper.vc_helper-" . esc_attr( $this->settings['base'] ) . " > .vc_element-icon[data-is-container=\"true\"],
                .vc_helper.vc_helper-" . esc_attr( $this->settings['base'] ) . " > .vc_element-icon[data-is-container=\"true\"],
                .wpb_" . esc_attr( $this->settings['base'] ) . " > .wpb_element_wrapper > .wpb_element_title > .vc_element-icon,
                .wpb_" . esc_attr( $this->settings['base'] ) . " > .wpb_element_wrapper > .wpb_element_title > .vc_element-icon[data-is-container=\"true\"] {
                    background-position: 0 0;
                    background-image: url(" . esc_url( $this->settings['icon'] ) . ");
                    -webkit-background-size: contain;
                    -moz-background-size: contain;
                    -ms-background-size: contain;
                    -o-background-size: contain;
                    background-size: contain;
                }
            </style>";
		}

		/**
		 * @param $param
		 */
		protected function registerJs( $param ) {
			if ( is_array( $param ) ) {
				foreach ( $param as $value ) {
					$this->registerJs( $value );
				}
			} elseif ( is_string( $param ) && ! empty( $param ) ) {
				$name               = $this->shortcode . '_enqueue_js_' . self::$enqueue_index ++;
				self::$js_scripts[] = $name;
				wp_register_script( $name, $param, array( 'jquery' ), time(), true );
			}
		}

		/**
		 * @param $param
		 */
		protected function registerCss( $param ) {
			if ( is_array( $param ) ) {
				foreach ( $param as $value ) {
					$this->registerCss( $value );
				}
			} elseif ( is_string( $param ) ) {
				$name                = $this->shortcode . '_enqueue_css_' . self::$enqueue_index ++;
				self::$css_scripts[] = $name;
				wp_register_style( $name, $param, array( 'js_composer' ), time() );
			}
		}

		/**
		 *
		 */
		public static function enqueueCss() {
			foreach ( self::$css_scripts as $stylesheet ) {
				wp_enqueue_style( $stylesheet );
			}
		}

		/**
		 *
		 */
		public static function enqueueJs() {
			foreach ( self::$js_scripts as $script ) {
				wp_enqueue_script( $script );
			}
		}

		/**
		 * @param $shortcode
		 */
		public function shortcode( $shortcode ) {

		}

		/**
		 * @param $template
		 */
		protected function setTemplate( $template ) {
			return $this->html_template = apply_filters('vc_shortcode_set_template_'.$this->shortcode, $template );
		}

		/**
		 * @return bool
		 */
		protected function getTemplate() {
			if ( isset( $this->html_template ) ) {
				return $this->html_template;
			}

			return false;
		}

		/**
		 * @return mixed
		 */
		protected function getFileName() {
			return $this->shortcode;
		}

		/**
		 * Find html template for shortcode output.
		 */
		protected function findShortcodeTemplate() {
			// Check template path in shortcode's mapping settings
			if ( ! empty( $this->settings['html_template'] ) && is_file( $this->settings( 'html_template' ) ) ) {
				return $this->setTemplate( $this->settings['html_template'] );
			}

			// Check template in theme directory
			$user_template = vc_shortcodes_theme_templates_dir( $this->getFilename() . '.php' );
			if ( is_file( $user_template ) ) {
				return $this->setTemplate( $user_template );
			}

			// Check default place
			$default_dir = vc_manager()->getDefaultShortcodesTemplatesDir() . '/';
			if ( is_file( $default_dir . $this->getFilename() . '.php' ) ) {
				return $this->setTemplate( $default_dir . $this->getFilename() . '.php' );
			}

			return '';
		}

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return mixed|void
		 */
		protected function content( $atts, $content = null ) {
			return $this->loadTemplate( $atts, $content );
		}

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * vc_filter: vc_shortcode_content_filter - hook to edit template content
		 * vc_filter: vc_shortcode_content_filter_after - hook after template is loaded to override output
		 * @return mixed|void
		 */
		protected function loadTemplate( $atts, $content = null ) {
			$output = '';
			if ( ! is_null( $content ) ) {
				$content = apply_filters( 'vc_shortcode_content_filter', $content, $this->shortcode );
			}
			$this->findShortcodeTemplate();
			if ( $this->html_template ) {
				ob_start();
				include( $this->html_template );
				$output = ob_get_contents();
				ob_end_clean();
			} else {
				trigger_error( sprintf( __( 'Template file is missing for `%s` shortcode. Make sure you have `%s` file in your theme folder.', 'js_composer' ), $this->shortcode, 'wp-content/themes/your_theme/vc_templates/' . $this->shortcode . '.php' ) );
			}

			return apply_filters( 'vc_shortcode_content_filter_after', $output, $this->shortcode );
		}

		/**
		 * @param $atts
		 * @param $content
		 *
		 * @return string
		 */
		public function contentAdmin( $atts, $content ) {
			$element = $this->shortcode;
			$output  = $custom_markup = $width = $el_position = '';

			if ( $content != null ) {
				$content = wpautop( stripslashes( $content ) );
			}
			$shortcode_attributes = array( 'width' => '1/1' );
			foreach ( $this->settings['params'] as $param ) {
				if ( $param['param_name'] != 'content' ) {
					if ( isset( $param['value'] ) ) {
						$shortcode_attributes[ $param['param_name'] ] = is_string( $param['value'] ) ? __( $param['value'], "js_composer" ) : $param['value'];
					} else {
						$shortcode_attributes[ $param['param_name'] ] = '';
					}
				} else if ( $param['param_name'] == 'content' && $content == null ) {
					$content = isset( $param['value'] ) ? __( $param['value'], "js_composer" ) : '';
				}
			}
			$atts = shortcode_atts(
				$shortcode_attributes
				, $atts );
			extract( $atts );
			$this->atts = $atts;
			$elem = $this->getElementHolder( $width );
			if ( isset( $this->settings["custom_markup"] ) && $this->settings["custom_markup"] != '' ) {
				$inner = '';
				if ( $content != '' ) {
					$custom_markup = str_ireplace( "%content%", $content, $this->settings["custom_markup"] );
				} else if ( $content == '' && isset( $this->settings["default_content_in_template"] ) && $this->settings["default_content_in_template"] != '' ) {
					$custom_markup = str_ireplace( "%content%", $this->settings["default_content_in_template"], $this->settings["custom_markup"] );
				}
				//$output .= do_shortcode($this->settings["custom_markup"]);
				$inner .= do_shortcode( $custom_markup );
				$elem = str_ireplace( '%wpb_element_content%', $inner, $elem );
				$output .= $elem;
			} else {
				$iner = $this->outputTitle( $this->settings['name'] );
				foreach ( $this->settings['params'] as $param ) {
					$param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
					if ( is_array( $param_value ) ) {
						// Get first element from the array
						reset( $param_value );
						$first_key = key( $param_value );
						$param_value = is_null( $first_key ) ? '' : $param_value[ $first_key ];
					}
					$iner .= $this->singleParamHtmlHolder( $param, $param_value );
				}
				$elem = str_ireplace( '%wpb_element_content%', $iner, $elem );
				$output .= $elem;
			}
			return $output;
		}

		/**
		 * @return bool
		 */
		public function isAdmin() {
			return is_admin() && ! empty( $_POST['action'] ) && preg_match( '/^wpb\_/', $_POST['action'] );
		}

		/**
		 * @return bool
		 */
		public function isInline() {
			return vc_is_inline();
		}

		/**
		 * @return bool
		 */
		public function isEditor() {
			return vc_is_editor();
		}

		/**
		 * @param $atts
		 * @param null $content
		 * @param string $base
		 *
		 * vc_filter: vc_shortcode_output - hook to override output of shortcode
		 * @return string
		 */
		public function output( $atts, $content = null, $base = '' ) {
			$this->atts              = $this->prepareAtts( $atts );
			$this->shortcode_content = $content;
			$output                  = '';
			$content                 = empty( $content ) && ! empty( $atts['content'] ) ? $atts['content'] : $content;
			if ( ( $this->isInline() || vc_is_page_editable() ) && method_exists( $this, 'contentInline' ) ) {
				$output .= $this->contentInline( $this->atts, $content );
			} elseif ( $this->isAdmin() ) {
				$output .= $this->contentAdmin( $this->atts, $content );
			}
			if ( empty( $output ) ) {
				$custom_output        = VC_SHORTCODE_CUSTOMIZE_PREFIX . $this->shortcode;
				$custom_output_before = VC_SHORTCODE_BEFORE_CUSTOMIZE_PREFIX . $this->shortcode; // before shortcode function hook
				$custom_output_after  = VC_SHORTCODE_AFTER_CUSTOMIZE_PREFIX . $this->shortcode; // after shortcode function hook

				// Before shortcode
				if ( function_exists( $custom_output_before ) ) {
					$output .= $custom_output_before( $this->atts, $content );
				} else {
					$output .= $this->beforeShortcode( $this->atts, $content );
				}
				// Shortcode content
				if ( function_exists( $custom_output ) ) {
					$output .= $custom_output( $this->atts, $content );
				} else {
					$output .= $this->content( $this->atts, $content );
				}
				// After shortcode
				if ( function_exists( $custom_output_after ) ) {
					$output .= $custom_output_after( $this->atts, $content );
				} else {
					$output .= $this->afterShortcode( $this->atts, $content );
				}
			}
			// Filter for overriding outputs
			$output = apply_filters( 'vc_shortcode_output', $output, $this, $this->atts );

			return $output;
		}

		/**
		 * Return shortcode attributes, see \WPBakeryShortCode::output
		 * @since 4.4
		 * @return array
		 */
		public function getAtts() {
			return $this->atts;
		}

		/**
		 * Creates html before shortcode html.
		 *
		 * @param $atts - shortcode attributes list
		 * @param $content - shortcode content
		 *
		 * @return string - html which will be displayed before shortcode html.
		 */
		public function beforeShortcode( $atts, $content ) {
			return '';
		}

		/**
		 * Creates html before shortcode html.
		 *
		 * @param $atts - shortcode attributes list
		 * @param $content - shortcode content
		 *
		 * @return string - html which will be displayed after shortcode html.
		 */
		public function afterShortcode( $atts, $content ) {
			return '';
		}

		/**
		 * @param $el_class
		 *
		 * @return string
		 */
		public function getExtraClass( $el_class ) {
			$output = '';
			if ( $el_class != '' ) {
				$output = " " . str_replace( ".", "", $el_class );
			}

			return $output;
		}

		/**
		 * @param $css_animation
		 *
		 * @return string
		 */
		public function getCSSAnimation( $css_animation ) {
			$output = '';
			if ( $css_animation != '' ) {
				wp_enqueue_script( 'waypoints' );
				$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
			}

			return $output;
		}

		/**
		 * Create HTML comment for blocks only if wpb_debug=true
		 *
		 * @param $string
		 *
		 * @return string
		 */
		public function endBlockComment( $string ) {
			//return '';
			return wpb_debug() ? '<!-- END ' . $string . ' -->' : '';
		}

		/**
		 * Start row comment for html shortcode block
		 *
		 * @param $position - block position
		 *
		 * @return string
		 */
		public function startRow( $position ) {
			$output = '';

			return '';
		}

		/**
		 * End row comment for html shortcode block
		 *
		 * @param $position -block position
		 *
		 * @return string
		 */

		public function endRow( $position ) {
			$output = '';

			return '';
		}

		/**
		 * @param $name
		 *
		 * @return null
		 */
		public function settings( $name ) {
			return isset( $this->settings[ $name ] ) ? $this->settings[ $name ] : null;
		}

		/**
		 * @param $name
		 * @param $value
		 */
		public function setSettings( $name, $value ) {
			$this->settings[ $name ] = $value;
		}

		/**
		 * @param $width
		 *
		 * @return string
		 */
		public function getElementHolder( $width ) {
			$output = '';
			$column_controls = $this->getColumnControlsModular();
			$css_class = 'wpb_' . $this->settings["base"] . ' wpb_content_element wpb_sortable' . ( ! empty( $this->settings["class"] ) ? ' ' . $this->settings["class"] : '' );
			$output .= '<div data-element_type="' . $this->settings["base"] . '" class="' . $css_class . '">';
			$output .= str_replace( "%column_size%", wpb_translateColumnWidthToFractional( $width ), $column_controls );
			$output .= $this->getCallbacks( $this->shortcode );
			$output .= '<div class="wpb_element_wrapper ' . $this->settings( "wrapper_class" ) . '">';
			$output .= '%wpb_element_content%';
			$output .= '</div>'; // <!-- end .wpb_element_wrapper -->';
			$output .= '</div>'; // <!-- end #element-'.$this->shortcode.' -->';
			return $output;
		}

		/* This returs block controls
---------------------------------------------------------- */
		/**
		 * @param $controls
		 * @param string $extended_css
		 *
		 * @return string
		 */
		public function getColumnControls( $controls, $extended_css = '' ) {
			$controls_start = '<div class="vc_controls controls controls_element' . ( ! empty( $extended_css ) ? " {$extended_css}" : '' ) . '">';

			$controls_end = '</div>';

			$controls_add = ''; //' <a class="column_add" href="#" title="'.sprintf(__('Add to %s', 'js_composer'), strtolower($this->settings('name'))).'"></a>';
			$controls_edit = ' <a class="vc_control column_edit" href="#" title="' . sprintf( __( 'Edit %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><span class="vc_icon"></span></a>';
			$controls_delete = ' <a class="vc_control column_clone" href="#" title="' . sprintf( __( 'Clone %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><span class="vc_icon"></span></a> <a class="column_delete" href="#" title="' . sprintf( __( 'Delete %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><span class="vc_icon"></span></a>';

			$column_controls_full              = $controls_start . $controls_add . $controls_edit . $controls_delete . $controls_end;
			$column_controls_size_delete       = $controls_start . $controls_delete . $controls_end;
			$column_controls_popup_delete      = $controls_start . $controls_delete . $controls_end;
			$column_controls_edit_popup_delete = $controls_start . $controls_edit . $controls_delete . $controls_end;

			if ( $controls == 'popup_delete' ) {
				return $column_controls_popup_delete;
			} else if ( $controls == 'edit_popup_delete' ) {
				return $column_controls_edit_popup_delete;
			} else if ( $controls == 'size_delete' ) {
				return $column_controls_size_delete;
			} else if ( $controls == 'add' ) {
				return $controls_start . $controls_add . $controls_end;
			} else {
				return $column_controls_full;
			}
		}

		/**
		 * Return list of controls
		 * @return array
		 */
		public function getControlsList() {
			return apply_filters('vc_wpbakery_shortcode_get_controls_list', $this->controls_list);
		}

		/**
		 * Build new modern controls for shortcode.
		 *
		 * @param string $extended_css
		 *
		 * @return string
		 * @internal param string $position - y,x position where to put controls inside block
		 *    Possible $position values
		 *    cc - center center position of the block
		 *    tl - top left
		 *    tr - top right
		 *    br - bottom right
		 */
		public function getColumnControlsModular( $extended_css = '' ) {
			ob_start();
			vc_include_template( apply_filters('vc_wpbakery_shortcode_get_column_controls_modular_template',
				$this->controls_template_file), array(
				'position' => $this->controls_css_settings,
				'extended_css' => $extended_css,
				'name' => $this->settings( 'name' ),
				'controls' => $this->getControlsList()
			) );

			return ob_get_clean();
		}

		/**
		 * This will fire callbacks if they are defined in map.php
		 *
		 * @param $id
		 *
		 * @return string
		 */
		public function getCallbacks( $id ) {
			$output = '';

			if ( isset( $this->settings['js_callback'] ) ) {
				foreach ( $this->settings['js_callback'] as $text_val => $val ) {
					/* TODO: name explain */
					$output .= '<input type="hidden" class="wpb_vc_callback wpb_vc_' . $text_val . '_callback " name="' . $text_val . '" value="' . $val . '" />';
				}
			}

			return $output;
		}

		/**
		 * @param $param
		 * @param $value
		 *
		 * vc_filter: vc_wpbakeryshortcode_single_param_html_holder_value - hook to override param value (param type and etc is available in args)
		 * @return string
		 */
		public function singleParamHtmlHolder( $param, $value ) {
			$value  = apply_filters( 'vc_wpbakeryshortcode_single_param_html_holder_value', $value, $param, $this->settings, $this->atts );
			$output = '';
			// Compatibility fixes
			$old_names = array(
				'yellow_message',
				'blue_message',
				'green_message',
				'button_green',
				'button_grey',
				'button_yellow',
				'button_blue',
				'button_red',
				'button_orange'
			);
			$new_names = array(
				'alert-block',
				'alert-info',
				'alert-success',
				'btn-success',
				'btn',
				'btn-info',
				'btn-primary',
				'btn-danger',
				'btn-warning'
			);
			$value = str_ireplace( $old_names, $new_names, $value );
			//$value = __($value, "js_composer");
			//
			$param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
			$type       = isset( $param['type'] ) ? $param['type'] : '';
			$class      = isset( $param['class'] ) ? $param['class'] : '';
			if ( ! empty( $param['holder'] ) ) {
				if ( $param['holder'] !== 'hidden' ) {
					$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">' . $value . '</' . $param['holder'] . '>';
				} elseif ( $param['holder'] == 'input' ) {
					$output .= '<' . $param['holder'] . ' readonly="true" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '">';
				} elseif ( in_array( $param['holder'], array( 'img', 'iframe' ) ) ) {
					$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" src="' . $value . '">';
				}
			}
			if ( ! empty( $param['admin_label'] ) && $param['admin_label'] === true ) {
				$output .= '<span class="vc_admin_label admin_label_' . $param['param_name'] . ( empty( $value ) ? ' hidden-label' : '' ) . '"><label>' . __( $param['heading'], 'js_composer' ) . '</label>: ' . $value . '</span>';
			}

			return $output;
		}
		/**
		 * @param $params
		 *
		 * @return string
		 */
		protected function getIcon( $params ) {
			$data = '';
			if ( isset( $params['is_container'] ) && $params['is_container'] === true ) {
				$data = ' data-is-container="true"';
			}
			$title = '';
			if ( isset( $params['title'] ) ) {
				$title = 'title="' . $params['title'] . '" ';
			}
			return '<i ' . $title . 'class="vc_element-icon' . ( ! empty( $params['icon'] ) ? ' ' . sanitize_text_field( $params['icon'] ) : '' ) . '"' . $data . '></i> ';
		}

		/**
		 * @param $title
		 *
		 * @return string
		 */
		protected function outputTitle( $title ) {
			$icon = $this->settings( 'icon' );
			if ( filter_var( $icon, FILTER_VALIDATE_URL ) ) {
				$icon = '';
			}
			$params = array(
				'icon' => $icon,
				'is_container' => $this->settings( 'is_container' ),
			);

			return '<h4 class="wpb_element_title"> ' . $this->getIcon( $params ) . esc_attr( $title ) . '</h4>';
		}

		/**
		 * @param string $content
		 *
		 * @return string
		 */
		public function template( $content = '' ) {
			return $this->contentAdmin( $this->atts, $content );
		}

		/**
		 * @param $atts
		 *
		 * @return array
		 */
		protected function prepareAtts( $atts ) {
			$return = array();
			if ( is_array( $atts ) ) {
				foreach ( $atts as $key => $val ) {
					$return[ $key ] = preg_replace( '/\`\`/', '"', $val );
				}
			}

			return $return;
		}
	}
}
if ( ! class_exists( 'WPBakeryShortCodesContainer' ) ) {
	/**
	 * Class WPBakeryShortCodesContainer
	 */
	abstract class WPBakeryShortCodesContainer extends WPBakeryShortCode {
		/**
		 * @var array
		 */
		protected $predefined_atts = array();

		/**
		 * @return string
		 */
		public function customAdminBlockParams() {
			return '';
		}

		/**
		 * @param $width
		 * @param $i
		 *
		 * @return string
		 */
		public function mainHtmlBlockParams( $width, $i ) {
			return 'data-element_type="' . $this->settings["base"] . '" class="wpb_' . $this->settings['base'] . ' wpb_sortable wpb_content_holder vc_shortcodes_container"' . $this->customAdminBlockParams();
		}

		/**
		 * @param $width
		 * @param $i
		 *
		 * @return string
		 */
		public function containerHtmlBlockParams( $width, $i ) {
			return 'class="wpb_column_container vc_container_for_children vc_clearfix"';
		}

		/**
		 * @param $controls
		 * @param string $extended_css
		 *
		 * @return string
		 */
		public function getColumnControls( $controls = full, $extended_css = '' ) {
			$controls_start = '<div class="vc_controls vc_controls-visible controls controls_column' . ( ! empty( $extended_css ) ? " {$extended_css}" : '' ) . '">';
			$controls_end   = '</div>';

			if ( $extended_css == 'bottom-controls' ) {
				$control_title = sprintf( __( 'Append to this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) );
			} else {
				$control_title = sprintf( __( 'Prepend to this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) );
			}

			$controls_move   = '<a class="vc_control column_move" data-vc-control="move" href="#" title="' . sprintf( __( 'Move this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><span class="vc_icon"></span></a>';
			$controls_add    = '<a class="vc_control column_add" data-vc-control="add" href="#" title="' . $control_title . '"><span class="vc_icon"></span></a>';
			$controls_edit   = '<a class="vc_control column_edit" data-vc-control="edit" href="#" title="' . sprintf( __( 'Edit this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><span class="vc_icon"></span></a>';
			$controls_clone  = '<a class="vc_control column_clone" data-vc-control="clone" href="#" title="' . sprintf( __( 'Clone this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><span class="vc_icon"></span></a>';
			$controls_delete = '<a class="vc_control column_delete" data-vc-control="delete" href="#" title="' . sprintf( __( 'Delete this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><span class="vc_icon"></span></a>';
			$controls_full = $controls_move . $controls_add . $controls_edit . $controls_clone . $controls_delete;
			if ( ! empty( $controls ) ) {
				if ( is_string( $controls ) ) {
					$controls = array( $controls );
				}
				$controls_string = $controls_start;
				foreach ( $controls as $control ) {
					$control_var = 'controls_' . $control;
					$controls_string .= $$control_var;
				}
				return $controls_string . $controls_end;
			}
			return $controls_start . $controls_full . $controls_end;
		}

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return string
		 */
		public function contentAdmin( $atts, $content = null ) {
			$width = $el_class = '';
			$atts  = shortcode_atts( $this->predefined_atts, $atts );
			extract( $atts );
			$this->atts = $atts;
			$output = '';

			$column_controls        = $this->getColumnControls( $this->settings( 'controls' ) );
			$column_controls_bottom = $this->getColumnControls( 'add', 'bottom-controls' );
			for ( $i = 0; $i < count( $width ); $i ++ ) {
				$output .= '<div ' . $this->mainHtmlBlockParams( $width, $i ) . '>';
				$output .= $column_controls;
				$output .= '<div class="wpb_element_wrapper">';
				$output .= $this->outputTitle( $this->settings['name'] );
				$output .= '<div ' . $this->containerHtmlBlockParams( $width, $i ) . '>';
				$output .= do_shortcode( shortcode_unautop( $content ) );
				$output .= '</div>';
				if ( isset( $this->settings['params'] ) ) {
					$inner = '';
					foreach ( $this->settings['params'] as $param ) {
						$param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
						if ( is_array( $param_value ) ) {
							// Get first element from the array
							reset( $param_value );
							$first_key   = key( $param_value );
							$param_value = $param_value[ $first_key ];
						}
						$inner .= $this->singleParamHtmlHolder( $param, $param_value );
					}
					$output .= $inner;
				}
				$output .= '</div>';
				$output .= $column_controls_bottom;
				$output .= '</div>';
			}

			return $output;
		}

		/**
		 * @param $title
		 *
		 * @return string
		 */
		protected function outputTitle( $title ) {
			$icon = $this->settings( 'icon' );
			if ( filter_var( $icon, FILTER_VALIDATE_URL ) ) {
				$icon = '';
			}
			$params = array(
				'icon' => $icon,
				'is_container' => $this->settings( 'is_container' ),
				'title' => $title,
			);

			return '<h4 class="wpb_element_title"> ' . $this->getIcon( $params ) . '</h4>';
		}
	}
}
if ( ! class_exists( 'WPBakeryShortCodeFishBones' ) ) {
	/**
	 * Class WPBakeryShortCodeFishBones
	 */
	class WPBakeryShortCodeFishBones extends WPBakeryShortCode {
		/**
		 * @var bool
		 */
		protected $shortcode_class = false;

		/**
		 * @param $settings
		 */
		public function __construct( $settings ) {
			$this->settings  = $settings;
			$this->shortcode = $this->settings['base'];
			$this->addAction( 'admin_init', 'enqueueAssets' );
			//die(print_r(array($this->isAdmin(),vc_mode()),true));
			if( vc_is_page_editable() ) {
				// fix for page editable
				$this->addAction( 'wp_head', 'printIconStyles' );
			}
			$this->addAction( 'admin_head', 'printIconStyles' ); // fe+be

			$this->addAction( 'admin_print_scripts-post.php', 'enqueueAssets' );
			$this->addAction( 'admin_print_scripts-post-new.php', 'enqueueAssets' );
			if ( $this->isAdmin() ) {
				$this->removeShortCode( $this->shortcode );
			}
			// if($this->isAdmin() || !shortcode_exists($this->shortcode)) $this->addShortCode($this->shortcode, Array($this, 'output'));
			if ( $this->isAdmin() || ! shortcode_exists( $this->shortcode ) ) {
				$this->addShortCode( $this->shortcode, Array( &$this, 'render' ) );
			}
		}

		/**
		 * @return bool|WPBakeryShortCodeFishBones
		 */
		public function shortcodeClass() {
			if ( $this->shortcode_class !== false ) {
				return $this->shortcode_class;
			}
			require_once vc_path_dir( 'SHORTCODES_DIR', 'wordpress-widgets.php' );
			$file_name = preg_replace( '/_/', '-', $this->settings( 'base' ) ) . '.php';
			if ( is_file( vc_path_dir( 'SHORTCODES_DIR', $file_name ) ) ) {
				require_once vc_path_dir( 'SHORTCODES_DIR', $file_name );
			}
			$class_name = $this->settings( 'php_class_name' ) ? $this->settings( 'php_class_name' ) : 'WPBakeryShortCode_' . $this->settings( 'base' );
			if ( class_exists( $class_name ) && is_subclass_of( $class_name, 'WPBakeryShortCode' ) ) {
				$this->shortcode_class = new $class_name( $this->settings );
			} else {
				$this->shortcode_class = $this;
			}

			return $this->shortcode_class;
		}

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return string
		 */
		public function render( $atts, $content = null ) {
			return $this->shortcodeClass()->output( $atts, $content );
		}

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return string
		 */
		protected function content( $atts, $content = null ) {
			return ''; // this method is not used
		}

		/**
		 * @param string $content
		 *
		 * @return string
		 */
		public function template( $content = '' ) {
			return $this->shortcodeClass()->contentAdmin( $this->atts, $content );
		}
	}
}