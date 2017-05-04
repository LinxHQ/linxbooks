<?php
$validated = get_option('revslider-valid', 'false');
$username = get_option('revslider-username', '');
$api_key = get_option('revslider-api-key', '');
$code = get_option('revslider-code', '');
$latest_version = get_option('revslider-latest-version', GlobalsRevSlider::SLIDER_REVISION);
   if(version_compare($latest_version, GlobalsRevSlider::SLIDER_REVISION, '>')){
    //neue version existiert
   }else{
    //up to date
   }

?>

<!-- 
  CONTENT BEFORE ACTIVATION, BASED OF VALIDATION 
-->
<?php if($validated === 'true') {

		$displ = "block";
		
	?> 
	<div class="revgreen" style="left:0px;top:0px;position:absolute;height:100%;padding:30px 10px;"><i style="color:#fff;font-size:25px" class="eg-icon-check"></i></div>
	<?php 	
} else {				
		$displ = "none";
	?> 
	<div class="revcarrot"   style="left:0px;top:0px;position:absolute;height:100%;padding:22px 10px;"><i style="color:#fff;font-size:25px" class="revicon-cancel"></i></div>
	<?php 
}
?>

<div id="rs-validation-wrapper" style="display:<?php echo $displ; ?>">
	
	
	<div class="validation-label"><?php _e('Username:',REVSLIDER_TEXTDOMAIN); ?></div> 
	<div class="validation-input"> 
		<input type="text" name="rs-validation-username" <?php echo ($validated === 'true') ? ' readonly="readonly"' : ''; ?> value="<?php echo $username; ?>" />
		<p class="validation-description"><?php _e('Your Envato username.',REVSLIDER_TEXTDOMAIN); ?></p>
	</div>
	<div class="clear"></div>
	
	
	<div class="validation-label"><?php _e('Envato API Key:',REVSLIDER_TEXTDOMAIN); ?> </div> 
	<div class="validation-input">
		<input type="text" name="rs-validation-api-key" value="<?php echo $api_key; ?>" <?php echo ($validated === 'true') ? ' readonly="readonly"' : ''; ?> style="width: 350px;" />
		<p class="validation-description"><?php _e('You can find API key by visiting your Envato Account page, then clicking the My Settings tab. At the bottom of he page you will find your accounts API key.',REVSLIDER_TEXTDOMAIN); ?></p>
	</div>
	<div class="clear"></div>
	
	<div class="validation-label"><?php _e('Purchase code:',REVSLIDER_TEXTDOMAIN); ?></div> 
	<div class="validation-input">
		<input type="text" name="rs-validation-token" value="<?php echo $code; ?>" <?php echo ($validated === 'true') ? ' readonly="readonly"' : ''; ?> style="width: 350px;" />
		<p class="validation-description"><?php _e('Please enter your ',REVSLIDER_TEXTDOMAIN); ?><strong style="color:#000"><?php _e('CodeCanyon Slider Revolution purchase code / license key',REVSLIDER_TEXTDOMAIN); ?></strong><?php _e('. You can find your key by following the instructions on',REVSLIDER_TEXTDOMAIN); ?><a target="_blank" href="http://www.themepunch.com/home/plugins/wordpress-plugins/revolution-slider-wordpress/where-to-find-the-purchase-code/"><?php _e(' this page.',REVSLIDER_TEXTDOMAIN); ?></a></p>
	</div>
	<div style="height:15px" class="clear"></div>
	
	<span style="display:none" id="rs_purchase_validation" class="loader_round"><?php _e('Please Wait...', REVSLIDER_TEXTDOMAIN); ?></span>

	<a href="javascript:void(0);" <?php echo ($validated !== 'true') ? '' : 'style="display: none;"'; ?> id="rs-validation-activate" class="button-primary revgreen"><?php _e('Register',REVSLIDER_TEXTDOMAIN); ?></a>
	
	<a href="javascript:void(0);" <?php echo ($validated === 'true') ? '' : 'style="display: none;"'; ?> id="rs-validation-deactivate" class="button-primary revred"><?php _e('Deregister',REVSLIDER_TEXTDOMAIN); ?></a>
		
	
	<?php
	if($validated === 'true'){
		?>
		<a href="update-core.php?checkforupdates=true" id="rs-check-updates" class="button-primary revpurple"><?php _e('Search for Updates',REVSLIDER_TEXTDOMAIN); ?></a>
		<?php
	}
	?>
	
	<?php
	if($validated === 'true'){
		echo '<span style="margin-left:10px;color: #999; font-weight: 400; font-style:italic;">'.__('To register the plugin on a different website, click the “Deregister” button here first.', REVSLIDER_TEXTDOMAIN).'</span>';
	}
	?>
	
</div>

<!-- 
  CONTENT AFTER ACTIVATION, BASED OF VALIDATION 
-->
<?php if($validated === 'true') {
	?> 
	<h3> <?php _e("How to get Support ?",REVSLIDER_TEXTDOMAIN)?></h3>				
	<p>
	<?php _e("Please feel free to contact us via our ",REVSLIDER_TEXTDOMAIN)?><a href='http://themepunch.ticksy.com'><?php _e("Support Forum ",REVSLIDER_TEXTDOMAIN)?></a><?php _e("and/or via the ",REVSLIDER_TEXTDOMAIN)?><a href='http://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380/comments'><?php _e("Item Disscussion Forum",REVSLIDER_TEXTDOMAIN)?></a><br />
	</p> 	
	<?php 	
} else {
	?> 
	<p style="margin-top:10px; margin-bottom:10px;" id="tp-before-validation">

	<?php _e("Click Here to get ",REVSLIDER_TEXTDOMAIN); ?><strong><?php _e("Premium Support and Auto Updates",REVSLIDER_TEXTDOMAIN); ?></strong><br />

	</p> 
	<?php 
}
?>

