			<?php
				
				//set "slider_main" settings
				$sliderMainSettings = new UniteSettingsAdvancedRev();
				
				$sliderMainSettings->addTextBox("title", "",__("Slider Title",REVSLIDER_TEXTDOMAIN),array("description"=>__("The title of the slider. Example: Slider1",REVSLIDER_TEXTDOMAIN),"required"=>"true"));	
				$sliderMainSettings->addTextBox("alias", "",__("Slider Alias",REVSLIDER_TEXTDOMAIN),array("description"=>__("The alias that will be used for embedding the slider. Example: slider1",REVSLIDER_TEXTDOMAIN),"required"=>"true"));
				$sliderMainSettings->addTextBox("shortcode", "",__("Slider Shortcode",REVSLIDER_TEXTDOMAIN), array("readonly"=>true,"class"=>"code"));
				$sliderMainSettings->addHr();
				
				//source type
				$arrSourceTypes = array("posts"=>__("Posts",REVSLIDER_TEXTDOMAIN),
										"specific_posts"=>__("Specific Posts",REVSLIDER_TEXTDOMAIN),
										"gallery"=>__("Gallery",REVSLIDER_TEXTDOMAIN));
				
				$sliderMainSettings->addRadio("source_type",$arrSourceTypes,__("Source Type",REVSLIDER_TEXTDOMAIN), "gallery"); 
				
				$sliderMainSettings->startBulkControl("source_type", UniteSettingsRev::CONTROL_TYPE_SHOW, "posts");
										
					//post types
					$arrPostTypes = UniteFunctionsWPRev::getPostTypesAssoc(array("post"));
					$arrParams = array("args"=>"multiple size='5'");
					$sliderMainSettings->addSelect("post_types", $arrPostTypes, __("Post Types",REVSLIDER_TEXTDOMAIN),"post",$arrParams);
	
					//post categories
					$arrParams = array("args"=>"multiple size='7'");
					$sliderMainSettings->addSelect("post_category", array(), __("Post Categories",REVSLIDER_TEXTDOMAIN),"",$arrParams);
					
					//sort by
					$arrSortBy = UniteFunctionsWPRev::getArrSortBy();
					
					//events integration
					if(UniteEmRev::isEventsExists()){
						$arrEventsFilter = UniteEmRev::getArrFilterTypes();
						$sliderMainSettings->addHr();
						$sliderMainSettings->addSelect("events_filter", $arrEventsFilter, __("Filter Events By",REVSLIDER_TEXTDOMAIN),UniteEmRev::DEFAULT_FILTER);
						$sliderMainSettings->addHr();
						
						//add values to sortby array
						$arrEMSortBy = UniteEmRev::getArrSortBy();
						$arrSortBy = $arrSortBy+$arrEMSortBy;						
					}
					
					$sliderMainSettings->addSelect("post_sortby", $arrSortBy, __("Sort Posts By",REVSLIDER_TEXTDOMAIN),RevSlider::DEFAULT_POST_SORTBY);
										
					//sort direction
					$arrSortDir = UniteFunctionsWPRev::getArrSortDirection();
					$sliderMainSettings->addRadio("posts_sort_direction", $arrSortDir, __("Sort Direction",REVSLIDER_TEXTDOMAIN), RevSlider::DEFAULT_POST_SORTDIR);
					
					//max posts for slider
					$arrParams = array("class"=>"small","unit"=>"posts");
					$sliderMainSettings->addTextBox("max_slider_posts", "30", __("Max Posts Per Slider",REVSLIDER_TEXTDOMAIN), $arrParams);
					
					//exerpt limit
					$arrParams = array("class"=>"small","unit"=>"words");		
					$sliderMainSettings->addTextBox("excerpt_limit", "55", __("Limit The Excerpt To",REVSLIDER_TEXTDOMAIN), $arrParams);
										
					//slider template
					$sliderMainSettings->addhr();
					
					$slider1 = new RevSlider();
					$arrSlidersTemplates = $slider1->getArrSlidersShort(null,RevSlider::SLIDER_TYPE_TEMPLATE);				
					$sliderMainSettings->addSelect("slider_template_id", $arrSlidersTemplates, __("Template Slider",REVSLIDER_TEXTDOMAIN),"",array());
					
				$sliderMainSettings->endBulkControl();
				
				$arrParams = array("description"=>__("Type here the post IDs you want to use separated by coma. ex: 23,24,25",REVSLIDER_TEXTDOMAIN));
				$sliderMainSettings->addTextBox("posts_list","",__("Specific Posts List",REVSLIDER_TEXTDOMAIN),$arrParams);
				$sliderMainSettings->addControl("source_type", "posts_list", UniteSettingsRev::CONTROL_TYPE_SHOW, "specific_posts");
				
				$sliderMainSettings->addHr();
				
				//set slider type / texts
				$sliderMainSettings->addRadio("slider_type", array("fixed"=>__("Fixed",REVSLIDER_TEXTDOMAIN),
					"responsitive"=>__("Custom",REVSLIDER_TEXTDOMAIN),
					"fullwidth"=>__("Auto Responsive",REVSLIDER_TEXTDOMAIN),
					"fullscreen"=>__("Full Screen",REVSLIDER_TEXTDOMAIN)
					),__("Slider Layout",REVSLIDER_TEXTDOMAIN),		
					"fullwidth");
			
				$arrParams = array("class"=>"medium","description"=>__("Example: #header or .header, .footer, #somecontainer | The height of fullscreen slider will be decreased with the height of these Containers to fit perfect in the screen",REVSLIDER_TEXTDOMAIN));
				$sliderMainSettings->addTextBox("fullscreen_offset_container", "",__("Offset Containers",REVSLIDER_TEXTDOMAIN), $arrParams);
				
				$sliderMainSettings->addControl("slider_type", "fullscreen_offset_container", UniteSettingsRev::CONTROL_TYPE_SHOW, "fullscreen");
				
				$arrParams = array("class"=>"medium","description"=>__("Defines an Offset to the top. Can be used with px and %. Example: 40px or 10%",REVSLIDER_TEXTDOMAIN));
				$sliderMainSettings->addTextBox("fullscreen_offset_size", "",__("Offset Size",REVSLIDER_TEXTDOMAIN), $arrParams);
				
				$sliderMainSettings->addControl("slider_type", "fullscreen_offset_size", UniteSettingsRev::CONTROL_TYPE_SHOW, "fullscreen");
				
				$arrParams = array("description"=>__("",REVSLIDER_TEXTDOMAIN));
				$sliderMainSettings->addTextBox("fullscreen_min_height", "",__("Min. Fullscreen Height",REVSLIDER_TEXTDOMAIN), $arrParams);
				
				$sliderMainSettings->addControl("slider_type", "fullscreen_min_height", UniteSettingsRev::CONTROL_TYPE_SHOW, "fullscreen");
					
				$sliderMainSettings->addRadio("full_screen_align_force", array("on"=>__("On",REVSLIDER_TEXTDOMAIN), "off"=>__("Off",REVSLIDER_TEXTDOMAIN)),__("FullScreen Align",REVSLIDER_TEXTDOMAIN),"off");
				
				
				$sliderMainSettings->addRadio("auto_height", array("on"=>__("On",REVSLIDER_TEXTDOMAIN), "off"=>__("Off",REVSLIDER_TEXTDOMAIN)),__("Unlimited Height",REVSLIDER_TEXTDOMAIN),"off");
				$sliderMainSettings->addRadio("force_full_width", array("on"=>__("On",REVSLIDER_TEXTDOMAIN), "off"=>__("Off",REVSLIDER_TEXTDOMAIN)),__("Force Full Width",REVSLIDER_TEXTDOMAIN),"off");
				
				$arrParams = array("description"=>__("",REVSLIDER_TEXTDOMAIN));
				$sliderMainSettings->addTextBox("min_height", "0",__("Min. Height",REVSLIDER_TEXTDOMAIN), $arrParams);
				$sliderMainSettings->addControl("slider_type", "min_height", UniteSettingsRev::CONTROL_TYPE_HIDE, "fullscreen");
				
				$paramsSize = array("width"=>960,"height"=>350,"datatype"=>UniteSettingsRev::DATATYPE_NUMBER,"description"=>__('
- The <span class="prevxmpl">LAYERS GRID</span> is the container of layers within the <span class="prevxmpl">SLIDER</span> <br>
- The "Grid Size" setting does not relate to the actual "Slider Size". <br>
- "Max Height" of the slider equals the "Grid Height"<br>
- "Slider Width" can be greater than the set "Grid Width"',REVSLIDER_TEXTDOMAIN));
				$sliderMainSettings->addCustom("slider_size", "slider_size","",__("Layers Grid Size",REVSLIDER_TEXTDOMAIN),$paramsSize);
				
				
				$paramsResponsitive = array("w1"=>940,"sw1"=>770,"w2"=>780,"sw2"=>500,"w3"=>510,"sw3"=>310,"datatype"=>UniteSettingsRev::DATATYPE_NUMBER);
				$sliderMainSettings->addCustom("responsitive_settings", "responsitive","",__("Responsive Sizes",REVSLIDER_TEXTDOMAIN),$paramsResponsitive);

				$sliderMainSettings->addHr();
				
				self::storeSettings("slider_main",$sliderMainSettings);
				
				//set "slider_params" settings. 
				$sliderParamsSettings = new UniteSettingsAdvancedRev();	
				$sliderParamsSettings->loadXMLFile(self::$path_settings."/slider_settings.xml");
				
				//update transition type setting.
				$settingFirstType = $sliderParamsSettings->getSettingByName("first_transition_type");
				$operations = new RevOperations();
				$arrTransitions = $operations->getArrTransition();
				if(count($arrTransitions) == 0) $arrTransitions = $operations->getArrTransition(true); //get premium transitions
				$settingFirstType["items"] = $arrTransitions;
				$sliderParamsSettings->updateArrSettingByName("first_transition_type", $settingFirstType);
				
				//store params
				self::storeSettings("slider_params",$sliderParamsSettings);
				 
				?>
				