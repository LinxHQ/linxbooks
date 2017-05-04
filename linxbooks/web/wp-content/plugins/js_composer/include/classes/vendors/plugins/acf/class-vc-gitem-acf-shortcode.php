<?php

Class Vc_Gitem_Acf_Shortcode extends WPBakeryShortCode {
	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return mixed|void
	 */
	protected function content( $atts, $content = null ) {
		$field_key = $label = '';
		/**
		 * @var string $el_class
		 * @var string $show_label
		 * @var string $align
		 */
		extract( shortcode_atts( array(
			'el_class' => '',
			'field_group' => '',
			'show_label' => '',
			'align' => ''
		), $atts ) );
		if ( !empty( $field_group ) ) {
			$field_key = !empty( $atts['field_from_' . $field_group] ) ? $atts['field_from_' . $field_group] : '';
		}
		if ( $show_label === 'yes' && $field_key ) {
			$field_key .= '_labeled';
		}
		$css_class = 'vc_gitem-acf'
		             . ( strlen( $el_class ) ? ' ' . $el_class : '' )
		             . ( strlen( $align ) ? ' vc_gitem-align-' . $align : '' )
		             . ( strlen( $field_key ) ? ' ' . $field_key : '' );
		return '<div class="' . esc_attr( $css_class ) . '">'
		       . '{{ acf' . ( !empty( $field_key ) ? ':' . $field_key : '' ) . ' }}'
		       . '</div>';
	}
}