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
 * @var string $featured_image ;
 */
$css_style = $css_style_mini = $attr = '';
$image_block = '';
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
	'featured_image' => '',
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
// Autoheight Mode
// http://jsfiddle.net/tL2pgtyb/4/ {{
// Set css classes for shortcode main html element wrapper and backgrtound block
$css_class .= vc_shortcode_custom_css_class( $css, ' ' )
              . ( strlen( $el_class ) ? ' ' . $el_class : '' );
preg_match( '/background(\-image)?\s*\:\s*[^\s]*?\s*url\(\'?([^\)]+)\'?\)/', $css, $img_matches );
$background_image_css_editor = isset( $img_matches[2] ) ? $img_matches[2] : false;
if ( 'custom' === $height_mode ) {
	if ( strlen( $height ) > 0 ) {
		if(preg_match('/^\d+$/', $height)) {
			$height .= 'px';
		}
		$css_style .= 'height: ' . $height . ';';
	}
} elseif ( 'original' !== $height_mode) {
	$css_class .= ' vc-gitem-zone-height-mode-auto'
	              . ( strlen( $height_mode ) > 0 ? ' vc-gitem-zone-height-mode-auto-' . $height_mode : '' );
}
if ( 'yes' === $featured_image ) {
	$css_style .= "{{ post_image_background_image_css }}";
	$image_block = '<img src="{{ post_image_url'
	               . ( false !== $background_image_css_editor ? ':' . rawurlencode( $background_image_css_editor ) . '' : '' )
	               . ' }}" class="vc_gitem-zone-img">';
} elseif ( false !== $background_image_css_editor ) {
	$image_block = '<img src="' . esc_attr( $background_image_css_editor ) . '" class="vc_gitem-zone-img">';
}
if ( strlen( $link ) > 0 && 'none' !== $link ) {
	$css_class .= ' vc_gitem-is-link';
	if ( 'custom' === $link && !empty( $url ) ) {
		$link_s = vc_build_link( $url );
		$attr = ' data-vc-link="' . esc_attr( $link_s['url'] ) . '"'
		           . ' data-vc-target="' . esc_attr( trim($link_s['target']) ) . '"'
		           . ' title="' . esc_attr( $link_s['title'] ) . '"';
	} elseif ( 'post_link' === $link ) {
		$attr = ' data-vc-link="{{ post_link_url }}"';
	} elseif ( 'image' === $link ) {
		$attr = ' data-vc-link="{{ post_image_url }}"';
	} elseif ( 'image_lightbox' === $link ) {
		if ( ! isset( $this->prettyphoto_rel ) ) {
			$this->prettyphoto_rel = ' rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';
		}
		$image_block .= '<a href="{{ post_image_url }}" title="{{ post_title }}" ' . $this->prettyphoto_rel . ' data-vc-gitem-zone="prettyphotoLink" class="prettyphoto vc-prettyphoto-link"></a>';
	}
}
?>
<div<?php echo $attr ?> class="<?php echo esc_attr( $css_class ) ?>"<?php
echo( empty( $css_style ) ? '' : ' style="' . esc_attr( $css_style ) . '"' )
?>>
	<?php echo $image_block ?>
	<div class="<?php echo esc_attr( $css_class_mini ) ?>"<?php
	echo( empty( $css_style_mini ) ? '' : ' style="' . esc_attr( $css_style_mini ) . '"' )
	?>>
		<?php echo do_shortcode( $content ) ?>
	</div>
</div>
