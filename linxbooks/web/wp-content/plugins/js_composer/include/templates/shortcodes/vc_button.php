<?php
$output = $color = $size = $icon = $target = $href = $el_class = $title = $position = '';
extract( shortcode_atts( array(
	'color' => 'wpb_button',
	'size' => '',
	'icon' => 'none',
	'target' => '_self',
	'href' => '',
	'el_class' => '',
	'title' => __( 'Text on the button', "js_composer" ),
	'position' => ''
), $atts ) );
$a_class = '';

if ( $el_class != '' ) {
	$tmp_class = explode( " ", strtolower( $el_class ) );
	$tmp_class = str_replace( ".", "", $tmp_class );
	if ( in_array( "prettyphoto", $tmp_class ) ) {
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );
		$a_class .= ' prettyphoto';
		$el_class = str_ireplace( "prettyphoto", "", $el_class );
	}
	if ( in_array( "pull-right", $tmp_class ) && $href != '' ) {
		$a_class .= ' pull-right';
		$el_class = str_ireplace( "pull-right", "", $el_class );
	}
	if ( in_array( "pull-left", $tmp_class ) && $href != '' ) {
		$a_class .= ' pull-left';
		$el_class = str_ireplace( "pull-left", "", $el_class );
	}
}

if ( $target == 'same' || $target == '_self' ) {
	$target = '';
}
$target = ( $target != '' ) ? ' target="' . $target . '"' : '';

$color = ( $color != '' ) ? ' wpb_' . $color : '';
$size = ( $size != '' && $size != 'wpb_regularsize' ) ? ' wpb_' . $size : ' ' . $size;
$icon = ( $icon != '' && $icon != 'none' ) ? ' ' . $icon : '';
$i_icon = ( $icon != '' ) ? ' <i class="icon"> </i>' : '';
$position = ( $position != '' ) ? ' ' . $position . '-button-position' : '';
$el_class = $this->getExtraClass( $el_class );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_button ' . $color . $size . $icon . $el_class . $position, $this->settings['base'], $atts );

if ( $href != '' ) {
	$output .= '<span class="' . $css_class . '">' . $title . $i_icon . '</span>';
	$output = '<a class="wpb_button_a' . $a_class . '" title="' . $title . '" href="' . $href . '"' . $target . '>' . $output . '</a>';
} else {
	$output .= '<button class="' . $css_class . '">' . $title . $i_icon . '</button>';

}

echo $output . $this->endBlockComment( 'button' ) . "\n";