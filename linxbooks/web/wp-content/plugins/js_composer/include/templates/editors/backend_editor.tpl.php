<?php
require_once vc_path_dir('EDITORS_DIR', 'navbar/class-vc-navbar.php');
/** @var $post WP_Post */
$nav_bar = new Vc_Navbar( $post );
$nav_bar->render();
/** @var $editor Vc_Backend_Editor */
?>
<div class="metabox-composer-content">
	<div id="visual_composer_content" class="wpb_main_sortable main_wrapper"></div>
	<?php require vc_path_dir( "TEMPLATES_DIR", 'editors/partials/vc_welcome_block.tpl.php' ); ?>

</div>
<?php

$wpb_vc_status = apply_filters( 'wpb_vc_js_status_filter', vc_get_param( 'wpb_vc_js_status', get_post_meta( $post->ID, '_wpb_vc_js_status', true ) ) );

// TODO: remove this.
if ( $wpb_vc_status == "" || !isset( $wpb_vc_status ) ) {
	$wpb_vc_status = 'false';
}

?>
<input type="hidden" name="vc_js_composer_group_access_show_rule" class="vc_js_composer_group_access_show_rule" value="<?php echo esc_attr( $editor->showRulesValue() ); ?>" />
<input type="hidden" id="wpb_vc_js_status" name="wpb_vc_js_status" value="<?php echo esc_attr( $wpb_vc_status ); ?>" />
<input type="hidden" id="wpb_vc_loading" name="wpb_vc_loading" value="<?php esc_attr_e( "Loading, please wait...", "js_composer" ) ?>" />
<input type="hidden" id="wpb_vc_loading_row" name="wpb_vc_loading_row" value="<?php esc_attr_e( "Crunching...", "js_composer" ) ?>" />
<?php
/* <input type="hidden" id="wpb_vc_js_interface_version" name="wpb_vc_js_interface_version" value="<?php esc_attr_e(vc_get_interface_version()) ?>" /> */
?>
<input type="hidden" name="vc_post_custom_css" id="vc_post-custom-css" value="<?php echo esc_attr( $editor->post_custom_css ); ?>" autocomplete="off" />