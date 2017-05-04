<?php
$type = $params = $annotation = '';
extract(shortcode_atts(array(
	'type' => 'horizontal'
), $atts));

$params .= ( $type != '' ) ? ' size="'.$type.'" ' : '';
$params .= ( $annotation != '' ) ? ' annotation="'.$annotation.'"' : '';
$url = rawurlencode(get_permalink());
if ( has_post_thumbnail() ) {
	$img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
	$media = ( is_array($img_url) ) ? '&amp;media='.rawurlencode($img_url[0]) : '';
} else {
	$media = '';
}
$description = ( get_the_excerpt() != '' ) ? '&amp;description='.rawurlencode(strip_tags(get_the_excerpt())) : '';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_pinterest wpb_content_element wpb_pinterest_type_' . $type, $this->settings['base'], $atts );
$output .=  '<div class="'.$css_class.'">';
$output .= '<a href="http://pinterest.com/pin/create/button/?url='.$url.$media.$description.'" class="pin-it-button" count-layout="'.$type.'"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
$output .= '</div>'.$this->endBlockComment('wpb_pinterest')."\n";

echo $output;