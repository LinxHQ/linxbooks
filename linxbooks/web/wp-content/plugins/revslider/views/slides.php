<?php

	$operations = new RevOperations();

	$sliderID = self::getGetVar("id");
	
	if(empty($sliderID))
		UniteFunctionsRev::throwError("Slider ID not found"); 
	
	$slider = new RevSlider();
	$slider->initByID($sliderID);
	$sliderParams = $slider->getParams();
	
	$arrSliders = $slider->getArrSlidersShort($sliderID);
	$selectSliders = UniteFunctionsRev::getHTMLSelect($arrSliders,"","id='selectSliders'",true);
	
	$numSliders = count($arrSliders);
	
	//set iframe parameters	
	$width = $sliderParams["width"];
	$height = $sliderParams["height"];
	
	$iframeWidth = $width+60;
	$iframeHeight = $height+50;
	
	$iframeStyle = "width:".$iframeWidth."px;height:".$iframeHeight."px;";
	
	$arrSlides = $slider->getSlides(false);
	
	$numSlides = count($arrSlides);
	
	$linksSliderSettings = self::getViewUrl(RevSliderAdmin::VIEW_SLIDER,"id=$sliderID");
	
	$patternViewSlide = self::getViewUrl("slide","id=[slideid]");		
	
	//treat in case of slides from gallery
	if($slider->isSlidesFromPosts() == false){
		
		$templateName = "slides_gallery";
		
		//handle wpml
		$isWpmlExists = UniteWpmlRev::isWpmlExists();
		$useWpml = $slider->getParam("use_wpml","off");
		
		$wpmlActive = false;
		if($isWpmlExists && $useWpml == "on"){
			$wpmlActive = true;
			
			//get langs floating menu
			$urlIconDelete = self::$url_plugin."images/icon-trash.png";
			$urlIconEdit = self::$url_plugin."images/icon-edit.png";
			$urlIconPreview = self::$url_plugin."images/preview.png";
			
			$textDelete = __("Delete Slide",REVSLIDER_TEXTDOMAIN);
			$textEdit = __("Edit Slide",REVSLIDER_TEXTDOMAIN);
			$textPreview = __("Preview Slide",REVSLIDER_TEXTDOMAIN);
			
			$htmlBefore = "";
			$htmlBefore .= "<li class='item_operation operation_delete'><a data-operation='delete' href='javascript:void(0)'>"."\n";
			$htmlBefore .= "<img src='".$urlIconDelete."'/> ".$textDelete."\n";				
			$htmlBefore .= "</a></li>"."\n";
			
			$htmlBefore .= "<li class='item_operation operation_edit'><a data-operation='edit' href='javascript:void(0)'>"."\n";
			$htmlBefore .= "<img src='".$urlIconEdit."'/> ".$textEdit."\n";				
			$htmlBefore .= "</a></li>"."\n";
			
			$htmlBefore .= "<li class='item_operation operation_preview'><a data-operation='preview' href='javascript:void(0)'>"."\n";
			$htmlBefore .= "<img src='".$urlIconPreview."'/> ".$textPreview."\n";				
			$htmlBefore .= "</a></li>"."\n";
			
			$htmlBefore .= "<li class='item_operation operation_sap'>"."\n";
			$htmlBefore .= "<div class='float_menu_sap'></div>"."\n";				
			$htmlBefore .= "</a></li>"."\n";
			
			$langFloatMenu = UniteWpmlRev::getLangsWithFlagsHtmlList("id='slides_langs_float' class='slides_langs_float'",$htmlBefore);
		}
			
	}
	
	else{	//slides from posts
		
		$templateName = "slides_posts";
		
		$sourceType = $slider->getParam("source_type","posts");
		$showSortBy = ($sourceType == "posts")?true:false;
		
		//get button links
		$urlNewPost = UniteFunctionsWPRev::getUrlNewPost();
		$linkNewPost = UniteFunctionsRev::getHtmlLink($urlNewPost, __("<i class='revicon-pencil-1'></i>New Post",REVSLIDER_TEXTDOMAIN),"button_new_post","button-primary revblue",true);
		
		//get ordering
		$arrSortBy = UniteFunctionsWPRev::getArrSortBy();
		$sortBy = $slider->getParam("post_sortby",RevSlider::DEFAULT_POST_SORTBY);
		$selectSortBy = UniteFunctionsRev::getHTMLSelect($arrSortBy,$sortBy,"id='select_sortby'",true);
	}
	
	
	require self::getPathTemplate($templateName);
	
?>
	