<?php
$output = $el_class = $width = '';
extract( shortcode_atts( array(
	'el_class' => '',
), $atts ) );

$el_class = $this->getExtraClass( $el_class );

echo '<div class="vc_items' . $el_class . '">' . __( 'Item', "js_composer" ) . '</div>';
