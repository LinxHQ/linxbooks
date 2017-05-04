<?php

	class RevSliderOutput{

		private static $sliderSerial = 0;

		private $sliderHtmlID;
		private $sliderHtmlID_wrapper;
		private $slider;
		private $oneSlideMode = false;
		private $oneSlideData;
		private $previewMode = false;	//admin preview mode
		private $slidesNumIndex;
		private $sliderLang = null;
		private $hasOnlyOneSlide = false;
		private $rev_inline_js = '';
		private $class_include = array();

		/**
		 *
		 * check the put in string
		 * return true / false if the put in string match the current page.
		 */
		public static function isPutIn($putIn,$emptyIsFalse = false){

			$putIn = strtolower($putIn);
			$putIn = trim($putIn);

			if($emptyIsFalse && empty($putIn))
				return(false);

			if($putIn == "homepage"){		//filter by homepage
				if(is_front_page() == false)
					return(false);
			}
			else		//case filter by pages
			if(!empty($putIn)){
				$arrPutInPages = array();
				$arrPagesTemp = explode(",", $putIn);
				foreach($arrPagesTemp as $page){
					$page = trim($page);
					if(is_numeric($page) || $page == "homepage")
						$arrPutInPages[] = $page;
				}
				if(!empty($arrPutInPages)){

					//get current page id
					$currentPageID = "";
					if(is_front_page() == true)
						$currentPageID = "homepage";
					else{
						global $post;
						if(isset($post->ID))
							$currentPageID = $post->ID;
					}

					//do the filter by pages
					if(array_search($currentPageID, $arrPutInPages) === false)
						return(false);
				}
			}

			return(true);
		}


		/**
		 *
		 * put the rev slider slider on the html page.
		 * @param $data - mixed, can be ID ot Alias.
		 */
		public static function putSlider($sliderID,$putIn=""){

			$isPutIn = self::isPutIn($putIn);
			if($isPutIn == false)
				return(false);
			
			//check if on mobile and if option hide on mobile is set

			$output = new RevSliderOutput();

			$output->putSliderBase($sliderID);

			$slider = $output->getSlider();
			return($slider);
		}


		/**
		 *
		 * set language
		 */
		public function setLang($lang){
			$this->sliderLang = $lang;
		}

		/**
		 *
		 * set one slide mode for preview
		 */
		public function setOneSlideMode($data){
			$this->oneSlideMode = true;
			$this->oneSlideData = $data;
		}

		/**
		 *
		 * set preview mode
		 */
		public function setPreviewMode(){
			$this->previewMode = true;
		}

		/**
		 *
		 * get the last slider after the output
		 */
		public function getSlider(){
			return($this->slider);
		}

		/**
		 *
		 * get slide full width video data
		 */
		private function getSlideFullWidthVideoData(RevSlide $slide){

			$response = array("found"=>false);

			//deal full width video:
			$enableVideo = $slide->getParam("enable_video","false");
			if($enableVideo != "true")
				return($response);

			$videoID = $slide->getParam("video_id","");
			$videoID = trim($videoID);

			if(empty($videoID))
				return($response);

			$response["found"] = true;

			$videoType = is_numeric($videoID)?"vimeo":"youtube";
			$videoAutoplay = $slide->getParam("video_autoplay");
			$videoCover = $slide->getParam("cover");
			$videoAutoplayOnlyFirstTime = $slide->getParam("autoplayonlyfirsttime");
			$previewimage = $slide->getParam("previewimage", "");
			$videoNextslide = $slide->getParam("video_nextslide");
			$mute = $slide->getParam("mute");

			$response["type"] = $videoType;
			$response["videoID"] = $videoID;
			$response["autoplay"] = UniteFunctionsRev::strToBool($videoAutoplay);
			$response["cover"] = UniteFunctionsRev::strToBool($videoCover);
			$response["autoplayonlyfirsttime"] = UniteFunctionsRev::strToBool($videoAutoplayOnlyFirstTime);
			$response["previewimage"] = UniteFunctionsRev::strToBool($previewimage);
			$response["nextslide"] = UniteFunctionsRev::strToBool($videoNextslide);
			$response["mute"] = UniteFunctionsRev::strToBool($mute);

			return($response);
		}


		/**
		 *
		 * put full width video layer
		 */
		private function putFullWidthVideoLayer($videoData){

			/*if($videoData["found"] == false)
				return(false);

			$autoplayonlyfirsttime = "";
			$autoplay = UniteFunctionsRev::boolToStr($videoData["autoplay"]);
			if($autoplay == "true"){
				$autoplayonlyfirsttime = UniteFunctionsRev::boolToStr($videoData["autoplayonlyfirsttime"]);
				$autoplayonlyfirsttime = ' data-autoplayonlyfirsttime="'. $autoplayonlyfirsttime.'"';
			}
			$nextslide = UniteFunctionsRev::boolToStr($videoData["nextslide"]);

			$htmlParams = 'data-x="0" data-y="0" data-speed="500" data-start="10" data-easing="easeOutBack"';

			if($videoData["previewimage"] != '') $htmlParams.= '			data-videoposter="'.$videoData["previewimage"].'"';

			$videoID = $videoData["videoID"];

			$setBase = (is_ssl()) ? "https://" : "http://";
			
			$mute = (UniteFunctionsRev::strToBool($videoData['mute'])) ? ' data-volume="mute"' : '';

			if($videoData["type"] == "youtube"):	//youtube
				?>	<div class="tp-caption fade fullscreenvideo " data-nextslideatend="<?php echo $nextslide?>" data-autoplay="<?php echo $autoplay?>"<?php echo $autoplayonlyfirsttime; ?> <?php echo $htmlParams?><?php echo $mute; ?>><iframe src="<?php echo $setBase; ?>www.youtube.com/embed/<?php echo $videoID?>?enablejsapi=1&amp;version=3&amp;html5=1&amp;hd=1&amp;controls=1&amp;showinfo=0;" allowfullscreen="true" width="100%" height="100%"></iframe></div><?php
			else:									//vimeo
				?>	<div class="tp-caption fade fullscreenvideo" data-nextslideatend="<?php echo $nextslide?>" data-autoplay="<?php echo $autoplay?>"<?php echo $autoplayonlyfirsttime; ?> <?php echo $htmlParams?><?php echo $mute; ?>><iframe src="<?php echo $setBase; ?>player.vimeo.com/video/<?php echo $videoID?>?title=0&amp;byline=0&amp;portrait=0;api=1" width="100%" height="100%"></iframe></div><?php
			endif;*/
		}

		/**
		 *
		 * filter the slides for one slide preview
		 */
		private function filterOneSlide($slides){

			$oneSlideID = $this->oneSlideData["slideid"];


			$oneSlideParams = UniteFunctionsRev::getVal($this->oneSlideData, "params");
			$oneSlideLayers = UniteFunctionsRev::getVal($this->oneSlideData, "layers");

			if(gettype($oneSlideParams) == "object")
				$oneSlideParams = (array)$oneSlideParams;

			if(gettype($oneSlideLayers) == "object")
				$oneSlideLayers = (array)$oneSlideLayers;

			if(!empty($oneSlideLayers))
				$oneSlideLayers = UniteFunctionsRev::convertStdClassToArray($oneSlideLayers);

			$newSlides = array();
			foreach($slides as $slide){
				$slideID = $slide->getID();

				if($slideID == $oneSlideID){

					if(!empty($oneSlideParams))
						$slide->setParams($oneSlideParams);

					if(!empty($oneSlideLayers))
						$slide->setLayers($oneSlideLayers);

					$newSlides[] = $slide;	//add 2 slides
					$newSlides[] = $slide;
				}
			}

			return($newSlides);
		}


		/**
		 *
		 * put the slider slides
		 */
		private function putSlides($doWrapFromTemplate){
			//go to template slider if post template
			if($doWrapFromTemplate !== false)	$this->slider->initByMixed($doWrapFromTemplate); //back to original Slider

			$sliderType = $this->slider->getParam("slider_type");

			$publishedOnly = true;
			if($this->previewMode == true && $this->oneSlideMode == true){
				$previewSlideID = UniteFunctionsRev::getVal($this->oneSlideData, "slideid");
				$previewSlide = new RevSlide();
				$previewSlide->initByID($previewSlideID);
				$slides = array($previewSlide);

			}else{
				$slides = $this->slider->getSlidesForOutput($publishedOnly,$this->sliderLang);
			}
			
			$this->slidesNumIndex = $this->slider->getSlidesNumbersByIDs(true);
			
			if(empty($slides)){
				?>
				<div class="no-slides-text">
					<?php
					if($this->slider->isSlidesFromPosts()){
						_e('No slides found, please add at least one Slide Template to the choosen Template Slider.', REVSLIDER_TEXTDOMAIN);
					}else{
						_e('No slides found, please add some slides', REVSLIDER_TEXTDOMAIN);
					}
					 ?>
				</div>
				<?php
			}

			//set that we are originally template slider
			$templateSlider = false;
			$postData = array();
			if($this->slider->isSlidesFromPosts() && $this->slider->getParam("slider_template_id",false) !== false){
				$templateSlider = true;
			}

			//go back to normal slider if post template
			if($doWrapFromTemplate)	$this->slider->initByMixed($this->slider->getParam("slider_template_id",false)); //back to template for JS

			$thumbWidth = $this->slider->getParam("thumb_width",100);
			$thumbHeight = $this->slider->getParam("thumb_height",50);

			$slideWidth = $this->slider->getParam("width",900);
			$slideHeight = $this->slider->getParam("height",300);

			$navigationType = $this->slider->getParam("navigaion_type","none");
			$isThumbsActive = ($navigationType == "thumb")?true:false;

			$lazyLoad = $this->slider->getParam("lazy_load","off");

			//for one slide preview
			if($this->oneSlideMode == true)
				$slides = $this->filterOneSlide($slides);

			echo "<ul>";

			$htmlFirstTransWrap = "";

			$startWithSlide = $this->slider->getStartWithSlideSetting();

			$firstTransActive = $this->slider->getParam("first_transition_active","false");
			if($firstTransActive == "true"){

				$firstTransition = $this->slider->getParam("first_transition_type","fade");
				$htmlFirstTransWrap .= " data-fstransition=\"$firstTransition\"";

				$firstDuration = $this->slider->getParam("first_transition_duration","300");
				if(!empty($firstDuration) && is_numeric($firstDuration))
					$htmlFirstTransWrap .= " data-fsmasterspeed=\"$firstDuration\"";

				$firstSlotAmount = $this->slider->getParam("first_transition_slot_amount","7");
				if(!empty($firstSlotAmount) && is_numeric($firstSlotAmount))
				$htmlFirstTransWrap .= " data-fsslotamount=\"$firstSlotAmount\"";

			}

			if(count($slides) == 1 && $this->oneSlideMode == false){
				$slides[] = $slides[0];
				$slides[1]->ignore_alt = true;
				$this->hasOnlyOneSlide = true;
			}

			foreach($slides as $index => $slide){
				$params = $slide->getParams();

				$cur_slide_title = $this->slider->getParam("navigation_style","round");

				if($templateSlider)
					$postData = $slide->getPostData();

				//check if date is set
				$date_from = $slide->getParam("date_from","");
				$date_to = $slide->getParam("date_to","");
				
				if($date_from != ""){
					$date_from = strtotime($date_from);
					if(time() < $date_from) continue;
				}

				if($date_to != ""){
					$date_to = strtotime($date_to);
					if(time() > $date_to) continue;
				}

				$transition = $slide->getParam("slide_transition","random");
				
				$transition_arr = explode(',', $transition);
				
				$add_rand = '';
				if(is_array($transition_arr) && !empty($transition_arr)){
					foreach($transition_arr as $tkey => $trans){
						if($trans == 'random-selected'){
							$add_rand = ' data-randomtransition="on"';
							unset($transition_arr[$tkey]);
							$transition = implode(',', $transition_arr);
							break;
						}
					}
				}
				
				//if($transition == "fade") $transition = "tp-fade";
				//$transitionPremium = $slide->getParam("slide_transition_premium","random");

				//if(trim($transition) == '')
				//	$transition = $transitionPremium;
				//else
				//	if(trim($transitionPremium) != '') $transition .= ','.$transitionPremium;


				$slotAmount = $slide->getParam("slot_amount","7");

				$isExternal = $slide->getParam("background_type","image");
				if($isExternal != "external"){
					$urlSlideImage = $slide->getImageUrl();
					//get image alt
					$imageFilename = $slide->getImageFilename();
					$info = pathinfo($imageFilename);
					$alt = $info["filename"];
				}else{

					$urlSlideImage = $slide->getParam("slide_bg_external","");

					$info = '';
					$alt = '';
				}
				//echo '<pre>';
				//var_dump();
				//echo '</pre>';
				if(isset($slide->ignore_alt)) $alt = '';

				$bgType = $slide->getParam("background_type","image");

				//get thumb url

				$is_special_nav = false;
				switch($cur_slide_title){ //generate also if we have a special navigation selected
					case 'preview1':
					case 'preview2':
					case 'preview3':
					case 'preview4':
					case 'custom':
						$is_special_nav = true;
				}
				$htmlThumb = "";
				if($isThumbsActive == true || $is_special_nav == true){
					$urlThumb = null;

					//check if post slider, if yes, get thumb from featured image
					//if($this->slider->isSlidesFromPosts())
					//	$urlThumb = '';

					if(empty($urlThumb)){
						$urlThumb = $slide->getParam("slide_thumb","");
					}

					if($bgType == 'image'){

						if(empty($urlThumb)){	//try to get resized thumb
							$url_img_link = $slide->getImageUrl();

							$urlThumb = rev_aq_resize($url_img_link, 320, 200, true, true, true);
							/*$pathThumb = $slide->getImageFilepath();
							if(!empty($pathThumb))
								$urlThumb = UniteBaseClassRev::getImageUrl($pathThumb,$thumbWidth,$thumbHeight,true);*/
						}

						//if not - put regular image:
						if(empty($urlThumb))
							$urlThumb = $slide->getImageUrl();
					}

					$htmlThumb = 'data-thumb="'.$urlThumb.'" ';
				}

				//get link
				$htmlLink = "";
				$enableLink = $slide->getParam("enable_link","false");
				if($enableLink == "true"){
					$linkType = $slide->getParam("link_type","regular");
					switch($linkType){

						//---- normal link

						default:
						case "regular":
							$link = $slide->getParam("link","");
							$linkOpenIn = $slide->getParam("link_open_in","same");
							$htmlTarget = "";
							if($linkOpenIn == "new")
								$htmlTarget = ' data-target="_blank"';
							$htmlLink = "data-link=\"$link\" $htmlTarget ";
						break;

						//---- link to slide

						case "slide":
							$slideLink = UniteFunctionsRev::getVal($params, "slide_link");
							if(!empty($slideLink) && $slideLink != "nothing"){
								//get slide index from id
								if(is_numeric($slideLink))
									$slideLink = UniteFunctionsRev::getVal($this->slidesNumIndex, $slideLink);

								if(!empty($slideLink)){
									$htmlLink = "data-link=\"slide\" data-linktoslide=\"$slideLink\" ";
								}
							}
						break;
					}

					//set link position:
					$linkPos = UniteFunctionsRev::getVal($params, "link_pos","front");
					if($linkPos == "back")
						$htmlLink .= ' data-slideindex="back"';
				}

				//set delay
				$htmlDelay = "";
				$delay = $slide->getParam("delay","");
				if(!empty($delay) && is_numeric($delay))
					$htmlDelay = "data-delay=\"$delay\" ";

				//get duration
				$htmlDuration = "";
				$duration = $slide->getParam("transition_duration","");
				if(!empty($duration) && is_numeric($duration))
					$htmlDuration = "data-masterspeed=\"$duration\" ";

				//get performance
				$htmlPerformance = "";
				$performance = $slide->getParam("save_performance","off");
				if(!empty($performance) && ($performance == 'on' || $performance == 'off'))
					$htmlPerformance = " data-saveperformance=\"$performance\" ";



				//get rotation
				$htmlRotation = "";
				$rotation = $slide->getParam("transition_rotation","");
				if(!empty($rotation)){
					$rotation = (int)$rotation;
					if($rotation != 0){
						if($rotation > 720 && $rotation != 999)
							$rotation = 720;
						if($rotation < -720)
							$rotation = -720;
					}
					$htmlRotation = "data-rotate=\"$rotation\" ";
				}

				$fullWidthVideoData = $this->getSlideFullWidthVideoData($slide);

				//set full width centering.
				/*$htmlImageCentering = "";
				$fullWidthCentering = $slide->getParam("fullwidth_centering","false");
				if($sliderType == "fullwidth" && $fullWidthCentering == "true")
					$htmlImageCentering = ' data-fullwidthcentering="on"';
				*/

				//set first slide transition
				$htmlFirstTrans = "";
				if($index == $startWithSlide){
					$htmlFirstTrans = $htmlFirstTransWrap;
				}//first trans

				$htmlParams = $htmlDuration.$htmlLink.$htmlThumb.$htmlDelay.$htmlRotation.$htmlFirstTrans.$htmlPerformance;


				$styleImage = "";
				$urlImageTransparent = UniteBaseClassRev::$url_plugin."images/transparent.png";

				switch($bgType){
					case "trans":
						$urlSlideImage = $urlImageTransparent;
					break;
					case "solid":
						$urlSlideImage = $urlImageTransparent;
						$slideBGColor = $slide->getParam("slide_bg_color","#d0d0d0");
						$styleImage = "style='background-color:".$slideBGColor."'";
					break;
				}

				//additional params
				$imageAddParams = "";
				if($lazyLoad == "on"){
					$imageAddParams .= "data-lazyload=\"$urlSlideImage\"";
					$urlSlideImage = UniteBaseClassRev::$url_plugin."images/dummy.png";
				}

				//$imageAddParams .= $htmlImageCentering;

				//additional background params
				$bgFit = $slide->getParam("bg_fit","cover");
				$bgFitX = intval($slide->getParam("bg_fit_x","100"));
				$bgFitY = intval($slide->getParam("bg_fit_y","100"));

				$bgPosition = $slide->getParam("bg_position","center top");
				$bgPositionX = intval($slide->getParam("bg_position_x","0"));
				$bgPositionY = intval($slide->getParam("bg_position_y","0"));

				$bgRepeat = $slide->getParam("bg_repeat","no-repeat");

				if($bgPosition == 'percentage'){
					$imageAddParams .= ' data-bgposition="'.$bgPositionX.'% '.$bgPositionY.'%"';
				}else{
					$imageAddParams .= ' data-bgposition="'.$bgPosition.'"';
				}



				//check for kenburn & pan zoom
				$kenburn_effect = $slide->getParam("kenburn_effect","off");
				//$kb_rotation_start = intval($slide->getParam("kb_rotation_start","0"));
				//$kb_rotation_end = intval($slide->getParam("kb_rotation_end","0"));
				$kb_duration = intval($slide->getParam("kb_duration",$this->slider->getParam("delay",9000)));
				$kb_ease = $slide->getParam("kb_easing","Linear.easeNone");
				$kb_start_fit = $slide->getParam("kb_start_fit","100");
				$kb_end_fit =$slide->getParam("kb_end_fit","100");

				$kb_pz = '';

				if($kenburn_effect == "on" && ($bgType == 'image' || $bgType == 'external')){
					$kb_pz.= ' data-kenburns="on"';
					//$kb_pz.= ' data-rotationstart="'.$kb_rotation_start.'"';
					//$kb_pz.= ' data-rotationend="'.$kb_rotation_end.'"';
					$kb_pz.= ' data-duration="'.$kb_duration.'"';
					$kb_pz.= ' data-ease="'.$kb_ease.'"';
					$kb_pz.= ' data-bgfit="'.$kb_start_fit.'"';
					$kb_pz.= ' data-bgfitend="'.$kb_end_fit.'"';

					$bgEndPosition = $slide->getParam("bg_end_position","center top");
					$bgEndPositionX = intval($slide->getParam("bg_end_position_x","0"));
					$bgEndPositionY = intval($slide->getParam("bg_end_position_y","0"));

					if($bgEndPosition == 'percentage'){
						$kb_pz.= ' data-bgpositionend="'.$bgEndPositionX.'% '.$bgEndPositionY.'%"';
					}else{
						$kb_pz.= ' data-bgpositionend="'.$bgEndPosition.'"';
					}

					//set image original width and height
					//$imgSize = @getimagesize($urlSlideImage);
					//if(is_array($imgSize) && !empty($imgSize)){
					//	$kb_pz.= ' data-owidth="'.$imgSize[0].'"';
					//	$kb_pz.= ' data-oheight="'.$imgSize[1].'"';
					//}

				}else{ //only set if kenburner is off

					if($bgFit == 'percentage'){
						$imageAddParams .= ' data-bgfit="'.$bgFitX.'% '.$bgFitY.'%"';
					}else{
						$imageAddParams .= ' data-bgfit="'.$bgFit.'"';
					}

					$imageAddParams .= ' data-bgrepeat="'.$bgRepeat.'"';

				}

				$thumbWidth = $this->slider->getParam("thumb_width",100);


				//add Slide Title if we have special navigation type choosen
				$slide_title = '';

				$class_attr = $slide->getParam("class_attr","");
				if($class_attr !== '')
					$htmlParams.= ' class="'.$class_attr.'"';

				$id_attr = $slide->getParam("id_attr","");
				if($id_attr !== '')
					$htmlParams.= ' id="'.$id_attr.'"';

				$attr_attr = $slide->getParam("attr_attr","");
				if($attr_attr !== '')
					$htmlParams.= ' id="'.$attr_attr.'"';

				$data_attr = stripslashes($slide->getParam("data_attr",""));
				if($data_attr !== '')
					$htmlParams.= ' '.$data_attr;

				switch($cur_slide_title){
					case 'preview1':
					case 'preview2':
					case 'preview3':
					case 'preview4':
					case 'custom':
						//check if we are post based or normal slider
						if($templateSlider){
							$new_title = @get_the_title($slide->getID());
							$slide_title = ' data-title="'.str_replace("\'", "'", $new_title).'"';
						}else{
							$slide_title = ' data-title="'.str_replace("\'", "'", $slide->getParam("title","Slide")).'"';
						}
					break;
				}
				
				//Html
				echo "	<!-- SLIDE  -->\n";
				echo "	<li data-transition=\"".$transition."\" data-slotamount=\"". $slotAmount."\" ".$add_rand.$htmlParams.$slide_title .">\n";
				echo "		<!-- MAIN IMAGE -->\n";
				echo "		<img src=\"". $urlSlideImage ."\" ". $styleImage." alt=\"". $alt . "\" ". $imageAddParams. $kb_pz .">\n";
				echo "		<!-- LAYERS -->\n";
				//put video:
				if($fullWidthVideoData["found"] == true)	//backward compatability
					$this->putFullWidthVideoLayer($fullWidthVideoData);

				$this->putCreativeLayer($slide);

				echo "	</li>\n";

			}	//get foreach

			echo "</ul>\n";

			//check for static layers
			$useStaticLayers = $this->slider->getParam("enable_static_layers","off");
			if($useStaticLayers == 'on'){
				$sliderID = $this->slider->getID();
				$staticID = $slide->getStaticSlideID($sliderID);
				if($staticID !== false){
					$static_slide = new RevSlide();
					$static_slide->initByStaticID($staticID);
					echo '<div class="tp-static-layers">'."\n";
					$this->putCreativeLayer($static_slide, true);
					echo '</div>'."\n";
				}
			}


			//add styles to the footer
			//add_action('wp_footer', array($this, 'add_inline_styles'));

		}


		/**
		 *
		 * put creative layer
		 */
		private function putCreativeLayer(RevSlide $slide, $static_slide = false){
			$layers = $slide->getLayers();
			$customAnimations = RevOperations::getCustomAnimations('customin'); //get all custom animations
			$customEndAnimations = RevOperations::getCustomAnimations('customout'); //get all custom animations
			$startAnimations = RevOperations::getArrAnimations(false); //only get the standard animations
			$endAnimations = RevOperations::getArrEndAnimations(false); //only get the standard animations

			$lazyLoad = $this->slider->getParam("lazy_load","off");
			$isTemplate = $this->slider->getParam("template","false");

			if(empty($layers))
				return(false);

			$zIndex = 5;

			foreach($layers as $layer):

				$type = UniteFunctionsRev::getVal($layer, "type","text");

				//set if video full screen
				$videoclass = '';
				
				$isFullWidthVideo = false;
				if($type == "video"){
					$videoclass = ' tp-videolayer';
					$videoData = UniteFunctionsRev::getVal($layer, "video_data");
					if(!empty($videoData)){
						$videoData = (array)$videoData;
						$isFullWidthVideo = UniteFunctionsRev::getVal($videoData, "fullwidth");
						$isFullWidthVideo = UniteFunctionsRev::strToBool($isFullWidthVideo);
					}else
						$videoData = array();
				}


				$class = UniteFunctionsRev::getVal($layer, "style");

				if(trim($class) !== '')
					$this->class_include['.'.trim($class)] = true; //add classname for style inclusion

				$animation = UniteFunctionsRev::getVal($layer, "animation","tp-fade");
				if($animation == "fade") $animation = "tp-fade";

				$customin = '';
				if(!array_key_exists($animation, $startAnimations) && array_key_exists($animation, $customAnimations)){ //if true, add custom animation
					$customin.= 'data-customin="';
					$animArr = RevOperations::getCustomAnimationByHandle($customAnimations[$animation]);
					if($animArr !== false) $customin.= RevOperations::parseCustomAnimationByArray($animArr);
					$customin.= '"';
					$animation = 'customin';
				}

				if(strpos($animation, 'customin-') !== false || strpos($animation, 'customout-') !== false) $animation = "tp-fade";

				//set output class:

				$layer_2d_rotation = intval(UniteFunctionsRev::getVal($layer, "2d_rotation",'0'));
				$layer_2d_origin_x = intval(UniteFunctionsRev::getVal($layer, "2d_origin_x",'50'));
				$layer_2d_origin_y = intval(UniteFunctionsRev::getVal($layer, "2d_origin_y",'50'));

				if($layer_2d_rotation == 0)
					$outputClass = "tp-caption ". trim($class);
				else
					$outputClass = "tp-caption ";

				$outputClass = trim($outputClass) . " ";

				$outputClass .= trim($animation);

				$left = UniteFunctionsRev::getVal($layer, "left",0);
				$top = UniteFunctionsRev::getVal($layer, "top",0);
				$speed = UniteFunctionsRev::getVal($layer, "speed",300);
				$time = UniteFunctionsRev::getVal($layer, "time",0);
				$easing = UniteFunctionsRev::getVal($layer, "easing","easeOutExpo");
				$randomRotate = UniteFunctionsRev::getVal($layer, "random_rotation","false");
				$randomRotate = UniteFunctionsRev::boolToStr($randomRotate);

				$splitin = UniteFunctionsRev::getVal($layer, "split","none");
				$splitout = UniteFunctionsRev::getVal($layer, "endsplit","none");
				$elementdelay = intval(UniteFunctionsRev::getVal($layer, "splitdelay",0));
				$endelementdelay = intval(UniteFunctionsRev::getVal($layer, "endsplitdelay",0));

				if($elementdelay > 0) $elementdelay /= 100;
				if($endelementdelay > 0) $endelementdelay /= 100;


				$text = UniteFunctionsRev::getVal($layer, "text");
				if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')) //use qTranslate
					$text = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);

				$htmlVideoAutoplay = "";
				$htmlVideoAutoplayOnlyFirstTime = "";
				$htmlVideoNextSlide = "";
				$htmlVideoThumbnail = "";
				$htmlMute = '';
				$htmlCover = '';
				$htmlDotted = '';
				$htmlRatio = '';
				$htmlRewind = '';
				$htmlDisableOnMobile = '';

				$ids = UniteFunctionsRev::getVal($layer, "attrID");
				$classes = UniteFunctionsRev::getVal($layer, "attrClasses");
				$title = UniteFunctionsRev::getVal($layer, "attrTitle");
				$rel = UniteFunctionsRev::getVal($layer, "attrRel");

				$ids = ($ids != '') ? ' id="'.$ids.'"' : '';
				$classes = ($classes != '') ? ' '.$classes : '';
				$title = ($title != '') ? ' title="'.$title.'"' : '';
				$rel = ($rel != '') ? ' rel="'.$rel.'"' : '';

				$max_width = UniteFunctionsRev::getVal($layer, "max_width",'auto');
				$max_height = UniteFunctionsRev::getVal($layer, "max_height",'auto');
				$white_space = UniteFunctionsRev::getVal($layer, "whitespace",'nowrap');


				$inline_styles = '';
				$layer_rotation = '';
				$do_rotation = false;
				$add_data = '';
				$videoType = '';
				$cover = false;
				
				//set html:
				$html = "";
				switch($type){
					default:
					case "text":
						$html = $text;
						$html = do_shortcode($html);
						$inline_styles .= ' max-width: '.$max_width.'; max-height: '.$max_height.'; white-space: '.$white_space.';';

						if($layer_2d_rotation !== 0)
							$do_rotation = true;
					break;
					case "image":
						$alt = UniteFunctionsRev::getVal($layer, "alt");
						
						if(isset($slide->ignore_alt)) $alt = '';
				
						$urlImage = UniteFunctionsRev::getVal($layer, "image_url");

						$additional = "";
						$scaleX = UniteFunctionsRev::getVal($layer, "scaleX");
						$scaleY = UniteFunctionsRev::getVal($layer, "scaleY");
						if($scaleX != '') $additional .= ' data-ww="'.$scaleX.'"';
						if($scaleY != '') $additional .= ' data-hh="'.$scaleY.'"';
						if(is_ssl()){
							$urlImage = str_replace("http://", "https://", $urlImage);
						}


						$imageAddParams = "";
						if($lazyLoad == "on"){
							$imageAddParams .= " data-lazyload=\"$urlImage\"";
							$urlImage = UniteBaseClassRev::$url_plugin."images/dummy.png";
						}

						$html = '<img src="'.$urlImage.'" alt="'.$alt.'"'.$additional.$imageAddParams.'>';
						$imageLink = UniteFunctionsRev::getVal($layer, "link","");
						if(!empty($imageLink)){
							$openIn = UniteFunctionsRev::getVal($layer, "link_open_in","same");

							$target = "";
							if($openIn == "new")
								$target = ' target="_blank"';

							$linkID = UniteFunctionsRev::getVal($layer, "link_id","");
							$linkClass = UniteFunctionsRev::getVal($layer, "link_class","");
							$linkTitle = UniteFunctionsRev::getVal($layer, "link_title","");
							$linkRel = UniteFunctionsRev::getVal($layer, "link_rel","");

							$linkIDHtml = "";
							$linkClassHtml = "";
							$linkTitleHtml = "";
							$linkRelHtml = "";
							if(!empty($linkID))
								$linkIDHtml = ' id="'.$linkID.'"';

							if(!empty($linkClass))
								$linkClassHtml = ' class="'.$linkClass.'"';

							if(!empty($linkTitle))
								$linkTitleHtml = ' title="'.$linkTitle.'"';

							if(!empty($linkRel))
								$linkRelHtml = ' rel="'.$linkRel.'"';

							$html = '<a href="'.$imageLink.'"'.$target.$linkIDHtml.$linkClassHtml.$linkTitleHtml.$linkRelHtml.'>'.$html.'</a>';
						}
						if($layer_2d_rotation !== 0)
							$do_rotation = true;
					break;
					case "video":
						$videoType = trim(UniteFunctionsRev::getVal($layer, "video_type"));
						$videoID = trim(UniteFunctionsRev::getVal($layer, "video_id"));
						$videoWidth = trim(UniteFunctionsRev::getVal($layer, "video_width"));
						$videoHeight = trim(UniteFunctionsRev::getVal($layer, "video_height"));
						$videoArgs = trim(UniteFunctionsRev::getVal($layer, "video_args"));
						$v_controls = UniteFunctionsRev::getVal($videoData, "controls");
						$v_controls = UniteFunctionsRev::strToBool($v_controls);

						$rewind = UniteFunctionsRev::getVal($videoData, "forcerewind");
						$rewind = UniteFunctionsRev::strToBool($rewind);
						$htmlRewind = ($rewind == true) ? ' data-forcerewind="on"' : '';
						
						$only_poster_on_mobile = UniteFunctionsRev::getVal($layer, "use_poster_on_mobile");
						$only_poster_on_mobile = UniteFunctionsRev::strToBool($only_poster_on_mobile);
						
						
						if($isFullWidthVideo == true){ // || $cover == true
							$videoWidth = "100%";
							$videoHeight = "100%";
						}

						$setBase = (is_ssl()) ? "https://" : "http://";
						
						$cover = UniteFunctionsRev::getVal($videoData, "cover");
						$cover = UniteFunctionsRev::strToBool($cover);
						
						switch($videoType){
							case "youtube":
								if(empty($videoArgs))
									$videoArgs = GlobalsRevSlider::DEFAULT_YOUTUBE_ARGUMENTS;
									
								//check if full URL
								if(strpos($videoID, 'http') !== false){
									//we have full URL, split it to ID
									parse_str( parse_url( $videoID, PHP_URL_QUERY ), $my_v_ret );
									$videoID = $my_v_ret['v'];
								}
								
								$videospeed = UniteFunctionsRev::getVal($videoData, "videospeed", '1');
								
								//$ytBase = 'https://';
								//if($v_controls) $videoArgs.='controls=0;';
								$videoArgs.=';origin='.$setBase.$_SERVER['SERVER_NAME'].';';
								$add_data = ' data-ytid="'.$videoID.'" data-videowidth="'.$videoWidth.'" data-videoheight="'.$videoHeight.'" data-videoattributes="version=3&amp;enablejsapi=1&amp;html5=1&amp;'.$videoArgs.'" data-videorate="'.$videospeed.'"';
								$add_data .= ($v_controls) ? ' data-videocontrols="none"' : ' data-videocontrols="controls"';
								//$html = "<iframe src='".$ytBase."www.youtube.com/embed/".$videoID."?enablejsapi=1&amp;html5=1&amp;".$videoArgs."' allowfullscreen='true' width='".$videoWidth."' height='".$videoHeight."' style='width:".$videoWidth."px;height:".$videoHeight."px;'></iframe>";
							break;
							case "vimeo":
								if(empty($videoArgs))
									$videoArgs = GlobalsRevSlider::DEFAULT_VIMEO_ARGUMENTS;

								//check if full URL
								if(strpos($videoID, 'http') !== false){
									//we have full URL, split it to ID
									$videoID = (int) substr(parse_url($videoID, PHP_URL_PATH), 1);
								}
								
								$add_data = ' data-vimeoid="'.$videoID.'" data-videowidth="'.$videoWidth.'" data-videoheight="'.$videoHeight.'" data-videoattributes="'.$videoArgs.'"';
								//no controls for vimeo $add_data .= ($v_controls) ? ' data-videocontrols="none"' : ' data-videocontrols="controls"';

								//$html = "<iframe src='".$setBase."player.vimeo.com/video/".$videoID."?".$videoArgs."' width='".$videoWidth."' height='".$videoHeight."' style='width:".$videoWidth."px;height:".$videoHeight."px;'></iframe>";
							break;
							case "html5":
								$urlPoster = UniteFunctionsRev::getVal($videoData, "urlPoster");
								$urlMp4 = UniteFunctionsRev::getVal($videoData, "urlMp4");
								$urlWebm = UniteFunctionsRev::getVal($videoData, "urlWebm");
								$urlOgv = UniteFunctionsRev::getVal($videoData, "urlOgv");
								$videopreload = UniteFunctionsRev::getVal($videoData, "preload");
								$videoloop = UniteFunctionsRev::getVal($videoData, "videoloop");
								
								
								$add_data = ' data-videowidth="'.$videoWidth.'" data-videoheight="'.$videoHeight.'"';

								$add_data .= ($v_controls) ? ' data-videocontrols="none"' : ' data-videocontrols="controls"';
								if(!empty($urlPoster)) $add_data .= ' data-videoposter="'.$urlPoster.'"';
								if(!empty($urlOgv)) $add_data .= ' data-videoogv="'.$urlOgv.'"';
								if(!empty($urlWebm)) $add_data .= ' data-videowebm="'.$urlWebm.'"';
								if(!empty($urlMp4)) $add_data .= ' data-videomp4="'.$urlMp4.'"';
								
								if(!empty($urlPoster)){
									if($only_poster_on_mobile === true){
										$add_data .= ' data-posterOnMObile="on"';
									}else{
										$add_data .= ' data-posterOnMObile="off"';
									}
								}

								if(!empty($videopreload)) $add_data .= ' data-videopreload="'.$videopreload.'"';
								if(UniteFunctionsRev::strToBool($videoloop) == true){ //fallback
									$add_data .= ' data-videoloop="loop"';
								}else{
									$add_data .= ' data-videoloop="'.$videoloop.'"';
								}
								
							break;
							default:
								UniteFunctionsRev::throwError("wrong video type: $videoType");
							break;
						}
						
						if($cover == true){
							$dotted = UniteFunctionsRev::getVal($videoData, "dotted");
							if($dotted !== 'none')
								$add_data .= ' data-dottedoverlay="'.$dotted.'"';
								
							$add_data .=  ' data-forceCover="1"';
								
							$ratio = UniteFunctionsRev::getVal($videoData, "ratio");
								if(!empty($ratio))
									$add_data .= ' data-aspectratio="'.$ratio.'"';
						}
						

						//set video autoplay, with backward compatability
						if(array_key_exists("autoplay", $videoData))
							$videoAutoplay = UniteFunctionsRev::getVal($videoData, "autoplay");
						else	//backword compatability
							$videoAutoplay = UniteFunctionsRev::getVal($layer, "video_autoplay");

						//set video autoplayonlyfirsttime, with backward compatability
						if(array_key_exists("autoplayonlyfirsttime", $videoData))
							$videoAutoplayOnlyFirstTime = UniteFunctionsRev::getVal($videoData, "autoplayonlyfirsttime");
						else
							$videoAutoplayOnlyFirstTime = "";

						$videoAutoplay = UniteFunctionsRev::strToBool($videoAutoplay);
						$videoAutoplayOnlyFirstTime = UniteFunctionsRev::strToBool($videoAutoplayOnlyFirstTime);
						$mute = UniteFunctionsRev::getVal($videoData, "mute");
						$mute = UniteFunctionsRev::strToBool($mute);
						$htmlMute = ($mute)	? ' data-volume="mute"' : '';

						if($videoAutoplay == true)
							$htmlVideoAutoplay = '			data-autoplay="true"'." \n";
						else
							$htmlVideoAutoplay = '			data-autoplay="false"'." \n";

						if($videoAutoplayOnlyFirstTime == true && $videoAutoplay == true)
							$htmlVideoAutoplayOnlyFirstTime = '			data-autoplayonlyfirsttime="true"'." \n";
						else
							$htmlVideoAutoplayOnlyFirstTime = '			data-autoplayonlyfirsttime="false"'." \n";

						$videoNextSlide = UniteFunctionsRev::getVal($videoData, "nextslide");
						$videoNextSlide = UniteFunctionsRev::strToBool($videoNextSlide);

						if($videoNextSlide == true)
							$htmlVideoNextSlide = '			data-nextslideatend="true"'." \n";

						$videoThumbnail = @$videoData["previewimage"];

						if(trim($videoThumbnail) !== '') $htmlVideoThumbnail = '			data-videoposter="'.$videoThumbnail.'"'." \n";
						if(!empty($videoThumbnail)){
							if($only_poster_on_mobile === true){
								$htmlVideoThumbnail .= '			data-posterOnMObile="on"'." \n";
							}else{
								$htmlVideoThumbnail .= '			data-posterOnMObile="off"'." \n";
							}
						}
						
						$disable_on_mobile = UniteFunctionsRev::getVal($videoData, "disable_on_mobile");
						$disable_on_mobile = UniteFunctionsRev::strToBool($disable_on_mobile);
						$htmlDisableOnMobile = ($disable_on_mobile)	? '			data-disablevideoonmobile="1"'." \n" : '';
						
					break;
				}

				if($do_rotation){
					$layer_rotation = ' -moz-transform: rotate('.$layer_2d_rotation.'deg); -ms-transform: rotate('.$layer_2d_rotation.'deg); -o-transform: rotate('.$layer_2d_rotation.'deg); -webkit-transform: rotate('.$layer_2d_rotation.'deg); transform: rotate('.$layer_2d_rotation.'deg);';
					$layer_rotation .= ' -moz-transform-origin: '.$layer_2d_origin_x.'% '.$layer_2d_origin_y.'%; -ms-transform-origin: '.$layer_2d_origin_x.'% '.$layer_2d_origin_y.'%; -o-transform-origin: '.$layer_2d_origin_x.'% '.$layer_2d_origin_y.'%; -webkit-transform-origin: '.$layer_2d_origin_x.'% '.$layer_2d_origin_y.'%; transform-origin: '.$layer_2d_origin_x.'% '.$layer_2d_origin_y.'%;';
				}

				//handle end transitions:
				$endTime = trim(UniteFunctionsRev::getVal($layer, "endtime"));
				$realEndTime = trim(UniteFunctionsRev::getVal($layer, "realEndTime"));
				$endWithSlide = UniteFunctionsRev::getVal($layer, "endWithSlide",false);
				$endSpeed = trim(UniteFunctionsRev::getVal($layer, "endspeed"));

				$calcSpeed = (!empty($endSpeed)) ? $endSpeed : $speed;

				if(!empty($calcSpeed) && $realEndTime - $calcSpeed !== $endTime){
					$endTime = $realEndTime - $calcSpeed;
				}

				$htmlEnd = "";
				$customout = '';
				if(!empty($endTime) && $endWithSlide !== true){
					$htmlEnd = " data-end=\"$endTime\""." \n";
				}

				if(!empty($endSpeed))
					$htmlEnd .= " data-endspeed=\"$endSpeed\""." \n";

				$endEasing = trim(UniteFunctionsRev::getVal($layer, "endeasing"));
				if(!empty($endSpeed) && $endEasing != "nothing")
					 $htmlEnd .= "			data-endeasing=\"$endEasing\""." \n";

				//add animation to class
				$endAnimation = trim(UniteFunctionsRev::getVal($layer, "endanimation"));
				if($endAnimation == "fade") $endAnimation = "tp-fade";

				if(!array_key_exists($endAnimation, $endAnimations) && array_key_exists($endAnimation, $customEndAnimations)){ //if true, add custom animation
					$customout = ' data-customout="';
					$animArr = RevOperations::getCustomAnimationByHandle($customEndAnimations[$endAnimation]);
					if($animArr !== false) $customout.= RevOperations::parseCustomAnimationByArray($animArr);
					$customout.= '"';
					$endAnimation = 'customout';
				}

				if(strpos($endAnimation, 'customin-') !== false || strpos($endAnimation, 'customout-') !== false) $endAnimation = "";

				if(!empty($endAnimation) && $endAnimation != "auto")
					$outputClass .= " ".$endAnimation;

				//slide link
				$htmlLink = "";
				$slideLink = UniteFunctionsRev::getVal($layer, "link_slide");
				if(!empty($slideLink) && $slideLink != "nothing" && $slideLink != "scroll_under"){
					//get slide index from id
					if(is_numeric($slideLink))
						$slideLink = UniteFunctionsRev::getVal($this->slidesNumIndex, $slideLink);

					if(!empty($slideLink))
						$htmlLink = " data-linktoslide=\"$slideLink\""." \n";
				}

				//scroll under the slider
				if($slideLink == "scroll_under"){
					$outputClass .= " tp-scrollbelowslider";
					$scrollUnderOffset = intval(UniteFunctionsRev::getVal($layer, "scrollunder_offset"));
					
					$htmlLink .= " data-scrolloffset=\"".$scrollUnderOffset."\""." \n";
				}

				//hidden under resolution
				$htmlHidden = "";
				$layerHidden = UniteFunctionsRev::getVal($layer, "hiddenunder");
				if($layerHidden == "true" || $layerHidden == "1")
					$htmlHidden = '			data-captionhidden="on"'." \n";

				$htmlParams = $add_data.$htmlEnd.$htmlLink.$htmlVideoAutoplay.$htmlVideoAutoplayOnlyFirstTime.$htmlVideoNextSlide.$htmlVideoThumbnail.$htmlHidden.$htmlMute.$htmlDisableOnMobile.$htmlCover.$htmlDotted.$htmlRatio.$htmlRewind."\n";

				//set positioning options

				$alignHor = UniteFunctionsRev::getVal($layer,"align_hor","left");
				$alignVert = UniteFunctionsRev::getVal($layer, "align_vert","top");

				$htmlPosX = "";
				$htmlPosY = "";
				switch($alignHor){
					default:
					case "left":
						$htmlPosX = " data-x=\"".$left."\"";
					break;
					case "center":
						$htmlPosX = " data-x=\"center\" data-hoffset=\"".$left."\"";
					break;
					case "right":
						$left = (int)$left*-1;
						$htmlPosX = " data-x=\"right\" data-hoffset=\"".$left."\"";
					break;
				}

				switch($alignVert){
					default:
					case "top":
						$htmlPosY = " data-y=\"".$top."\" ";
					break;
					case "middle":
						$htmlPosY = " data-y=\"center\" data-voffset=\"".$top."\"";
					break;
					case "bottom":
						$top = (int)$top*-1;
						$htmlPosY = " data-y=\"bottom\" data-voffset=\"".$top."\"";
					break;
				}

				//set corners
				$htmlCorners = "";

				if($type == "text"){
					$cornerLeft = UniteFunctionsRev::getVal($layer, "corner_left");
					$cornerRight = UniteFunctionsRev::getVal($layer, "corner_right");
					switch($cornerLeft){
						case "curved":
							$htmlCorners .= "<div class='frontcorner'></div>";
						break;
						case "reverced":
							$htmlCorners .= "<div class='frontcornertop'></div>";
						break;
					}

					switch($cornerRight){
						case "curved":
							$htmlCorners .= "<div class='backcorner'></div>";
						break;
						case "reverced":
							$htmlCorners .= "<div class='backcornertop'></div>";
						break;
					}

				//add resizeme class
				$resizeme = UniteFunctionsRev::getVal($layer, "resizeme");
				if($resizeme == "true" || $resizeme == "1")
					$outputClass .= ' tp-resizeme';

				}//end text related layer

				//make some modifications for the full screen video
				if($isFullWidthVideo == true){
					$htmlPosX = " data-x=\"0\"";
					$htmlPosY = " data-y=\"0\"";
					$outputClass .= " fullscreenvideo";
					
				}

				//parallax part
				$use_parallax = $this->slider->getParam("use_parallax","off");

				$parallax_class = '';
				if($use_parallax == 'on'){
					$slide_level = intval(UniteFunctionsRev::getVal($layer, "parallax_level", '-'));
					if($slide_level !== '-')
						$parallax_class = ' rs-parallaxlevel-'.$slide_level;
				}

				//check for loop animation here
				$do_loop = UniteFunctionsRev::getVal($layer,"loop_animation","none");
				$loop_data = '';
				$loop_class = '';
				
				if($do_loop !== 'none'){
					$loop_class = ' '.$do_loop;
					switch($do_loop){
						case 'rs-pendulum':
							$loop_data.= ' data-easing="'.UniteFunctionsRev::getVal($layer,"loop_easing","Power3.easeInOut").'"';
							$loop_data.= ' data-startdeg="'.UniteFunctionsRev::getVal($layer,"loop_startdeg","-20").'"';
							$loop_data.= ' data-enddeg="'.UniteFunctionsRev::getVal($layer,"loop_enddeg","20").'"';
							$loop_data.= ' data-speed="'.UniteFunctionsRev::getVal($layer,"loop_speed","2").'"';
							$loop_data.= ' data-origin="'.UniteFunctionsRev::getVal($layer,"loop_xorigin","50").'% '.UniteFunctionsRev::getVal($layer,"loop_yorigin","50").'%"';
						break;
						case 'rs-rotate':
							$loop_data.= ' data-easing="'.UniteFunctionsRev::getVal($layer,"loop_easing","Power3.easeInOut").'"';
							$loop_data.= ' data-startdeg="'.UniteFunctionsRev::getVal($layer,"loop_startdeg","-20").'"';
							$loop_data.= ' data-enddeg="'.UniteFunctionsRev::getVal($layer,"loop_enddeg","20").'"';
							$loop_data.= ' data-speed="'.UniteFunctionsRev::getVal($layer,"loop_speed","2").'"';
							$loop_data.= ' data-origin="'.UniteFunctionsRev::getVal($layer,"loop_xorigin","50").'% '.UniteFunctionsRev::getVal($layer,"loop_yorigin","50").'%"';
						break;
						
						case 'rs-slideloop':
							$loop_data.= ' data-easing="'.UniteFunctionsRev::getVal($layer,"loop_easing","Power3.easeInOut").'"';
							$loop_data.= ' data-speed="'.UniteFunctionsRev::getVal($layer,"loop_speed","1").'"';
							$loop_data.= ' data-xs="'.UniteFunctionsRev::getVal($layer,"loop_xstart","0").'"';
							$loop_data.= ' data-xe="'.UniteFunctionsRev::getVal($layer,"loop_xend","0").'"';
							$loop_data.= ' data-ys="'.UniteFunctionsRev::getVal($layer,"loop_ystart","0").'"';
							$loop_data.= ' data-ye="'.UniteFunctionsRev::getVal($layer,"loop_yend","0").'"';
						break;
						case 'rs-pulse':
							$loop_data.= ' data-easing="'.UniteFunctionsRev::getVal($layer,"loop_easing","Power3.easeInOut").'"';
							$loop_data.= ' data-speed="'.UniteFunctionsRev::getVal($layer,"loop_speed","1").'"';
							$loop_data.= ' data-zoomstart="'.UniteFunctionsRev::getVal($layer,"loop_zoomstart","1").'"';
							$loop_data.= ' data-zoomend="'.UniteFunctionsRev::getVal($layer,"loop_zoomend","1").'"';
						break;
						case 'rs-wave':
							$loop_data.= ' data-speed="'.UniteFunctionsRev::getVal($layer,"loop_speed","1").'"';
							$loop_data.= ' data-angle="'.UniteFunctionsRev::getVal($layer,"loop_angle","0").'"';
							$loop_data.= ' data-radius="'.UniteFunctionsRev::getVal($layer,"loop_radius","10").'"';
							$loop_data.= ' data-origin="'.UniteFunctionsRev::getVal($layer,"loop_xorigin","50").'% '.UniteFunctionsRev::getVal($layer,"loop_yorigin","50").'%"';
						break;
					}
				}



				echo "\n		<!-- LAYER NR. ";
				echo $zIndex - 4;
				echo " -->\n";
				echo "		<div class=\"".$outputClass;
				echo ($classes != '') ? ' '.$classes : '';
				echo $parallax_class;
				if($static_slide) echo ' tp-static-layer';
				
				echo $videoclass;
				
				echo "\" \n";
				echo ($ids != '') ? '			'.$ids." \n" : '';
				echo ($title != '') ? '			'.$title." \n" : '';
				echo ($rel != '') ? '			'.$rel." \n" : '';
				if($htmlPosX != "") echo "			".$htmlPosX." \n";
				if($htmlPosY != "") echo "			".$htmlPosY." \n";
				if($customin != "") echo "			".$customin." \n";
				if($customout != "") echo "			".$customout." \n";
				echo "			data-speed=\"".$speed."\" \n";
				echo "			data-start=\"".$time."\" \n";
				echo "			data-easing=\"".$easing."\" \n";
				if($type == "text"){ //only output if we are a text layer
					echo "			data-splitin=\"".$splitin."\" \n";
					echo "			data-splitout=\"".$splitout."\" \n";
				}
				//check if static layer and if yes, set values for it.
				if($static_slide){
					if($isTemplate != "true"){
						$start_on_slide = intval(UniteFunctionsRev::getVal($layer,"static_start",1)) - 1;
						$end_on_slide = intval(UniteFunctionsRev::getVal($layer,"static_end",2)) - 1;
					}else{
						$start_on_slide = '-1';
						$end_on_slide = '-1';
					}
					echo '			data-startslide="'.$start_on_slide.'"'." \n";
					echo '			data-endslide="'.$end_on_slide.'"'." \n";
				}
				echo "			data-elementdelay=\"".$elementdelay."\" \n";
				echo "			data-endelementdelay=\"".$endelementdelay."\" \n";
				if($htmlParams != "") echo "			".$htmlParams;
				echo "			style=\"z-index: ".$zIndex.";".$inline_styles. "\"";
				echo ">";
				
				if($do_loop !== 'none'){

					echo "\n".'				<div style="'.$layer_rotation.'" class="tp-layer-inner-rotation ';
					$rotationClass = trim($class);
					$rotationClass = trim($rotationClass) . " ";
					echo $rotationClass;
					echo $loop_class;
					echo '" ';
					echo $loop_data;
					echo '>';
				}elseif($layer_rotation != ''){
					$rotationClass = trim($class);
					$rotationClass = trim($rotationClass) . " ";
					echo '<div class="tp-layer-inner-rotation '.$rotationClass.'" style="'.$layer_rotation.'">'." \n";
				}
				echo stripslashes($html)." \n";
				if($htmlCorners != ""){
					echo $htmlCorners." \n";
				}
				if($do_loop !== 'none' || $layer_rotation != ''){
					echo "				</div>\n";
				}
				echo "		</div>\n";
				$zIndex++;
			endforeach;
		}

		/**
		 *
		 * put slider javascript
		 */
		private function putJS(){

			$params = $this->slider->getParams();
			$sliderType = $this->slider->getParam("slider_type");
			$optFullWidth = ($sliderType == "fullwidth")?"on":"off";

			$optFullScreen = "off";
			if($sliderType == "fullscreen"){
				$optFullWidth = "off";
				$optFullScreen = "on";
			}

			$use_spinner = $this->slider->getParam("use_spinner","0");
			$spinner_color = $this->slider->getParam("spinner_color","#FFFFFF");

			$noConflict = $this->slider->getParam("jquery_noconflict","on");

			//set thumb amount
			$numSlides = $this->slider->getNumSlides(true);
			$thumbAmount = (int)$this->slider->getParam("thumb_amount","5");
			if($thumbAmount > $numSlides)
				$thumbAmount = $numSlides;


			//get stop slider options
			$stopSlider = $this->slider->getParam("stop_slider","off");
			$stopAfterLoops = $this->slider->getParam("stop_after_loops","0");
			$stopAtSlide = $this->slider->getParam("stop_at_slide","2");

			if($stopSlider == "off"){
				$stopAfterLoops = "-1";
				$stopAtSlide = "-1";
			}

			$oneSlideLoop = $this->slider->getParam("loop_slide","loop");
			if($oneSlideLoop == 'noloop' && $this->hasOnlyOneSlide == true){
				$stopAfterLoops = '0';
				$stopAtSlide = '1';
			}

			// set hide navigation after
			$hideThumbs = $this->slider->getParam("hide_thumbs","200");
			if(is_numeric($hideThumbs) == false)
				$hideThumbs = "0";
			else{
				$hideThumbs = (int)$hideThumbs;
				if($hideThumbs < 10)
					$hideThumbs = 10;
			}

			$alwaysOn = $this->slider->getParam("navigaion_always_on","false");
			if($alwaysOn == "true")
				$hideThumbs = "0";

			$sliderID = $this->slider->getID();

			//treat hide slider at limit
			$hideSliderAtLimit = $this->slider->getParam("hide_slider_under","0",RevSlider::VALIDATE_NUMERIC);
			if(!empty($hideSliderAtLimit))
				$hideSliderAtLimit++;

			$hideCaptionAtLimit = $this->slider->getParam("hide_defined_layers_under","0",RevSlider::VALIDATE_NUMERIC);;
			if(!empty($hideCaptionAtLimit))
				$hideCaptionAtLimit++;

			$hideAllCaptionAtLimit = $this->slider->getParam("hide_all_layers_under","0",RevSlider::VALIDATE_NUMERIC);;
			if(!empty($hideAllCaptionAtLimit))
				$hideAllCaptionAtLimit++;

			//start_with_slide
			$startWithSlide = $this->slider->getStartWithSlideSetting();

	 	  //modify navigation type (backward compatability)
			$arrowsType = $this->slider->getParam("navigation_arrows","nexttobullets");
			switch($arrowsType){
				case "verticalcentered":
					$arrowsType = "solo";
				break;
			}

			//More Mobile Options
			$hideThumbsOnMobile = $this->slider->getParam("hide_thumbs_on_mobile","off");

			$hideThumbsDelayMobile = $this->slider->getParam("hide_thumbs_delay_mobile","1500");

			$hideBulletsOnMobile = $this->slider->getParam("hide_bullets_on_mobile","off");

			$hideArrowsOnMobile = $this->slider->getParam("hide_arrows_on_mobile","off");

			$hideThumbsUnderResolution = $this->slider->getParam("hide_thumbs_under_resolution","0",RevSlider::VALIDATE_NUMERIC);

			$timerBar =  $this->slider->getParam("show_timerbar","top");
			
			$disableKenBurnOnMobile =  $this->slider->getParam("disable_kenburns_on_mobile","off");

			$swipe_velocity = $this->slider->getParam("swipe_velocity","0.7",RevSlider::VALIDATE_NUMERIC);
			$swipe_min_touches = $this->slider->getParam("swipe_min_touches","1",RevSlider::VALIDATE_NUMERIC);
			$swipe_max_touches = $this->slider->getParam("swipe_max_touches","1",RevSlider::VALIDATE_NUMERIC);
			$drag_block_vertical = $this->slider->getParam("drag_block_vertical","false");

			$use_parallax = $this->slider->getParam("use_parallax","off");
			$disable_parallax_mobile = $this->slider->getParam("disable_parallax_mobile","off");

			if($use_parallax == 'on'){
				$parallax_type = $this->slider->getParam("parallax_type","mouse");
				$parallax_bg_freeze = $this->slider->getParam("parallax_bg_freeze","off");
				$parallax_level[] = intval($this->slider->getParam("parallax_level_1","5"));
				$parallax_level[] = intval($this->slider->getParam("parallax_level_2","10"));
				$parallax_level[] = intval($this->slider->getParam("parallax_level_3","15"));
				$parallax_level[] = intval($this->slider->getParam("parallax_level_4","20"));
				$parallax_level[] = intval($this->slider->getParam("parallax_level_5","25"));
				$parallax_level[] = intval($this->slider->getParam("parallax_level_6","30"));
				$parallax_level[] = intval($this->slider->getParam("parallax_level_7","35"));
				$parallax_level[] = intval($this->slider->getParam("parallax_level_8","40"));
				$parallax_level[] = intval($this->slider->getParam("parallax_level_9","45"));
				$parallax_level[] = intval($this->slider->getParam("parallax_level_10","50"));
				$parallax_level = implode(',', $parallax_level);
			}

			$operations = new RevOperations();
			$arrValues = $operations->getGeneralSettingsValues();
			
			$do_delay = $this->slider->getParam("start_js_after_delay","0");
			
			$do_delay = apply_filters('revslider_add_js_delay', $do_delay);
			
			$do_delay = intval($do_delay);
			
			$js_to_footer = (isset($arrValues['js_to_footer']) && $arrValues['js_to_footer'] == 'on') ? true : false;
			
			//add inline style into the footer
			if($js_to_footer && $this->previewMode == false){
				ob_start();
			}
			
			?>
			

			<?php
				// ADD SCOPED INLINE STYLES 			
				$this->add_inline_styles();
			?>

			<script type="text/javascript">

				/******************************************
					-	PREPARE PLACEHOLDER FOR SLIDER	-
				******************************************/
				<?php
							/*var setREVStartSize = function() {

							var	tpopt = new Object();
								tpopt.startwidth = <?php echo $this->slider->getParam("width","900")?>;
								tpopt.startheight = <?php echo $this->slider->getParam("height","300")?>;
								tpopt.container = jQuery('#<?php echo $this->sliderHtmlID?>');
								tpopt.fullScreen = "<?php echo $optFullScreen?>";
								tpopt.forceFullWidth="<?php echo $this->slider->getParam("force_full_width", 'off'); ?>";




							tpopt.container.closest('.rev_slider_wrapper').css({'height':tpopt.container.height()});

							tpopt.width=parseInt(tpopt.container.width(),0);
							tpopt.height=parseInt(tpopt.container.height(),0);


							tpopt.bw= (tpopt.width / tpopt.startwidth);
							tpopt.bh = (tpopt.height / tpopt.startheight);

							if (tpopt.bh>tpopt.bw) tpopt.bh=tpopt.bw;
							if (tpopt.bh<tpopt.bw) tpopt.bw = tpopt.bh;
							if (tpopt.bw<tpopt.bh) tpopt.bh = tpopt.bw;
							if (tpopt.bh>1) { tpopt.bw=1; tpopt.bh=1; }
							if (tpopt.bw>1) {tpopt.bw=1; tpopt.bh=1; }
							tpopt.height = Math.round(tpopt.startheight * (tpopt.width/tpopt.startwidth));
							if (tpopt.height>tpopt.startheight && tpopt.autoHeight!="on") tpopt.height=tpopt.startheight;




							if (tpopt.fullScreen=="on") {
									tpopt.height = tpopt.bw * tpopt.startheight;
									var cow = tpopt.container.parent().width();
									var coh = jQuery(window).height();
									if (tpopt.fullScreenOffsetContainer!=undefined) {
										try{
											var offcontainers = tpopt.fullScreenOffsetContainer.split(",");
											jQuery.each(offcontainers,function(index,searchedcont) {
												coh = coh - jQuery(searchedcont).outerHeight(true);
												if (coh<tpopt.minFullScreenHeight) coh=tpopt.minFullScreenHeight;
											});
										} catch(e) {}
									}

									tpopt.container.parent().height(coh);
									tpopt.container.height(coh);
									tpopt.container.closest('.rev_slider_wrapper').height(coh);
									tpopt.container.closest('.forcefullwidth_wrapper_tp_banner').find('.tp-fullwidth-forcer').height(coh);
									tpopt.container.css({'height':'100%'});

									tpopt.height=coh;

							} else {
								tpopt.container.height(tpopt.height);
								tpopt.container.closest('.rev_slider_wrapper').height(tpopt.height);
								tpopt.container.closest('.forcefullwidth_wrapper_tp_banner').find('.tp-fullwidth-forcer').height(tpopt.height);
							}

						}				*/
				?>


				var setREVStartSize = function() {
					var	tpopt = new Object();
						tpopt.startwidth = <?php echo $this->slider->getParam("width","900")?>;
						tpopt.startheight = <?php echo $this->slider->getParam("height","300")?>;
						tpopt.container = jQuery('#<?php echo $this->sliderHtmlID?>');
						tpopt.fullScreen = "<?php echo $optFullScreen?>";
						tpopt.forceFullWidth="<?php echo $this->slider->getParam("force_full_width", 'off'); ?>";

					tpopt.container.closest(".rev_slider_wrapper").css({height:tpopt.container.height()});tpopt.width=parseInt(tpopt.container.width(),0);tpopt.height=parseInt(tpopt.container.height(),0);tpopt.bw=tpopt.width/tpopt.startwidth;tpopt.bh=tpopt.height/tpopt.startheight;if(tpopt.bh>tpopt.bw)tpopt.bh=tpopt.bw;if(tpopt.bh<tpopt.bw)tpopt.bw=tpopt.bh;if(tpopt.bw<tpopt.bh)tpopt.bh=tpopt.bw;if(tpopt.bh>1){tpopt.bw=1;tpopt.bh=1}if(tpopt.bw>1){tpopt.bw=1;tpopt.bh=1}tpopt.height=Math.round(tpopt.startheight*(tpopt.width/tpopt.startwidth));if(tpopt.height>tpopt.startheight&&tpopt.autoHeight!="on")tpopt.height=tpopt.startheight;if(tpopt.fullScreen=="on"){tpopt.height=tpopt.bw*tpopt.startheight;var cow=tpopt.container.parent().width();var coh=jQuery(window).height();if(tpopt.fullScreenOffsetContainer!=undefined){try{var offcontainers=tpopt.fullScreenOffsetContainer.split(",");jQuery.each(offcontainers,function(e,t){coh=coh-jQuery(t).outerHeight(true);if(coh<tpopt.minFullScreenHeight)coh=tpopt.minFullScreenHeight})}catch(e){}}tpopt.container.parent().height(coh);tpopt.container.height(coh);tpopt.container.closest(".rev_slider_wrapper").height(coh);tpopt.container.closest(".forcefullwidth_wrapper_tp_banner").find(".tp-fullwidth-forcer").height(coh);tpopt.container.css({height:"100%"});tpopt.height=coh;}else{tpopt.container.height(tpopt.height);tpopt.container.closest(".rev_slider_wrapper").height(tpopt.height);tpopt.container.closest(".forcefullwidth_wrapper_tp_banner").find(".tp-fullwidth-forcer").height(tpopt.height);}
				};

				/* CALL PLACEHOLDER */
				setREVStartSize();


				var tpj=jQuery;
				<?php if($noConflict == "on"):?>tpj.noConflict();<?php endif;?>

				var revapi<?php echo $sliderID?>;

				tpj(document).ready(function() {

				if(tpj('#<?php echo $this->sliderHtmlID?>').revolution == undefined){
					revslider_showDoubleJqueryError('#<?php echo $this->sliderHtmlID?>');
				}else{
				   revapi<?php echo $sliderID?> = tpj('#<?php echo $this->sliderHtmlID?>').show().revolution(
					{	
						<?php if($do_delay > 0){ ?>startDelay: <?php echo $do_delay; ?>,<?php } ?>
						dottedOverlay:"<?php echo $this->slider->getParam("background_dotted_overlay","none");?>",
						delay:<?php echo $this->slider->getParam("delay","9000",RevSlider::FORCE_NUMERIC)?>,
						startwidth:<?php echo $this->slider->getParam("width","900")?>,
						startheight:<?php echo $this->slider->getParam("height","300")?>,
						hideThumbs:<?php echo $hideThumbs?>,

						thumbWidth:<?php echo $this->slider->getParam("thumb_width","100",RevSlider::FORCE_NUMERIC)?>,
						thumbHeight:<?php echo $this->slider->getParam("thumb_height","50",RevSlider::FORCE_NUMERIC)?>,
						thumbAmount:<?php echo $thumbAmount?>,
						
						<?php
						if($this->slider->getParam("slider_type") != "fullscreen"){
							$minHeight = $this->slider->getParam("min_height","0",RevSlider::FORCE_NUMERIC);
							if($minHeight > 0){ ?>minHeight:<?php echo $minHeight; ?>,
								<?php
							}
						}
						?>
						
						simplifyAll:"<?php echo $this->slider->getParam("simplify_ie8_ios4","off"); ?>",

						navigationType:"<?php echo $this->slider->getParam("navigaion_type","none")?>",
						navigationArrows:"<?php echo $arrowsType?>",
						navigationStyle:"<?php echo $this->slider->getParam("navigation_style","round")?>",

						touchenabled:"<?php echo $this->slider->getParam("touchenabled","on")?>",
						onHoverStop:"<?php echo $this->slider->getParam("stop_on_hover","on")?>",
						nextSlideOnWindowFocus:"<?php echo $this->slider->getParam("next_slide_on_window_focus","off")?>",

						<?php
						if($this->slider->getParam("touchenabled","on") == 'on'){
						?>swipe_threshold: <?php echo $swipe_velocity ?>,
						swipe_min_touches: <?php echo $swipe_min_touches ?>,
						drag_block_vertical: <?php echo ($drag_block_vertical == 'true') ? 'true' : 'false'; ?>,
						<?php
						}
						?>

						<?php
						if($use_parallax == 'on'){
						?>
						parallax:"<?php echo $parallax_type; ?>",
						parallaxBgFreeze:"<?php echo $parallax_bg_freeze; ?>",
						parallaxLevels:[<?php echo $parallax_level; ?>],
						<?php
						if($disable_parallax_mobile == 'on'){
						?>
						parallaxDisableOnMobile:"on",
						<?php
						}
						}
						?>
						
						<?php
						if($disableKenBurnOnMobile == 'on'){
							?>
							panZoomDisableOnMobile:"on",
							<?php
						}
						?>
						
						keyboardNavigation:"<?php echo $this->slider->getParam("keyboard_navigation","off")?>",

						navigationHAlign:"<?php echo $this->slider->getParam("navigaion_align_hor","center")?>",
						navigationVAlign:"<?php echo $this->slider->getParam("navigaion_align_vert","bottom")?>",
						navigationHOffset:<?php echo $this->slider->getParam("navigaion_offset_hor","0",RevSlider::FORCE_NUMERIC)?>,
						navigationVOffset:<?php echo $this->slider->getParam("navigaion_offset_vert","20",RevSlider::FORCE_NUMERIC)?>,

						soloArrowLeftHalign:"<?php echo $this->slider->getParam("leftarrow_align_hor","left")?>",
						soloArrowLeftValign:"<?php echo $this->slider->getParam("leftarrow_align_vert","center")?>",
						soloArrowLeftHOffset:<?php echo $this->slider->getParam("leftarrow_offset_hor","20",RevSlider::FORCE_NUMERIC)?>,
						soloArrowLeftVOffset:<?php echo $this->slider->getParam("leftarrow_offset_vert","0",RevSlider::FORCE_NUMERIC)?>,

						soloArrowRightHalign:"<?php echo $this->slider->getParam("rightarrow_align_hor","right")?>",
						soloArrowRightValign:"<?php echo $this->slider->getParam("rightarrow_align_vert","center")?>",
						soloArrowRightHOffset:<?php echo $this->slider->getParam("rightarrow_offset_hor","20",RevSlider::FORCE_NUMERIC)?>,
						soloArrowRightVOffset:<?php echo $this->slider->getParam("rightarrow_offset_vert","0",RevSlider::FORCE_NUMERIC)?>,

						shadow:<?php echo $this->slider->getParam("shadow_type","2")?>,
						fullWidth:"<?php echo $optFullWidth?>",
						fullScreen:"<?php echo $optFullScreen?>",

						<?php 
						if($use_spinner == '-1'){
						?>
						spinner:"off",
						<?php
						}else{
						?>
						spinner:"spinner<?php echo $use_spinner?>",
						<?php
						}
						?>
						
						stopLoop:"<?php echo $stopSlider?>",
						stopAfterLoops:<?php echo $stopAfterLoops?>,
						stopAtSlide:<?php echo $stopAtSlide?>,

						shuffle:"<?php echo $this->slider->getParam("shuffle","off") ?>",

						<?php if($this->slider->getParam("slider_type") == "fullwidth"){ ?>autoHeight:"<?php echo $this->slider->getParam("auto_height", 'off'); ?>",<?php }  ?>

						<?php if($this->slider->getParam("slider_type") == "fullwidth" || $this->slider->getParam("slider_type") == "fullscreen"){ ?>forceFullWidth:"<?php echo $this->slider->getParam("force_full_width", 'off'); ?>",<?php }  ?>

						<?php if($this->slider->getParam("slider_type") == "fullscreen"){ ?>fullScreenAlignForce:"<?php echo $this->slider->getParam("full_screen_align_force","off") ?>",<?php }  ?>

						<?php if($this->slider->getParam("slider_type") == "fullscreen"){ ?>minFullScreenHeight:"<?php echo $this->slider->getParam("fullscreen_min_height","0") ?>",<?php }  ?>

						<?php if($timerBar == "hide"){ ?>hideTimerBar:"on",<?php } ?>

						hideThumbsOnMobile:"<?php echo $hideThumbsOnMobile?>",
						<?php if($hideThumbsOnMobile == 'off'){ ?>hideNavDelayOnMobile:<?php echo $hideThumbsDelayMobile; ?>,
						<?php } ?>hideBulletsOnMobile:"<?php echo $hideBulletsOnMobile?>",
						hideArrowsOnMobile:"<?php echo $hideArrowsOnMobile?>",
						hideThumbsUnderResolution:<?php echo $hideThumbsUnderResolution?>,

						<?php
						if($this->slider->getParam("slider_type") == 'fullscreen'){
						?>
						fullScreenOffsetContainer: "<?php echo $this->slider->getParam("fullscreen_offset_container","");?>",
						fullScreenOffset: "<?php echo $this->slider->getParam("fullscreen_offset_size","");?>",
						<?php
						}
						?>
						hideSliderAtLimit:<?php echo $hideSliderAtLimit?>,
						hideCaptionAtLimit:<?php echo $hideCaptionAtLimit?>,
						hideAllCaptionAtLilmit:<?php echo $hideAllCaptionAtLimit?>,
						startWithSlide:<?php echo $startWithSlide?>
					});



					<?php
					if($this->slider->getParam("custom_javascript", '') !== ''){
						echo stripslashes($this->slider->getParam("custom_javascript", ''));
					}
					?>
				}
				});	/*ready*/

			</script>


			<?php
			if($js_to_footer && $this->previewMode == false){
				$js_content = ob_get_contents();
				ob_clean();
				ob_end_clean();

				$this->rev_inline_js = $js_content;

				add_action('wp_footer', array($this, 'add_inline_js'));
			}

			switch($use_spinner){
				case '1':
				case '2':
					echo '<style type="text/css">'."\n";
					echo '	#'.$this->sliderHtmlID_wrapper.' .tp-loader.spinner'.$use_spinner.'{ background-color: '.$spinner_color.' !important; }'."\n";
					echo '</style>'."\n";
				break;
				case '3':
				case '4':
					echo '<style type="text/css">'."\n";
					echo '	#'.$this->sliderHtmlID_wrapper.' .tp-loader.spinner'.$use_spinner.' div { background-color: '.$spinner_color.' !important; }'."\n";
					echo '</style>'."\n";
				break;
				case '0':
				case '5':
				default:
				break;

			}

			if($this->slider->getParam("custom_css", '') !== ''){
				?>
				<style type="text/css">
					<?php
					echo stripslashes($this->slider->getParam("custom_css", ''));
					?>
				</style>
				<?php
			}
		}


		/**
		 * Output Inline JS
		 */
		public function add_inline_js(){

			echo $this->rev_inline_js;

		}


		/**
		 * Output Dynamic Inline Styles
		 */
		public function add_inline_styles(){
		
			//echo '<div class="revsliderstyles">';
			echo '<style scoped>';

			$db = new UniteDBRev();

			$styles = $db->fetch(GlobalsRevSlider::$table_css);
			foreach($styles as $key => $style){
				$handle = str_replace('.tp-caption', '', $style['handle']);
				if(!isset($this->class_include[$handle])) unset($styles[$key]);
			}


			$styles = UniteCssParserRev::parseDbArrayToCss($styles, "\n");
			$styles = UniteCssParserRev::compress_css($styles);
			echo $styles;

			echo '</style>'."\n";
			//echo '</div>';

		}

		/**
		 *
		 * put inline error message in a box.
		 */
		public function putErrorMessage($message){
			?>
			<div style="width:800px;height:300px;margin-bottom:10px;border:1px solid black;margin:0px auto;">
				<div style="padding-left:20px;padding-right:20px;line-height:1.5;padding-top:40px;color:red;font-size:16px;text-align:left;">
					<?php _e("Revolution Slider Error",REVSLIDER_TEXTDOMAIN)?>: <?php echo $message?>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery(".rev_slider").show();
				});
			</script>
			<?php
		}

		/**
		 *
		 * fill the responsitive slider values for further output
		 */
		private function getResponsitiveValues(){
			$sliderWidth = (int)$this->slider->getParam("width");
			$sliderHeight = (int)$this->slider->getParam("height");

			$percent = $sliderHeight / $sliderWidth;

			$w1 = (int) $this->slider->getParam("responsitive_w1",0);
			$w2 = (int) $this->slider->getParam("responsitive_w2",0);
			$w3 = (int) $this->slider->getParam("responsitive_w3",0);
			$w4 = (int) $this->slider->getParam("responsitive_w4",0);
			$w5 = (int) $this->slider->getParam("responsitive_w5",0);
			$w6 = (int) $this->slider->getParam("responsitive_w6",0);

			$sw1 = (int) $this->slider->getParam("responsitive_sw1",0);
			$sw2 = (int) $this->slider->getParam("responsitive_sw2",0);
			$sw3 = (int) $this->slider->getParam("responsitive_sw3",0);
			$sw4 = (int) $this->slider->getParam("responsitive_sw4",0);
			$sw5 = (int) $this->slider->getParam("responsitive_sw5",0);
			$sw6 = (int) $this->slider->getParam("responsitive_sw6",0);

			$arrItems = array();

			//add main item:
			$arr = array();
			$arr["maxWidth"] = -1;
			$arr["minWidth"] = $w1;
			$arr["sliderWidth"] = $sliderWidth;
			$arr["sliderHeight"] = $sliderHeight;
			$arrItems[] = $arr;

			//add item 1:
			if(empty($w1))
				return($arrItems);

			$arr = array();
			$arr["maxWidth"] = $w1-1;
			$arr["minWidth"] = $w2;
			$arr["sliderWidth"] = $sw1;
			$arr["sliderHeight"] = floor($sw1 * $percent);
			$arrItems[] = $arr;

			//add item 2:
			if(empty($w2))
				return($arrItems);

			$arr["maxWidth"] = $w2-1;
			$arr["minWidth"] = $w3;
			$arr["sliderWidth"] = $sw2;
			$arr["sliderHeight"] = floor($sw2 * $percent);
			$arrItems[] = $arr;

			//add item 3:
			if(empty($w3))
				return($arrItems);

			$arr["maxWidth"] = $w3-1;
			$arr["minWidth"] = $w4;
			$arr["sliderWidth"] = $sw3;
			$arr["sliderHeight"] = floor($sw3 * $percent);
			$arrItems[] = $arr;

			//add item 4:
			if(empty($w4))
				return($arrItems);

			$arr["maxWidth"] = $w4-1;
			$arr["minWidth"] = $w5;
			$arr["sliderWidth"] = $sw4;
			$arr["sliderHeight"] = floor($sw4 * $percent);
			$arrItems[] = $arr;

			//add item 5:
			if(empty($w5))
				return($arrItems);

			$arr["maxWidth"] = $w5-1;
			$arr["minWidth"] = $w6;
			$arr["sliderWidth"] = $sw5;
			$arr["sliderHeight"] = floor($sw5 * $percent);
			$arrItems[] = $arr;

			//add item 6:
			if(empty($w6))
				return($arrItems);

			$arr["maxWidth"] = $w6-1;
			$arr["minWidth"] = 0;
			$arr["sliderWidth"] = $sw6;
			$arr["sliderHeight"] = floor($sw6 * $percent);
			$arrItems[] = $arr;

			return($arrItems);
		}


		/**
		 *
		 * put responsitive inline styles
		 */
		private function putResponsitiveStyles(){

			$bannerWidth = $this->slider->getParam("width");
			$bannerHeight = $this->slider->getParam("height");

			$arrItems = $this->getResponsitiveValues();

			?>
			<style type='text/css'>
				#<?php echo $this->sliderHtmlID?>, #<?php echo $this->sliderHtmlID_wrapper?> { width:<?php echo $bannerWidth?>px; height:<?php echo $bannerHeight?>px;}
			<?php
			foreach($arrItems as $item):
				$strMaxWidth = "";

				if($item["maxWidth"] >= 0)
					$strMaxWidth = "and (max-width: ".$item["maxWidth"]."px)";

			?>

			   @media only screen and (min-width: <?php echo $item["minWidth"]?>px) <?php echo $strMaxWidth?> {
			 		  #<?php echo $this->sliderHtmlID?>, #<?php echo $this->sliderHtmlID_wrapper?> { width:<?php echo $item["sliderWidth"]?>px; height:<?php echo $item["sliderHeight"]?>px;}
			   }

			<?php
			endforeach;
			echo "</style>";
		}


		/**
		 *
		 * modify slider settings for preview mode
		 */
		private function modifyPreviewModeSettings(){
			$params = $this->slider->getParams();
			$params["js_to_body"] = "false";

			$this->slider->setParams($params);
		}


		/**
		 *
		 * put html slider on the html page.
		 * @param $data - mixed, can be ID ot Alias.
		 */
		//TODO: settings google font, position, margin, background color, alt image text
		public function putSliderBase($sliderID){

			try{
				self::$sliderSerial++;

				$this->slider = new RevSlider();
				$this->slider->initByMixed($sliderID);

				$doWrapFromTemplate = false;

				if($this->slider->isSlidesFromPosts() && $this->slider->getParam("slider_template_id",false) !== false){ //need to use general settings from the Template Slider
					$this->slider->initByMixed($this->slider->getParam("slider_template_id",false));
					$doWrapFromTemplate = $sliderID;
				}

				//modify settings for admin preview mode
				if($this->previewMode == true)
					$this->modifyPreviewModeSettings();

				//set slider language
				$isWpmlExists = UniteWpmlRev::isWpmlExists();
				$useWpml = $this->slider->getParam("use_wpml","off");
				if(	$isWpmlExists && $useWpml == "on"){
					if($this->previewMode == false)
						$this->sliderLang = UniteFunctionsWPRev::getCurrentLangCode();
				}

				//edit html before slider
				$htmlBeforeSlider = "";
				if($this->slider->getParam("load_googlefont","false") == "true"){
					$googleFont = $this->slider->getParam("google_font");
					if(is_array($googleFont)){
						foreach($googleFont as $key => $font){
							$htmlBeforeSlider .= RevOperations::getCleanFontImport($font);
						}
					}else{
						$htmlBeforeSlider .= RevOperations::getCleanFontImport($googleFont);
					}

				}

				//pub js to body handle
				if($this->slider->getParam("js_to_body","false") == "true"){
					$operations = new RevOperations();
					$arrValues = $operations->getGeneralSettingsValues();
					$enable_logs = UniteFunctionsRev::getVal($arrValues, "enable_logs",'off');
					
					if($enable_logs == 'on'){
						$urlIncludeJS = UniteBaseClassRev::$url_plugin."rs-plugin/js/jquery.themepunch.enablelog.js?rev=". GlobalsRevSlider::SLIDER_REVISION;
						$htmlBeforeSlider .= "<script type='text/javascript' src='$urlIncludeJS'></script>";
					}

					$urlIncludeJS = UniteBaseClassRev::$url_plugin."rs-plugin/js/jquery.themepunch.tools.min.js?rev=". GlobalsRevSlider::SLIDER_REVISION;
					$htmlBeforeSlider .= "<script type='text/javascript' src='$urlIncludeJS'></script>";
					$urlIncludeJS = UniteBaseClassRev::$url_plugin."rs-plugin/js/jquery.themepunch.revolution.min.js?rev=". GlobalsRevSlider::SLIDER_REVISION;
					$htmlBeforeSlider .= "<script type='text/javascript' src='$urlIncludeJS'></script>";
				}

				//the initial id can be alias
				$sliderID = $this->slider->getID();

				$bannerWidth = $this->slider->getParam("width",null,RevSlider::VALIDATE_NUMERIC,"Slider Width");
				$bannerHeight = $this->slider->getParam("height",null,RevSlider::VALIDATE_NUMERIC,"Slider Height");

				$sliderType = $this->slider->getParam("slider_type");

				//set wrapper height
				$wrapperHeigh = 0;
				$wrapperHeigh += $this->slider->getParam("height");

				//add thumb height
				if($this->slider->getParam("navigaion_type") == "thumb"){
					$wrapperHeigh += $this->slider->getParam("thumb_height");
				}

				$this->sliderHtmlID = "rev_slider_".$sliderID."_".self::$sliderSerial;
				$this->sliderHtmlID_wrapper = $this->sliderHtmlID."_wrapper";

				$containerStyle = "";

				$sliderPosition = $this->slider->getParam("position","center");

				//set position:
				if($sliderType != "fullscreen"){

					switch($sliderPosition){
						case "center":
						default:
							$containerStyle .= "margin:0px auto;";
						break;
						case "left":
							$containerStyle .= "float:left;";
						break;
						case "right":
							$containerStyle .= "float:right;";
						break;
					}

				}

				//add background color
				$backgrondColor = trim($this->slider->getParam("background_color"));
				if(!empty($backgrondColor))
					$containerStyle .= "background-color:$backgrondColor;";

				//set padding
				$containerStyle .= "padding:".$this->slider->getParam("padding","0")."px;";

				//set margin:
				if($sliderType != "fullscreen"){

					if($sliderPosition != "center"){
						$containerStyle .= "margin-left:".$this->slider->getParam("margin_left","0")."px;";
						$containerStyle .= "margin-right:".$this->slider->getParam("margin_right","0")."px;";
					}

					$containerStyle .= "margin-top:".$this->slider->getParam("margin_top","0")."px;";
					$containerStyle .= "margin-bottom:".$this->slider->getParam("margin_bottom","0")."px;";
				}

				//set height and width:
				$bannerStyle = "display:none;";

				//add background image (to banner style)
				$showBackgroundImage = $this->slider->getParam("show_background_image","false");
				if($showBackgroundImage == "true"){
					$backgroundImage = $this->slider->getParam("background_image");
					$backgroundFit = $this->slider->getParam("bg_fit", "cover");
					$backgroundRepeat = $this->slider->getParam("bg_repeat", "no-repeat");
					$backgroundPosition = $this->slider->getParam("bg_position", "center top");

					if(!empty($backgroundImage))
						$bannerStyle .= "background-image:url($backgroundImage);background-repeat:".$backgroundRepeat.";background-fit:".$backgroundFit.";background-position:".$backgroundPosition.";";
				}

				//set wrapper and slider class:
				$sliderWrapperClass = "rev_slider_wrapper";
				$sliderClass = "rev_slider";

				$putResponsiveStyles = false;

				switch($sliderType){
					case "responsitive":
						//$containerStyle .= "height:".$bannerHeight."px;";
						$putResponsiveStyles = true;
					break;
					case "fullwidth":
						$sliderWrapperClass .= " fullwidthbanner-container";
						$sliderClass .= " fullwidthabanner";
						$bannerStyle .= "max-height:".$bannerHeight."px;height:".$bannerHeight."px;";
						$containerStyle .= "max-height:".$bannerHeight."px;";
					break;
					case "fullscreen":
						//$containerStyle .= "height:".$bannerHeight."px;";
						$sliderWrapperClass .= " fullscreen-container";
						$sliderClass .= " fullscreenbanner";
					break;
					case "fixed":
					default:
						$bannerStyle .= "height:".$bannerHeight."px;width:".$bannerWidth."px;";
						$containerStyle .= "height:".$bannerHeight."px;width:".$bannerWidth."px;";
					break;
				}

				$htmlTimerBar = "";

				$timerBar =  $this->slider->getParam("show_timerbar","top");

				if($timerBar == "true")
					$timerBar = $this->slider->getParam("timebar_position","top");

				switch($timerBar){
					case "top":
						$htmlTimerBar = '<div class="tp-bannertimer"></div>';
					break;
					case "bottom":
						$htmlTimerBar = '<div class="tp-bannertimer tp-bottom"></div>';
					break;
					case "hide":
						$htmlTimerBar = '<div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>';
					break;
				}

				//check inner / outer border
				$paddingType = $this->slider->getParam("padding_type","outter");
				if($paddingType == "inner")
					$sliderWrapperClass .= " tp_inner_padding";

				global $revSliderVersion;

					if($putResponsiveStyles == true)
						$this->putResponsitiveStyles();

				echo $htmlBeforeSlider."\n";
				echo "<div id=\"";
				echo $this->sliderHtmlID_wrapper;
				echo "\" ";
				echo "class=\"". $sliderWrapperClass ."\"";
				
				$show_alternate = $this->slider->getParam("show_alternative_type","off");
				if($show_alternate !== 'off'){
					$show_alternate_image = $this->slider->getParam("show_alternate_image","");
					echo ' data-aimg="'.$show_alternate_image.'" ';
					if($show_alternate == 'mobile' || $show_alternate == 'mobile-ie8'){
						echo ' data-amobile="enabled" ';
					}else{
						echo ' data-amobile="disabled" ';
					}
					if($show_alternate == 'mobile-ie8' || $show_alternate == 'ie8'){
						echo ' data-aie8="enabled" ';
					}else{
						echo ' data-aie8="disabled" ';
					}
					
				}
				
				echo " style=\"". $containerStyle ."\">\n";

				echo "<!-- START REVOLUTION SLIDER ". $revSliderVersion ." ". $sliderType ." mode -->\n";

				echo "	<div id=\"";
				echo $this->sliderHtmlID;
				echo "\" ";
				echo "class=\"". $sliderClass ."\"";
				echo " style=\"". $bannerStyle ."\">\n";

				echo $this->putSlides($doWrapFromTemplate);
				echo $htmlTimerBar;
				echo "	</div>\n";
				
				$this->putJS();
				
				echo "</div>";
				echo "<!-- END REVOLUTION SLIDER -->";
			}catch(Exception $e){
				$message = $e->getMessage();
				$this->putErrorMessage($message);
			}

		}

	}

?>