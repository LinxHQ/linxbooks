<?php

	//set Slide settings
	$arrTransitions = $operations->getArrTransition();
	$arrPremiumTransitions = $operations->getArrTransition(true);
	$defaultTransition = $operations->getDefaultTransition();

	$arrSlideNames = array();
	if(isset($slider) && $slider->isInited())
		$arrSlideNames = $slider->getArrSlideNames();

	$slideSettings = new UniteSettingsAdvancedRev();

	//title
	$params = array("description"=>__("The title of the slide, will be shown in the slides list.",REVSLIDER_TEXTDOMAIN),"class"=>"medium");
	$slideSettings->addTextBox("title",__("Slide",REVSLIDER_TEXTDOMAIN),__("Slide Title",REVSLIDER_TEXTDOMAIN), $params);

	//state
	$params = array("description"=>__("The state of the slide. The unpublished slide will be excluded from the slider.",REVSLIDER_TEXTDOMAIN));
	$slideSettings->addSelect("state",array("published"=>__("Published",REVSLIDER_TEXTDOMAIN),"unpublished"=>__("Unpublished",REVSLIDER_TEXTDOMAIN)),__("State",REVSLIDER_TEXTDOMAIN),"published",$params);

	if(isset($slider) && $slider->isInited()){
		$isWpmlExists = UniteWpmlRev::isWpmlExists();
		$useWpml = $slider->getParam("use_wpml","off");

		if($isWpmlExists && $useWpml == "on"){
			$arrLangs = UniteWpmlRev::getArrLanguages();
			$params = array("description"=>__("The language of the slide (uses WPML plugin).",REVSLIDER_TEXTDOMAIN));
			$slideSettings->addSelect("lang",$arrLangs,__("Language",REVSLIDER_TEXTDOMAIN),"all",$params);
		}
	}

	$params = array("description"=>__("If set, slide will be visible after the date is reached",REVSLIDER_TEXTDOMAIN));
	$slideSettings->addDatePicker("date_from","",__("Visible from",REVSLIDER_TEXTDOMAIN), $params);

	$params = array("description"=>__("If set, slide will be visible till the date is reached",REVSLIDER_TEXTDOMAIN));
	$slideSettings->addDatePicker("date_to","",__("Visible until",REVSLIDER_TEXTDOMAIN), $params);

	$slideSettings->addHr("");

	//transition
	$params = array("description"=>__("The appearance transitions of this slide.",REVSLIDER_TEXTDOMAIN),"minwidth"=>"250px");
	$slideSettings->addChecklist("slide_transition",$arrTransitions,__("Transitions",REVSLIDER_TEXTDOMAIN),$defaultTransition,$params);

	//slot amount
	$params = array("description"=>__("The number of slots or boxes the slide is divided into. If you use boxfade, over 7 slots can be juggy.",REVSLIDER_TEXTDOMAIN)
		,"class"=>"small","datatype"=>"number"
	);
	$slideSettings->addTextBox("slot_amount","7",__("Slot Amount",REVSLIDER_TEXTDOMAIN), $params);

	//rotation:
	$params = array("description"=>__("Rotation (-720 -> 720, 999 = random) Only for Simple Transitions.",REVSLIDER_TEXTDOMAIN)
		,"class"=>"small","datatype"=>"number"
	);
	$slideSettings->addTextBox("transition_rotation","0",__("Rotation",REVSLIDER_TEXTDOMAIN), $params);

	//transition speed
	$params = array("description"=>__("The duration of the transition (Default:300, min: 100 max 2000). ",REVSLIDER_TEXTDOMAIN)
		,"class"=>"small","datatype"=>"number"
	);
	$slideSettings->addTextBox("transition_duration","300",__("Transition Duration",REVSLIDER_TEXTDOMAIN), $params);
	

	if(!isset($sliderDelay))
		$sliderDelay = 0;

	//delay
	$params = array("description"=>__("A new delay value for the Slide. If no delay defined per slide, the delay defined via Options (",REVSLIDER_TEXTDOMAIN). $sliderDelay .__("ms) will be used",REVSLIDER_TEXTDOMAIN)
		,"class"=>"small","datatype"=>UniteSettingsRev::DATATYPE_NUMBEROREMTY
	);
	$slideSettings->addTextBox("delay","",__("Delay",REVSLIDER_TEXTDOMAIN), $params);

	$params = array("description"=>__("",REVSLIDER_TEXTDOMAIN)
		,"class"=>"small"
	);
	$slideSettings->addRadio("save_performance", array("on"=>__("On",REVSLIDER_TEXTDOMAIN),"off"=>__("Off",REVSLIDER_TEXTDOMAIN)), __("Save Performance",REVSLIDER_TEXTDOMAIN),"off", $params);
	
	$slideSettings->addHr("");

	//-----------------------

	//enable link
	$slideSettings->addSelect_boolean("enable_link", __("Enable Link",REVSLIDER_TEXTDOMAIN), false, __("Enable",REVSLIDER_TEXTDOMAIN),__("Disable",REVSLIDER_TEXTDOMAIN));

	$slideSettings->startBulkControl("enable_link", UniteSettingsRev::CONTROL_TYPE_SHOW, "true");

		//link type
		$slideSettings->addRadio("link_type", array("regular"=>__("Regular",REVSLIDER_TEXTDOMAIN),"slide"=>__("To Slide",REVSLIDER_TEXTDOMAIN)), __("Link Type",REVSLIDER_TEXTDOMAIN),"regular");

		//link
		$params = array('id'=>'rev_link', "description"=>__("A link on the whole slide pic (use %link% or %meta:somemegatag% in template sliders to link to a post or some other meta)",REVSLIDER_TEXTDOMAIN));
		$slideSettings->addTextBox("link","",__("Slide Link",REVSLIDER_TEXTDOMAIN), $params);

		//link target
		$params = array("description"=>__("The target of the slide link",REVSLIDER_TEXTDOMAIN));
		$slideSettings->addSelect("link_open_in",array("same"=>__("Same Window",REVSLIDER_TEXTDOMAIN),"new"=>__("New Window")),__("Link Open In",REVSLIDER_TEXTDOMAIN),"same",$params);

		//num_slide_link
		$arrSlideLink = array();
		$arrSlideLink["nothing"] = __("-- Not Chosen --",REVSLIDER_TEXTDOMAIN);
		$arrSlideLink["next"] = __("-- Next Slide --",REVSLIDER_TEXTDOMAIN);
		$arrSlideLink["prev"] = __("-- Previous Slide --",REVSLIDER_TEXTDOMAIN);

		$arrSlideLinkLayers = $arrSlideLink;
		$arrSlideLinkLayers["scroll_under"] = __("-- Scroll Below Slider --",REVSLIDER_TEXTDOMAIN);

		foreach($arrSlideNames as $slideNameID=>$arr){
			$slideName = $arr["title"];
			$arrSlideLink[$slideNameID] = $slideName;
			$arrSlideLinkLayers[$slideNameID] = $slideName;
		}

		$slideSettings->addSelect("slide_link", $arrSlideLink, "Link To Slide","nothing");

		$params = array("description"=>"The position of the link related to layers");
		$slideSettings->addRadio("link_pos", array("front"=>"Front","back"=>"Back"), "Link Position","front",$params);

		//$slideSettings->addHr("link_sap");

	$slideSettings->endBulkControl();

		$slideSettings->addControl("link_type", "slide_link", UniteSettingsRev::CONTROL_TYPE_ENABLE, "slide");
		$slideSettings->addControl("link_type", "link", UniteSettingsRev::CONTROL_TYPE_DISABLE, "slide");
		$slideSettings->addControl("link_type", "link_open_in", UniteSettingsRev::CONTROL_TYPE_DISABLE, "slide");

	//-----------------------

	$slideSettings->addHr("");

	$params = array("description"=>__("Slide Thumbnail. If not set - it will be taken from the slide image.",REVSLIDER_TEXTDOMAIN));
	$slideSettings->addImage("slide_thumb", "",__("Thumbnail",REVSLIDER_TEXTDOMAIN) , $params);

	//$params = array("description"=>__("Apply to full width mode only. Centering vertically slide images.",REVSLIDER_TEXTDOMAIN));
	//$slideSettings->addCheckbox("fullwidth_centering", false, __("Full Width Centering",REVSLIDER_TEXTDOMAIN), $params);


	//add background type (hidden)
	$slideSettings->addTextBox("background_type","image",__("Background Type",REVSLIDER_TEXTDOMAIN), array("hidden"=>true));
	//store settings
	
	$slideSettings->addHr("");
	
	$params = array("description"=>__('Adds a unique class to the li of the Slide like class="rev_special_class" (add only the classnames, seperated by space)',REVSLIDER_TEXTDOMAIN));
	$slideSettings->addTextBox("class_attr","",__("Class",REVSLIDER_TEXTDOMAIN), $params);
	
	$params = array("description"=>__('Adds a unique ID to the li of the Slide like id="rev_special_id" (add only the id)',REVSLIDER_TEXTDOMAIN));
	$slideSettings->addTextBox("id_attr","",__("ID",REVSLIDER_TEXTDOMAIN), $params);
	
	$params = array("description"=>__('Adds a unique Attribute to the li of the Slide like attr="rev_special_attr" (add only the attribute)',REVSLIDER_TEXTDOMAIN));
	$slideSettings->addTextBox("attr_attr","",__("Attribute",REVSLIDER_TEXTDOMAIN), $params);
	
	$params = array("description"=>__('Add as many attributes as you wish here. (i.e.: data-layer="firstlayer" data-custom="somevalue")',REVSLIDER_TEXTDOMAIN));
	$slideSettings->addTextArea("data_attr","",__("Custom Fields",REVSLIDER_TEXTDOMAIN), $params);
	
	self::storeSettings("slide_settings",$slideSettings);

?>
