<?php
/**
** A base module for [count], Twitter-like character count
**/

/* Shortcode handler */

add_action( 'wpcf7_init', 'wpcf7_add_shortcode_count' );

function wpcf7_add_shortcode_count() {
	wpcf7_add_shortcode( 'count', 'wpcf7_count_shortcode_handler', true );
}

function wpcf7_count_shortcode_handler( $tag ) {
	$tag = new WPCF7_Shortcode( $tag );

	if ( empty( $tag->name ) ) {
		return '';
	}

	$target = wpcf7_scan_shortcode( array( 'name' => $tag->name ) );
	$maxlength = $minlength = null;

	if ( $target ) {
		$target = new WPCF7_Shortcode( $target[0] );
		$maxlength = $target->get_maxlength_option();
		$minlength = $target->get_minlength_option();

		if ( $maxlength && $minlength && $maxlength < $minlength ) {
			$maxlength = $minlength = null;
		}
	}

	if ( $tag->has_option( 'down' ) ) {
		$value = (int) $maxlength;
		$class = 'wpcf7-character-count down';
	} else {
		$value = '0';
		$class = 'wpcf7-character-count up';
	}

	$atts = array();
	$atts['id'] = $tag->get_id_option();
	$atts['class'] = $tag->get_class_option( $class );
	$atts['data-target-name'] = $tag->name;
	$atts['data-starting-value'] = $value;
	$atts['data-current-value'] = $value;
	$atts['data-maximum-value'] = $maxlength;
	$atts['data-minimum-value'] = $minlength;
	$atts = wpcf7_format_atts( $atts );

	$html = sprintf( '<span %1$s>%2$s</span>', $atts, $value );

	return $html;
}

?>