<?php
/**
* @var string $el_class
* @var string $background_color
* @var string $float
*/
$atts = shortcode_atts(array(
'el_class' => '',
'background_color' => '',
'float' => 'none'
), $atts);
extract($atts);
if(!empty($background_color)) {
	$background_color = ' vc_bg-' . $background_color;
}
echo '<div class="vc_gitem-block' . $background_color
			. ( strlen( $el_class ) > 0 ? ' ' . $el_class : '' )
			. ' vc_gitem-float-' . $float
	. '">'
	. do_shortcode( $content ) . '</div>';