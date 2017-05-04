<?php
/**
 * WPBakery Visual Composer helpers functions
 *
 * @package WPBakeryVisualComposer
 *
 */

if ( ! defined( 'WPB_VC_VERSION' ) ) {
	die( '-1' );
} // Check if this file is loaded in js_composer

/**
 * @param array $params
 *
 * @since 4.2
 * vc_filter: vc_wpb_getimagesize - to override output of this function
 * @return array|bool
 */
function wpb_getImageBySize(
	$params = array(
		'post_id' => null,
		'attach_id' => null,
		'thumb_size' => 'thumbnail',
		'class' => ''
	)
) {
	//array( 'post_id' => $post_id, 'thumb_size' => $grid_thumb_size )
	if ( ( ! isset( $params['attach_id'] ) || $params['attach_id'] == null ) && ( ! isset( $params['post_id'] ) || $params['post_id'] == null ) ) {
		return false;
	}
	$post_id = isset( $params['post_id'] ) ? $params['post_id'] : 0;

	if ( $post_id ) {
		$attach_id = get_post_thumbnail_id( $post_id );
	} else {
		$attach_id = $params['attach_id'];
	}

	$thumb_size = $params['thumb_size'];
	$thumb_class = ( isset( $params['class'] ) && $params['class'] != '' ) ? $params['class'] . ' ' : '';

	global $_wp_additional_image_sizes;
	$thumbnail = '';

	if ( is_string( $thumb_size ) && ( ( ! empty( $_wp_additional_image_sizes[ $thumb_size ] ) && is_array( $_wp_additional_image_sizes[ $thumb_size ] ) ) || in_array( $thumb_size, array(
				'thumbnail',
				'thumb',
				'medium',
				'large',
				'full'
			) ) )
	) {
		$thumbnail = wp_get_attachment_image( $attach_id, $thumb_size, false, array( 'class' => $thumb_class . 'attachment-' . $thumb_size ) );
	} elseif ( $attach_id ) {
		if ( is_string( $thumb_size ) ) {
			preg_match_all( '/\d+/', $thumb_size, $thumb_matches );
			if ( isset( $thumb_matches[0] ) ) {
				$thumb_size = array();
				if ( count( $thumb_matches[0] ) > 1 ) {
					$thumb_size[] = $thumb_matches[0][0]; // width
					$thumb_size[] = $thumb_matches[0][1]; // height
				} elseif ( count( $thumb_matches[0] ) > 0 && count( $thumb_matches[0] ) < 2 ) {
					$thumb_size[] = $thumb_matches[0][0]; // width
					$thumb_size[] = $thumb_matches[0][0]; // height
				} else {
					$thumb_size = false;
				}
			}
		}
		if ( is_array( $thumb_size ) ) {
			// Resize image to custom size
			$p_img = wpb_resize( $attach_id, null, $thumb_size[0], $thumb_size[1], true );
			$alt = trim( strip_tags( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) ) );
			$attachment = get_post( $attach_id );
			if(!empty($attachment)) {
				$title = trim( strip_tags( $attachment->post_title ) );

				if ( empty( $alt ) ) {
					$alt = trim( strip_tags( $attachment->post_excerpt ) ); // If not, Use the Caption
				}
				if ( empty( $alt ) ) {
					$alt = $title;
				} // Finally, use the title
				if ( $p_img ) {
					$img_class = '';
					//if ( $grid_layout == 'thumbnail' ) $img_class = ' no_bottom_margin'; class="'.$img_class.'"
					$thumbnail = '<img class="' . esc_attr( $thumb_class ) . '" src="' . esc_attr( $p_img['url'] ) . '" width="' . esc_attr( $p_img['width'] ) . '" height="' . esc_attr( $p_img['height'] ) . '" alt="' . esc_attr( $alt ) . '" title="' . esc_attr( $title ) . '" />';
				}
			}
		}
	}

	$p_img_large = wp_get_attachment_image_src( $attach_id, 'large' );

	return apply_filters( 'vc_wpb_getimagesize', array(
		'thumbnail' => $thumbnail,
		'p_img_large' => $p_img_large
	), $attach_id, $params );
}

/**
 * @param $width
 *
 * @since 4.2
 * @return string
 */
function wpb_getColumnControls( $width ) {
	switch ( $width ) {
		case "vc_col-md-2" :
			$w = "1/6";
			break;
		case "vc_col-sm-3" :
			$w = "1/4";
			break;
		case "vc_col-sm-4" :
			$w = "1/3";
			break;
		case "vc_col-sm-6" :
			$w = "1/2";
			break;
		case "vc_col-sm-8" :
			$w = "2/3";
			break;
		case "vc_col-sm-9" :
			$w = "3/4";
			break;
		case "vc_col-sm-12" :
			$w = "1/1";
			break;

		default :
			$w = $width;
	}

	return $w;
}

/* Convert vc_col-sm-3 to 1/4
---------------------------------------------------------- */
/**
 * @param $width
 *
 * @since 4.2
 * @return string
 */
function wpb_translateColumnWidthToFractional( $width ) {
	switch ( $width ) {
		case "vc_col-sm-2" :
			$w = "1/6";
			break;
		case "vc_col-sm-3" :
			$w = "1/4";
			break;
		case "vc_col-sm-4" :
			$w = "1/3";
			break;
		case "vc_col-sm-6" :
			$w = "1/2";
			break;
		case "vc_col-sm-8" :
			$w = "2/3";
			break;
		case "vc_col-sm-9" :
			$w = "3/4";
			break;
		case "vc_col-sm-12" :
			$w = "1/1";
			break;

		default :
			$w = $width;
	}

	return $w;
}

/* Convert 2 to
---------------------------------------------------------- */
/**
 * @param $grid_columns_count
 *
 * @since 4.2
 * @return string
 */
function wpb_translateColumnsCountToSpanClass( $grid_columns_count ) {
	$teaser_width = '';
	switch ( $grid_columns_count ) {
		case '1' :
			$teaser_width = 'vc_col-sm-12';
			break;
		case '2' :
			$teaser_width = 'vc_col-sm-6';
			break;
		case '3' :
			$teaser_width = 'vc_col-sm-4';
			break;
		case '4' :
			$teaser_width = 'vc_col-sm-3';
			break;
		case '5':
			$teaser_width = 'vc_col-sm-10';
			break;
		case '6' :
			$teaser_width = 'vc_col-sm-2';
			break;
	}
	//return $teaser_width;
	$custom = get_custom_column_class( $teaser_width );

	return $custom ? $custom : $teaser_width;
}

/**
 * @param $width
 * @param bool $front
 *
 * @since 4.2
 * @return bool|string
 */
function wpb_translateColumnWidthToSpan( $width, $front = true ) {
	if ( preg_match( '/^(\d{1,2})\/12$/', $width, $match ) ) {
		$w = 'vc_col-sm-' . $match[1];
	} else {
		$w = 'vc_col-sm-';
		switch ( $width ) {
			case "1/6" :
				$w .= '2';
				break;
			case "1/4" :
				$w .= '3';
				break;
			case "1/3" :
				$w .= '4';
				break;
			case "1/2" :
				$w .= '6';
				break;
			case "2/3" :
				$w .= '8';
				break;
			case "3/4" :
				$w .= '9';
				break;
			case "5/6" :
				$w .= '10';
				break;
			case "1/1" :
				$w .= '12';
				break;
			default :
				$w = $width;
		}
	}
	$custom = $front ? get_custom_column_class( $w ) : false;

	return $custom ? $custom : $w;
}

/**
 * @param $content
 * @param bool $autop
 *
 * @since 4.2
 * @return string
 */
function wpb_js_remove_wpautop( $content, $autop = false ) {

	if ( $autop ) { // Possible to use !preg_match('('.WPBMap::getTagsRegexp().')', $content)
		$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
	}

	return do_shortcode( shortcode_unautop( $content ) );
}

if ( ! function_exists( 'shortcode_exists' ) ) {
	/**
	 * Check if a shortcode is registered in WordPress.
	 *
	 * Examples: shortcode_exists( 'caption' ) - will return true.
	 * shortcode_exists( 'blah' ) - will return false.
	 *
	 * @param bool $shortcode
	 *
	 * @since 4.2
	 * @return bool
	 */
	function shortcode_exists( $shortcode = false ) {
		global $shortcode_tags;

		if ( ! $shortcode ) {
			return false;
		}

		if ( array_key_exists( $shortcode, $shortcode_tags ) ) {
			return true;
		}

		return false;
	}
}

/* Helper function which returs list of site attached images,
   and if image is attached to the current post it adds class
   'added'
---------------------------------------------------------- */
if ( ! function_exists( 'siteAttachedImages' ) ) {
	/**
	 * @param array $att_ids
	 *
	 * @since 4.2
	 * @return string
	 */
	function siteAttachedImages( $att_ids = array() ) {
		$output = '';

		global $wpdb;
		$media_images = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' order by ID desc" );
		foreach ( $media_images as $image_post ) {
			$thumb_src = wp_get_attachment_image_src( $image_post->ID, 'thumbnail' );
			$thumb_src = $thumb_src[0];

			$class = ( in_array( $image_post->ID, $att_ids ) ) ? ' class="added"' : '';

			$output .= '<li' . $class . '>
						<img rel="' . $image_post->ID . '" src="' . $thumb_src . '" />
						<span class="img-added">' . __( 'Added', "js_composer" ) . '</span>
					</li>';
		}

		if ( $output != '' ) {
			$output = '<ul class="gallery_widget_img_select">' . $output . '</ul>';
		}

		return $output;
	} // end siteAttachedImages()
}

/**
 * @param array $att_ids
 *
 * @since 4.2
 * @return string
 */
function fieldAttachedImages( $att_ids = array() ) {
	$output = '';

	foreach ( $att_ids as $th_id ) {
		$thumb_src = wp_get_attachment_image_src( $th_id, 'thumbnail' );
		if ( $thumb_src ) {
			$thumb_src = $thumb_src[0];
			$output .= '
			<li class="added">
				<img rel="' . $th_id . '" src="' . $thumb_src . '" />
				<a href="#" class="icon-remove"></a>
			</li>';
		}
	}

	return $output;
}

/**
 * @param $param_value
 *
 * @since 4.2
 * @return array
 */
function wpb_removeNotExistingImgIDs( $param_value ) {
	$tmp = explode( ",", $param_value );
	$return_ar = array();
	foreach ( $tmp as $id ) {
		if ( wp_get_attachment_image( $id ) ) {
			$return_ar[] = $id;
		}
	}
	$tmp = implode( ",", $return_ar );

	return $tmp;
}

/*
* Resize images dynamically using wp built in functions
* Victor Teixeira
*
* php 5.2+
*
* Exemplo de uso:
*
* <?php
* $thumb = get_post_thumbnail_id();
* $image = vt_resize( $thumb, '', 140, 110, true );
* ?>
* <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
*
*/
if ( ! function_exists( 'wpb_resize' ) ) {
	/**
	 * @param int $attach_id
	 * @param string $img_url
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
	 *
	 * @since 4.2
	 * @return array
	 */
	function wpb_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {
		// this is an attachment, so we have the ID
		$image_src = array();
		if ( $attach_id ) {
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$actual_file_path = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url
		} else if ( $img_url ) {
			$file_path = parse_url( $img_url );
			$actual_file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
			$actual_file_path = ltrim( $file_path['path'], '/' );
			$actual_file_path = rtrim( ABSPATH, '/' ) . $file_path['path'];
			$orig_size = getimagesize( $actual_file_path );
			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		}
		if(!empty($actual_file_path)) {
			$file_info = pathinfo( $actual_file_path );
			$extension = '.' . $file_info['extension'];

			// the image path without the extension
			$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

			$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

			// checking if the file size is larger than the target size
			// if it is smaller or the same size, stop right here and return
			if ( $image_src[1] > $width || $image_src[2] > $height ) {

				// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
				if ( file_exists( $cropped_img_path ) ) {
					$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
					$vt_image = array(
						'url' => $cropped_img_url,
						'width' => $width,
						'height' => $height
					);

					return $vt_image;
				}

				// $crop = false
				if ( $crop == false ) {
					// calculate the size proportionaly
					$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
					$resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

					// checking if the file already exists
					if ( file_exists( $resized_img_path ) ) {
						$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

						$vt_image = array(
							'url' => $resized_img_url,
							'width' => $proportional_size[0],
							'height' => $proportional_size[1]
						);

						return $vt_image;
					}
				}

				// no cache files - let's finally resize it
				$img_editor = wp_get_image_editor( $actual_file_path );

				if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => ''
					);
				}

				$new_img_path = $img_editor->generate_filename();

				if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => ''
					);
				}
				if ( ! is_string( $new_img_path ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => ''
					);
				}

				$new_img_size = getimagesize( $new_img_path );
				$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

				// resized output
				$vt_image = array(
					'url' => $new_img,
					'width' => $new_img_size[0],
					'height' => $new_img_size[1]
				);

				return $vt_image;
			}

			// default output - without resizing
			$vt_image = array(
				'url' => $image_src[0],
				'width' => $image_src[1],
				'height' => $image_src[2]
			);

			return $vt_image;
		}
		return false;
	}
}

if ( ! function_exists( 'wpb_debug' ) ) {
	/**
	 * Returns bool if wpb_debug is provided in url - set visual composer debug mode.
	 * Used for example in shortcodes (end block comment for example)
	 * @since 4.2
	 * @return bool
	 */
	function wpb_debug() {
		if ( isset( $_GET['wpb_debug'] ) && $_GET['wpb_debug'] == 'true' ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Method adds css class to body tag.
 *
 * Hooked class method by body_class WP filter. Method adds custom css class to body tag of the page to help
 * identify and build design specially for VC shortcodes.
 * Used in wp-content/plugins/js_composer/include/classes/core/class-vc-base.php\Vc_Base\bodyClass
 *
 * @param $classes
 *
 * @since 4.2
 * @return array
 */
function js_composer_body_class( $classes ) {
	$classes[] = 'wpb-js-composer js-comp-ver-' . WPB_VC_VERSION;
	$disable_responsive = vc_settings()->get( 'not_responsive_css' );
	if ( $disable_responsive !== '1' ) {
		$classes[] = 'vc_responsive';
	} else {
		$classes[] = 'vc_non_responsive';
	}

	return $classes;
}

/**
 * @todo check for usage, \Vc_Base::jsForceSend
 *
 * @param $args
 *
 * @since 4.2
 * @return array
 */
function wpb_js_force_send( $args ) {
	$args['send'] = true;

	return $args;
}

/**
 * @deprecated and will be removed
 * @since 4.2
 * @return int
 */
function vc_get_interface_version() {
	return 2;
}

/**
 * @deprecated and will be removed.
 * @since 4.2
 * @return int
 */
function vc_get_initerface_version() {
	return vc_get_interface_version();
}

/**
 * @param $m
 *
 * @since 4.2
 * @return string
 */
function vc_convert_shortcode( $m ) {
	list( $output, $m_one, $tag, $attr_string, $m_four, $content ) = $m;
	$result = $width = $el_position = '';
	$shortcode_attr = shortcode_parse_atts( $attr_string );
	extract( shortcode_atts( array(
		'width' => '1/1',
		'el_class' => '',
		'el_position' => ''
	), $shortcode_attr ) );
	if ( $tag == 'vc_row' ) {
		return $output;
	}
	// Start
	if ( preg_match( '/first/', $el_position ) || empty( $shortcode_attr['width'] ) || $shortcode_attr['width'] === '1/1' ) {
		$result = '[vc_row]';
	}
	if ( $tag != 'vc_column' ) {
		$result .= "\n" . '[vc_column width="' . $width . '"]';
	}

	// Tag
	$pattern = get_shortcode_regex();
	if ( $tag == 'vc_column' ) {
		$result .= "[{$m_one}{$tag} {$attr_string}]" . preg_replace_callback( "/{$pattern}/s", 'vc_convert_inner_shortcode', $content ) . "[/{$tag}{$m_four}]";
	} elseif ( $tag == 'vc_tabs' || $tag == 'vc_accordion' || $tag == 'vc_tour' ) {
		$result .= "[{$m_one}{$tag} {$attr_string}]" . preg_replace_callback( "/{$pattern}/s", 'vc_convert_tab_inner_shortcode', $content ) . "[/{$tag}{$m_four}]";
	} else {
		$result .= preg_replace( '/(\"\d\/\d\")/', '"1/1"', $output );
	}

	// $content = preg_replace_callback( "/{$pattern}/s", 'vc_convert_inner_shortcode', $content );

	// End
	if ( $tag != 'vc_column' ) {
		$result .= '[/vc_column]';
	}
	if ( preg_match( '/last/', $el_position ) || empty( $shortcode_attr['width'] ) || $shortcode_attr['width'] === '1/1' ) {
		$result .= '[/vc_row]' . "\n";
	}

	return $result;
}

/**
 * @param $m
 *
 * @since 4.2
 * @return string
 */
function vc_convert_tab_inner_shortcode( $m ) {
	list( $output, $m_one, $tag, $attr_string, $m_four, $content ) = $m;
	$result = $width = $el_position = '';
	extract( shortcode_atts( array(
		'width' => '1/1',
		'el_class' => '',
		'el_position' => ''
	), shortcode_parse_atts( $attr_string ) ) );
	$pattern = get_shortcode_regex();
	$result .= "[{$m_one}{$tag} {$attr_string}]" . preg_replace_callback( "/{$pattern}/s", 'vc_convert_inner_shortcode', $content ) . "[/{$tag}{$m_four}]";

	return $result;
}

/**
 * @param $m
 *
 * @since 4.2
 * @return string
 */
function vc_convert_inner_shortcode( $m ) {
	list( $output, $m_one, $tag, $attr_string, $m_four, $content ) = $m;
	$result = $width = $el_position = '';
	extract( shortcode_atts( array(
		'width' => '1/1',
		'el_class' => '',
		'el_position' => ''
	), shortcode_parse_atts( $attr_string ) ) );
	if ( $width != '1/1' ) {
		if ( preg_match( '/first/', $el_position ) ) {
			$result .= '[vc_row_inner]';
		}
		$result .= "\n" . '[vc_column_inner width="' . $width . '" el_position="' . $el_position . '"]';
		$attr = '';
		foreach ( shortcode_parse_atts( $attr_string ) as $key => $value ) {
			if ( $key == 'width' ) {
				$value = '1/1';
			} elseif ( $key == 'el_position' ) {
				$value = 'first last';
			}
			$attr .= ' ' . $key . '="' . $value . '"';
		}
		$result .= "[{$m_one}{$tag} {$attr}]" . $content . "[/{$tag}{$m_four}]";
		$result .= '[/vc_column_inner]';
		if ( preg_match( '/last/', $el_position ) ) {
			$result .= '[/vc_row_inner]' . "\n";
		}
	} else {
		$result = $output;
	}

	return $result;
}

global $vc_row_layouts;
$vc_row_layouts = array(
	/*
 * How to count mask?
 * mask = column_count . sum of all numbers. Example layout 12_12 mask = (column count=2)(1+2+1+2=6)= 26
*/
	array( 'cells' => '11', 'mask' => '12', 'title' => '1/1', 'icon_class' => 'l_11' ),
	array( 'cells' => '12_12', 'mask' => '26', 'title' => '1/2 + 1/2', 'icon_class' => 'l_12_12' ),
	array( 'cells' => '23_13', 'mask' => '29', 'title' => '2/3 + 1/3', 'icon_class' => 'l_23_13' ),
	array( 'cells' => '13_13_13', 'mask' => '312', 'title' => '1/3 + 1/3 + 1/3', 'icon_class' => 'l_13_13_13' ),
	array(
		'cells' => '14_14_14_14',
		'mask' => '420',
		'title' => '1/4 + 1/4 + 1/4 + 1/4',
		'icon_class' => 'l_14_14_14_14'
	),
	array( 'cells' => '14_34', 'mask' => '212', 'title' => '1/4 + 3/4', 'icon_class' => 'l_14_34' ),
	array( 'cells' => '14_12_14', 'mask' => '313', 'title' => '1/4 + 1/2 + 1/4', 'icon_class' => 'l_14_12_14' ),
	array( 'cells' => '56_16', 'mask' => '218', 'title' => '5/6 + 1/6', 'icon_class' => 'l_56_16' ),
	array(
		'cells' => '16_16_16_16_16_16',
		'mask' => '642',
		'title' => '1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6',
		'icon_class' => 'l_16_16_16_16_16_16'
	),
	array( 'cells' => '16_23_16', 'mask' => '319', 'title' => '1/6 + 4/6 + 1/6', 'icon_class' => 'l_16_46_16' ),
	array(
		'cells' => '16_16_16_12',
		'mask' => '424',
		'title' => '1/6 + 1/6 + 1/6 + 1/2',
		'icon_class' => 'l_16_16_16_12'
	)
);

/**
 * @param $width
 *
 * @since 4.2
 * @return string
 */
function wpb_vc_get_column_width_indent( $width ) {
	$identy = '11';
	if ( $width == 'vc_col-sm-6' ) {
		$identy = '12';
	} elseif ( $width == 'vc_col-sm-3' ) {
		$identy = '14';
	} elseif ( $width == 'vc_col-sm-4' ) {
		$identy = '13';
	} elseif ( $width == 'vc_col-sm-8' ) {
		$identy = '23';
	} elseif ( $width == 'vc_col-sm-2' ) {
		$identy = '16';
	} elseif ( $width == 'vc_col-sm-9' ) {
		$identy = '34';
	} elseif ( $width == 'vc_col-sm-2' ) {
		$identy = '16';
	} elseif ( $width == 'vc_col-sm-10' ) {
		$identy = '56';
	}

	return $identy;
}

/**
 * @since 4.2
 * @return mixed|string|void
 */
function get_row_css_class() {
	$custom = vc_settings()->get( 'row_css_class' );

	return ! empty( $custom ) ? $custom : 'vc_row-fluid';
}

/**
 * @param $class
 *
 * @since 4.2
 * @return string
 */
function get_custom_column_class( $class ) {
	$custom_array = (array) vc_settings()->get( 'column_css_classes' );

	return ! empty( $custom_array[ $class ] ) ? $custom_array[ $class ] : '';
}

/* Make any HEX color lighter or darker
---------------------------------------------------------- */
/**
 * @param $colour
 * @param $per
 *
 * @since 4.2
 * @return string
 */
function vc_colorCreator( $colour, $per ) {
	$colour = substr( $colour, 1 ); // Removes first character of hex string (#)
	$rgb = ''; // Empty variable
	$per = $per / 100 * 255; // Creates a percentage to work with. Change the middle figure to control colour temperature

	if ( $per < 0 ) // Check to see if the percentage is a negative number
	{
		// DARKER
		$per = abs( $per ); // Turns Neg Number to Pos Number
		for ( $x = 0; $x < 3; $x ++ ) {
			$c = hexdec( substr( $colour, ( 2 * $x ), 2 ) ) - $per;
			$c = ( $c < 0 ) ? 0 : dechex( $c );
			$rgb .= ( strlen( $c ) < 2 ) ? '0' . $c : $c;
		}
	} else {
		// LIGHTER
		for ( $x = 0; $x < 3; $x ++ ) {
			$c = hexdec( substr( $colour, ( 2 * $x ), 2 ) ) + $per;
			$c = ( $c > 255 ) ? 'ff' : dechex( $c );
			$rgb .= ( strlen( $c ) < 2 ) ? '0' . $c : $c;
		}
	}

	return '#' . $rgb;
}

/* HEX to RGB converter
---------------------------------------------------------- */
/**
 * @param $color
 *
 * @since 4.2
 * @return array|bool
 */
function vc_hex2rgb( $color ) {
	if ( ! empty( $color ) && $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	if ( strlen( $color ) == 6 ) {
		list( $r, $g, $b ) = array(
			$color[0] . $color[1],
			$color[2] . $color[3],
			$color[4] . $color[5]
		);
	} elseif ( strlen( $color ) == 3 ) {
		list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return false;
	}

	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );

	return array( $r, $g, $b );
}

/**
 * Parse string like "title:Hello world|weekday:Monday" to array('title' => 'Hello World', 'weekday' => 'Monday')
 *
 * @param $value
 * @param array $default
 *
 * @since 4.2
 * @return array
 */
function vc_parse_multi_attribute( $value, $default = array() ) {
	$result = $default;
	$params_pairs = explode( '|', $value );
	foreach ( $params_pairs as $pair ) {
		$param = preg_split( '/\:/', $pair );
		if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
			$result[ $param[0] ] = rawurldecode( $param[1] );
		}
	}

	return $result;
}

/**
 * @param $string
 *
 * @since 4.2
 * @return string
 */
function wpb_stripslashes_if_gpc_magic_quotes( $string ) {
	if ( get_magic_quotes_gpc() ) {
		return stripslashes( $string );
	} else {
		return $string;
	}
}

/**
 * @param $v
 *
 * @since 4.2
 * @return string
 */
function vc_param_options_parse_values( $v ) {
	return rawurldecode( $v );
}

/**
 * @param $name
 * @param $settings
 *
 * @since 4.2
 * @return bool
 */
function vc_param_options_get_settings( $name, $settings ) {
	foreach ( $settings as $params ) {
		if ( isset( $params['name'] ) && $params['name'] === $name && isset( $params['type'] ) ) {
			return $params;
		}
	}

	return false;
}

/**
 * @param $atts
 *
 * @since 4.2
 * @return string
 */
function vc_convert_atts_to_string( $atts ) {
	$output = '';
	foreach ( $atts as $key => $value ) {
		$output .= ' ' . $key . '="' . $value . '"';
	}

	return $output;
}

/**
 * @param $string
 * @param $tag
 * @param $param
 *
 * @since 4.2
 * @return array
 */
function vc_parse_options_string( $string, $tag, $param ) {
	$options = $option_settings_list = array();
	$settings = WPBMap::getParam( $tag, $param );

	foreach ( preg_split( '/\|/', $string ) as $value ) {
		if ( preg_match( '/\:/', $value ) ) {
			$split = preg_split( '/\:/', $value );
			$option_name = $split[0];
			$option_settings = $option_settings_list[ $option_name ] = vc_param_options_get_settings( $option_name, $settings['options'] );
			if ( isset( $option_settings['type'] ) && $option_settings['type'] === 'checkbox' ) {
				$option_value = array_map( 'vc_param_options_parse_values', preg_split( '/\,/', $split[1] ) );
			} else {
				$option_value = rawurldecode( $split[1] );
			}
			$options[ $option_name ] = $option_value;
		}

	}
	if ( isset( $settings['options'] ) ) {
		foreach ( $settings['options'] as $setting_option ) {
			if ( $setting_option['type'] !== 'separator' && isset( $setting_option['value'] ) && empty( $options[ $setting_option['name'] ] ) ) {
				$options[ $setting_option['name'] ] = $setting_option['type'] === 'checkbox' ? preg_split( '/\,/', $setting_option['value'] ) : $setting_option['value'];
			}
			if ( isset( $setting_option['name'] ) && isset( $options[ $setting_option['name'] ] ) && isset( $setting_option['value_type'] ) ) {
				if ( $setting_option['value_type'] === 'integer' ) {
					$options[ $setting_option['name'] ] = (int) $options[ $setting_option['name'] ];
				} elseif ( $setting_option['value_type'] === 'float' ) {
					$options[ $setting_option['name'] ] = (float) $options[ $setting_option['name'] ];
				} elseif ( $setting_option['value_type'] === 'boolean' ) {
					$options[ $setting_option['name'] ] = (boolean) $options[ $setting_option['name'] ];
				}
			}
		}
	}

	return $options;
}

/**
 * @since 4.2
 */
function wpb_js_composer_check_version_schedule_deactivation() {
	wp_clear_scheduled_hook( 'wpb_check_for_update' );
	delete_option( 'wpb_js_composer_show_new_version_message' );
}

/**
 * Helper function to add new third-party adaptation class.
 *
 * @since 4.3
 *
 * @param Vc_Vendor_Interface $vendor - instance of class.
 */
function vc_add_vendor( Vc_Vendor_Interface $vendor ) {
	visual_composer()->vendorsManager()->add( $vendor );
}

/**
 * Convert string to a valid css class name.
 *
 * @since 4.3
 *
 * @param string $class
 *
 * @return string
 */
function vc_build_safe_css_class( $class ) {
	return preg_replace( '/\W+/', '', strtolower( str_replace( " ", "_", strip_tags( $class ) ) ) );
}

/**
 * Include template from templates dir.
 *
 * @since 4.3
 *
 * @param $template
 * @param array $variables - passed variables to the template.
 *
 * @param bool $once
 *
 * @return mixed
 */
function vc_include_template( $template, $variables = array(), $once = false ) {
	is_array( $variables ) && extract( $variables );
	if ( $once ) {
		return require_once vc_template( $template );
	} else {
		return require vc_template( $template );
	}
}

/**
 * Output template from templates dir.
 *
 * @since 4.4
 *
 * @param $template
 * @param array $variables - passed variables to the template.
 *
 * @param bool $once
 *
 * @return string
 */
function vc_get_template( $template, $variables = array(), $once = false ) {
	ob_start();
	vc_include_template( $template, $variables, $once );

	return ob_get_clean();
}

/**
 * if php version < 5.3 this function is required.
 */
if ( function_exists( 'lcfirst' ) === false ) {
	/**
	 * @param $str
	 *
	 * @since 4.3, fix #1093
	 * @return mixed
	 */
	function lcfirst( $str ) {
		$str[0] = mb_strtolower( $str[0] );

		return $str;
	}
}
/**
 * VC Convert a value to studly caps case.
 *
 * @since 4.3
 *
 * @param  string $value
 *
 * @return string
 */
function vc_studly( $value ) {
	$value = ucwords( str_replace( array( '-', '_' ), ' ', $value ) );

	return str_replace( ' ', '', $value );
}

/**
 * VC Convert a value to camel case.
 *
 * @since 4.3
 *
 * @param  string $value
 *
 * @return string
 */
function vc_camel_case( $value ) {
	return lcfirst( vc_studly( $value ) );
}

/**
 * Enqueue icon element font
 * @todo move to separate folder
 * @since 4.4
 *
 * @param $font
 */
function vc_icon_element_fonts_enqueue( $font ) {
	switch ( $font ) {
		case 'fontawesome':
			wp_enqueue_style( 'font-awesome' );
			break;
		case 'openiconic':
			wp_enqueue_style( 'vc_openiconic' );
			break;
		case 'typicons':
			wp_enqueue_style( 'vc_typicons' );
			break;
		case 'entypo':
			wp_enqueue_style( 'vc_entypo' );
			break;
		case 'linecons':
			wp_enqueue_style( 'vc_linecons' );
			break;
		default:
			do_action( 'vc_enqueue_font_icon_element', $font ); // hook to custom do enqueue style
	}
}

/**
 * Function merges defaults attributes in attributes by keeping it values
 *
 * Example
 *      array defaults     |   array attributes     |    result array
 *      'color'=>'black',         -                   'color'=>'black',
 *      'target'=>'_self',      'target'=>'_blank',   'target'=>'_blank',
 *             -                'link'=>'google.com'  'link'=>'google.com'
 *
 * @since 4.4
 *
 * @param array $defaults
 * @param array $attributes
 *
 * @return array - merged attributes
 */
function vc_shortcode_attribute_parse( $defaults = array(), $attributes = array() ) {
	$atts = $attributes + shortcode_atts( $defaults, $attributes );

	return $atts;
}
