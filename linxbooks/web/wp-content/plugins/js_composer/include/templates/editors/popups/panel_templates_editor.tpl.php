<?php
/**
 * @deprecated since 4.4
 */
?>
<div id="vc_templates-editor" class="vc_panel vc_templates-editor" style="display: none;">
	<div class="vc_panel-heading">
		<a title="<?php _e( 'Close panel', 'js_composer' ); ?>" href="#" class="vc_close" data-dismiss="panel"
		   aria-hidden="true"><i class="vc_icon"></i></a>
		<a title="<?php _e( 'Hide panel', 'js_composer' ); ?>" href="#" class="vc_transparent" data-transparent="panel"
		   aria-hidden="true"><i class="vc_icon"></i></a>

		<h3 class="vc_panel-title"><?php _e( 'Templates', 'js_composer' ) ?></h3>
	</div>
	<div class="vc_panel-body vc_templates-body vc_properties-list vc_with-tabs">
		<div class="vc_row wpb_edit_form_elements">
			<div class="vc_column">
				<div id="vc_tabs-templates" class="vc_panel-tabs">
					<?php
					/** @var $box Vc_Templates_Editor */
					?>
					<?php $templates = apply_filters( 'vc_load_default_templates_panels', $box->loadDefaultTemplates() );
					$templates_exists = is_array( $templates ) && ! empty( $templates ); ?>
					<ul class="vc_edit-form-tabs-menu">
						<li class="vc_edit-form-tab-control"><a class="vc_edit-form-link"
						                                        href="#tabs-templates-tabs-1"><?php _e( 'My templates', 'js_composer' ); ?></a>
						</li>
						<?php if ( $templates_exists ): ?>
							<li class="vc_edit-form-tab-control"><a class="vc_edit-form-link"
							                                        href="#tabs-templates-tabs-2"><?php _e( 'Default templates', 'js_composer' ); ?></a>
							</li>
						<?php endif; ?>
					</ul>
					<div class="vc_edit-form-tab" id="tabs-templates-tabs-1">
						<div class="vc_col-sm-12 vc_column inside">
							<div
								class="wpb_element_label"><?php _e( 'Save current layout as a template', 'js_composer' ) ?></div>
							<div class="edit_form_line">
								<input name="padding" class="wpb-textinput vc_title_name" type="text" value=""
								       id="vc_template-name"
								       placeholder="<?php _e( 'Template name', 'js_composer' ) ?>">
								<button id="vc_template-save"
								        class="vc_btn vc_btn-primary vc_btn-sm"><?php _e( 'Save template', 'js_composer' ) ?></button>
							</div>
								<span
									class="vc_description"><?php _e( 'Save your layout and reuse it on different sections of your website', 'js_composer' ) ?></span>
						</div>
						<div class="vc_col-sm-12 vc_column">
							<div class="wpb_element_label"><?php _e( 'Load Template', 'js_composer' ) ?></div>
								<span
									class="vc_description"><?php _e( 'Append previosly saved template to the current layout', 'js_composer' ) ?></span>
							<ul class="wpb_templates_list" id="vc_template-list">
								<?php $box->renderMenu( true ) ?>
							</ul>
						</div>
					</div>
					<?php if ( $templates_exists ): ?>
						<div class="vc_edit-form-tab" id="tabs-templates-tabs-2">
							<div class="vc_col-sm-12 vc_column inside">

								<div class="wpb_element_label"><?php _e( 'Load Template', 'js_composer' ); ?></div>
								<span
									class="description"><?php _e( 'Append default template to the current layout', 'js_composer' ); ?></span>
								<ul id="vc_default-template-list" class="wpb_templates_list">
									<?php foreach ( $templates as $key => $template ): ?>
										<li class="wpb_template_li"><a href="#"
										                               data-template_name="<?php echo $key; ?>"><?php echo $template['name']; ?></a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="vc_panel-footer">
		<button type="button" class="vc_btn vc_btn-default vc_close"
		        data-dismiss="panel"><?php _e( 'Close', 'js_composer' ) ?></button>
	</div>
</div>