<?php
require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-media-grid.php' );

class WPBakeryShortCode_VC_Masonry_Media_Grid extends WPBakeryShortCode_VC_Media_Grid {

	public function shortcodeScripts() {
		parent::shortcodeScripts();
		wp_register_script( 'vc_masonry', vc_asset_url( 'lib/masonry/dist/masonry.pkgd.min.js' ),
			array( 'vc_grid-style-all' ), WPB_VC_VERSION, true );
		wp_register_script( 'vc_grid-style-all-masonry', vc_asset_url( 'js/components/vc_grid_style_all_masonry.js' ),
			array( 'vc_grid-style-all' ), WPB_VC_VERSION, true );
		wp_register_script( 'vc_grid-style-lazy-masonry', vc_asset_url( 'js/components/vc_grid_style_lazy_masonry.js' ),
			array( 'vc_grid-style-all' ), WPB_VC_VERSION, true );
		wp_register_script( 'vc_grid-style-load-more-masonry', vc_asset_url( 'js/components/vc_grid_style_load_more_masonry.js' ),
			array( 'vc_grid-style-all' ), WPB_VC_VERSION, true );

	}

	public function enqueueScripts() {
		parent::enqueueScripts();
		wp_enqueue_script( 'vc_masonry' );
		wp_enqueue_script( 'vc_grid-style-all-masonry' );
		wp_enqueue_script( 'vc_grid-style-lazy-masonry' );
		wp_enqueue_script( 'vc_grid-style-load-more-masonry' );
	}

	public function buildGridSettings() {
		parent::buildGridSettings();
		$this->grid_settings['style'] .= '-masonry';
	}

	protected function contentAllMasonry( $grid_style, $settings, $content ) {
		return parent::contentAll( $grid_style, $settings, $content );
	}

	protected function contentLazyMasonry( $grid_style, $settings, $content ) {
		return parent::contentLazy( $grid_style, $settings, $content );
	}

	protected function contentLoadMoreMasonry( $grid_style, $settings, $content ) {
		return parent::contentLoadMore( $grid_style, $settings, $content );
	}
}