<?php

/**
 * Vendors manager to load required classes and functions to work with VC.
 * @deprecated due to autoload logic introduced in 4.4
 * @since 4.3
 */
Class Vc_Vendors_Manager {
	/**
	 * @var array
	 */
	protected $vendors = array();

	/**
	 * @deprecated
	 */
	function __construct() {
		add_action( 'vc_before_init_base', array( &$this, 'init' ) );
	}

	/**
	 * @deprecated
	 */
	public function init() {
		require_once vc_path_dir( 'VENDORS_DIR', '_autoload.php' );
		$this->load();
	}

	/**
	 * @deprecated
	 *
	 * @param Vc_Vendor_Interface $vendor
	 */
	public function add( Vc_Vendor_Interface $vendor ) {
		$this->vendors[] = $vendor;
	}

	/**
	 * @deprecated
	 */
	public function load() {
		foreach ( $this->vendors as $vendor ) {
			$vendor->load();
		}
	}
}
