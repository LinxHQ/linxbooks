<div id="vc_post-settings-panel" class="vc_panel" style="display: none;">
	<div class="vc_panel-heading">
		<a title="<?php _e( 'Close panel', 'js_composer' ); ?>" href="#" class="vc_close" data-dismiss="panel"
		   aria-hidden="true"><i class="vc_icon"></i></a>
		<a title="<?php _e( 'Hide panel', 'js_composer' ); ?>" href="#" class="vc_transparent" data-transparent="panel"
		   aria-hidden="true"><i class="vc_icon"></i></a>

		<h3 class="vc_panel-title"><?php _e('Page Settings', 'js_composer') ?></h3>
	</div>
	<div class="vc_panel-body vc_properties-list">
		<div class="vc_row">
			<div class="vc_col-sm-12 vc_column" id="vc_settings-title-container">
				<div class="wpb_element_label"><?php _e('Page title', 'js_composer') ?></div>
				<div class="edit_form_line">
					<input name="page_title" class="wpb-textinput vc_title_name" type="text" value=""
						   id="vc_page-title-field"
						   placeholder="<?php _e( 'Please enter page title', 'js_composer' ) ?>">
					<span class="description"><?php _e('Here you can change title of the current ' . get_post_type()
						. '. Possibly changes will not be affected in a preview, but will be updated after saving.', 'js_composer') ?></span>
				</div>
			</div>
			<div class="vc_col-sm-12 vc_column">
				<div class="wpb_element_label"><?php _e('Custom CSS settings', 'js_composer') ?></div>
				<div class="edit_form_line">
					<pre id="wpb_csseditor" class="wpb_content_element custom_css wpb_frontend"></pre>
					<span
					  class="vc_description vc_clearfix"><?php _e( 'Enter custom CSS code here. Your custom CSS will be outputted only on this particular page.', "js_composer" ) ?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="vc_panel-footer">
		<button type="button" class="vc_btn vc_btn-default"
				data-dismiss="panel"><?php _e( 'Close', 'js_composer' ) ?></button>
		<button type="button" class="vc_btn vc_btn-primary"
				data-save="true"><?php _e( 'Save changes', 'js_composer' ) ?></button>
	</div>
</div>
