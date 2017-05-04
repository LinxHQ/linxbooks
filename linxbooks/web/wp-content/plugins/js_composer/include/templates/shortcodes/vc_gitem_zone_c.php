<?php
/**
 * @var string $content ;
 * @var string $el_class
 * @var string $css ;
 * @var WPBakeryShortCode_VC_Gitem_Zone $this ;
 */
$image_block = '';
$atts = shortcode_atts( array(
	'el_class' => '',
	'css' => '',
	'render' => '',
), $atts );
extract( $atts );
if($render === 'no') {
	echo '';
	return;
}
$css_class = 'vc_gitem-zone'
             . ( strlen( $this->zone_name ) ? ' vc_gitem-zone-' . $this->zone_name : '' );
$css_class_mini = 'vc_gitem-zone-mini';
$css_class .= vc_shortcode_custom_css_class( $css, ' ' );
?>
<div class="<?php echo esc_attr( $css_class ) ?>">
	<div class="<?php echo esc_attr( $css_class_mini ) ?>">
		<?php echo do_shortcode( $content ) ?>
	</div>
</div>
