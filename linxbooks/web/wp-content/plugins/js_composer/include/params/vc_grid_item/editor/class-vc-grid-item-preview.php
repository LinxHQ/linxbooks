<?php

Class Vc_Grid_Item_Preview {
	protected $shortcodes_string = '';
	protected $post_id = false;

	public function render() {
		$this->shortcodes_string = stripslashes( vc_request_param( 'shortcodes_string', true ) );
		$this->post_id           = vc_request_param( 'post_id' );
		require_once vc_path_dir( 'PARAMS_DIR', 'vc_grid_item/class-vc-grid-item.php' );
		$grid_item = new Vc_Grid_Item();
		$grid_item->setIsEnd( false );
		$grid_item->setGridAttributes(array('element_width' => 4));
		$grid_item->setTemplate( $this->shortcodes_string, $this->post_id );
		$this->enqueue();
		vc_include_template( 'params/vc_grid_item/preview.tpl.php', array(
			'preview'   => $this,
			'grid_item' => $grid_item,
			'shortcodes_string' => $this->shortcodes_string,
			'post' => $this->mockingPost(),
			'default_width_value' => apply_filters('vc_grid_item_preview_render_default_width_value', 4),
		));
	}
	public function addCssBackgroundImage($css) {
		if(empty($css)) {
			$css = 'background-image: url('.vc_asset_url('vc/vc_gitem_image.png').') !important';
		}
		return $css;
	}
	public function addImageUrl($url) {
		if(empty($url)) {
			$url = vc_asset_url('vc/vc_gitem_image.png');
		}
		return $url;
	}
	public function addImage($img) {
		if(empty($img)) {
			$img = '<img src="' . vc_asset_url( 'vc/vc_gitem_image.png' ) . '" alt="">';
		}
		return $img;
	}
	public function enqueue() {
		visual_composer()->frontCss();
		visual_composer()->frontJsRegister();
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );
		wp_enqueue_style( 'js_composer_front' );
		wp_enqueue_script( 'wpb_composer_front_js' );
		wp_enqueue_style('js_composer_custom_css');
		require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-basic-grid.php' );
		$grid = new WPBakeryShortCode_VC_Basic_Grid(array('base' => 'vc_basic_grid'));
		$grid->shortcodeScripts();
		$grid->enqueueScripts();
	}

	public function mockingPost() {
		$post = get_post($this->post_id);
		$post->post_title = __('Post title', 'js_composer');
		$post->post_content = __('The WordPress Excerpt is an optional summary or description of a post; in short, a post summary.', 'js_composer');
		$post->post_excerpt = __('The WordPress Excerpt is an optional summary or description of a post; in short, a post summary.', 'js_composer');
		$GLOBALS['post'] = $post;
		return $post;
	}
}