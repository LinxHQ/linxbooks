<?php
/**
 * @var string $width ;
 * @var string $align ;
 * @var string $content ;
 * @var array $atts ;
 * @var array $css ;
 * @var array $el_class ;
 * @var array $featured_image ;
 * */
$atts = shortcode_atts( array(
	'width' => '1/1',
	'align' => 'left',
	'css' => '',
	'el_class' => '',
	'featured_image' => '',
), $atts );
extract( $atts );
$style = '';
$width = wpb_translateColumnWidthToSpan( $width );
$css_class = $width
             . ( strlen( $el_class ) ? ' ' . $el_class : '' )
             . ' vc_gitem-col vc_gitem-col-align-' . $align
             . vc_shortcode_custom_css_class( $css, ' ' );

if ( 'yes' === $featured_image ) {
    $style = "{{ post_image_background_image_css }}";
}
echo '<div class="' . $css_class . '"'
     . ( strlen( $style ) > 0 ? ' style="' . $style . '"' : '' )
     . '>'
     . do_shortcode( $content )
     . '</div>';