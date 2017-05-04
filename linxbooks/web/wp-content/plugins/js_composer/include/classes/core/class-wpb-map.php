<?php
/**
 * WPBakery Visual Composer Main manager.
 *
 * @package WPBakeryVisualComposer
 * @since   4.2
 */

/**
 * Vc mapper new class.
 *
 * This class maps shortcodes settings to VC editors. You can manage add new shortcodes or manage default shortcodes
 * mapped in config/map.php. For developers it is possible to use API functions to add update settings attributes.
 *
 * @see config/map.php
 * @see include/helpers/helpers_api.php
 * @since 3.1
 *
 */
class WPBMap {

	/**
	 * @var array
	 */
	protected static $sc = Array();

	/**
	 * @var array
	 */
	protected static $categories = Array();

	/**
	 * @var bool
	 */
	protected static $user_sc = false;

	/**
	 * @var bool
	 */
	protected static $user_sorted_sc = false;

	/**
	 * @var bool
	 */
	protected static $user_categories = false;

	/**
	 * @var Vc_Settings $settings
	 */
	protected static $settings;

	/**
	 * @var
	 */
	protected static $user_role;

	/**
	 * @var
	 */
	protected static $tags_regexp;

	/**
	 * @var bool
	 */
	protected static $is_init = false;

	/**
	 * Set init status fro WPMap.
	 *
	 * if $is_init is FALSE, then all activity like add, update and delete for shortcodes attributes will be hold in
	 * the list of activity and will be executed after initialization.
	 *
	 * @see Vc_Mapper::iniy.
	 * @static
	 *
	 * @param bool $value
	 */
	public static function setInit( $value = true ) {
		self::$is_init = $value;
	}

	/**
	 * Gets user role and access rules for current user.
	 *
	 * @static
	 * @return mixed
	 */
	protected static function getSettings() {
		global $current_user;

		if ( self::$settings === null ) {
			if ( function_exists( 'get_currentuserinfo' ) ) {
				get_currentuserinfo();
				/** @var Vc_Settings $settings - get use group access rules */
				if ( ! empty( $current_user->roles ) ) {
					self::$user_role = $current_user->roles[0];
				} else {
					self::$user_role = 'author';
				}
			} else {
				self::$user_role = 'author';
			}
			self::$settings = vc_settings()->get( 'groups_access_rules' );
		}

		return self::$settings;
	}

	/**
	 * Check is shortcode with a tag mapped to VC.
	 *
	 * @static
	 *
	 * @param $tag - shortcode tag.
	 *
	 * @return bool
	 */
	public static function exists( $tag ) {
		return (boolean) isset( self::$sc[ $tag ] );
	}

	/**
	 * Map shortcode to VC.
	 *
	 * This method maps shortcode to VC.
	 * You need to shortcode's tag and  settings to map correctly.
	 * Default shortcodes are mapped in config/map.php file.
	 * The best way is to call this method with "init" action callback function of WP.
	 *
	 * vc_filter: vc_mapper_tag - to change shortcode tag, arguments 2 ( $tag, $attributes )
	 * vc_filter: vc_mapper_attributes - to change shortcode attributes (like params array), arguments 2 ( $attributes, $tag )
	 * vc_filter: vc_mapper_attribute - to change singe shortcode param data, arguments 2 ( $attribute, $tag )
	 * vc_filter: vc_mapper_attribute_{PARAM_TYPE} - to change singe shortcode param data by param type, arguments 2 ( $attribute, $tag )
	 *
	 * @static
	 *
	 * @param $tag
	 * @param $attributes
	 *
	 * @return bool
	 */
	public static function map( $tag, $attributes ) {
		if ( ! self::$is_init ) {
			if ( empty( $attributes['name'] ) ) {
				trigger_error( sprintf( __( "Wrong name for shortcode:%s. Name required", "js_composer" ), $tag ) );
			} elseif ( empty( $attributes['base'] ) ) {
				trigger_error( sprintf( __( "Wrong base for shortcode:%s. Base required", "js_composer" ), $tag ) );
			} else {
				vc_mapper()->addActivity(
					'mapper', 'map', array(
						'tag' => $tag,
						'attributes' => $attributes
					)
				);

				return true;
			}

			return false;
		}
		if ( empty( $attributes['name'] ) ) {
			trigger_error( sprintf( __( "Wrong name for shortcode:%s. Name required", "js_composer" ), $tag ) );
		} elseif ( empty( $attributes['base'] ) ) {
			trigger_error( sprintf( __( "Wrong base for shortcode:%s. Base required", "js_composer" ), $tag ) );
		} else {
			self::$sc[ $tag ] = $attributes;
			self::$sc[ $tag ]['params'] = Array();
			if ( ! empty( $attributes['params'] ) ) {
				foreach ( $attributes['params'] as $attribute ) {
					$attribute = apply_filters( 'vc_mapper_attribute', $attribute, $tag );
					$attribute = apply_filters( 'vc_mapper_attribute_' . $attribute['type'], $attribute, $tag );
					self::$sc[ $tag ]['params'][] = $attribute;
				}
				$sort = new Vc_Sort( self::$sc[ $tag ]['params'] );
				self::$sc[ $tag ]['params'] = $sort->sortByKey();
			}
			visual_composer()->addShortCode( self::$sc[ $tag ] );

			return true;
		}

		return false;
	}

	/**
	 * Generates list of shortcodes taking into account the access rules for shortcodes from VC Settings page.
	 *
	 * This method parses the list of mapped shortcodes and creates categories list for users.
	 *
	 * @static
	 *
	 * @param bool $force - force data generation even data already generated.
	 */
	protected static function generateUserData( $force = false ) {
		if ( ! $force && self::$user_sc !== false && self::$user_categories !== false ) {
			return;
		}

		$settings = self::getSettings();
		self::$user_sc = self::$user_categories = self::$user_sorted_sc = array();
		foreach ( self::$sc as $name => $values ) {
			if ( in_array( $name, array(
					'vc_column',
					'vc_row',
					'vc_row_inner',
					'vc_column_inner'
				) ) || ! isset( $settings[ self::$user_role ]['shortcodes'] )
			     || ( isset( $settings[ self::$user_role ]['shortcodes'][ $name ] ) && (int) $settings[ self::$user_role ]['shortcodes'][ $name ] == 1 )
			) {
				if ( ! isset( $values['content_element'] ) || $values['content_element'] === true ) {
					$categories = isset( $values['category'] ) ? $values['category'] : '_other_category_';
					$values['_category_ids'] = array();
					if ( is_array( $categories ) ) {
						foreach ( $categories as $c ) {
							if ( array_search( $c, self::$user_categories ) === false ) {
								self::$user_categories[] = $c;
							}
							$values['_category_ids'][] = md5( $c ); // array_search($category, self::$categories);
						}
					} else {
						if ( array_search( $categories, self::$user_categories ) === false ) {
							self::$user_categories[] = $categories;
						}
						$values['_category_ids'][] = md5( $categories ); // array_search($category, self::$categories);
					}

				}
				self::$user_sc[ $name ] = $values;
				self::$user_sorted_sc[] = $values;
			}

		}
		$sort = new Vc_Sort( self::$user_sorted_sc );
		self::$user_sorted_sc = $sort->sortByKey();
	}

	/**
	 * Get mapped shortcode settings.
	 *
	 * @static
	 * @return array
	 */
	public static function getShortCodes() {
		return self::$sc;
	}

	/**
	 * Get sorted list of mapped shortcode settings for current user.
	 *
	 * Sorting depends on the weight attribute and mapping order.
	 *
	 * @static
	 * @return array
	 */
	public static function getSortedUserShortCodes() {
		self::generateUserData();

		return self::$user_sorted_sc;
	}

	/**
	 * Get list of mapped shortcode settings for current user.
	 * @static
	 * @return array - associated array of shortcodes settings with tag as the key.
	 */
	public static function getUserShortCodes() {
		self::generateUserData();

		return self::$user_sc;
	}

	/**
	 * Get mapped shortcode settings by tag.
	 *
	 * @static
	 *
	 * @param $tag - shortcode tag.
	 *
	 * @return array
	 */
	public static function getShortCode( $tag ) {
		return self::$sc[ $tag ];
	}

	/**
	 * Get all categories for mapped shortcodes.
	 *
	 * @static
	 * @return array
	 */
	public static function getCategories() {
		return self::$categories;
	}

	/**
	 * Get all categories for current user.
	 *
	 * Category is added to the list when at least one shortcode of this category is allowed for current user
	 * by Vc access rules.
	 *
	 * @static
	 * @return array
	 */
	public static function getUserCategories() {
		self::generateUserData();

		return self::$user_categories;
	}

	/**
	 * Drop shortcode param.
	 *
	 * @static
	 *
	 * @param $name
	 * @param $attribute_name
	 *
	 * @return bool
	 */
	public static function dropParam( $name, $attribute_name ) {
		if ( ! self::$is_init ) {
			vc_mapper()->addActivity(
				'mapper', 'drop_param', array(
					'name' => $name,
					'attribute_name' => $attribute_name
				)
			);

			return true;
		}
		foreach ( self::$sc[ $name ]['params'] as $index => $param ) {
			if ( $param['param_name'] == $attribute_name ) {
				array_splice( self::$sc[ $name ]['params'], $index, 1 );

				return true;
			}
		}

		return true;
	}

	/**
	 * Returns param settings for mapped shortcodes.
	 *
	 * @static
	 *
	 * @param $tag
	 * @param $param_name
	 *
	 * @return bool| array
	 */
	public static function getParam( $tag, $param_name ) {
		if ( ! isset( self::$sc[ $tag ] ) ) {
			return trigger_error( sprintf( __( "Wrong name for shortcode:%s. Name required", "js_composer" ), $tag ) );
		}
		foreach ( self::$sc[ $tag ]['params'] as $index => $param ) {
			if ( $param['param_name'] == $param_name ) {
				return self::$sc[ $tag ]['params'][ $index ];
			}
		}

		return false;
	}

	/**
	 * Add new param to shortcode params list.
	 *
	 * @static
	 *
	 * @param $name
	 * @param array $attribute
	 *
	 * @return bool - true if added, false if scheduled/rejected
	 */
	public static function addParam( $name, $attribute = Array() ) {
		if ( ! self::$is_init ) {
			vc_mapper()->addActivity(
				'mapper', 'add_param', array(
					'name' => $name,
					'attribute' => $attribute
				)
			);

			return false;
		}
		if ( ! isset( self::$sc[ $name ] ) ) {
			trigger_error( sprintf( __( "Wrong name for shortcode:%s. Name required", "js_composer" ), $name ) );
		} elseif ( ! isset( $attribute['param_name'] ) ) {
			trigger_error( sprintf( __( "Wrong attribute for '%s' shortcode. Attribute 'param_name' required", "js_composer" ), $name ) );
		} else {

			$replaced = false;

			foreach ( self::$sc[ $name ]['params'] as $index => $param ) {
				if ( $param['param_name'] == $attribute['param_name'] ) {
					$replaced = true;
					self::$sc[ $name ]['params'][ $index ] = $attribute;
				}
			}
			if ( $replaced === false ) {
				self::$sc[ $name ]['params'][] = $attribute;
			}
			$sort = new Vc_Sort( self::$sc[ $name ]['params'] );
			self::$sc[ $name ]['params'] = $sort->sortByKey();
			visual_composer()->addShortCode( self::$sc[ $name ] );

			return true;
		}

		return false;
	}

	/**
	 * Change param attributes of mapped shortcode.
	 *
	 * @static
	 *
	 * @param $name
	 * @param array $attribute
	 *
	 * @return bool
	 */
	public static function mutateParam( $name, $attribute = Array() ) {
		if ( ! self::$is_init ) {
			vc_mapper()->addActivity(
				'mapper', 'mutate_param', array(
					'name' => $name,
					'attribute' => $attribute
				)
			);

			return false;
		}
		if ( ! isset( self::$sc[ $name ] ) ) {
			return trigger_error( sprintf( __( "Wrong name for shortcode:%s. Name required", "js_composer" ), $name ) );
		} elseif ( ! isset( $attribute['param_name'] ) ) {
			trigger_error( sprintf( __( "Wrong attribute for '%s' shortcode. Attribute 'param_name' required", "js_composer" ), $name ) );
		} else {

			$replaced = false;

			foreach ( self::$sc[ $name ]['params'] as $index => $param ) {
				if ( $param['param_name'] == $attribute['param_name'] ) {
					$replaced = true;
					self::$sc[ $name ]['params'][ $index ] = array_merge( $param, $attribute );
				}
			}

			if ( $replaced === false ) {
				self::$sc[ $name ]['params'][] = $attribute;
			}
			$sort = new Vc_Sort( self::$sc[ $name ]['params'] );
			self::$sc[ $name ]['params'] = $sort->sortByKey();
			visual_composer()->addShortCode( self::$sc[ $name ] );
		}

		return true;
	}

	/**
	 * Removes shortcode from mapping list.
	 *
	 * @static
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	public static function dropShortcode( $name ) {
		if ( ! self::$is_init ) {
			vc_mapper()->addActivity(
				'mapper', 'drop_shortcode', array(
					'name' => $name
				)
			);

			return false;
		}
		unset( self::$sc[ $name ] );
		visual_composer()->removeShortCode( $name );

		return true;
	}

	/**
	 * Modify shortcode's mapped settings.
	 * You can modify only one option of the group options.
	 * Call this method with $settings_name param as associated array to mass modifications.
	 *
	 * @static
	 *
	 * @param $name - shortcode' name.
	 * @param $setting_name - option key name or the array of options.
	 * @param $value - value of settings if $setting_name is option key.
	 *
	 * @return array|bool
	 */
	public static function modify( $name, $setting_name, $value = '' ) {
		if ( ! self::$is_init ) {
			vc_mapper()->addActivity(
				'mapper', 'modify', array(
					'name' => $name,
					'setting_name' => $setting_name,
					'value' => $value
				)
			);

			return false;
		}
		if ( ! isset( self::$sc[ $name ] ) ) {
			return trigger_error( sprintf( __( "Wrong name for shortcode:%s. Name required", "js_composer" ), $name ) );
		} elseif ( $setting_name === 'base' ) {
			return trigger_error( sprintf( __( "Wrong setting_name for shortcode:%s. Base can't be modified.", "js_composer" ), $name ) );
		}
		if ( is_array( $setting_name ) ) {
			foreach ( $setting_name as $key => $value ) {
				self::modify( $name, $key, $value );
			}
		} else {
			self::$sc[ $name ][ $setting_name ] = $value;
			visual_composer()->updateShortcodeSetting( $name, $setting_name, $value );
		}

		return self::$sc;
	}

	/**
	 * Returns "|" separated list of mapped shortcode tags.
	 *
	 * @static
	 * @return string
	 */
	public static function getTagsRegexp() {
		if ( empty( self::$tags_regexp ) ) {
			self::$tags_regexp = implode( '|', array_keys( self::$sc ) );
		}

		return self::$tags_regexp;
	}

	/**
	 * Sorting method for WPBMap::generateUserData method. Called by usort php function.
	 * @deprecated - use Vc_Sort::sortByKey since 4.4
	 * @static
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	public static function sort( $a, $b ) {
		$a_weight = isset( $a['weight'] ) ? (int) $a['weight'] : 0;
		$b_weight = isset( $b['weight'] ) ? (int) $b['weight'] : 0;
		if ( $a_weight == $b_weight ) {
			$cmpa = array_search( $a, self::$user_sorted_sc );
			$cmpb = array_search( $b, self::$user_sorted_sc );

			return ( $cmpa > $cmpb ) ? 1 : - 1;
		}

		return ( $a_weight < $b_weight ) ? 1 : - 1;
	}
}
