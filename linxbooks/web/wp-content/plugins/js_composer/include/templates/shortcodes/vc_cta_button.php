<?php
$output = $color = $icon = $size = $target = $href = $title = $call_text = $position = $el_class = '';
extract( shortcode_atts( array(
	'color' => 'wpb_button',
	'icon' => 'none',
	'size' => '',
	'target' => '',
	'href' => '',
	'title' => __( 'Text on the button', "js_composer" ),
	'call_text' => '',
	'position' => 'cta_align_right',
	'el_class' => '',
	'css_animation' => ''
), $atts ) );

$el_class = $this->getExtraClass( $el_class );

if ( $target == 'same' || $target == '_self' ) {
	$target = '';
}
if ( $target != '' ) {
	$target = ' target="' . $target . '"';
}

$icon = ( $icon != '' && $icon != 'none' ) ? ' ' . $icon : '';
$i_icon = ( $icon != '' ) ? ' <i class="icon"> </i>' : '';

$color = ( $color != '' ) ? ' wpb_' . $color : '';
$size = ( $size != '' && $size != 'wpb_regularsize' ) ? ' wpb_' . $size : ' ' . $size;

$a_class = '';
if ( $el_class != '' ) {
	$tmp_class = explode( " ", $el_class );
	if ( in_array( "prettyphoto", $tmp_class ) ) {
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );
		$a_class .= ' prettyphoto';
		$el_class = str_ireplace( "prettyphoto", "", $el_class );
	}
}

if ( $href != '' ) {
	$button = '<span class="wpb_button ' . $color . $size . $icon . '">' . $title . $i_icon . '</span>';
	$button = '<a class="wpb_button_a' . $a_class . '" href="' . $href . '"' . $target . '>' . $button . '</a>';
} else {
	//$button = '<button class="wpb_button '.$color.$size.$icon.'">'.$title.$i_icon.'</button>';
	$button = '';
	$el_class .= ' cta_no_button';
}
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_call_to_action wpb_content_element vc_clearfix ' . $position . $el_class, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation( $css_animation );

$output .= '<div class="' . $css_class . '">';
if ( $position != 'cta_align_bottom' ) $output .= $button;
$output .= apply_filters( 'wpb_cta_text', '<h2 class="wpb_call_text">' . $call_text . '</h2>', array( 'content' => $call_text ) );
//$output .= '<h2 class="wpb_call_text">'. $call_text . '</h2>';
if ( $position == 'cta_align_bottom' ) $output .= $button;
$output .= '</div> ' . $this->endBlockComment( '.wpb_call_to_action' ) . "\n";

echo $output;