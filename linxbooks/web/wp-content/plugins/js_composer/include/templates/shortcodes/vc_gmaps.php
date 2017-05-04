<?php
$output = $title = $link = $size = $zoom = $type = $bubble = $el_class = '';
extract( shortcode_atts( array(
	'title' => '',
	//'link' => 'https://maps.google.com/maps?q=New+York&hl=en&sll=40.686236,-73.995409&sspn=0.038009,0.078192',
	'link' => '<iframe src="https://mapsengine.google.com/map/u/0/embed?mid=z4vjH8i214vQ.kj0Xiukzzle4" width="640" height="480"></iframe>',
	'size' => '',
	'zoom' => 14, //depreceated from 4.0.2
	'type' => 'm', //depreceated from 4.0.2
	'bubble' => '', //depreceated from 4.0.2
	'el_class' => ''
), $atts ) );

if ( $link == '' ) {
	return null;
}
$link = trim( vc_value_from_safe( $link ) );
$bubble = ( $bubble != '' && $bubble != '0' ) ? '&amp;iwloc=near' : '';
$size = str_replace( array( 'px', ' ' ), array( '', '' ), $size );

$el_class = $this->getExtraClass( $el_class );
$el_class .= ( $size == '' ) ? ' vc_map_responsive' : '';

if ( is_numeric( $size ) ) $link = preg_replace( '/height="[0-9]*"/', 'height="' . $size . '"', $link );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gmaps_widget wpb_content_element' . $el_class, $this->settings['base'], $atts );
?>
<div class="<?php echo $css_class; ?>">
	<?php echo wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_map_heading' ) ); ?>
	<div class="wpb_wrapper">
		<div class="wpb_map_wraper">
			<?php
			if ( preg_match( '/^\<iframe/', $link ) ) echo $link; // trim(substr($link, 0, 8)) == '<iframe' && strpos($link, '//mapsengine.google')) echo $link; //this is new google maps
			else echo '<iframe width="100%" height="' . $size . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . $link . '&amp;t=' . $type . '&amp;z=' . $zoom . '&amp;output=embed' . $bubble . '"></iframe>';
			?>
		</div>
	</div><?php echo $this->endBlockComment( '.wpb_wrapper' ); ?>
</div><?php echo $this->endBlockComment( '.wpb_gmaps_widget' ); ?>