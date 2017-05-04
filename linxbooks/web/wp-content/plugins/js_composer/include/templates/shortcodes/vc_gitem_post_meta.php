<?php
/**
 * @var array $atts ;
 * @var string $field_key ;
 * @var string $el_class ;
 * @var string $align ;
 * @var string $label ;
 */
$label_html = '';
extract( shortcode_atts( array(
	'key' => '',
	'custom_field_key' => '',
	'el_class' => '',
	'align' => '',
	'label' => '',
), $atts ) );

$css_class = 'vc_gitem-post-meta-field-' . $key
             . ( strlen( $el_class ) ? ' ' . $el_class : '' )
             . ( strlen( $align ) ? ' vc_gitem-align-' . $align : '' );
if ( strlen( $label ) ) {
	$label_html = '<span class="vc_gitem-post-meta-label">' . esc_html( $label ) . '</span>';
}
if ( strlen( $key ) ):
	?>
	<div class="<?php echo esc_attr( $css_class ) ?>"><?php echo $label_html ?> {{
		post_meta_value:<?php echo esc_attr( $key ) ?> }}
	</div>
<?php endif;