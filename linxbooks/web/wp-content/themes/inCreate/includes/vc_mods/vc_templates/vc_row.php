<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = '';
extract(shortcode_atts(array(
    'full_width'      => 'no',
    'bg_pos'          => '',
    'parallax'        => '',
    'border'        => '',
    'text_color'      => '',
    'top_padding'     =>'', 
    'bottom_padding'  =>'',   
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'margin_bottom'   => '',
    'text_align'      =>''
 
), $atts));

wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass($el_class);

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '.get_row_css_class(), $this->settings['base']);

$style = ht_build_style($bg_image, $bg_color, $bg_image_repeat, $bg_pos, '', $top_padding, $bottom_padding, $margin_bottom, $text_align);


// prallax 
$parallax_class    = ($parallax =='yes') ? 'parallax ': '';
$parallax_settings = ($parallax =='yes') ? ' data-stellar-background-ratio="0.2"' : '';
$style             = ($parallax =='yes') ? $style. 'background-repeat:repeat;background-position: 50% 0;' : $style ;
// dark or light text color
$text_color     = ($text_color =='light') ? 'light ': 'dark ';

//
$border    = ($border =='yes') ? ' grey-line ': '';


// full-width section
$full_width     = ($full_width =='yes') ? ' full-width-section clearfix' : '';

wp_reset_query();
$ht_sidebar_status = ht_sidebar_layout();  

if ( $ht_sidebar_status =='no-sidebar' ) {
    $output .= '<div style="'.$style.'" class="' . $text_color . $parallax_class . $full_width . $el_class. $border. ' ht-row-wrap clearfix" '.$parallax_settings.'>';

} else {
    $output .= '<div style="'.$style.'" class="' . $text_color . $parallax_class . $el_class. $border . ' ht-row-wrap clearfix">';

}
$output .= '<div class="' . $css_class . '">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>'.$this->endBlockComment('row');
$output .= '</div>';  


echo $output;