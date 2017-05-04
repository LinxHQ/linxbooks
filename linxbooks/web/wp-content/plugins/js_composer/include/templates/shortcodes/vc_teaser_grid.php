<?php

$title = $grid_columns_count = $grid_teasers_count = $grid_layout = $grid_link = $grid_link_target = '';
$grid_template = $grid_thumb_size = $grid_posttypes = $grid_layout_mode = $grid_taxomonies = $grid_categories = $posts_in = $posts_not_in = '';
$grid_content = $el_class = $width = $orderby = $order = $el_position = $isotope_item = '';

extract( shortcode_atts( array(
	'title' => '',
	'grid_columns_count' => 4,
	'grid_teasers_count' => 8,
	'grid_layout' => 'title_thumbnail_text', // title_thumbnail_text, thumbnail_title_text, thumbnail_text, thumbnail_title, thumbnail, title_text
	'grid_link' => 'link_post', // link_post, link_image, link_image_post, link_no
	'grid_link_target' => '_self',
	'grid_template' => 'grid', //grid, carousel
	'grid_thumb_size' => 'thumbnail',
	'grid_posttypes' => '',
	'grid_taxomonies' => '',
	'grid_categories' => '',
	'grid_layout_mode' => 'fitRows',
	'posts_in' => '',
	'posts_not_in' => '',
	'grid_content' => 'teaser', // teaser, content
	'el_class' => '',
	'width' => '1/1',
	'orderby' => NULL,
	'order' => 'DESC',
	'el_position' => ''
), $atts ) );

if ( $grid_template == 'grid' || $grid_template == 'filtered_grid' ) {
	wp_enqueue_style( 'isotope-css' );
	wp_enqueue_script( 'isotope' );
	$isotope_item = 'isotope-item ';
} else if ( $grid_template == 'carousel' ) {
	wp_enqueue_script( 'jcarousellite' );
	$isotope_item = '';
}

if ( $grid_link == 'link_image' || $grid_link == 'link_image_post' ) {
	wp_enqueue_script( 'prettyphoto' );
	wp_enqueue_style( 'prettyphoto' );
}

$output = '';

$el_class = $this->getExtraClass( $el_class );
$width = ''; //wpb_translateColumnWidthToSpan( $width );
$li_span_class = wpb_translateColumnsCountToSpanClass( $grid_columns_count );


$query_args = array();

$not_in = array();
if ( $posts_not_in != '' ) {
	$posts_not_in = str_ireplace( " ", "", $posts_not_in );
	$not_in = explode( ",", $posts_not_in );
}

$link_target = $grid_link_target == '_blank' ? ' target="_blank"' : '';


//exclude current post/page from query
if ( $posts_in == '' ) {
	global $post;
	array_push( $not_in, $post->ID );
} else if ( $posts_in != '' ) {
	$posts_in = str_ireplace( " ", "", $posts_in );
	$query_args['post__in'] = explode( ",", $posts_in );
}
if ( $posts_in == '' || $posts_not_in != '' ) {
	$query_args['post__not_in'] = $not_in;
}

// Post teasers count
if ( $grid_teasers_count != '' && ! is_numeric( $grid_teasers_count ) ) $grid_teasers_count = - 1;
if ( $grid_teasers_count != '' && is_numeric( $grid_teasers_count ) ) $query_args['posts_per_page'] = $grid_teasers_count;

// Post types
$pt = array();
if ( $grid_posttypes != '' ) {
	$grid_posttypes = explode( ",", $grid_posttypes );
	foreach ( $grid_posttypes as $post_type ) {
		array_push( $pt, $post_type );
	}
	$query_args['post_type'] = $pt;
}

// Taxonomies

$taxonomies = array();
if ( $grid_taxomonies != '' ) {
	$grid_taxomonies = explode( ",", $grid_taxomonies );
	foreach ( $grid_taxomonies as $taxom ) {
		array_push( $taxonomies, $taxom );
	}
}

// Narrow by categories
if ( $grid_categories != '' ) {
	$grid_categories = explode( ",", $grid_categories );
	$gc = array();
	foreach ( $grid_categories as $grid_cat ) {
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
				'terms' => $grid_categories,
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

$teasers = '';
$teaser_categories = Array();
if ( $grid_template == 'filtered_grid' && empty( $grid_taxomonies ) ) {
	$taxonomies = get_object_taxonomies( ! empty( $query_args['post_type'] ) ? $query_args['post_type'] : get_post_types( array( 'public' => false, 'name' => 'attachment' ), 'names', 'NOT' ) );
}

$posts_Ids = array();

while ( $my_query->have_posts() ) {
	$link_title_start = $link_image_start = $p_link = $link_image_end = $p_img_large = '';

	$my_query->the_post();

	$posts_Ids[] = $my_query->post->ID;


	$categories_css = '';
	if ( $grid_template == 'filtered_grid' ) {
		/** @var $post_cate``gories get list of categories */
		// $post_categories = get_the_category($my_query->post->ID);
		$post_categories = wp_get_object_terms( $my_query->post->ID, array_values( $taxonomies ) );
		if ( ! is_wp_error( $post_categories ) ) {
			foreach ( $post_categories as $cat ) {
				if ( ! in_array( $cat->term_id, $teaser_categories ) ) {
					$teaser_categories[] = $cat->term_id;
				}
				$categories_css .= ' grid-cat-' . $cat->term_id;
			}
		}

	}
	$post_title = the_title( "", "", false );
	$post_id = $my_query->post->ID;

	$teaser_post_type = 'posts_grid_teaser_' . $my_query->post->post_type . ' ';
	if ( $grid_content == 'teaser' ) {
		$content = apply_filters( 'the_excerpt', get_the_excerpt() );
	} else {
		$content = get_the_content();
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
	}

	// $content = ( $grid_content == 'teaser' ) ? apply_filters('the_excerpt', get_the_excerpt()) : get_the_content(); //TODO: get_the_content() rewrite more WP native way.
	$content = wpautop( $content );
	$link = '';
	$thumbnail = '';

	// Read more link
	if ( $grid_link != 'link_no' ) {
		$link = '<a class="more-link" href="' . get_permalink( $post_id ) . '"' . $link_target . ' title="' . sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ) . '">' . __( "Read more", "js_composer" ) . '</a>';
	}

	// Thumbnail logic
	if ( in_array( $grid_layout, array( 'title_thumbnail_text', 'thumbnail_title_text', 'thumbnail_text', 'thumbnail_title', 'thumbnail', 'title_text' ) ) ) {
		$post_thumbnail = $p_img_large = '';
		//$attach_id = get_post_thumbnail_id($post_id);

		$post_thumbnail = wpb_getImageBySize( array( 'post_id' => $post_id, 'thumb_size' => $grid_thumb_size ) );
		$thumbnail = $post_thumbnail['thumbnail'];
		$p_img_large = $post_thumbnail['p_img_large'];
	}

	// Link logic
	if ( $grid_link != 'link_no' ) {
		$p_video = '';
		if ( $grid_link == 'link_image' || $grid_link == 'link_image_post' ) {
			$p_video = get_post_meta( $post_id, "_p_video", true );
		}

		if ( $grid_link == 'link_post' ) {
			$link_image_start = '<a class="link_image" href="' . get_permalink( $post_id ) . '"' . $link_target . ' title="' . sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ) . '">';
			$link_title_start = '<a class="link_title" href="' . get_permalink( $post_id ) . '"' . $link_target . ' title="' . sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ) . '">';
		} else if ( $grid_link == 'link_image' ) {
			if ( $p_video != "" ) {
				$p_link = $p_video;
			} else {
				$p_link = $p_img_large[0];
			}
			$link_image_start = '<a class="link_image prettyphoto" href="' . $p_link . '"' . $link_target . ' title="' . the_title_attribute( 'echo=0' ) . '">';
			$link_title_start = '<a class="link_title prettyphoto" href="' . $p_link . '"' . $link_target . ' title="' . the_title_attribute( 'echo=0' ) . '">';
		} else if ( $grid_link == 'link_image_post' ) {
			if ( $p_video != "" ) {
				$p_link = $p_video;
			} else {
				$p_link = $p_img_large[0];
			}
			$link_image_start = '<a class="link_image prettyphoto" href="' . $p_link . '"' . $link_target . ' title="' . the_title_attribute( 'echo=0' ) . '">';
			$link_title_start = '<a class="link_title" href="' . get_permalink( $post_id ) . '"' . $link_target . ' title="' . sprintf( esc_attr__( 'Permalink to %s', 'js_composer' ), the_title_attribute( 'echo=0' ) ) . '">';
		}
		$link_title_end = $link_image_end = '</a>';
	} else {
		$link_image_start = '';
		$link_title_start = '';
		$link_title_end = $link_image_end = '';
	}
    $teasers .= '<li class="' . $isotope_item.apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $li_span_class, 'vc_teaser_grid_li', $atts ) . $categories_css . '">';
	// If grid layout is: Title + Thumbnail + Text
	if ( $grid_layout == 'title_thumbnail_text' ) {
		if ( $post_title ) {
			$to_filter = '<h2 class="post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
			$teasers .= apply_filters( 'vc_teaser_grid_title', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link ) );
		}
		if ( $thumbnail ) {
			$to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end . '</div>';
			$teasers .= apply_filters( 'vc_teaser_grid_thumbnail', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link ) );
		}
		if ( $content ) {
			$to_filter = '<div class="entry-content">' . $content . '</div>';
			$teasers .= apply_filters( 'vc_teaser_grid_content', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link ) );
		}
	} // If grid layout is: Thumbnail + Title + Text
	else if ( $grid_layout == 'thumbnail_title_text' ) {
		if ( $thumbnail ) {
			$to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end . '</div>';
			$teasers .= apply_filters( 'vc_teaser_grid_thumbnail', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link ) );
		}
		if ( $post_title ) {
			$to_filter = '<h2 class="post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
			$teasers .= apply_filters( 'vc_teaser_grid_title', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link ) );
		}
		if ( $content ) {
			$to_filter = '<div class="entry-content">' . $content . '</div>';
			$teasers .= apply_filters( 'vc_teaser_grid_content', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link ) );
		}
	} // If grid layout is: Thumbnail + Text
	else if ( $grid_layout == 'thumbnail_text' ) {
		if ( $thumbnail ) {
			$to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end . '</div>';
			$teasers .= apply_filters( 'vc_teaser_grid_thumbnail', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link ) );
		}
		if ( $content ) {
			$to_filter = '<div class="entry-content">' . $content . '</div>';
			$teasers .= apply_filters( 'vc_teaser_grid_content', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link ) );
		}
	} // If grid layout is: Thumbnail + Title
	else if ( $grid_layout == 'thumbnail_title' ) {
		if ( $thumbnail ) {
			$to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end . '</div>';
			$teasers .= apply_filters( 'vc_teaser_grid_thumbnail', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link ) );
		}
		if ( $post_title ) {
			$to_filter = '<h2 class="post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
			$teasers .= apply_filters( 'vc_teaser_grid_title', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link ) );
		}
	} // If grid layout is: Thumbnail
	else if ( $grid_layout == 'thumbnail' ) {
		if ( $thumbnail ) {
			$to_filter = '<div class="post-thumb">' . $link_image_start . $thumbnail . $link_image_end . '</div>';
			$teasers .= apply_filters( 'vc_teaser_grid_thumbnail', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "thumbnail" => $thumbnail, "media_link" => $p_link ) );
		}
	} // If grid layout is: Title + Text
	else if ( $grid_layout == 'title_text' ) {
		if ( $post_title ) {
			$to_filter = '<h2 class="post-title">' . $link_title_start . $post_title . $link_title_end . '</h2>';
			$teasers .= apply_filters( 'vc_teaser_grid_title', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "title" => $post_title, "media_link" => $p_link ) );
		}
		if ( $content ) {
			$to_filter = '<div class="entry-content">' . $content . '</div>';
			$teasers .= apply_filters( 'vc_teaser_grid_content', $to_filter, array( "grid_layout" => $grid_layout, "ID" => $post_id, "content" => $content, "media_link" => $p_link ) );
		}
	}
	$teasers .= '</li> ' . $this->endBlockComment( 'single teaser' );
} // endwhile loop
wp_reset_query();

if ( $grid_template == 'filtered_grid' && $teasers && ! empty( $teaser_categories ) ) {
	/*
$categories_list = wp_list_categories(array(
	'orderby' => 'name',
	'walker' => new Teaser_Grid_Category_Walker(),
	'include' => implode(',', $teaser_categories),
	'show_option_none'   => __('No categories', 'js_composer'),
	'echo' => false
));
*/
	$categories_array = get_terms( array_values( $taxonomies ), array(
		'orderby' => 'name',
		'include' => implode( ',', $teaser_categories )
	) );

	$categories_list_output = '<ul class="categories_filter vc_clearfix">';
	$categories_list_output .= '<li class="active"><a href="#" data-filter="*">' . __( 'All', 'js_composer' ) . '</a></li>';
	if ( ! is_wp_error( $categories_array ) ) {
		foreach ( $categories_array as $cat ) {
			$categories_list_output .= '<li><a href="#" data-filter=".grid-cat-' . $cat->term_id . '">' . esc_attr( $cat->name ) . '</a></li>';
		}
	}
	$categories_list_output .= '</ul><div class="vc_clearfix"></div>';
} else {
	$categories_list_output = '';
}

if ( $teasers ) {
	$teasers = '<div class="teaser_grid_container">' . $categories_list_output . '<ul class="wpb_thumbnails wpb_thumbnails-fluid vc_clearfix" data-layout-mode="' . $grid_layout_mode . '">' . $teasers . '</ul></div>';
} else {
	$teasers = __( "Nothing found.", "js_composer" );
}

$posttypes_teasers = '';


if ( is_array( $grid_posttypes ) ) {
	//$posttypes_teasers_ar = explode(",", $grid_posttypes);
	$posttypes_teasers_ar = $grid_posttypes;
	foreach ( $posttypes_teasers_ar as $post_type ) {
		$posttypes_teasers .= 'wpb_teaser_grid_' . $post_type . ' ';
	}
}

$grid_class = 'wpb_' . $grid_template . ' columns_count_' . $grid_columns_count . ' grid_layout-' . $grid_layout . ' ' . $grid_layout . '_' . $li_span_class . ' ' . 'columns_count_' . $grid_columns_count . '_' . $grid_layout . ' ' . $posttypes_teasers;
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_teaser_grid wpb_content_element ' . $grid_class . $width . $el_class, $this->settings['base'], $atts );

$output .= "\n\t" . '<div class="' . $css_class . '">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
//$output .= ($title != '' ) ? "\n\t\t\t".'<h2 class="wpb_heading wpb_teaser_grid_heading">'.$title.'</h2>' : '';
$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_teaser_grid_heading' ) );
if ( $grid_template == 'carousel' ) {
	$output .= apply_filters( 'vc_teaser_grid_carousel_arrows', '<a href="#" class="prev">&larr;</a> <a href="#" class="next">&rarr;</a>' );
}

$output .= $teasers;
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_teaser_grid' );

echo $output;