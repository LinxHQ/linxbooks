<?php
require_once vc_path_dir('PARAMS_DIR', 'vc_grid_item/editor/popups/class-vc-add-element-box-grid-item.php');
$add_element_box = new Vc_Add_Element_Box_Grid_Item();
$add_element_box->render();
// Edit form for mapped shortcode.
visual_composer()->editForm()->render();
require_once vc_path_dir('PARAMS_DIR', 'vc_grid_item/editor/popups/class-vc-templates-editor-grid-item.php' );
$templates_editor = new Vc_Templates_Editor_Grid_Item();
$templates_editor->render();

require_once vc_path_dir('EDITORS_DIR', 'popups/class-vc-edit-layout.php');
$edit_layout = new Vc_Edit_Layout();
$edit_layout->render();
$grid_item = new Vc_Grid_Item();
$shortcodes = $grid_item->shortcodes();
$grid_item->mapShortcodes();
?>
<script type="text/javascript">
	var vc_user_mapper = <?php echo json_encode($shortcodes) ?>,
		vc_mapper = <?php echo json_encode($shortcodes) ?>,
		vc_frontend_enabled = false,
		vc_mode = '<?php echo vc_mode() ?>';
</script>

<script type="text/html" id="vc_settings-image-block">
	<li class="added">
		<div class="inner" style="width: 75px; height: 75px; overflow: hidden;text-align: center;">
			<img rel="<%= id %>" src="<%= url %>"/>
		</div>
		<a href="#" class="icon-remove"></a>
	</li>
</script>
<?php foreach ( $shortcodes as $sc_base => $el ): ?>
<script type="text/html" id="vc_shortcode-template-<?php echo $sc_base ?>">
	<?php
	echo visual_composer()->getShortCode( $sc_base )->template();
	?>
</script>
<?php endforeach; ?>