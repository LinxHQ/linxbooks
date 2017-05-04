<?php
/** @var WPBakeryShortCode_VC_Basic_Grid $this */

$isotope_options = $posts = $filter_terms = array();

$this->buildAtts( $atts, $content );
$css_classes = ' ' . $this->shortcode;
wp_enqueue_script( 'prettyphoto' );
wp_enqueue_style( 'prettyphoto' );
// $isotope_options = $this->isotopeOptions( $layout, 'vertical' );
/*
if ( $this->atts['style'] == 'lazy' || $this->atts['style'] == 'load-more' ) {
	$this->buildItems();
}
*/
$this->buildGridSettings();
if ( $this->atts['style'] == 'pagination' ) {
	wp_enqueue_script( 'twbs-pagination' );
}
$this->enqueueScripts();
?>
<!-- vc_grid start -->
<div class="vc_grid-container wpb_content_element<?php echo esc_attr( $css_classes ) ?>" data-vc-<?php echo $this->pagable_type ?>-settings="<?php echo esc_attr( json_encode( $this->grid_settings ) ) ?>" data-vc-request="<?php echo esc_attr( admin_url( 'admin-ajax.php', 'relative' ) ) ?>" data-vc-post-id="<?php echo esc_attr(get_the_ID()) ?>">
</div><!-- vc_grid end -->
