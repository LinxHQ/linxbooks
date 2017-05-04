<?php
/**
 * WPBakery Visual Composer Main manager.
 *
 * @package WPBakeryVisualComposer
 * @since   4.2
 */

/**
 * Vc mapper new class. On maintenance
 * Allows to bind hooks for shortcodes.
 * @since 4.2
 */
class Vc_Mapper {
	/**
	 * @since 4.2
	 * Stores mapping activities list which where called before initialization
	 * @var array
	 */
	protected $init_activity = array();

	/**
	 * @since 4.2
	 */
	function __construct() {
	}

	/**
	 * Include params list objects and calls all stored activity methods.
	 *
	 * @since  4.2
	 * @access public
	 */
	public function init() {
		do_action( 'vc_mapper_init_before' );
		require_once vc_path_dir( 'PARAMS_DIR', 'load.php' );
		WPBMap::setInit();
		require_once vc_path_dir( 'CONFIG_DIR', 'map.php' );
		$this->callActivities();
		do_action( 'vc_mapper_init_after' );
	}

	/**
	 * This method is called by VC objects methods if it is called before VC initialization.
	 *
	 * @see WPBMAP
	 * @since  4.2
	 * @access public
	 *
	 * @param $object - mame of class object
	 * @param $method - method name
	 * @param array $params - list of attributes for object method
	 */
	public function addActivity( $object, $method, $params = array() ) {
		$this->init_activity[] = array( $object, $method, $params );
	}

	/**
	 * Call all stored activities.
	 *
	 * Called by init method. List of activities stored by $init_activity are created by other objects called after
	 * initialization.
	 *
	 * @since  4.2
	 * @access public
	 */
	protected function callActivities() {
		while ( $activity = each( $this->init_activity ) ) {
			list( $object, $method, $params ) = $activity[1];
			if ( $object == 'mapper' ) {
				switch ( $method ) {
					case 'map':
						WPBMap::map( $params['tag'], $params['attributes'] );
						break;
					case 'drop_param':
						WPBMap::dropParam( $params['name'], $params['attribute_name'] );
						break;
					case 'add_param':
						WPBMap::addParam( $params['name'], $params['attribute'] );
						break;
					case 'mutate_param':
						WPBMap::mutateParam( $params['name'], $params['attribute'] );
						break;
					case 'drop_shortcode':
						WPBMap::dropShortcode( $params['name'] );
						break;
					case 'modify':
						WPBMap::modify( $params['name'], $params['setting_name'], $params['value'] );
						break;
				}
			}
		}
	}
}