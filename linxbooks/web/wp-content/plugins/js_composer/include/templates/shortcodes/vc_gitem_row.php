<?php
/**
 * @var string $content ;
 * @var string $css ;
 * @var string $position ;
 * @var string $el_class ;
 * @var array $atts ;
 */
extract( shortcode_atts( array(
	'css'      => '',
	'el_class' => '',
	'position' => 'top'
), $atts ));
$css_class = 'vc_gitem_row vc_row'
             . ( strlen( $el_class ) ? ' ' . $el_class : '' )
             . vc_shortcode_custom_css_class( $css, ' ' )
             . ( $position ? ' vc_gitem-row-position-' . $position : '' );
echo '<div class="' . $css_class . '">' . do_shortcode( $content ) . '</div>';