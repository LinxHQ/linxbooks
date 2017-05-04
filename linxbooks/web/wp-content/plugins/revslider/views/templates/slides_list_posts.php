	<div class="postbox box-slideslist">
		<h3>
			<span class='slideslist-title'><?php _e("Slides List",REVSLIDER_TEXTDOMAIN)?></span>
			<span id="saving_indicator" class='slideslist-loading'><?php _e("Saving Order",REVSLIDER_TEXTDOMAIN)?>...</span>
		</h3>
		<div class="inside">
			<?php if(empty($arrSlides)):?>
				<?php _e("No Slides Found",REVSLIDER_TEXTDOMAIN)?>
			<?php endif?>
			<ul id="list_slides" class="list_slides ui-sortable">
				<?php foreach($arrSlides as $index=>$slide):
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
					
					if($sortBy == UniteFunctionsWPRev::SORTBY_MENU_ORDER)
						$order = $slide->getOrder();
					else
						$order = $index + 1;
						
					$urlImageForView = $slide->getUrlImageThumb();
					$slideTitle = $slide->getParam("title","Slide");
					$title = $slideTitle;
					$filename = $slide->getImageFilename();
					$imageAlt = stripslashes($slideTitle);
					
					if(empty($imageAlt))
						$imageAlt = "slide";
						
					if($bgType == "image" && !empty($filename))
						$title .= " (".$filename.")";
						
					$postID = $slide->getID();
					$urlEditSlide = UniteFunctionsWPRev::getUrlEditPost($postID);
					$linkEdit = UniteFunctionsRev::getHtmlLink($urlEditSlide, $title,"","",true);
					$state = $slide->getParam("state","published");
					?>
					<li id="slidelist_item_<?php echo $postID?>" class="ui-state-default">
						<span class="slide-col col-order">
							<span class="order-text"><?php echo $order?></span>
							<div class="state_loader" style="display:none;"></div>
							<?php if($state == "published"):?>
								<div class="icon_state state_published" data-slideid="<?php echo $postID?>" title="<?php _e("Unpublish Post",REVSLIDER_TEXTDOMAIN)?>"></div>
							<?php else:?>
								<div class="icon_state state_unpublished" data-slideid="<?php echo $postID?>" title="<?php _e("Publish Post",REVSLIDER_TEXTDOMAIN)?>"></div>
							<?php endif?>
						</span>
						<span class="slide-col col-name">
							<div class="slide-title-in-list"><?php echo $linkEdit?></div>
							<a class='button-primary revgreen' href='<?php echo $urlEditSlide?>'><i class="revicon-pencil-1"></i><?php _e("Edit Post",REVSLIDER_TEXTDOMAIN)?></a>
						</span>
						<span class="slide-col col-image">
							<?php if(!empty($urlImageForView)):?>
								<div id="slide_image_<?php echo $postID?>" class="slide_image" title="Click to change the slide image. Note: The post featured image will be changed." alt="<?php echo $imageAlt?>" style="background-image:url('<?php echo $urlImageForView?>');<?php echo $bgStyle; ?>"></div>
							<?php else:?>
								no image
							<?php endif?>
						</span>
						<span class="slide-col col-operations-posts">
							<a id="button_delete_slide" class='button-primary revred button_delete_slide' data-slideid="<?php echo $postID?>" href='javascript:void(0)'><i class="revicon-trash"></i><?php _e("Delete",REVSLIDER_TEXTDOMAIN)?></a>
						</span>
						<span class="slide-col col-handle">
							<div class="col-handle-inside">
								<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
							</div>
						</span>
						<div class="clear"></div>
					</li>
				<?php endforeach;?>	
			</ul>
		</div>
	</div>