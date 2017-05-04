<div class="vc_modal wpb-elements-list-modal fade" id="vc_add-element-dialog" tabindex="-1" role="dialog"
	 aria-labelledby="vc_add-element-dialog-title" aria-hidden="true">
	<div class="vc_modal-dialog modal-dialog">
		<div class="vc_modal-content">
			<div class="vc_modal-header">
				<a href="#" class="vc_close" data-dismiss="modal" aria-hidden="true"><i class="vc_icon"></i></a>
				<input id="vc_elements_name_filter" type="text" name="vc_content_filter" class="vc_elements-list-filter"
					   placeholder="<?php esc_attr_e( 'Search by element name', "js_composer" ); ?>"/>

				<h3 class="vc_modal-title"
					id="vc_add-element-dialog-title"><?php _e( 'Add Element', 'js_composer' ) ?></h3>
			</div>
			<div class="vc_modal-body wpb-elements-list">
				<ul class="wpb-content-layouts-container" style="position: relative;">
					<?php /** @var $box Vc_Add_Element_Box */ ?>
					<li><?php echo $box->contentCategories() ?></li>
					<li><?php echo $box->getControls() ?></li>
				</ul>
				<div class="vc_clearfix"></div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div><!-- /.modal -->