<?php
$output = $category = $orderby = $options = $el_class = '';
extract( shortcode_atts( array(
	'category' => false,
	'orderby' => 'name',
	'options' => '',
	'limit' => - 1,
	'el_class' => ''
), $atts ) );
$options = explode( ",", $options );
if ( in_array( "images", $options ) ) $atts['images'] = true;
if ( in_array( "name", $options ) ) $atts['name'] = true;
if ( in_array( "description", $options ) ) $atts['description'] = true;
if ( in_array( "rating", $options ) ) $atts['rating'] = true;

$el_class = $this->getExtraClass( $el_class );

$output = '<div class="vc_wp_links wpb_content_element' . $el_class . '">';
$type = 'WP_Widget_Links';
$args = array();

ob_start();
the_widget( $type, $atts, $args );
$output .= ob_get_clean();

$output .= '</div>' . $this->endBlockComment( 'vc_wp_links' ) . "\n";

echo $output;