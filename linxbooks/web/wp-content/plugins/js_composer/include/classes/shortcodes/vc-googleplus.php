<?php
class WPBakeryShortCode_VC_GooglePlus extends WPBakeryShortCode {
    protected function contentInline( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'type' => 'standard',
            'annotation' => 'bubble'
        ), $atts));
        if(strlen($type) == 0) $type = 'standard';
        if(strlen($annotation) == 0) $annotation = 'bubble';
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_googleplus vc_social-placeholder wpb_content_element vc_socialtype-' . $type . ' vc_annotation-' . $annotation, $this->settings['base'], $atts );
        return '<div class="'.$css_class.'"></div>';
    }
}