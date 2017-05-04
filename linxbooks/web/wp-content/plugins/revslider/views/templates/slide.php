
	<!--  load good font -->
	<?php

		if($loadGoogleFont == "true"){
			$googleFont = $slider->getParam("google_font","");
			if(!empty($googleFont)){
				if(is_array($googleFont)){
					foreach($googleFont as $key => $font){
						echo RevOperations::getCleanFontImport($font);
					}
				}else{
					echo RevOperations::getCleanFontImport($googleFont);
				}
			}
		}

		if($slide->isStaticSlide()){ //insert sliderid for preview
			?>
			<input type="hidden" id="sliderid" value="<?php echo $slider->getID(); ?>" />
			<?php
		}
		?>
		
	<div class="wrap settings_wrap">
		<div class="clear_both"></div>

		<div class="title_line">
			<div id="icon-options-general" class="icon32"></div>
			<div class="view_title">
				<?php _e('Slider:', REVSLIDER_TEXTDOMAIN); echo ' '.$slider->getParam("title",""); ?>, 
				<?php
				if($sliderTemplate == "true"){
					_e("Edit Template Slide",REVSLIDER_TEXTDOMAIN);
				}else{
					_e("Edit Slide",REVSLIDER_TEXTDOMAIN);
				}
				?> <?php echo $slideOrder?>, <?php _e("Title:",REVSLIDER_TEXTDOMAIN); ?> <?php echo $slideTitle?>
			</div>

			<a href="<?php echo GlobalsRevSlider::LINK_HELP_SLIDE?>" class="button-primary float_right revblue mtop_10 mleft_10" target="_blank"><?php _e("Help",REVSLIDER_TEXTDOMAIN)?></a>

		</div>
		
		<div id="slide_selector" class="slide_selector">
			<?php
			$sID = $slider->getID();
			
			$useStaticLayers = $slider->getParam("enable_static_layers","off");
			if($useStaticLayers == 'on'){
				?>
				<ul class="list_static_slide_links">
					<li class="revgray nowrap">
						<a href="<?php echo self::getViewUrl(RevSliderAdmin::VIEW_SLIDE,"id=static_$sID"); ?>" class="add_slide"><i class="eg-icon-dribbble"></i><span><?php _e("Static / Global Layers",REVSLIDER_TEXTDOMAIN)?></span></a>
					</li>
				</ul>
				<?php
			}
			?>
			<ul class="list_slide_links">
				<?php
				foreach($arrSlideNames as $slidelistID=>$c_slide){

					$slideName = $c_slide["name"];
					$title = $c_slide["title"];
					$arrChildrenIDs = $c_slide["arrChildrenIDs"];

					$class = "tipsy_enabled_top";
					$titleclass = "";
					$urlEditSlide = self::getViewUrl(RevSliderAdmin::VIEW_SLIDE,"id=$slidelistID");
					if($slideID == $slidelistID || in_array($slideID, $arrChildrenIDs)){
						$class .= " selected";
						$titleclass = " slide_title";
						$urlEditSlide = "javascript:void(0)";
					}

					$addParams = "class='".$class."'";
					$slideName = str_replace("'", "", $slideName);
		
					?>
					<li id="slidelist_item_<?php echo $slidelistID?>">
						<a href="<?php echo $urlEditSlide?>" title='<?php echo $slideName?>' <?php echo $addParams?>><span class="nowrap<?php echo $titleclass?>"><?php echo $title?></span></a>
					</li>
					<?php
				}
				?>
				<li>
					<a id="link_add_slide" href="javascript:void(0);" class="add_slide"><span class="nowrap"><?php _e("Add Slide",REVSLIDER_TEXTDOMAIN)?></span></a>
				</li>
				<li>
					<div id="loader_add_slide" class="loader_round" style="display:none"></div>
				</li>
			</ul>
		</div>

		<div class="clear"></div>
		<!--<hr class="tabdivider">-->

		<?php
		if($wpmlActive == true && count($arrChildLangs) > 1){
			?>
			<div class="clear"></div>
			<div class="divide220"></div>
			<div class="slide_langs_selector">
				<span class="float_left ptop_15"> <?php _e("Choose slide language",REVSLIDER_TEXTDOMAIN)?>: </span>
				<ul class="list_slide_view_icons float_left">
					<?php
					foreach($arrChildLangs as $arrLang){
						$childSlideID = $arrLang["slideid"];
						$lang = $arrLang["lang"];
						$urlFlag = UniteWpmlRev::getFlagUrl($lang);
						$langTitle = UniteWpmlRev::getLangTitle($lang);

						$class = "";
						$urlEditSlide = self::getViewUrl(RevSliderAdmin::VIEW_SLIDE,"id=$childSlideID");

						if($childSlideID == $slideID){
							$class = "lang-selected";
							$urlEditSlide = "javascript:void(0)";
						}
						
						?>
						<li>
							<a href="<?php echo $urlEditSlide; ?>" class="tipsy_enabled_top <?php echo $class; ?>" title="<?php echo $langTitle; ?>">
								<img class="icon_slide_lang" src="<?php echo $urlFlag; ?>" >
							</a>
						</li>
						<?php
					}
					?>
				</ul>
				<span class="float_left ptop_15 pleft_20"> <?php _e("All the language related operations are from",REVSLIDER_TEXTDOMAIN)?> <a href="<?php echo $closeUrl?>"><?php _e("slides view",REVSLIDER_TEXTDOMAIN)?></a>. </span>
			</div>
			<div class="clear"></div>
			<?php
		}else{
			?>

			<div class="divide220"></div>

			<?php
		}
		?>
		
		<?php
		if(!$slide->isStaticSlide()){
		?>
		
			<div id="slide_params_holder" class="postbox unite-postbox" style="max-width:100% !important;">
				<h3 class="box-closed tp-accordion"><span class="postbox-arrow2">-</span><span><?php _e("General Slide Settings",REVSLIDER_TEXTDOMAIN) ?></span></h3>
				<div class="toggled-content">
					<form name="form_slide_params" id="form_slide_params">
					<?php
						$settingsSlideOutput->draw("form_slide_params",false);
					?>
						<input type="hidden" id="image_url" name="image_url" value="<?php echo $imageUrl?>" />
						<input type="hidden" id="image_id" name="image_id" value="<?php echo $imageID?>" />
					</form>
				</div>
			</div>

		<?php
		}
		?>

		<div id="jqueryui_error_message" class="unite_error_message" style="display:none;">
				<b>Warning!!! </b>The jquery ui javascript include that is loaded by some of the plugins are custom made and not contain needed components like 'autocomplete' or 'draggable' function.
				Without those functions the editor may not work correctly. Please remove those custom jquery ui includes in order the editor will work correctly.
		 </div>

		<?php require self::getPathTemplate("edit_layers");?>

		<?php
		if(!$slide->isStaticSlide()){
		?>
			<a href="javascript:void(0)" id="button_save_slide" class="revgreen button-primary"><div class="updateicon"></div><?php _e("Update Slide",REVSLIDER_TEXTDOMAIN)?></a>
		<?php }else{ ?>
			<a href="javascript:void(0)" id="button_save_static_slide" class="revgreen button-primary"><div class="updateicon"></div><?php _e("Update Static Layers",REVSLIDER_TEXTDOMAIN)?></a>
		<?php } ?>
		<span id="loader_update" class="loader_round" style="display:none;"><?php _e("updating",REVSLIDER_TEXTDOMAIN)?>...</span>
		<span id="update_slide_success" class="success_message" class="display:none;"></span>
		<a href="<?php echo self::getViewUrl(RevSliderAdmin::VIEW_SLIDER,"id=$sliderID");?>" class="button-primary revblue"><?php _e("To Slider Settings",REVSLIDER_TEXTDOMAIN)?></a>
		<a id="button_close_slide" href="<?php echo $closeUrl?>" class="button-primary revyellow"><div class="closeicon"></div><?php _e("To Slide List",REVSLIDER_TEXTDOMAIN)?></a>
		
		<?php
		if(!$slide->isStaticSlide()){
		?>
		<a href="javascript:void(0)" id="button_delete_slide" class="button-primary revred" original-title=""><i class="revicon-trash"></i><?php _e("Delete Slide",REVSLIDER_TEXTDOMAIN)?></a>
		<?php } ?>
	</div>

	<div class="vert_sap"></div>

	<?php require self::getPathTemplate("dialog_preview_slide");?>
	<?php
	if($slide->isStaticSlide())
		require self::getPathTemplate("dialog_preview_slider");
	?>

	<!-- FIXED POSITIONED TOOLBOX -->
		<div class="" style="position:fixed;right:-10px;top:148px;z-index:100;">
			<?php
			if(!$slide->isStaticSlide()){
			?>
			<a href="javascript:void(0)" id="button_save_slide-tb" class="revgreen button-primary button-fixed"><div style="font-size:16px; padding:10px 5px;" class="revicon-arrows-ccw"></div></a>
			<?php }else{ ?>
			<a href="javascript:void(0)" id="button_save_static_slide-tb" class="revgreen button-primary button-fixed"><div style="font-size:16px; padding:10px 5px;" class="revicon-arrows-ccw"></div></a>
			<?php } ?>
		</div>

	<div class="" style="position:fixed;right:-10px;top:100px;z-index:100;">

	</div>

	<?php
	if($slide->isStaticSlide()){
		$slideID = $slide->getID();
	}
	?>
	<script type="text/javascript">
		var g_messageDeleteSlide = "<?php _e("Delete this slide?",REVSLIDER_TEXTDOMAIN)?>";
		jQuery(document).ready(function(){
			RevSliderAdmin.initEditSlideView(<?php echo $slideID?>,<?php echo $sliderID?>);
		});
	</script>
	

