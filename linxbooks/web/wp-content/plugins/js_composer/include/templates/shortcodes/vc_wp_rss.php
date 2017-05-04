<?php
$output = $title = $url = $items = $options = $el_class = '';
extract( shortcode_atts( array(
	'title' => '',
	'url' => '',
	'items' => 10,
	'options' => '',
	'el_class' => ''
), $atts ) );
if ( $url == '' ) return;
$atts['title'] = $title;
$atts['items'] = $items;

$options = explode( ",", $options );
if ( in_array( "show_summary", $options ) ) $atts['show_summary'] = true;
if ( in_array( "show_author", $options ) ) $atts['show_author'] = true;
if ( in_array( "show_date", $options ) ) $atts['show_date'] = true;

$el_class = $this->getExtraClass( $el_class );

$output = '<div class="vc_wp_rss wpb_content_element' . $el_class . '">';
$type = 'WP_Widget_RSS';
$args = array();

ob_start();
the_widget( $type, $atts, $args );
$output .= ob_get_clean();

$output .= '</div>' . $this->endBlockComment( 'vc_wp_rss' ) . "\n";

echo $output;