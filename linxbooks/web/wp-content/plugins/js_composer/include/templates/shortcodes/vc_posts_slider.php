<?php
$output = $title = $type = $count = $interval = $slides_content = $link = '';
$custom_links = $thumb_size = $posttypes = $posts_in = $categories = '';
$orderby = $order = $el_class = $link_image_start = '';
extract( shortcode_atts( array(
	'title' => '',
	'type' => 'flexslider_fade',
	'count' => 3,
	'interval' => 3,
	'slides_content' => '',
	'slides_title' => '',
	'link' => 'link_post',
	'custom_links' => site_url() . '/',
	'thumb_size' => 'medium',
	'posttypes' => '',
	'posts_in' => '',
	'categories' => '',
	'orderby' => NULL,
	'order' => 'DESC',
	'el_class' => ''
), $atts ) );

$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';

$el_class = $this->getExtraClass( $el_class );

if ( $type == 'nivo' ) {
	$type = ' wpb_slider_nivo theme-default';
	wp_enqueue_script( 'nivo-slider' );
	wp_enqueue_style( 'nivo-slider-css' );
	wp_enqueue_style( 'nivo-slider-theme' );

	$slides_wrap_start = '<div class="nivoSlider">';
	$slides_wrap_end = '</div>';
} else if ( $type == 'flexslider' || $type == 'flexslider_fade' || $type == 'flexslider_slide' || $type == 'fading' ) {
	$el_start = '<li>';
	$el_end = '</li>';
	$slides_wrap_start = '<ul class="slides">';
	$slides_wrap_end = '</ul>';
	wp_enqueue_style( 'flexslider' );
	wp_enqueue_script( 'flexslider' );
}
$flex_fx = '';
if ( $type == 'flexslider' || $type == 'flexslider_fade' || $type == 'fading' ) {
	$type = ' wpb_flexslider flexslider_fade flexslider';
	$flex_fx = ' data-flex_fx="fade"';
} else if ( $type == 'flexslider_slide' ) {
	$type = ' wpb_flexslider flexslider_slide flexslider';
	$flex_fx = ' data-flex_fx="slide"';
}

if ( $link == 'link_image' ) {
	wp_enqueue_script( 'prettyphoto' );
	wp_enqueue_style( 'prettyphoto' );
}

$query_args = array(
	'post_status' => 'publish'
);

//exclude current post/page from query
if ( $posts_in != '' ) {
	$query_args['post__in'] = explode( ",", $posts_in );
}
global $vc_posts_grid_exclude_id;
$vc_posts_grid_exclude_id[] = get_the_ID();
$query_args['post__not_in'] = array( get_the_ID() );

// Post teasers count
if ( $count != '' && ! is_numeric( $count ) ) $count = - 1;
if ( $count != '' && is_numeric( $count ) ) $query_args['posts_per_page'] = $count;

// Post types
$pt = array();
if ( $posttypes != '' ) {
	$posttypes = explode( ",", $posttypes );
	foreach ( $posttypes as $post_type ) {
		array_push( $pt, $post_type );
	}
	$query_args['post_type'] = $pt;
}

// Narrow by categories
if ( $categories != '' ) {
	$categories = explode( ",", $categories );
	$gc = array();
	foreach ( $categories as $grid_cat ) {
		array_push( $gc, $grid_cat );
	}
	$gc = implode( ",", $gc );
	////http://snipplr.com/view/17434/wordpress-get-category-slug/
	$query_args['category_name'] = $gc;

	$taxonomies = get_taxonomies( '', 'object' );
	$query_args['tax_query'] = array( 'relation' => 'OR' );
	foreach ( $taxonomies as $t ) {
		if ( in_array( $t->object_type[0], $pt ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => $t->name, //$t->name,//'portfolio_category',
				'terms' => $categories,
				'field' => 'slug',
			);
		}
	}
}

// Order posts
if ( $orderby != NULL ) {
	$query_args['orderby'] = $orderby;
}
$query_args['order'] = $order;

// Run query
$my_query = new WP_Query( $query_args );

$pretty_rel_random = ' rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';
if ( $link == 'custom_link' ) {
	$custom_links = explode( ',', $custom_links );
}
$teasers = '';
$i = - 1;

while ( $my_query->have_posts() ) {
	$i ++;
	$my_query->the_post();
	$post_title = the_title( "", "", false );
	$post_id = $my_query->post->ID;
	if ( in_array( get_the_ID(), $vc_posts_grid_exclude_id ) ) {
		continue;
	}
	//$teaser_post_type = 'posts_slider_teaser_'.$my_query->post->post_type . ' ';
	if ( $slides_content == 'teaser' ) {
		$content = apply_filters( 'the_excerpt', get_the_excerpt() ); //get_the_excerpt();
	} else {
		$content = '';
	}
	$thumbnail = '';

	// Thumbnail logic
	$post_thumbnail = $p_img_large = '';

	$post_thumbnail = wpb_getImageBySize( array( 'post_id' => $post_id, 'thumb_size' => $thumb_size ) );
	$thumbnail = $post_thumbnail['thumbnail'];
	$p_img_large = $post_thumbnail['p_img_large'];

	// if ( $thumbnail == '' ) $thumbnail = __("No Featured image set.", "js_composer");

	// Link logic
	if ( $link != 'link_no' ) {
		if ( $link == 'link_post' ) {
			$link_image_start = '<a class="link_image" href="' . get_permalink( $post_id ) . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ) . '">';
		} else if ( $link == 'link_image' ) {
			$p_video = get_post_meta( $post_id, "_p_video", true );
			//
			if ( $p_video != "" ) {
				$p_link = $p_video;
			} else {
				$p_link = $p_img_large[0]; // TODO!!!
			}
			$link_image_start = '<a class="link_image prettyphoto" href="' . $p_link . '" ' . $pretty_rel_random . ' title="' . the_title_attribute( 'echo=0' ) . '" >';
		} else if ( $link == 'custom_link' ) {
			if ( isset( $custom_links[$i] ) ) {
				$slide_custom_link = $custom_links[$i];
			} else {
				$slide_custom_link = $custom_links[0];
			}
			$link_image_start = '<a class="link_image" href="' . $slide_custom_link . '">';
		}

		$link_image_end = '</a>';
	} else {
		$link_image_start = '';
		$link_image_end = '';
	}

	$description = '';
	if ( $slides_content != '' && $content != '' && ( $type == ' wpb_flexslider flexslider_fade flexslider' || $type == ' wpb_flexslider flexslider_slide flexslider' ) ) {
		$description = '<div class="flex-caption">';
		if ( $slides_title == true ) $description .= '<h2 class="post-title">' . $link_image_start . $post_title . $link_image_end . '</h2>';
		$description .= $content;
		$description .= '</div>';
	}

	$teasers .= $el_start . $link_image_start . $thumbnail . $link_image_end . $description . $el_end;
} // endwhile loop
wp_reset_query();

if ( $teasers ) {
	$teasers = $slides_wrap_start . $teasers . $slides_wrap_end;
} else {
	$teasers = __( "Nothing found.", "js_composer" );
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_posts_slider wpb_content_element' . $el_class, $this->settings['base'], $atts );

$output .= "\n\t" . '<div class="' . $css_class . '">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_posts_slider_heading' ) );
$output .= '<div class="wpb_gallery_slides' . $type . '" data-interval="' . $interval . '"' . $flex_fx . '>' . $teasers . '</div>';
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_gallery' );

echo $output;