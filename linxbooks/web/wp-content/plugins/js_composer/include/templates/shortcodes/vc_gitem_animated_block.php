<?php
/**
 * @var string $el_class
 * @var string $width
 * @var string $is_end
 * @var array $atts ;
 * @var string $content ;
 * @var array $atts ;
 * @var string bgimage;
 */
$animation_attr = '';
extract( shortcode_atts( array(
	'css' => '',
	'animation' => '',
	'bgimage' => '',
), $atts ) );
$css_style = '';
$css_class = 'vc_gitem-animated-block' . vc_shortcode_custom_css_class( $css, ' ' );
if ( !empty( $animation ) ) {
	$css_class .= ' vc_gitem-animate vc_gitem-animate-' . $animation;
	$animation_attr .= ' data-vc-animation="' . esc_attr( $animation ) . '"';
} elseif( 'vc_gitem_preview' !== vc_request_param( 'action' )) {
	$content = preg_replace( '/(?<=\[)(vc_gitem_zone_b\b)/', '$1 render="no"', $content );
}
if ( $bgimage === 'featured' ) {
	$css_style = 'background-image: url(\'{{ post_image_url }}\');';
	$css_class .= ' vc_grid-item-background-cover';
}
?>
<div class="<?php echo esc_attr( $css_class ) ?>"<?php echo $animation_attr ?><?php
echo( empty( $css_style ) ? '' : ' style="' . esc_attr( $css_style ) . '"' )
?>><?php echo do_shortcode( $content ) ?></div>
