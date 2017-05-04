<div id="vc_row-layout-panel" class="vc_panel" style="display: none;">
	<div class="vc_panel-heading">
		<a title="<?php _e( 'Close panel', 'js_composer' ); ?>" href="#" class="vc_close" data-dismiss="panel"
		   aria-hidden="true"><i class="vc_icon"></i></a>
		<a title="<?php _e( 'Hide panel', 'js_composer' ); ?>" href="#" class="vc_transparent" data-transparent="panel"
		   aria-hidden="true"><i class="vc_icon"></i></a>

		<h3 class="vc_panel-title"><?php echo __('Row Layout', 'js_composer') ?></h3>
	</div>
	<div class="vc_panel-body vc_properties-list">
		<div class="vc_row vc_edit_form_elements">
			<div class="vc_col-sm-12 vc_column vc_layout-panel-switcher">
				<div class="wpb_element_label"><?php _e('Row layout', 'js_composer') ?></div>
				<?php foreach($vc_row_layouts as $layout): ?>
				<a class="vc_layout-btn <?php echo $layout['icon_class']
				  .'" data-cells="'.$layout['cells']
				  .'" data-cells-mask="'.$layout['mask']
				  .'" title="'.$layout['title'] ?>"><span class="icon"></span></a>
				<?php endforeach; ?>
				<span
				  class="vc_description vc_clearfix"><?php _e( "Choose row layout from predefined options.", "js_composer" ); ?></span>
			</div>
			<div class="vc_col-sm-12 vc_column">
				<div class="wpb_element_label"><?php _e('Enter custom layout for your row', 'js_composer') ?></div>
				<div class="edit_form_line">
					<input name="padding" class="wpb-textinput vc_row_layout" type="text" value="" id="vc_row-layout">
					<button id="vc_row-layout-update"
							class="vc_btn vc_btn-primary vc_btn-sm"><?php _e( 'Update', 'js_composer' ) ?></button>
					<span
					  class="vc_description vc_clearfix"><?php _e( "Change particular row layout manually by specifying number of columns and their size value.", "js_composer" ); ?></span>
				</div>
			</div>
		</div>
	</div>
</div>