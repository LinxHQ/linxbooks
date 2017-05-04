<?php
	global $revSliderVersion;
	
	$wrapperClass = "";
	if(GlobalsRevSlider::$isNewVersion == false)
		 $wrapperClass = " oldwp";
	
	$nonce = wp_create_nonce("revslider_actions");
	
?>

<script type="text/javascript">
	var g_revNonce = "<?php echo $nonce?>";
	var g_uniteDirPlagin = "<?php echo self::$dir_plugin?>";
	var g_urlContent = "<?php echo str_replace(array("\n", "\r", chr(10), chr(13)), array(''), content_url())."/";?>";
	var g_urlAjaxShowImage = "<?php echo UniteBaseClassRev::$url_ajax_showimage?>";
	var g_urlAjaxActions = "<?php echo UniteBaseClassRev::$url_ajax_actions?>";
	var g_settingsObj = {};
	
</script>

<div id="div_debug"></div>

<div class='unite_error_message' id="error_message" style="display:none;"></div>

<div class='unite_success_message' id="success_message" style="display:none;"></div>

<div id="viewWrapper" class="view_wrapper<?php echo $wrapperClass?>">
<?php
	self::requireView($view);
?>

</div>

<div id="divColorPicker" style="display:none;"></div>

<?php self::requireView("system/video_dialog")?>
<?php self::requireView("system/update_dialog")?>
<?php self::requireView("system/general_settings_dialog")?>

<div class="tp-plugin-version">
	<span style="margin-right:15px">&copy; All rights reserved, <a href="http://themepunch.com" target="_blank">Themepunch</a>  ver. <?php echo $revSliderVersion?></span>
	<a id="button_upload_plugin" class="button-primary revpurple update_plugin" href="javascript:void(0)"><?php _e("Manual Plugin Update",REVSLIDER_TEXTDOMAIN)?></a>
</div>

<?php if(GlobalsRevSlider::SHOW_DEBUG == true): ?>

	Debug Functions (for developer use only): 
	<br><br>
	
	<a id="button_update_text" class="button-primary revpurple" href="javascript:void(0)">Update Text</a>
	
<?php endif?>

