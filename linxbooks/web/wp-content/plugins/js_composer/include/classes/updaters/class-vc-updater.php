<?php
/**
 * WPBakery Visual Composer updater
 *
 * @package WPBakeryVisualComposer
 *
 */

/**
 * Vc updating manager.
 */
class Vc_Updater {
	/**
	 * @var string
	 */
	protected $version_url = 'http://wpbakery.com/version/?';
	/**
	 * @var string
	 */
	public $title = 'WPBakery Visual Composer';

	/**
	 * @var bool
	 */
	protected $auto_updater = false;
	/**
	 * @var bool
	 */
	protected $upgrade_manager = false;
	/**
	 * @var bool
	 */
	protected $iframe = false;

	/**
	 *
	 */
	public function init() {
		add_filter( 'upgrader_pre_download', array( $this, 'upgradeFilterFromEnvato' ), 10, 4 );
		add_action( 'upgrader_process_complete', array( $this, 'removeTemporaryDir' ) );
	}

	/**
	 * Setter for manager updater.
	 *
	 * @param Vc_Updating_Manager $updater
	 */
	public function setUpdateManager( Vc_Updating_Manager $updater ) {
		$this->auto_updater = $updater;
	}

	/**
	 * Getter for manager updater.
	 *
	 * @return Vc_Updating_Manager
	 */
	public function updateManager() {
		return $this->auto_updater;
	}

	/**
	 * Get url for version validation
	 * @return string
	 */
	public function versionUrl() {
		return $this->version_url . time();
	}

	/**
	 * Downloads new VC from Envato marketplace and unzips into temporary directory.
	 *
	 * @param $reply
	 * @param $package
	 * @param $updater
	 *
	 * @return mixed|string|WP_Error
	 */
	public function upgradeFilterFromEnvato( $reply, $package, $updater ) {
		global $wp_filesystem;

		if ( ( isset( $updater->skin->plugin ) && $updater->skin->plugin === vc_plugin_name() ) ||
		     ( isset( $updater->skin->plugin_info ) && $updater->skin->plugin_info['Name'] === $this->title )
		) {
			$updater->strings['download_envato'] = __( 'Downloading package from envato market...', 'js_composer' );
			$updater->skin->feedback( 'download_envato' );
			$package_filename = 'js_composer.zip';
			$res = $updater->fs_connect( array( WP_CONTENT_DIR ) );
			if ( ! $res ) {
				return new WP_Error( 'no_credentials', __( "Error! Can't connect to filesystem", 'js_composer' ) );
			}
			$username = vc_settings()->get( 'envato_username' );
			$api_key = vc_settings()->get( 'envato_api_key' );
			$purchase_code = vc_settings()->get( 'js_composer_purchase_code' );
			if ( ! vc_license()->isActivated() || empty( $username ) || empty( $api_key ) || empty( $purchase_code ) ) {
				return new WP_Error( 'no_credentials', __( 'To receive automatic updates license activation is required. Please visit <a href="' . admin_url( 'options-general.php?page=vc_settings&tab=updater' ) . '' . '" target="_blank">Settings</a> to activate your Visual Composer.', 'js_composer' ) );
			}
			$json = wp_remote_get( $this->envatoDownloadPurchaseUrl( $username, $api_key, $purchase_code ) );
			$result = json_decode( $json['body'], true );
			if ( ! isset( $result['download-purchase']['download_url'] ) ) {
				return new WP_Error( 'no_credentials', __( 'Error! Envato API error' . ( isset( $result['error'] ) ? ': ' . $result['error'] : '.' ), 'js_composer' ) );
			}
			$result['download-purchase']['download_url'];
			$download_file = download_url( $result['download-purchase']['download_url'] );
			if ( is_wp_error( $download_file ) ) {
				return $download_file;
			}
			$upgrade_folder = $wp_filesystem->wp_content_dir() . 'uploads/js_composer_envato_package';
			if ( is_dir( $upgrade_folder ) ) {
				$wp_filesystem->delete( $upgrade_folder );
			}
			$result = unzip_file( $download_file, $upgrade_folder );
			if ( $result && is_file( $upgrade_folder . '/' . $package_filename ) ) {
				return $upgrade_folder . '/' . $package_filename;
			}

			return new WP_Error( 'no_credentials', __( 'Error on unzipping package', 'js_composer' ) );
		}

		return $reply;
	}

	/**
	 *
	 */
	public function removeTemporaryDir() {
		global $wp_filesystem;
		if ( is_dir( $wp_filesystem->wp_content_dir() . 'uploads/js_composer_envato_package' ) ) {
			$wp_filesystem->delete( $wp_filesystem->wp_content_dir() . 'uploads/js_composer_envato_package', true );
		}
	}

	/**
	 * @param $username
	 * @param $api_key
	 * @param $purchase_code
	 *
	 * @return string
	 */
	protected function envatoDownloadPurchaseUrl( $username, $api_key, $purchase_code ) {
		return 'http://marketplace.envato.com/api/edge/' . rawurlencode( $username ) . '/' . rawurlencode( $api_key ) . '/download-purchase:' . rawurlencode( $purchase_code ) . '.json';
	}
}