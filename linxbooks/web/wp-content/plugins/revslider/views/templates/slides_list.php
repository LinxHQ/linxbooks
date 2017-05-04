	<div class="postbox box-slideslist">
		<h3>
			<span class='slideslist-title'><?php _e("Slides List",REVSLIDER_TEXTDOMAIN)?></span>
			<span id="saving_indicator" class='slideslist-loading'><?php _e("Saving Order",REVSLIDER_TEXTDOMAIN)?>...</span>
		</h3>
		<div class="inside">
			<?php if(empty($arrSlides)):?>
			<?php _e("No Slides Found",REVSLIDER_TEXTDOMAIN)?>
			<?php endif?>
			
			<?php
			$useStaticLayers = $slider->getParam("enable_static_layers","off");
			?>
			<ul id="list_slides" class="list_slides ui-sortable">
			
				<?php
					$counter = 0; 
					foreach($arrSlides as $slide):
						
						$counter++;
						
						$bgType = $slide->getParam("background_type","image");
						
						$bgFit = $slide->getParam("bg_fit","cover");
						$bgFitX = intval($slide->getParam("bg_fit_x","100"));
						$bgFitY = intval($slide->getParam("bg_fit_y","100"));
						
						$bgPosition = $slide->getParam("bg_position","center top");
						$bgPositionX = intval($slide->getParam("bg_position_x","0"));
						$bgPositionY = intval($slide->getParam("bg_position_y","0"));
						
						$bgRepeat = $slide->getParam("bg_repeat","no-repeat");
						
						$bgStyle = ' ';
						if($bgFit == 'percentage'){
							$bgStyle .= "background-size: ".$bgFitX.'% '.$bgFitY.'%;';
						}else{
							$bgStyle .= "background-size: ".$bgFit.";";
						}
						if($bgPosition == 'percentage'){
							$bgStyle .= "background-position: ".$bgPositionX.'% '.$bgPositionY.'%;';
						}else{
							$bgStyle .= "background-position: ".$bgPosition.";";
						}
						$bgStyle .= "background-repeat: ".$bgRepeat.";";
						
						
						//set language flag url
						$isWpmlExists = UniteWpmlRev::isWpmlExists();
						$useWpml = $slider->getParam("use_wpml","off");
						$showLangs = false;
						if($isWpmlExists && $useWpml == "on"){
							$showLangs = true;
							$arrChildLangs = $slide->getArrChildrenLangs();
							$arrSlideLangCodes = $slide->getArrChildLangCodes();
							
							$addItemStyle = "";
							if(UniteWpmlRev::isAllLangsInArray($arrSlideLangCodes))
								$addItemStyle = "style='display:none'";
						}
											
						$imageFilepath = $slide->getImageFilepath();									
						$urlImageForView = $slide->getThumbUrl();
						
						$slideTitle = $slide->getParam("title","Slide");
						$title = $slideTitle;
						$filename = $slide->getImageFilename();
						
						$imageAlt = stripslashes($slideTitle);
						if(empty($imageAlt))
							$imageAlt = "slide";
						
						if($bgType == "image")
							$title .= " (".$filename.")";
						
						$slideid = $slide->getID();
						
						$urlEditSlide = self::getViewUrl(RevSliderAdmin::VIEW_SLIDE,"id=$slideid");
						$linkEdit = UniteFunctionsRev::getHtmlLink($urlEditSlide, $title);
						
						$state = $slide->getParam("state","published");
					
				?>
					<li id="slidelist_item_<?php echo $slideid?>" class="ui-state-default">
						
						<span class="slide-col col-order">
							<span class="order-text"><?php echo $counter?></span>
							<div class="state_loader" style="display:none;"></div>
							<?php if($state == "published"):?>
							<div class="icon_state state_published" data-slideid="<?php echo $slideid?>" title="<?php _e("Unpublish Slide",REVSLIDER_TEXTDOMAIN)?>"></div>
							<?php else:?>
							<div class="icon_state state_unpublished" data-slideid="<?php echo $slideid?>" title="<?php _e("Publish Slide",REVSLIDER_TEXTDOMAIN)?>"></div>
							<?php endif?>
							
							<div class="icon_slide_preview" title="Preview Slide" data-slideid="<?php echo $slideid?>"></div>
							
						</span>
						
						<span class="slide-col col-name">
							<div class="slide-title-in-list"><?php echo $linkEdit?></div>
							<a class='button-primary revgreen' href='<?php echo $urlEditSlide?>' style="width:120px; "><i class="revicon-pencil-1"></i><?php _e("Edit Slide",REVSLIDER_TEXTDOMAIN)?></a>
						</span>
						<span class="slide-col col-image">
							<?php switch($bgType):
									default:
									case "image":
										?>
										<div id="slide_image_<?php echo $slideid?>" style="background-image:url('<?php echo $urlImageForView?>');<?php echo $bgStyle; ?>" class="slide_image" title="Slide Image - Click to change"></div>
										<?php 
									break;
									case "solid":
										$bgColor = $slide->getParam("slide_bg_color","#d0d0d0");
										?>
										<div class="slide_color_preview" style="background-color:<?php echo $bgColor?>"></div>
										<?php 
									break;
									case "trans":
										?>
										<div class="slide_color_preview_trans"></div>
										<?php 
									break;
									endswitch;  ?>
						</span>
						
						<span class="slide-col col-operations">
							<a id="" class='button-primary revred button_delete_slide ' style="width:120px; margin-top:8px !important" data-slideid="<?php echo $slideid?>" href='javascript:void(0)'><i class="revicon-trash"></i><?php _e("Delete",REVSLIDER_TEXTDOMAIN)?></a>
							<span class="loader_round loader_delete" style="display:none;"><?php _e("Deleting Slide...",REVSLIDER_TEXTDOMAIN)?></span>
							<a id="button_duplicate_slide_<?php echo $slideid?>" style="width:120px; " class='button-primary revyellow button_duplicate_slide' href='javascript:void(0)'><i class="revicon-picture"></i><?php _e("Duplicate",REVSLIDER_TEXTDOMAIN)?></a>
							<?php
								$copyButtonClass = "button-primary revblue  button_copy_slide";
								$copyButtonTitle = __("Open copy / move dialog",REVSLIDER_TEXTDOMAIN);
								
								if($numSliders == 0){
								 	$copyButtonClass .= " button-disabled";
								 	$copyButtonTitle = "Copy / move disabled, no more sliders found";
							 	}
							?>
							<a id="button_copy_slide_<?php echo $slideid?>" class='<?php echo $copyButtonClass?>' title="<?php echo $copyButtonTitle?>" style="width:120px; " href='javascript:void(0)'><i class="revicon-picture"></i><?php _e("Copy / Move",REVSLIDER_TEXTDOMAIN)?></a>							
							<span class="loader_round loader_copy mtop_10 mleft_20 display_block" style="display:none;"><?php _e("Working...",REVSLIDER_TEXTDOMAIN)?></span>
						</span>
						
						<span class="slide-col col-handle">
							<div class="col-handle-inside">
								<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
							</div>
						</span>	
						<div class="clear"></div>
						<?php if($showLangs == true):?>
						<ul class="list_slide_icons">
							<?php foreach($arrChildLangs as $arrLang):
									$isParent = UniteFunctionsRev::boolToStr($arrLang["isparent"]);
									$childSlideID = $arrLang["slideid"];
									$lang = $arrLang["lang"];
									$urlFlag = UniteWpmlRev::getFlagUrl($lang);
									$langTitle = UniteWpmlRev::getLangTitle($lang);	
							?>
							<li>
								<img id="icon_lang_<?php echo $childSlideID?>" class="icon_slide_lang" src="<?php echo $urlFlag?>" title="<?php echo $langTitle?>" data-slideid="<?php echo $childSlideID?>" data-lang="<?php echo $lang?>" data-isparent="<?php echo $isParent?>">
								<div class="icon_lang_loader loader_round" style="display:none"></div>								
							</li>
							<?php endforeach?>
							<li>
								<div id="icon_add_lang_<?php echo $slideid?>" class="icon_slide_lang_add" data-operation="add" data-slideid="<?php echo $slideid?>" <?php echo $addItemStyle?>></div>
								<div class="icon_lang_loader loader_round" style="display:none"></div>
							</li>
						</ul>						
						<?php endif?>
					</li>
				<?php endforeach;?>
			</ul>
			
		</div>
	</div>