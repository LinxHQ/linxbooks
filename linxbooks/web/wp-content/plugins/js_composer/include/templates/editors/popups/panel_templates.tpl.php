<?php
/**
 * @since 4.4
 */
?>
<div id="vc_templates-panel" class="vc_panel vc_templates-panel" style="display: none;">
	<div class="vc_panel-heading"><a
			title="<?php _e( 'Close panel', 'js_composer' ); ?>" href="javascript:;" class="vc_close" data-dismiss="panel"
		   aria-hidden="true"><i class="vc_icon"></i></a><a
			title="<?php _e( 'Hide panel', 'js_composer' ); ?>" href="javascript:;" class="vc_transparent" data-transparent="panel"
		   aria-hidden="true"><i class="vc_icon"></i></a><h3
			class="vc_panel-title"><?php _e( 'Templates', 'js_composer' ); ?></h3>
	</div>
	<?php
	/** @var $box Vc_Templates_Panel_Editor */
	$categories_data = $box->getAllTemplatesSorted();
	$categories = $box->getAllCategoriesNames( $categories_data );
	$with_tabs = count( $categories ) > 0;
	if(count($categories)>0):
	?>
	<div class="vc_panel-body vc_with-tabs">
		<div class="vc_row">
			<div class="vc_column">
				<div class="vc_panel-tabs">
					<ul class="vc_panel-tabs-menu">
					<?php foreach ( $categories as $key => $value ): ?><li
						class="vc_panel-tabs-control"><a
								class="vc_panel-tabs-link" data-target="[data-tab=<?php echo trim( esc_attr( $key ) ); ?>]"><?php
									echo esc_html( $value ); ?></a></li><?php endforeach; ?></ul>
					<?php
					/**
					 * Preparing tabs content
					 */
					?>
					<?php foreach ( $categories_data as $key => $category ): ?><div
						class="vc_panel-tab vc_clearfix" data-tab="<?php echo esc_attr( $category['category'] ); ?>">
						<?php
						$templates_block = apply_filters( 'vc_templates_render_category', $category );
						if ( isset( $templates_block['output'] ) && is_string( $templates_block['output'] ) ) {
							echo $templates_block['output'];
						}
						?>
					</div><?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>