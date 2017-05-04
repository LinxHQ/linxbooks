<?php
$output = $el_class = '';
extract(shortcode_atts(array(
	'type'                 => 'line', 
	'el_class'             => ''
), $atts));
 

wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass($el_class);

$output .='<hr class="'.$type.' '.$el_class.'">';

echo $output;