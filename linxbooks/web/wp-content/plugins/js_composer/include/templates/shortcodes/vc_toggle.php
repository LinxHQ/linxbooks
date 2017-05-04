<?php
$output = $title = $el_class = $open = $css_animation = '';

$inverted = false;
/**
 * @var string $title
 * @var string $el_class
 * @var string $style
 * @var string $color
 * @var string $size
 * @var string $open
 * @var string $css_animation
 *
 * @var array $atts
 */
extract( shortcode_atts( array(
	'title' => __( "Click to toggle", "js_composer" ),
	'el_class' => '',
	'style' => 'default',
	'color' => 'default',
	'size' => '',
	'open' => 'false',
	'css_animation' => '',
), $atts ) );

// checking is color inverted
$style = str_replace( '_outline', '', $style, $inverted );
/**
 * class wpb_toggle removed since 4.4
 * @since 4.4
 */
$elementClass = array(
	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_toggle', $this->settings['base'], $atts ),
	// TODO: check this code, don't know how to get base class names from params
	'style' => 'vc_toggle_' . $style,
	'color' => ( $color ) ? 'vc_toggle_color_' . $color : '',
	'inverted' => ( $inverted ) ? 'vc_toggle_color_inverted' : '',
	'size' => ( $size ) ? 'vc_toggle_size_' . $size : '',
	'open' => ( $open == 'true' ) ? 'vc_toggle_active' : '',
	'extra' => $this->getExtraClass( $el_class ),
	'css_animation' => $this->getCSSAnimation( $css_animation ), // @todo remove getCssAnimation as function in helpers
);

$elementClass = trim( implode( ' ', $elementClass ) );

?>
<div class="<?php echo esc_attr( $elementClass ); ?>">
	<div class="vc_toggle_title"><?php echo apply_filters( 'wpb_toggle_heading', '<h4>' . esc_html( $title ) . '</h4>', array(
			'title' => $title,
			'open' => $open
		) ); ?><i class="vc_toggle_icon"></i></div>
	<div class="vc_toggle_content"><?php echo wpb_js_remove_wpautop( apply_filters( 'the_content', $content ), true ); ?></div>
</div>