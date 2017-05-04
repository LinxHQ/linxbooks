<?php
$output = $el_class = $width = '';
extract(shortcode_atts(array(
    'el_class' => '',
), $atts));

$el_class = $this->getExtraClass($el_class);

$el_class .= (!empty($el_class) ? ' ' : '').'wpb_item items_container';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class, $this->settings['base'], $atts );
$output .= "\n\t".'<div class="'.$css_class.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

echo $output;