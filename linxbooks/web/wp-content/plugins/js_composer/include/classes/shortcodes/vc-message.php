<?php

class WPBakeryShortCode_VC_Message extends WPBakeryShortCode {

	public static function convertAttributesToMessageBox2( $atts ) {
		if ( isset( $atts['style'] ) ) {
			if ( $atts['style'] == '3d' ) {
				$atts['message_box_style'] = '3d';
				$atts['style'] = 'rounded';
			} else if ( $atts['style'] == 'outlined' ) {
				$atts['message_box_style'] = 'outline';
				$atts['style'] = 'rounded';
			} else if ( $atts['style'] == 'square_outlined' ) {
				$atts['message_box_style'] = 'outline';
				$atts['style'] = 'square';
			}
		}

		return $atts;
	}

	public function outputTitle( $title ) {
		return '';
	}
}