<?php
/**
 * Manage update messages and Plugins info for VC in default Wordpress plugins list.
 */
class Vc_Updating_Manager {
	/**
	 * The plugin current version
	 *
	 * @var string
	 */
	public $current_version;

	/**
	 * The plugin remote update path
	 *
	 * @var string
	 */
	public $update_path;

	/**
	 * Plugin Slug (plugin_directory/plugin_file.php)
	 *
	 * @var string
	 */
	public $plugin_slug;

	/**
	 * Plugin name (plugin_file)
	 *
	 * @var string
	 */
	public $slug;
	/**
	 * Link to download VC.
	 * @var string
	 */
	protected $url = 'http://bit.ly/vcomposer';
	/**
	 * Initialize a new instance of the WordPress Auto-Update class
	 *
	 * @param string $current_version
	 * @param string $update_path
	 * @param string $plugin_slug
	 */
	function __construct( $current_version, $update_path, $plugin_slug ) {
		// Set the class public variables
		$this->current_version = $current_version;
		$this->update_path = $update_path;
		$this->plugin_slug = $plugin_slug;
		$t = explode( '/', $plugin_slug );
		$this->slug = str_replace( '.php', '', $t[1] );

		// define the alternative API for updating checking
		add_filter( 'pre_set_site_transient_update_plugins', array( &$this, 'check_update' ) );

		// Define the alternative response for information checking
		add_filter( 'plugins_api', array( &$this, 'check_info' ), 10, 3 );

		add_action( 'in_plugin_update_message-' . vc_plugin_name(), array( &$this, 'addUpgradeMessageLink' ) );
	}

	/**
	 * Add our self-hosted autoupdate plugin to the filter transient
	 *
	 * @param $transient
	 * @return object $ transient
	 */
	public function check_update( $transient ) {

		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		// Get the remote version
		$remote_version = $this->getRemote_version();

		// If a newer version is available, add the update
		if ( version_compare( $this->current_version, $remote_version, '<' ) ) {
			$obj = new stdClass();
			$obj->slug = $this->slug;
			$obj->new_version = $remote_version;
			$obj->url = ''; // $this->update_path;
			$obj->package = ''; // $this->update_path;
			$obj->name = vc_updater()->title;
			$transient->response[$this->plugin_slug] = $obj;
		}

		return $transient;
	}

	/**
	 * Add our self-hosted description to the filter
	 *
	 * @param boolean $false
	 * @param array $action
	 * @param object $arg
	 * @return bool|object
	 */
	public function check_info( $false, $action, $arg ) {
		if ( isset( $arg->slug ) && $arg->slug === $this->slug ) {
			$information = $this->getRemote_information();
			$array_pattern = array(
				'/^([\*\s])*(\d\d\.\d\d\.\d\d\d\d[^\n]*)/m',
				'/^\n+|^[\t\s]*\n+/m',
				'/\n/',
			);
			$array_replace = array(
				'<h4>$2</h4>',
				'</div><div>',
				'</div><div>'
			);
			$information->name = vc_updater()->title;
			$information->sections['changelog'] = '<div>' . preg_replace( $array_pattern, $array_replace, $information->sections['changelog'] ) . '</div>';
			return $information;
		}
		return $false;
	}

	/**
	 * Return the remote version
	 *
	 * @return string $remote_version
	 */
	public function getRemote_version() {
		$request = wp_remote_post( $this->update_path, array( 'body' => array( 'action' => 'version' ) ) );
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			return $request['body'];
		}
		return false;
	}

	/**
	 * Get information about the remote version
	 *
	 * @return bool|object
	 */
	public function getRemote_information() {
		$request = wp_remote_post( $this->update_path, array( 'body' => array( 'action' => 'info' ) ) );
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			return unserialize( base64_decode( $request['body'] ) );
		}
		return false;
	}

	/**
	 * Return the status of the plugin licensing
	 *
	 * @return boolean $remote_license
	 */
	public function getRemote_license() {
		$request = wp_remote_post( $this->update_path, array( 'body' => array( 'action' => 'license' ) ) );
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			return $request['body'];
		}
		return false;
	}
	/**
	 * Shows message on Wp plugins page with a link for updating from envato.
	 */
	public function addUpgradeMessageLink() {
		$username = vc_settings()->get( 'envato_username' );
		$api_key = vc_settings()->get( 'envato_api_key' );
		$purchase_code = vc_settings()->get( 'js_composer_purchase_code' );
		echo '<style type="text/css" media="all">tr#wpbakery-visual-composer + tr.plugin-update-tr a.thickbox + em { display: none; }</style>';
		if ( empty( $username ) || empty( $api_key ) || empty( $purchase_code ) ) {
			echo ' <a href="' . $this->url . '">' . __( 'Download new version from CodeCanyon.', 'js_composer' ) . '</a>';
		} else {
			// update.php?action=upgrade-plugin&plugin=testimonials-widget%2Ftestimonials-widget.php&_wpnonce=6178d48b6e
			// echo '<a href="' . wp_nonce_url( admin_url( 'plugins.php?vc_action=vc_upgrade' ) ) . '">' . __( 'Update Visual Composer now.', 'js_composer' ) . '</a>';
			echo '<a href="' . wp_nonce_url( admin_url( 'update.php?action=upgrade-plugin&plugin='.vc_plugin_name() ), 'upgrade-plugin_'.vc_plugin_name() ) . '">' . __( 'Update Visual Composer now.', 'js_composer' ) . '</a>';
		}
	}
}