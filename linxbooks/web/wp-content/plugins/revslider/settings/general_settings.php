<?php

	$generalSettings = new UniteSettingsRev();
	
	$generalSettings->addSelect("role", 
								array(UniteBaseAdminClassRev::ROLE_ADMIN => __("To Admin",REVSLIDER_TEXTDOMAIN),
									  UniteBaseAdminClassRev::ROLE_EDITOR =>__("To Editor, Admin",REVSLIDER_TEXTDOMAIN),
									  UniteBaseAdminClassRev::ROLE_AUTHOR =>__("Author, Editor, Admin",REVSLIDER_TEXTDOMAIN)),									  
									  __("View Plugin Permission",REVSLIDER_TEXTDOMAIN), 
									  UniteBaseAdminClassRev::ROLE_ADMIN, 
									  array("description"=>__("The role of user that can view and edit the plugin",REVSLIDER_TEXTDOMAIN)));

	$generalSettings->addRadio("includes_globally", 
							   array("on"=>__("On",REVSLIDER_TEXTDOMAIN),"off"=>__("Off",REVSLIDER_TEXTDOMAIN)),
							   __("Include RevSlider libraries globally",REVSLIDER_TEXTDOMAIN),
							   "on",
							   array("description"=>__("Add css and js includes only on all pages. Id turned to off they will added to pages where the rev_slider shortcode exists only. This will work only when the slider added by a shortcode.",REVSLIDER_TEXTDOMAIN)));
	
	$generalSettings->addTextBox("pages_for_includes", "",__("Pages to include RevSlider libraries",REVSLIDER_TEXTDOMAIN),
								  array("description"=>__("Specify the page id's that the front end includes will be included in. Example: 2,3,5 also: homepage,3,4",REVSLIDER_TEXTDOMAIN)));
									  
	$generalSettings->addRadio("js_to_footer", 
							   array("on"=>__("On",REVSLIDER_TEXTDOMAIN),"off"=>__("Off",REVSLIDER_TEXTDOMAIN)),
							   __("Put JS Includes To Footer",REVSLIDER_TEXTDOMAIN),
							   "off",
							   array("description"=>__("Putting the js to footer (instead of the head) is good for fixing some javascript conflicts.",REVSLIDER_TEXTDOMAIN)));
	
	$generalSettings->addRadio("show_dev_export", 
							   array("on"=>__("On",REVSLIDER_TEXTDOMAIN),"off"=>__("Off",REVSLIDER_TEXTDOMAIN)),
							   __("Enable Markup Export option",REVSLIDER_TEXTDOMAIN),
							   "off",
							   array("description"=>__("This will enable the option to export the Slider Markups to copy/paste it directly into websites.",REVSLIDER_TEXTDOMAIN)));
		
	$generalSettings->addRadio("enable_logs", 
							   array("on"=>__("On",REVSLIDER_TEXTDOMAIN),"off"=>__("Off",REVSLIDER_TEXTDOMAIN)),
							   __("Enable Logs",REVSLIDER_TEXTDOMAIN),
							   "off",
							   array("description"=>__("Enable console logs for debugging.",REVSLIDER_TEXTDOMAIN)));
	//transition
	/*$operations = new RevOperations();
	$arrTransitions = $operations->getArrTransition();
	$arrPremiumTransitions = $operations->getArrTransition(true);
	
	$arrTransitions = array_merge($arrTransitions, $arrPremiumTransitions);
	$params = array("description"=>"<br>".__("The default appearance transitions of slides.",REVSLIDER_TEXTDOMAIN),"minwidth"=>"450px");
	$generalSettings->addRadio("slide_transition_default",$arrTransitions,__("Default Transition",REVSLIDER_TEXTDOMAIN),"random",$params);
	*/
	//--------------------------
	
	//get stored values
	$operations = new RevOperations();
	$arrValues = $operations->getGeneralSettingsValues();
	$generalSettings->setStoredValues($arrValues);
	
	self::storeSettings("general", $generalSettings);

?>