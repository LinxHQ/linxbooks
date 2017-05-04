<?php
require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-basic-grid.php' );

class WPBakeryShortCode_VC_Media_Grid extends WPBakeryShortCode_VC_Basic_Grid {
	public function __construct( $settings ) {
		parent::__construct( $settings );
		add_filter( $this->shortcode . '_items_list', array( $this, 'setItemsIfEmpty' ) );
	}

	protected function getFileName() {
		return 'vc_basic_grid';
	}

	protected function setPagingAll( $max_items ) {
		$this->atts['items_per_page'] = $this->atts['query_items_per_page']
			= apply_filters( 'vc_basic_grid_items_per_page_all_max_items', self::$default_max_items );
	}

	public function buildQuery( $atts ) {
		if ( empty( $atts['include'] ) ) {
			$atts['include'] = - 1;
		}
		$settings = array(
			'include' => $atts['include'],
			'posts_per_page' => apply_filters( 'vc_basic_grid_max_items', self::$default_max_items ),
			'offset' => 0,
			'post_type' => 'attachment', // $atts['post_type'],
			'orderby' => 'post__in',
		);

		return $settings;
	}

	public function setItemsIfEmpty( $items ) {

		if ( empty( $items ) ) {
			require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/class-vc-grid-item.php' );
			$grid_item = new Vc_Grid_Item();
			$grid_item->setGridAttributes( $this->atts );
			$grid_item->shortcodes();
			$item = '[vc_gitem]<img src="' . vc_asset_url( 'vc/vc_gitem_image.png' ) . '">[/vc_gitem]';
			$grid_item->parseTemplate( $item );
			$items = str_repeat( $grid_item->renderItem( get_post( vc_request_param( 'vc_post_id' ) ) ), 3 );
		}

		return $items;
	}
}