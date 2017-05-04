<?php
if ( $atts['show_filter'] === 'yes' && ! empty( $filter_terms ) ):
	$unique_terms = array_unique( $filter_terms );
	$terms_ids = !empty($atts['exclude_filter']) ?
		array_diff(
			$unique_terms, // Posts filter terms
			array_map('abs', preg_split('/\s*\,\s*/', $atts['exclude_filter']))
		) : $unique_terms;
	$terms = count($terms_ids) > 0 ? get_terms($atts['filter_source'], array(
		'include' => implode( ',', $terms_ids)
	)) : array();
	if( $atts['filter_style'] != 'dropdown' ): ?>
	<ul class="vc_grid-filter vc_clearfix vc_grid-filter-<?php echo esc_attr( $atts['filter_style'] ); ?> vc_grid-filter-size-<?php echo esc_attr( $atts['filter_size'] ); ?> vc_grid-filter-<?php echo esc_attr( $atts['filter_align'] ); ?> vc_grid-filter-color-<?php echo esc_attr( $atts['filter_color'] ); ?>" data-vc-grid-filter="<?php echo esc_attr( $atts['filter_source'] ) ?>"><li class="vc_active vc_grid-filter-item"><span data-vc-grid-filter-value="*"><?php _e( 'All', 'js_composer' ); ?></span></li><!-- fix whitespace
				!--><?php foreach ( $terms as $term ): ?><li class="vc_grid-filter-item"><span data-vc-grid-filter-value=".vc_grid-term-<?php echo $term->term_id; ?>"><?php esc_attr_e( $term->name ); ?></span></li><?php endforeach; ?></ul>
	<?php endif; ?>
<!-- for responsive vc_responsive !-->
<div class="<?php echo $atts['filter_style'] == 'dropdown' ? 'vc_grid-filter-dropdown':'vc_grid-filter-select'; ?> vc_grid-filter-<?php echo esc_attr($atts['filter_align']); ?> vc_grid-filter-color-<?php echo esc_attr( $atts['filter_color'] ); ?>" data-vc-grid-filter-select="<?php echo esc_attr( $atts['filter_source'] ) ?>">
	<div class="vc_grid-styled-select"><select data-filter="<?php echo esc_attr( $atts['filter_source'] ) ?>">
		<option class="vc_active" value="*"><?php _e( 'All', 'js_composer' ) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
		<?php foreach ( $terms as $term ): ?>
		<option value=".vc_grid-term-<?php echo esc_attr($term->term_id) ?>"><?php echo esc_html( $term->name ) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
		<?php endforeach; ?>
	</select><i class="vc_arrow-icon-navicon"></i>
	</div>
</div>
<?php endif; ?>