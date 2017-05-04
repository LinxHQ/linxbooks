<?php
$output = $el_class = $width = $el_position = '';
extract(shortcode_atts(array(
'el_class' => '',
'el_position' => '',
'width' => '1/2'
), $atts));

$el_class = $this->getExtraClass($el_class);
$el_class .= ($this->settings['base']=='vc_raw_html') ? ' wpb_content_element wpb_raw_html' : ' wpb_raw_js';
$content =  rawurldecode(base64_decode(strip_tags($content)));
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_raw_code' . $el_class, $this->settings['base'], $atts );
$output .= "\n\t".'<div class="'.$css_class.'">';
    $output .= "\n\t\t".'<div class="wpb_wrapper">';
        $output .= "\n\t\t\t".$content;
        $output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
    $output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_raw_code');

echo $output;