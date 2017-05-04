<?php
class WPBakeryShortCode_VC_Facebook extends WPBakeryShortCode {
    protected function contentInline( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'type' => 'standard',//standard, button_count, box_count
            'url' => ''
        ), $atts));
        if ( $url == '') $url = get_permalink();
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_social-placeholder fb_like wpb_content_element vc_socialtype-' . $type, $this->settings['base'], $atts );
        return '<a href="'.$url.'" class="'.$css_class.'"></a>';
    }
}