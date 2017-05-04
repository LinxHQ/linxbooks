<?php
global $vc_teaser_box;
$posts_query = $el_class = $args = $my_query = $speed = $mode = $swiper_options = '';
$content = $link = $layout = $thumb_size = $link_target = $slides_per_view = $wrap = '';
$autoplay = $hide_pagination_control = $hide_prev_next_buttons = $title = '';
$posts = array();
extract( shortcode_atts( array(
	'el_class' => '',
	'posts_query' => '',
	'mode' => 'horizontal',
	'speed' => '5000',
	'slides_per_view' => '1',
	'swiper_options' => '',
	'wrap' => '',
	'autoplay' => 'no',
	'hide_pagination_control' => '',
	'hide_prev_next_buttons' => '',
	'layout' => 'title,thumbnail,excerpt',
	'link_target' => '',
	'thumb_size' => 'thumbnail',
	'partial_view' => '',
	'title' => ''
), $atts ) );
global $vc_posts_grid_exclude_id;
$vc_posts_grid_exclude_id[] = get_the_ID(); // fix recursive nesting
if ( is_array( $posts_query ) ) {
	$posts_query['post_status'] = 'publish';
} else {
	$posts_query .= '|post_status:publish';
}
list( $args, $my_query ) = vc_build_loop_query( $posts_query, get_the_ID() );
$teaser_blocks = vc_sorted_list_parse_value( $layout );
/** @var $my_query WP_Query */
while ( $my_query->have_posts() ) {
	$my_query->the_post(); // Get post from query
	if ( in_array( get_the_ID(), $vc_posts_grid_exclude_id ) ) {
		continue;
	}
	$post = new stdClass(); // Creating post object.
	$post->id = get_the_ID();
	$post->link = get_permalink( $post->id );
	$post->post_type = get_post_type();
	if ( $vc_teaser_box->getTeaserData( 'enable', $post->id ) === '1' ) {
		$post->custom_user_teaser = true;
		$data = $vc_teaser_box->getTeaserData( 'data', $post->id );
		if ( ! empty( $data ) ) $data = json_decode( $data );
		$post->bgcolor = $vc_teaser_box->getTeaserData( 'bgcolor', $post->id );
		$post->custom_teaser_blocks = array();
		$post->title_attribute = the_title_attribute( 'echo=0' );
		if ( ! empty( $data ) )
			foreach ( $data as $block ) {
				$settings = array();
				if ( $block->name === 'title' ) {
					$post->title = the_title( "", "", false );
				} elseif ( $block->name === 'image' ) {
					if ( $block->image === 'featured' ) {
						$post->thumbnail_data = $this->getPostThumbnail( $post->id, $thumb_size );
					} elseif ( ! empty( $block->image ) ) {
						$post->thumbnail_data = wpb_getImageBySize( array( 'attach_id' => (int)$block->image, 'thumb_size' => $thumb_size ) );
					} else {
						$post->thumbnail_data = false;
					}
					$post->thumbnail = $post->thumbnail_data && isset( $post->thumbnail_data['thumbnail'] ) ? $post->thumbnail_data['thumbnail'] : '';
					$post->image_link = empty( $video ) && $post->thumbnail && isset( $post->thumbnail_data['p_img_large'][0] ) ? $post->thumbnail_data['p_img_large'][0] : $video;
				} elseif ( $block->name === 'text' ) {
					if ( $block->mode === 'custom' ) {
						$settings[] = 'text';
						$post->content = $block->text;
					} elseif ( $block->mode === 'excerpt' ) {
						$settings[] = $block->mode;
						$post->excerpt = $this->getPostExcerpt();
					} else {
						$settings[] = $block->mode;
						$post->content = $this->getPostContent();
					}
				}
				if ( isset( $block->link ) ) {
					if ( $block->link === 'post' ) {
						$settings[] = 'link_post';
					} elseif ( $block->link === 'big_image' ) {
						$settings[] = 'link_image';
					} else {
						$settings[] = 'no_link';
					}
					$settings[] = '';
				}
				$post->custom_teaser_blocks[] = array( $block->name, $settings );
			}
	} else {
		$post->custom_user_teaser = false;
		$post->title = the_title( "", "", false );
		$post->title_attribute = the_title_attribute( 'echo=0' );
		$post->post_type = get_post_type();
		$post->content = $this->getPostContent();
		$post->excerpt = $this->getPostExcerpt();
		$post->thumbnail_data = $this->getPostThumbnail( $post->id, $thumb_size );
		$post->thumbnail = $post->thumbnail_data && isset( $post->thumbnail_data['thumbnail'] ) ? $post->thumbnail_data['thumbnail'] : '';
		$video = get_post_meta( $post->id, "_p_video", true );
		$post->image_link = empty( $video ) && $post->thumbnail && isset( $post->thumbnail_data['p_img_large'][0] ) ? $post->thumbnail_data['p_img_large'][0] : $video;
	}

	$post->categories_css = $this->getCategoriesCss( $post->id );

	$posts[] = $post;
}
wp_reset_query();
// $options = vc_parse_options_string($bxslider_options, $this->shortcode, 'bxslider_options');
$tmp_options = vc_parse_options_string( $swiper_options, $this->shortcode, 'swiper_options' );
// }}
$this->setLinktarget( $link_target );

// wp_enqueue_script('vc_bxslider');
// wp_enqueue_style('vc_bxslider_css');
// wp_enqueue_script('vc_swiper');
// wp_enqueue_style('vc_swiper_css');
wp_enqueue_script( 'vc_carousel_js' );
wp_enqueue_style( 'vc_carousel_css' );

$options = array();
// Convert keys to Camel case.
foreach ( $tmp_options as $key => $value ) {
	$key = preg_replace( '/_([a-z])/e', "strtoupper('\\1')", $key );
	$options[$key] = $value;
}
if ( (int)$slides_per_view > 0 ) $options['slidesPerView'] = (int)$slides_per_view;
if ( (int)$autoplay > 0 ) $options['autoplay'] = (int)$autoplay;
$options['mode'] = $mode;
// $options['calculateHeight'] = true;
$css_class = $this->settings['base'] . ' wpb_content_element vc_carousel_slider_' . $slides_per_view . ' vc_carousel_' . $mode . ( empty( $el_class ) ? '' : ' ' . $el_class );
$carousel_id = 'vc_carousel-' . WPBakeryShortCode_Vc_Carousel::getCarouselIndex();
?>
<div class="<?php echo apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ?>">
	<div class="wpb_wrapper">
		<?php echo  wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_gallery_heading' ) ) ?>
		<div id="<?php echo $carousel_id ?>" data-ride="vc_carousel"
			 data-wrap="<?php echo $wrap === 'yes' ? 'true' : 'false' ?>"
			 data-interval="<?php echo $autoplay == 'yes' ? $speed : 0 ?>" data-auto-height="true"
			 data-mode="<?php echo $mode ?>" data-partial="<?php echo $partial_view === 'yes' ? 'true' : 'false' ?>"
			 data-per-view="<?php echo $slides_per_view ?>"
			 data-hide-on-end="<?php echo $autoplay == 'yes' ? 'false' : 'true' ?>" class="vc_carousel vc_slide">
			<?php if ( $hide_pagination_control !== 'yes' ): ?>
			<!-- Indicators -->
			<ol class="vc_carousel-indicators">
				<?php for ( $i = 0; $i < count( $posts ); $i ++ ): ?>
				<li data-target="#<?php echo $carousel_id ?>" data-slide-to="<?php echo $i ?>"></li>
				<?php endfor; ?>
			</ol>
			<?php endif; ?>
			<!-- Wrapper for slides -->
			<div class="vc_carousel-inner">
				<div class="vc_carousel-slideline">
					<div class="vc_carousel-slideline-inner">
						<?php foreach ( $posts as $post ): ?>
						<?php
						$blocks_to_build = $post->custom_user_teaser === true ? $post->custom_teaser_blocks : $teaser_blocks;
						$block_style = isset( $post->bgcolor ) ? ' style="background-color: ' . $post->bgcolor . '"' : '';
						?>
						<div class="vc_item vc_slide_<?php echo $post->post_type ?>"<?php echo $block_style ?>>
							<div class="vc_inner">
								<?php foreach ( $blocks_to_build as $block_data ): ?>
								<?php include $this->getBlockTemplate() ?>
								<?php endforeach; ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<?php if ( $hide_prev_next_buttons !== 'yes' ): ?>
			<!-- Controls -->
			<a class="vc_left vc_carousel-control" href="#<?php echo $carousel_id ?>" data-slide="prev">
				<span class="icon-prev"></span>
			</a>
			<a class="vc_right vc_carousel-control" href="#<?php echo $carousel_id ?>" data-slide="next">
				<span class="icon-next"></span>
			</a>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php return; ?>