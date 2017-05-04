<?php
$type = '';
extract(shortcode_atts(array(
    'type' => 'horizontal'//horizontal, vertical, none
), $atts));

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'twitter-share-button', $this->settings['base'], $atts );

$output = '<a href="http://twitter.com/share" class="'.$css_class.'" data-count="'.$type.'">'. __("Tweet", "js_composer") .'</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>'.$this->endBlockComment('tweetmeme')."\n";

echo $output;