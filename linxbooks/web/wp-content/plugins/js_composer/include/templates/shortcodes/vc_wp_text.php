<?php
$output = $title = $el_class = $text = $filter = '';
extract( shortcode_atts( array(
	'title' => '',
	'text' => '',
	'filter' => true,
	'el_class' => ''
), $atts ) );
$atts['filter'] = true; //Hack to make sure that <p> added

$el_class = $this->getExtraClass( $el_class );

$output = '<div class="vc_wp_text wpb_content_element' . $el_class . '">';
$type = 'WP_Widget_Text';
$args = array();
if ( strlen( $content ) > 0 ) $atts['text'] = $content;
ob_start();
the_widget( $type, $atts, $args );
$output .= ob_get_clean();

$output .= '</div>' . $this->endBlockComment( 'vc_wp_text' ) . "\n";

echo $output;