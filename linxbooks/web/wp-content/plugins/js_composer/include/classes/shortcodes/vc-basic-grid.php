<?php
require_once vc_path_dir( 'SHORTCODES_DIR', 'paginator/class-vc-pageable.php' );

class WPBakeryShortCode_VC_Basic_Grid extends WPBakeryShortCodeVc_Pageable {
	public $pagable_type = 'grid';
	public $items = array();
	public static $excluded_ids = array();
	protected $element_template = '';
	protected static $default_max_items = 1000;
	public $post_id = false;
	protected $filter_terms;
	//protected $atts = array();
	public $attributes_defaults = array(
		'full_width' => '',
		'layout' => '',
		'element_width' => '4',
		'items_per_page' => '5',
		'gap' => '',
		'style' => 'all',
		'show_filter' => '',
		'exclude_filter' => '',
		'filter_style' => '',
		'filter_size' => 'md',
		'filter_align' => '',
		'filter_color' => '',
		'button_style' => '',
		'button_color' => '',
		'button_size' => 'md',
		'arrows_design' => '',
		'arrows_position' => '',
		'arrows_color' => '',
		'paging_design' => '',
		'paging_color' => '',
		'paging_animation_in' => '',
		'paging_animation_out' => '',
		'loop' => '',
		'autoplay' => '',
		'post_type' => 'post',
		'filter_source' => 'category',
		'orderby' => '',
		'order' => 'DESC',
		'meta_key' => '',
		'max_items' => '10',
		'offset' => '0',
		'taxonomies' => '',
		'custom_query' => '',
		'data_type' => 'query',
		'include' => '',
		'exclude' => '',
		'item' => 'none'
	);
	protected $grid_settings = array();

	function __construct( $settings ) {
		parent::__construct( $settings );

		$this->shortcodeScripts();
	}

	public function shortcodeScripts() {
		parent::shortcodeScripts();
		/*wp_register_script( 'vc_grid-js-isotope-horizontal',
			vc_asset_url( 'lib/isotope-horizontal/horizontal.js' ) );
		wp_register_script( 'vc_grid-js-isotope-masonry-horizontal',
			vc_asset_url( 'lib/isotope-masonry-horizontal/masonry-horizontal.js' ) );
		wp_register_script( 'vc_grid-js-isotope-packery',
			vc_asset_url( 'lib/isotope-packery-mode/packery-mode.pkgd.min.js' ) );*/

		wp_register_script( 'vc_grid-js-imagesloaded',
			vc_asset_url( 'lib/imagesloaded/imagesloaded.pkgd.min.js' ) );
		wp_register_script( 'vc_grid-style-all', vc_asset_url( 'js/components/vc_grid_style_all.js' ),
			array(), WPB_VC_VERSION, true );
		wp_register_script( 'vc_grid-style-load-more', vc_asset_url( 'js/components/vc_grid_style_load_more.js' ),
			array(), WPB_VC_VERSION, true );
		wp_register_script( 'vc_grid-style-lazy', vc_asset_url( 'js/components/vc_grid_style_lazy.js' ),
			array( 'waypoints' ), WPB_VC_VERSION, true );
		wp_register_script( 'vc_grid-style-pagination', vc_asset_url( 'js/components/vc_grid_style_pagination.js' ),
			array(), WPB_VC_VERSION, true );
		wp_register_script( 'vc_grid', vc_asset_url( 'js/components/vc_grid.js' ), array(
			'jquery',
			'underscore',
			'vc_pageable_owl-carousel',
			'waypoints',
			//'isotope',
			'vc_grid-style-all',
			'vc_grid-style-load-more',
			'vc_grid-style-lazy',
			'vc_grid-style-pagination',
		), WPB_VC_VERSION, true );
	}

	public function enqueueScripts() {
		parent::enqueueScripts();
		wp_enqueue_script( 'vc_grid-js-imagesloaded' );
		wp_enqueue_script( 'vc_grid' );
	}

	public static function addExcludedId( $id ) {
		self::$excluded_ids[] = $id;
	}

	public static function excludedIds() {
		return self::$excluded_ids;
	}

	/**
	 * Get shortcode hash by it content and attributes
	 *
	 * @param $atts
	 * @param $content
	 *
	 * @return string
	 */
	public function getHash( $atts, $content ) {
		if ( vc_is_page_editable() || is_preview() ) {
			/* We are in Frontend editor
			 * We need to send RAW shortcode data, so hash is just json_encode of atts and content
			 */
			return urlencode( json_encode( array(
				'tag' => $this->shortcode,
				'atts' => $atts,
				'content' => $content
			) ) );
		}

		/** Else
		 * We are in preview mode (viewing page).
		 * So hash is shortcode atts and content hash
		 */

		return sha1( serialize( array(
			'tag' => $this->shortcode,
			'atts' => $atts,
			'content' => $content,
		) ) );

	}

	/**
	 * Search in post meta vc_post_settings value
	 * For shortcode data by hash
	 *
	 * @param $page_id
	 * @param $hash
	 *
	 * @return bool|array
	 */
	public function findPostShortcodeByHash( $page_id, $hash ) {
		if ( preg_match( '/\"tag\"\:/', urldecode( $hash ) ) ) {
			return json_decode( urldecode( $hash ), true ); // if frontend, no hash exists - just RAW data
		}
		$post_meta = get_post_meta( $page_id, '_vc_post_settings' );
		if ( is_array( $post_meta ) ) {
			foreach ( $post_meta as $meta ) {
				if ( isset( $meta['vc_grid'] ) && ! empty( $meta['vc_grid']['shortcodes'] ) && isset( $meta['vc_grid']['shortcodes'][ $hash ] ) ) {
					return $meta['vc_grid']['shortcodes'][ $hash ];
				}
			}
		}

		return false;
	}

	private function renderItems() {
		$output = $items = '';
		$this->buildGridSettings();
		$css_classes = 'vc_row vc_clearfix vc_grid' . esc_attr( $this->atts['gap'] > 0 ? ' vc_grid-gutter-' . (int) $this->atts['gap'] . 'px' : '' );
		if ( is_array( $this->items ) && ! empty( $this->items ) ) {
			require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/class-vc-grid-item.php' );
			$grid_item = new Vc_Grid_Item();
			$grid_item->setGridAttributes( $this->atts );
			$grid_item->setIsEnd( isset( $this->is_end ) && $this->is_end );
			$grid_item->setTemplateById( $this->atts['item'] );
			$output .= $grid_item->addShortcodesCustomCss();
			ob_start();
			wp_print_styles();
			$output .= ob_get_clean();
			$output .= vc_get_template( 'shortcodes/vc_basic_grid_filter.php', array(
				'filter_terms' => $this->filter_terms,
				'atts' => $this->atts
			) );
			while ( have_posts() ) {
				the_post();
				$items .= $grid_item->renderItem( get_post() );
			}
			/*
			foreach ( $this->items as $post ) {
				$post->the_post();
				$items .= $grid_item->renderItem( $post );

				$items .= trim( vc_get_template( 'shortcodes/vc_grid_item.php', array(
					'post' => $post,
					'element_width' => $this->atts['element_width'],
				) ) );
			*/
		}
		$items = apply_filters( $this->shortcode . '_items_list', $items );
		$output .= $this->renderPagination( $this->atts['style'], $this->grid_settings, $items, $css_classes ) . "\n";

		return $output;
	}

	public function setContentLimits() {
		$atts = $this->atts;
		if ( $this->atts['post_type'] === 'ids' ) {
			$this->atts['max_items'] = 0;
			$this->atts['offset'] = 0;
			$this->atts['items_per_page'] = apply_filters( 'vc_basic_grid_max_items', self::$default_max_items );
		} else {
			$this->atts['offset'] = $offset = isset( $atts['offset'] ) ? (int) $atts['offset'] : $this->attributes_defaults['offset'];
			$this->atts['max_items'] = isset( $atts['max_items'] )
				? (int) $atts['max_items'] : (int) $this->attributes_defaults['max_items'];
			$this->atts['items_per_page'] = ! isset( $atts['items_per_page'] )
				? (int) $this->attributes_defaults['items_per_page']
				: (int) $atts['items_per_page'];
			if ( $this->atts['max_items'] < 1 ) {
				$this->atts['max_items'] = apply_filters( 'vc_basic_grid_max_items', self::$default_max_items );
			}
		}
		$this->setPagingAll( $this->atts['max_items'] );
	}

	protected function setPagingAll(
		$max_items
	) {
		$atts = $this->atts;
		$this->atts['items_per_page'] = $this->atts['query_items_per_page'] = $max_items > 0
			? $max_items
			: apply_filters( 'vc_basic_grid_items_per_page_all_max_items', self::$default_max_items );
		$this->atts['query_offset'] = isset( $atts['offset'] )
			? (int) $atts['offset']
			: $this->attributes_defaults['offset'];
	}

	public
	function renderAjax(
		$vc_request_param
	) {
		$this->items = array(); // clear this items array (if used more than once);
		$hash = $vc_request_param['shortcode_hash'];
		$shortcode = $this->findPostShortcodeByHash( $vc_request_param['page_id'], $hash );
		if ( ! is_array( $shortcode ) ) {
			return "{'status':'Nothing found'}"; // Nothing found
		}
		// Set post id
		$this->post_id = (int) $vc_request_param['page_id'];

		$shortcode_atts = $shortcode['atts'];
		$this->shortcode_content = $shortcode['content'];
		$this->buildAtts( $shortcode_atts, $shortcode['content'] );
		if ( isset( $vc_request_param['taxonomies'] ) ) {
			$this->atts['taxonomies'] = $vc_request_param['taxonomies'];
		}

		$this->buildItems();

		return $this->renderItems();
	}

	public
	function postID() {
		if ( $this->post_id == false ) {
			$this->post_id = get_the_ID();
		}

		return $this->post_id;
	}

	public function buildAtts(
		$atts, $content
	) {
		$arr_keys = array_keys( $atts );
		for ( $i = 0; $i < count( $atts ); $i ++ ) {
			$atts[ $arr_keys[ $i ] ] = html_entity_decode( $atts[ $arr_keys[ $i ] ], ENT_QUOTES, 'utf-8' );
		}
		$hash = $this->getHash( $atts, $content );
		$this->atts = shortcode_atts( $this->attributes_defaults, $atts );
		$this->atts['shortcode_hash'] = $hash;
		$this->atts['page_id'] = $this->postID();
		$this->element_template = $content;
	}

	public
	function buildGridSettings() {
		$this->grid_settings = array(
			// used in ajax request for items
			'shortcode_hash' => $this->atts['shortcode_hash'],
			'page_id' => $this->atts['page_id'],
			// used in basic grid for initialization
			'style' => $this->atts['style'],
			'action' => 'vc_get_vc_grid_data',
			// 'grid_options' => $isotope_options
			// animation_in used everywhere.. (in filter)
			'animation_in' => 'zoomIn',
		);
		if ( $this->atts['style'] == 'load-more' ) {
			$this->grid_settings = array_merge( $this->grid_settings, array(
				// used in dispaly style load more button, lazy, pagination
				'items_per_page' => $this->atts['items_per_page'],
				// used in load more button style
				'button_style' => $this->atts['button_style'],
				// load more btn style
				'button_color' => $this->atts['button_color'],
				// load more btn color
				'button_size' => $this->atts['button_size'],
				// load more btn size
			) );
		} else if ( $this->atts['style'] == 'lazy' ) {
			$this->grid_settings = array_merge( $this->grid_settings, array(
				'items_per_page' => $this->atts['items_per_page'],
			) );
		} else if ( $this->atts['style'] == 'pagination' ) {
			$this->grid_settings = array_merge( $this->grid_settings, array(
				'items_per_page' => $this->atts['items_per_page'],
				// used in pagination style
				'auto_play' => $this->atts['autoplay'] > 0 ? true : false,
				'gap' => (int) $this->atts['gap'], // not used yet, but can be used in isotope..
				'speed' => (int) $this->atts['autoplay'] * 1000,
				'loop' => $this->atts['loop'],
				'animation_in' => $this->atts['paging_animation_in'],
				'animation_out' => $this->atts['paging_animation_out'],
				'arrows_design' => $this->atts['arrows_design'],
				'arrows_color' => $this->atts['arrows_color'],
				'arrows_position' => $this->atts['arrows_position'],
				'paging_design' => $this->atts['paging_design'],
				'paging_color' => $this->atts['paging_color'],
			) );
		}
		$this->grid_settings['tag'] = $this->shortcode;
	}

// TODO: setter & getter to attributes
	public
	function buildQuery(
		$atts
	) {
		// Set include & exclude
		if ( $atts['post_type'] !== 'ids' && ! empty( $atts['exclude'] ) ) {
			$atts['exclude'] .= ',' . implode( ',', $this->excludedIds() );
		} else {
			$atts['exclude'] = implode( ',', $this->excludedIds() );
		}
		if ( $atts['post_type'] !== 'ids' ) {
			$settings = array(
				'posts_per_page' => $atts['query_items_per_page'],
				'offset' => $atts['query_offset'],
				'orderby' => $atts['orderby'],
				'order' => $atts['order'],
				'meta_key' => $atts['orderby'] == 'meta_key' ? $atts['meta_key'] : '',
				'post_type' => $atts['post_type'],
				'exclude' => $atts['exclude'],
			);
			if ( ! empty( $atts['taxonomies'] ) ) {
				$vc_taxonomies_types = get_taxonomies( array( 'public' => true ) );
				$terms = get_terms( array_keys( $vc_taxonomies_types ), array(
					'hide_empty' => false,
					'include' => $atts['taxonomies'],
				) );
				$settings['tax_query'] = array();
				$tax_queries = array(); // List of taxnonimes
				foreach ( $terms as $t ) {
					if ( ! isset( $tax_queries[ $t->taxonomy ] ) ) {
						$tax_queries[ $t->taxonomy ] = array(
							'taxonomy' => $t->taxonomy,
							'field' => 'id',
							'terms' => array( $t->term_id ),
							'relation' => 'IN'
						);
					} else {
						$tax_queries[ $t->taxonomy ]['terms'][] = $t->term_id;
					}
				}
				$settings['tax_query'] = array_values( $tax_queries );
				$settings['tax_query']['relation'] = 'OR';
			}
		} else {
			if ( empty( $atts['include'] ) ) {
				$atts['include'] = - 1;
			} elseif ( ! empty( $atts['exclude'] ) ) {
				$atts['include'] = preg_replace(
					'/(('
					. preg_replace(
						array( '/^\,\*/', '/\,\s*$/', '/\s*\,\s*/' ),
						array( '', '', '|' ),
						$atts['exclude']
					)
					. ')\,*\s*)/', '', $atts['include'] );
			}
			$settings = array(
				'include' => $atts['include'],
				'posts_per_page' => $atts['query_items_per_page'],
				'offset' => $atts['query_offset'],
				'post_type' => 'any', // $atts['post_type'],
				'orderby' => 'post__in',
			);
		}

		return $settings;
	}

	public function buildItems() {
		$this->filter_terms = $this->items = array();

		$this->setContentLimits();

		//wp_enqueue_script( 'isotope' );

		$this->addExcludedId( $this->postID() );
		if ( 'custom' == $this->atts['post_type'] && ! empty( $this->atts['custom_query'] ) ) {
			$query = html_entity_decode( vc_value_from_safe( $this->atts['custom_query'] ), ENT_QUOTES, "utf-8" );
			$post_data = query_posts( $query );
		} elseif ( false !== $this->atts['query_items_per_page'] ) {
			$settings = $this->filterQuerySettings( $this->buildQuery( $this->atts ) );
			$post_data = query_posts( $settings );
		} else {
			return;
		}
		if ( count( $post_data ) > $this->atts['items_per_page'] ) {
			$post_data = array_slice( $post_data, 0, $this->atts['items_per_page'] );
		}
		foreach ( $post_data as $post ) {
			$post->filter_terms = wp_get_object_terms( $post->ID, $this->atts['filter_source'], array( 'fields' => 'ids' ) );
			$this->filter_terms = wp_parse_args( $this->filter_terms, $post->filter_terms );
			$this->items[] = $post;
		}
	}

	public function filterQuerySettings( $args ) {
		$defaults = array(
			'numberposts' => 5,
			'offset' => 0,
			'category' => 0,
			'orderby' => 'date',
			'order' => 'DESC',
			'include' => array(),
			'exclude' => array(),
			'meta_key' => '',
			'meta_value' => '',
			'post_type' => 'post',
			'suppress_filters' => true
		);

		$r = wp_parse_args( $args, $defaults );
		if ( empty( $r['post_status'] ) ) {
			$r['post_status'] = ( 'attachment' == $r['post_type'] ) ? 'inherit' : 'publish';
		}
		if ( ! empty( $r['numberposts'] ) && empty( $r['posts_per_page'] ) ) {
			$r['posts_per_page'] = $r['numberposts'];
		}
		if ( ! empty( $r['category'] ) ) {
			$r['cat'] = $r['category'];
		}
		if ( ! empty( $r['include'] ) ) {
			$incposts = wp_parse_id_list( $r['include'] );
			$r['posts_per_page'] = count( $incposts );  // only the number of posts included
			$r['post__in'] = $incposts;
		} elseif ( ! empty( $r['exclude'] ) ) {
			$r['post__not_in'] = wp_parse_id_list( $r['exclude'] );
		}

		$r['ignore_sticky_posts'] = true;
		$r['no_found_rows'] = true;

		return $r;
	}
}