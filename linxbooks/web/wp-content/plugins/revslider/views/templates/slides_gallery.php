	
	<div class="wrap settings_wrap">
	
		<div class="clear_both"></div> 
	
		<div class="title_line">
			<div id="icon-options-general" class="icon32"></div>
			<div class="view_title"><?php _e("Edit Slides",REVSLIDER_TEXTDOMAIN)?>: <?php echo $slider->getTitle()?></div>
			
			<a href="<?php echo GlobalsRevSlider::LINK_HELP_SLIDE_LIST?>" class="button-secondary float_right mtop_10 mleft_10" target="_blank"><?php _e("Help",REVSLIDER_TEXTDOMAIN)?></a>			
			
		</div>
		
		<div class="vert_sap"></div>
		<?php if($numSlides >= 5){ ?>
			<a class='button-primary revblue' id="button_new_slide_top" href='javascript:void(0)' ><i class="revicon-list-add"></i><?php _e("New Slide",REVSLIDER_TEXTDOMAIN)?></a>

			<a class='button-primary revblue' id="button_new_slide_transparent_top" href='javascript:void(0)' ><i class="revicon-list-add"></i><?php _e("New Transparent Slide",REVSLIDER_TEXTDOMAIN)?></a>
			<span class="loader_round new_trans_slide_loader" style="display:none"><?php _e("Adding Slide...",REVSLIDER_TEXTDOMAIN)?></span>		

			<a class="button-primary revyellow" href='<?php echo self::getViewUrl(RevSliderAdmin::VIEW_SLIDERS);?>' ><i class="revicon-cancel"></i><?php _e("Close",REVSLIDER_TEXTDOMAIN)?></a>
		<?php } ?>
		
		<?php if($wpmlActive == true){ ?>
			<div id="langs_float_wrapper" class="langs_float_wrapper" style="display:none">
				<?php echo $langFloatMenu?>
			</div>
		<?php } ?>
				
		<div class="vert_sap"></div>
		<div class="sliders_list_container">
			<?php require self::getPathTemplate("slides_list");?>
		</div>
		<div class="vert_sap_medium"></div>
		<a class='button-primary revblue' id="button_new_slide" data-dialogtitle="<?php _e("Select image or multiple images to add slide or slides",REVSLIDER_TEXTDOMAIN)?>" href='javascript:void(0)' ><i class="revicon-list-add"></i><?php _e("New Slide",REVSLIDER_TEXTDOMAIN)?></a>
		<a class='button-primary revblue' id="button_new_slide_transparent" href='javascript:void(0)' ><i class="revicon-list-add"></i><?php _e("New Transparent Slide",REVSLIDER_TEXTDOMAIN)?></a>
		<span class="loader_round new_trans_slide_loader" style="display:none"><?php _e("Adding Slide...",REVSLIDER_TEXTDOMAIN)?></span>
		<?php
		if($useStaticLayers == 'on'){
			?>		
			<a class='button-primary revgray' href='<?php echo self::getViewUrl(RevSliderAdmin::VIEW_SLIDE,"id=static_".$slider->getID()); ?>' style="width:190px; "><i class="eg-icon-dribbble"></i><?php _e("Edit Static/Global Layers",REVSLIDER_TEXTDOMAIN)?></a>
			<?php
		}
		?>
		<a class="button-primary revyellow" href='<?php echo self::getViewUrl(RevSliderAdmin::VIEW_SLIDERS);?>' ><i class="revicon-cancel"></i><?php _e("Close",REVSLIDER_TEXTDOMAIN)?></a>		
		<a href="<?php echo $linksSliderSettings?>" class="button-primary revgreen"><i class="revicon-cog"></i><?php _e("Slider Settings",REVSLIDER_TEXTDOMAIN)?></a>		

		
	</div>
	
	<div id="dialog_copy_move" data-textclose="<?php _e("Close",REVSLIDER_TEXTDOMAIN)?>" data-textupdate="<?php _e("Do It!",REVSLIDER_TEXTDOMAIN)?>" title="<?php _e("Copy / move slide",REVSLIDER_TEXTDOMAIN)?>" style="display:none">
		
		<br>
		
		<?php _e("Choose Slider",REVSLIDER_TEXTDOMAIN)?> :
		<?php echo $selectSliders?>
		
		<br><br>
		
		<?php _e("Choose Operation",REVSLIDER_TEXTDOMAIN)?> :
		 
		<input type="radio" id="radio_copy" value="copy" name="copy_move_operation" checked />
		<label for="radio_copy" style="cursor:pointer;"><?php _e("Copy",REVSLIDER_TEXTDOMAIN)?></label>
		&nbsp; &nbsp;
		<input type="radio" id="radio_move" value="move" name="copy_move_operation" />
		<label for="radio_move" style="cursor:pointer;"><?php _e("Move",REVSLIDER_TEXTDOMAIN)?></label>		
		
	</div>
	
	<?php require self::getPathTemplate("dialog_preview_slide");?>
	
	<script type="text/javascript">
	
		var g_patternViewSlide = '<?php echo $patternViewSlide?>';
		
		var g_messageChangeImage = "<?php _e("Select Slide Image",REVSLIDER_TEXTDOMAIN)?>";
		
		jQuery(document).ready(function() {
			var g_messageDeleteSlide = "<?php _e("Delete this slide?",REVSLIDER_TEXTDOMAIN)?>";
			RevSliderAdmin.initSlidesListView("<?php echo $sliderID?>");
			
		});
		
	</script>
	