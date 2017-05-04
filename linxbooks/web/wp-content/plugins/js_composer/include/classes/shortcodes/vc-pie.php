<?php
class WPBakeryShortCode_Vc_Pie extends WPBakeryShortCode {
	public function __construct( $settings ) {
		parent::__construct( $settings );
		// $this->addAction( 'wp_enqueue_scripts', 'jsScripts' );
		$this->jsScripts();
	}
	public function jsScripts() {
		wp_register_script( 'progressCircle', vc_asset_url( 'lib/progress-circle/ProgressCircle.js' ), WPB_VC_VERSION , true );
		wp_register_script( 'vc_pie', vc_asset_url( 'lib/vc_chart/jquery.vc_chart.js' ), array( 'jquery', 'waypoints', 'progressCircle' ), WPB_VC_VERSION, true );
		//wp_enqueue_script('vc_pie');
	}
}