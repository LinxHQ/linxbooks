<?php
$type = $url = '';
extract(shortcode_atts(array(
    'type' => 'standard',//standard, button_count, box_count
    'url' => ''
), $atts));
if ( $url == '') $url = get_permalink();
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'fb_like wpb_content_element fb_type_' . $type, $this->settings['base'], $atts );

$output = '<div class="'.$css_class.'"><iframe src="http://www.facebook.com/plugins/like.php?href='.$url.'&amp;layout='.$type.'&amp;show_faces=false&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true"></iframe></div>'.$this->endBlockComment('fb_like')."\n";

echo $output;