<?php
/**
 * @var string $content ;
 * @var string $el_class
 * @var string $css ;
 * @var WPBakeryShortCode_VC_Gitem_Zone $this ;
 * @var array $atts ;
 * @var string $position ;
 * @var string $bgimage ;
 * @var string $height ;
 * @var string $link ;
 * @var string $url ;
 */
$tag_attr = $extend = $content_bg = $css_style_bg = $attr_bg = $css_style = '';
$atts = shortcode_atts( array(
	'el_class' => '',
	'css' => '',
	'position' => '',
	'bgimage' => '',
	'height' => '',
	'link' => '',
	'url' => '',
	'height_mode' => '',
	'height' => '',
), $atts );
extract( $atts );
// Set css classes for shortcode main html element wrapper and backgrtound block
$css_class = 'vc_gitem-zone'
             . ( strlen( $this->zone_name ) ? ' vc_gitem-zone-' . $this->zone_name : '' )
             . ( strlen( $el_class ) ? ' ' . $el_class : '' )
             . ( strlen( $position ) ? ' vc_gitem-zone-position-' . $position : '' )
             . ( strlen( $height_mode ) ? ' vc-gitem-zone-height-mode-' . $height_mode : '' );
$css_class_mini = 'vc_gitem-zone-mini';
$css_class_bg = 'vc_gitem-zone-bgimage';
/*
if ( $bgimage === 'featured' ) {
	// $css_style = 'background-image: url(\'{{ post_image_url }}\');';
	// $css_class .= ' vc_grid-item-background-cover';
}
*/
if ( 'custom' === $height_mode ) {
	if ( strlen( $height ) > 0 ) {
		$css_style_bg .= 'height: ' . $height . ';';
	}
} elseif ( 'original' === $height_mode ) {
	$extend = '<img src="{{ post_image_url }}">';
} elseif ( strlen( $height_mode ) > 0 ) {
	$css_style_bg .= 'background-image: url({{ post_image_url }}); height: left: 0; top: 0; bottom: 0; right: 0;';
}
if ( strlen( $link ) > 0 ) {
	$css_class .= ' vc_gitem-is-link';
	if ( 'custom' === $link && !empty( $url ) ) {
		$link_s = vc_build_link( $url );
		$attr_bg = ' data-vc-link="' . esc_attr( $link_s['url'] ) . '"'
		           . ' data-vc-target="' . esc_attr( trim( $link_s['target'] ) ) . '"'
		           . ' title="' . esc_attr( $link_s['title'] ) . '"';
	} elseif ( 'post_link' === $link ) {
		$attr_bg = ' data-vc-link="{{ post_link_url }}"';
	} elseif ( 'image' === $link ) {
		$attr_bg = ' data-vc-link="{{ post_image_url }}"';
	} elseif ( 'image_lightbox' === $link ) {
		$css_class_bg = ' prettyphoto';
	}
}
?>

<div<?php echo $tag_attr ?> class="<?php echo esc_attr( $css_class ) ?>"<?php
echo( empty( $css_style ) ? '' : ' style="' . esc_attr( $css_style ) . '"' )
?>>
	<div class="<?php echo esc_attr( $css_class_mini ) ?>">
		<?php echo $extend ?>
		<div class="<?php echo esc_attr( vc_shortcode_custom_css_class( $css, ' ' ) ) ?>">
			<?php echo do_shortcode( $content ) ?>
		</div>
	</div>
</div>