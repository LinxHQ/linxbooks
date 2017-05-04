<?php
/**
 * Gte woocommerce data
 *
 * @param $value
 * @param $data
 *
 * @return string
 */
function vc_gitem_template_attribute_acf( $value, $data ) {
	$label = '';
	/**
	 * @var null|Wp_Post $post ;
	 * @var string $data ;
	 */
	extract( array_merge( array(
		'post' => null,
		'data' => ''
	), $data ) );
	if ( preg_match( '/_labeled$/', $data ) ) {
		$data  = preg_replace( '/_labeled$/', '', $data );
		$field = apply_filters( 'acf/load_field', array(), $data );
		$label = is_array( $field ) ? '<span class="vc_gite-acf-label">' . $field['label'] . ':</span> ' : '';
	}

	if ( get_field( $data ) ) {
		$value = apply_filters( 'vc_gitem_template_attribute_acf_value', get_field( $data, $post->ID ) );
	}
	return strlen( $value ) > 0 ? $label . $value : '';
}

add_filter( 'vc_gitem_template_attribute_acf', 'vc_gitem_template_attribute_acf', 10, 2 );
