<?php

	class RevOperations extends UniteElementsBaseRev{

		/**
		 *
		 * get wildcards settings object
		 * $isInsidePost it means that it's used inside the post and not template page.
		 */
		public static function getWildcardsSettings(){

			$settings = new UniteSettingsAdvancedRev();

			//add youtube, excerpt and vimeo id
			$slider = new RevSlider();
			$arrOutput = array();
			$arrOutput["default"] = "default";

			$arrSlides = $slider->getArrSlidersWithSlidesShort(RevSlider::SLIDER_TYPE_TEMPLATE);
			$arrOutput = $arrOutput + $arrSlides;	//union arrays

			$settings->addSelect("slide_template", $arrOutput, __("Choose Slide Template",REVSLIDER_TEXTDOMAIN),"default");

			/*
			$params = array("class"=>"textbox_small","description"=>"Overwrite the global excerpt words limit option for this post");
			$settings->addTextBox("revslider_excerpt_limit", "", "Excerpt Words Limit",$params);
			$params = array("description"=>"The youtube ID, example: 9bZkp7q19f0");
			$settings->addTextBox("youtube_id", "", "Youtube ID", $params);
			$params = array("description"=>"The youtube ID, example: 18554749");
			$settings->addTextBox("vimeo_id", "", "Vimeo ID",$params);
			*/

			return($settings);
		}


		/**
		 *
		 * get names and titles of the wildcards
		 */
		public static function getWildcardsSettingNames(){
			$settings = $this->getWildcardsSettings();
			$arrNames = $settings->getArrSettingNamesAndTitles();
			return($arrNames);
		}

		/**
		 *
		 * get wildcard values of the post
		 */
		public static function getPostWilcardValues($postID){
			$settings = RevOperations::getWildcardsSettings();
			$settings->updateValuesFromPostMeta($postID);
			$arrValues = $settings->getArrValues();
			return($arrValues);
		}


		/**
		 *
		 * get button classes
		 */
		public function getButtonClasses(){

			$arrButtons = array(
				"red"=>"Red Button",
				"green"=>"Green Button",
				"blue"=>"Blue Button",
				"orange"=>"Orange Button",
				"darkgrey"=>"Darkgrey Button",
				"lightgrey"=>"Lightgrey Button",
			);

			return($arrButtons);
		}




		/**
		 *
		 * get easing functions array
		 */
		public function getArrEasing(){ //true

			$arrEasing = array(
				"Linear.easeNone" => "Linear.easeNone",
				"Power0.easeIn" => "Power0.easeIn  (linear)",
				"Power0.easeInOut" => "Power0.easeInOut  (linear)",
				"Power0.easeOut" => "Power0.easeOut  (linear)",
				"Power1.easeIn" => "Power1.easeIn",
				"Power1.easeInOut" => "Power1.easeInOut",
				"Power1.easeOut" => "Power1.easeOut",
				"Power2.easeIn" => "Power2.easeIn",
				"Power2.easeInOut" => "Power2.easeInOut",
				"Power2.easeOut" => "Power2.easeOut",
				"Power3.easeIn" => "Power3.easeIn",
				"Power3.easeInOut" => "Power3.easeInOut",
				"Power3.easeOut" => "Power3.easeOut",
				"Power4.easeIn" => "Power4.easeIn",
				"Power4.easeInOut" => "Power4.easeInOut",
				"Power4.easeOut" => "Power4.easeOut",
				"Quad.easeIn" => "Quad.easeIn  (same as Power1.easeIn)",
				"Quad.easeInOut" => "Quad.easeInOut  (same as Power1.easeInOut)",
				"Quad.easeOut" => "Quad.easeOut  (same as Power1.easeOut)",
				"Cubic.easeIn" => "Cubic.easeIn  (same as Power2.easeIn)",
				"Cubic.easeInOut" => "Cubic.easeInOut  (same as Power2.easeInOut)",
				"Cubic.easeOut" => "Cubic.easeOut  (same as Power2.easeOut)",
				"Quart.easeIn" => "Quart.easeIn  (same as Power3.easeIn)",
				"Quart.easeInOut" => "Quart.easeInOut  (same as Power3.easeInOut)",
				"Quart.easeOut" => "Quart.easeOut  (same as Power3.easeOut)",
				"Quint.easeIn" => "Quint.easeIn  (same as Power4.easeIn)",
				"Quint.easeInOut" => "Quint.easeInOut  (same as Power4.easeInOut)",
				"Quint.easeOut" => "Quint.easeOut  (same as Power4.easeOut)",
				"Strong.easeIn" => "Strong.easeIn  (same as Power4.easeIn)",
				"Strong.easeInOut" => "Strong.easeInOut  (same as Power4.easeInOut)",
				"Strong.easeOut" => "Strong.easeOut  (same as Power4.easeOut)",
				"Back.easeIn" => "Back.easeIn",
				"Back.easeInOut" => "Back.easeInOut",
				"Back.easeOut" => "Back.easeOut",
				"Bounce.easeIn" => "Bounce.easeIn",
				"Bounce.easeInOut" => "Bounce.easeInOut",
				"Bounce.easeOut" => "Bounce.easeOut",
				"Circ.easeIn" => "Circ.easeIn",
				"Circ.easeInOut" => "Circ.easeInOut",
				"Circ.easeOut" => "Circ.easeOut",
				"Elastic.easeIn" => "Elastic.easeIn",
				"Elastic.easeInOut" => "Elastic.easeInOut",
				"Elastic.easeOut" => "Elastic.easeOut",
				"Expo.easeIn" => "Expo.easeIn",
				"Expo.easeInOut" => "Expo.easeInOut",
				"Expo.easeOut" => "Expo.easeOut",
				"Sine.easeIn" => "Sine.easeIn",
				"Sine.easeInOut" => "Sine.easeInOut",
				"Sine.easeOut" => "Sine.easeOut",
				"SlowMo.ease" => "SlowMo.ease",
				//add old easings
				"easeOutBack" => "easeOutBack",
				"easeInQuad" => "easeInQuad",
				"easeOutQuad" => "easeOutQuad",
				"easeInOutQuad" => "easeInOutQuad",
				"easeInCubic" => "easeInCubic",
				"easeOutCubic" => "easeOutCubic",
				"easeInOutCubic" => "easeInOutCubic",
				"easeInQuart" => "easeInQuart",
				"easeOutQuart" => "easeOutQuart",
				"easeInOutQuart" => "easeInOutQuart",
				"easeInQuint" => "easeInQuint",
				"easeOutQuint" => "easeOutQuint",
				"easeInOutQuint" => "easeInOutQuint",
				"easeInSine" => "easeInSine",
				"easeOutSine" => "easeOutSine",
				"easeInOutSine" => "easeInOutSine",
				"easeInExpo" => "easeInExpo",
				"easeOutExpo" => "easeOutExpo",
				"easeInOutExpo" => "easeInOutExpo",
				"easeInCirc" => "easeInCirc",
				"easeOutCirc" => "easeOutCirc",
				"easeInOutCirc" => "easeInOutCirc",
				"easeInElastic" => "easeInElastic",
				"easeOutElastic" => "easeOutElastic",
				"easeInOutElastic" => "easeInOutElastic",
				"easeInBack" => "easeInBack",
				"easeInOutBack" => "easeInOutBack",
				"easeInBounce" => "easeInBounce",
				"easeOutBounce" => "easeOutBounce",
				"easeInOutBounce" => "easeInOutBounce"
			);

			return($arrEasing);
		}


		/**
		 *
		 * get easing functions array
		 */
		public function getArrSplit(){ //true

			$arrSplit = array(
				"none" => "No Split",
				"chars" => "Char Based",
				"words" => "Word Based",
				"lines" => "Line Based"
			);

			return($arrSplit);
		}

		/**
		 *
		 * get arr end easing
		 */
		public function getArrEndEasing(){
			$arrEasing = $this->getArrEasing();
			$arrEasing = array_merge(array("nothing" => "No Change"),$arrEasing);

			return($arrEasing);
		}

		/**
		 *
		 * get transition array
		 */
		public function getArrTransition($premium = false){

				$arrTransition = array(
					"notselectable1"=>"RANDOM TRANSITIONS",
					"random-selected"=>"Random of Selected",
					"random-static"=>"Random Flat",
					"random-premium"=>"Random Premium",
					"random"=>"Random Flat and Premium",
					"notselectable2"=>"SLIDING TRANSITIONS",
					"slideup"=>"Slide To Top",
					"slidedown"=>"Slide To Bottom",
					"slideright"=>"Slide To Right",
					"slideleft"=>"Slide To Left",
					"slidehorizontal"=>"Slide Horizontal (depending on Next/Previous)",
					"slidevertical"=>"Slide Vertical (depending on Next/Previous)",
					"boxslide"=>"Slide Boxes",
					"slotslide-horizontal"=>"Slide Slots Horizontal",
					"slotslide-vertical"=>"Slide Slots Vertical",
					"notselectable3"=>"FADE TRANSITIONS",
					"notransition"=>"No Transition",
					"fade"=>"Fade",
					"boxfade"=>"Fade Boxes",
					"slotfade-horizontal"=>"Fade Slots Horizontal",
					"slotfade-vertical"=>"Fade Slots Vertical",
					"fadefromright"=>"Fade and Slide from Right",
					"fadefromleft"=>"Fade and Slide from Left",
					"fadefromtop"=>"Fade and Slide from Top",
					"fadefrombottom"=>"Fade and Slide from Bottom",
					"fadetoleftfadefromright"=>"Fade To Left and Fade From Right",
					"fadetorightfadefromleft"=>"Fade To Right and Fade From Left",
					"fadetotopfadefrombottom"=>"Fade To Top and Fade From Bottom",
					"fadetobottomfadefromtop"=>"Fade To Bottom and Fade From Top",
					"notselectable4"=>"PARALLAX TRANSITIONS",
					"parallaxtoright"=>"Parallax to Right",
					"parallaxtoleft"=>"Parallax to Left",
					"parallaxtotop"=>"Parallax to Top",
					"parallaxtobottom"=>"Parallax to Bottom",
					"parallaxhorizontal"=>"Parallax Horizontal",
					"parallaxvertical"=>"Parallax Vertical",
					"notselectable5"=>"ZOOM TRANSITIONS",
					"scaledownfromright"=>"Zoom Out and Fade From Right",
					"scaledownfromleft"=>"Zoom Out and Fade From Left",
					"scaledownfromtop"=>"Zoom Out and Fade From Top",
					"scaledownfrombottom"=>"Zoom Out and Fade From Bottom",
					"zoomout"=>"ZoomOut",
					"zoomin"=>"ZoomIn",
					"slotzoom-horizontal"=>"Zoom Slots Horizontal",
					"slotzoom-vertical"=>"Zoom Slots Vertical",
					"notselectable6"=>"CURTAIN TRANSITIONS",
					"curtain-1"=>"Curtain from Left",
					"curtain-2"=>"Curtain from Right",
					"curtain-3"=>"Curtain from Middle",
					"notselectable7"=>"PREMIUM TRANSITIONS",
					"3dcurtain-horizontal"=>"3D Curtain Horizontal",
					"3dcurtain-vertical"=>"3D Curtain Vertical",
					"cube"=>"Cube Vertical",
					"cube-horizontal"=>"Cube Horizontal",
					"incube"=>"In Cube Vertical",
					"incube-horizontal"=>"In Cube Horizontal",
					"turnoff"=>"TurnOff Horizontal",
					"turnoff-vertical"=>"TurnOff Vertical",
					"papercut"=>"Paper Cut",
					"flyin"=>"Fly In"
				);


			return($arrTransition);
		}

		/**
		 *
		 * get random transition
		 */
		public static function getRandomTransition(){
			$arrTrans = self::getArrTransition();
			unset($arrTrans["random"]);
			$trans = array_rand($arrTrans);

			return($trans);
		}

		/**
		 *
		 * get default transition
		 */
		public static function getDefaultTransition(){
			$arrValues = self::getGeneralSettingsValues();
			return 'random';
			//return UniteFunctionsRev::getVal($arrValues, "slide_transition_default", "random");
		}

		/**
		 *
		 * get animations array
		 */
		public static function getArrAnimations($all = true){

			$arrAnimations = array(
				"tp-fade"=>"Fade",
				"sft"=>"Short from Top",
				"sfb"=>"Short from Bottom",
				"sfr"=>"Short from Right",
				"sfl"=>"Short from Left",
				"lft"=>"Long from Top",
				"lfb"=>"Long from Bottom",
				"lfr"=>"Long from Right",
				"lfl"=>"Long from Left",
				"skewfromright"=>"Skew From Long Right",
				"skewfromleft"=>"Skew From Long Left",
				"skewfromrightshort"=>"Skew From Short Right",
				"skewfromleftshort"=>"Skew From Short Left",
				"randomrotate"=>"Random Rotate"
			);

			if($all){
				$custom = RevOperations::getCustomAnimations('customin');

				$arrAnimations = array_merge($arrAnimations, $custom);
			}
			return($arrAnimations);
		}

		/**
		 *
		 * get "end" animations array
		 */
		public static function getArrEndAnimations($all = true){
			$arrAnimations = array(
				"auto"=>"Choose Automatic",
				"fadeout"=>"Fade Out",
				"stt"=>"Short to Top",
				"stb"=>"Short to Bottom",
				"stl"=>"Short to Left",
				"str"=>"Short to Right",
				"ltt"=>"Long to Top",
				"ltb"=>"Long to Bottom",
				"ltl"=>"Long to Left",
				"ltr"=>"Long to Right",
				"skewtoright"=>"Skew To Right",
				"skewtoleft"=>"Skew To Left",
				"skewtorightshort"=>"Skew To Right Short",
				"skewtoleftshort"=>"Skew To Left Short",
				"randomrotateout"=>"Random Rotate Out"
			);

			if($all){
				$custom = RevOperations::getCustomAnimations('customout');

				$arrAnimations = array_merge($arrAnimations, $custom);
			}
			return($arrAnimations);
		}

		/**
		 *
		 * insert custom animations
		 */
		public static function insertCustomAnim($anim){
			if(isset($anim['handle'])) {
				$db = new UniteDBRev();

				$arrInsert = array();
				$arrInsert["handle"] = $anim['handle'];
				unset($anim['handle']);

				$arrInsert["params"] = stripslashes(json_encode(str_replace("'", '"', $anim)));

				$result = $db->insert(GlobalsRevSlider::$table_layer_anims, $arrInsert);
			}

			$arrAnims['customin'] = RevOperations::getCustomAnimations();
			$arrAnims['customout'] = RevOperations::getCustomAnimations('customout');
			$arrAnims['customfull'] = RevOperations::getFullCustomAnimations();

			return $arrAnims;
		}

		/**
		 *
		 * insert custom animations
		 */
		public static function updateCustomAnim($anim){
			if(isset($anim['handle'])) {
				$db = new UniteDBRev();
				$handle = $anim['handle'];
				unset($anim['handle']);

				$arrUpdate = array();
				$arrUpdate['params'] = stripslashes(json_encode(str_replace("'", '"', $anim)));

				$result = $db->update(GlobalsRevSlider::$table_layer_anims, $arrUpdate, array('handle' => $handle));
			}

			$arrAnims['customin'] = RevOperations::getCustomAnimations();
			$arrAnims['customout'] = RevOperations::getCustomAnimations('customout');
			$arrAnims['customfull'] = RevOperations::getFullCustomAnimations();

			return $arrAnims;
		}

		/**
		 *
		 * delete custom animations
		 */
		public static function deleteCustomAnim($rawID){
			if(trim($rawID) != '') {
				$db = new UniteDBRev();
				$id = str_replace(array('customin-', 'customout'), array('', ''), $rawID);
				$db->delete(GlobalsRevSlider::$table_layer_anims, "id = '".mysqli_real_escape_string($id)."'");
			}

			$arrAnims['customin'] = RevOperations::getCustomAnimations();
			$arrAnims['customout'] = RevOperations::getCustomAnimations('customout');
			$arrAnims['customfull'] = RevOperations::getFullCustomAnimations();

			return $arrAnims;
		}

		/**
		 *
		 * get custom animations
		 */
		public static function getCustomAnimations($pre = 'customin'){
			$db = new UniteDBRev();

			$customAnimations = array();

			$result = $db->fetch(GlobalsRevSlider::$table_layer_anims);
			if(!empty($result)){
				foreach($result as $key => $value){
					$customAnimations[$pre.'-'.$value['id']] = $value['handle'];
				}
			}

			return $customAnimations;
		}

		/**
		 *
		 * get full custom animations
		 */
		public static function getFullCustomAnimations(){
			$db = new UniteDBRev();

			$customAnimations = array();

			$result = $db->fetch(GlobalsRevSlider::$table_layer_anims);
			if(!empty($result)){
				foreach($result as $key => $value){
					$customAnimations[$key]['id'] = $value['id'];
					$customAnimations[$key]['handle'] = $value['handle'];
					$customAnimations[$key]['params'] = json_decode(str_replace("'", '"', $value['params']), true);
				}
			}

			return $customAnimations;
		}

		/**
		 *
		 * get animation params by handle
		 */
		public static function getCustomAnimationByHandle($handle){
			$db = new UniteDBRev();

			$result = $db->fetch(GlobalsRevSlider::$table_layer_anims, "handle = '".$handle."'");
			if(!empty($result)) return json_decode(str_replace("'", '"', $result[0]['params']), true);

			return false;
		}

		/**
		 *
		 * get animation params by id
		 */
		public static function getFullCustomAnimationByID($id){
			$db = new UniteDBRev();

			$result = $db->fetch(GlobalsRevSlider::$table_layer_anims, "id = '".$id."'");

			if(!empty($result)){
				$customAnimations = array();
				$customAnimations['id'] = $result[0]['id'];
				$customAnimations['handle'] = $result[0]['handle'];
				$customAnimations['params'] = json_decode(str_replace("'", '"', $result[0]['params']), true);
				return $customAnimations;
			}

			return false;
		}

		/**
		 *
		 * parse animation params
		 */
		public static function parseCustomAnimationByArray($animArray){
			$retString = '';
			if(isset($animArray['movex']) && $animArray['movex'] !== '') $retString.= 'x:'.$animArray['movex'].';';
			if(isset($animArray['movey']) && $animArray['movey'] !== '') $retString.= 'y:'.$animArray['movey'].';';
			if(isset($animArray['movez']) && $animArray['movez'] !== '') $retString.= 'z:'.$animArray['movez'].';';

			if(isset($animArray['rotationx']) && $animArray['rotationx'] !== '') $retString.= 'rotationX:'.$animArray['rotationx'].';';
			if(isset($animArray['rotationy']) && $animArray['rotationy'] !== '') $retString.= 'rotationY:'.$animArray['rotationy'].';';
			if(isset($animArray['rotationz']) && $animArray['rotationz'] !== '') $retString.= 'rotationZ:'.$animArray['rotationz'].';';

			if(isset($animArray['scalex']) && $animArray['scalex'] !== ''){
				$retString.= 'scaleX:';
				$retString.= (intval($animArray['scalex']) == 0) ? 0 : $animArray['scalex'] / 100;
				$retString.= ';';
			}
			if(isset($animArray['scaley']) && $animArray['scaley'] !== ''){
				$retString.= 'scaleY:';
				$retString.= (intval($animArray['scaley']) == 0) ? 0 : $animArray['scaley'] / 100;
				$retString.= ';';
			}

			if(isset($animArray['skewx']) && $animArray['skewx'] !== '') $retString.= 'skewX:'.$animArray['skewx'].';';
			if(isset($animArray['skewy']) && $animArray['skewy'] !== '') $retString.= 'skewY:'.$animArray['skewy'].';';

			if(isset($animArray['captionopacity']) && $animArray['captionopacity'] !== ''){
				$retString.= 'opacity:';
				$retString.= (intval($animArray['captionopacity']) == 0) ? 0 : $animArray['captionopacity'] / 100;
				$retString.= ';';
			}

			if(isset($animArray['captionperspective']) && $animArray['captionperspective'] !== '') $retString.= 'transformPerspective:'.$animArray['captionperspective'].';';

			if(isset($animArray['originx']) && $animArray['originx'] !== '' && isset($animArray['originy']) && $animArray['originy'] !== ''){
				$retString.= "transformOrigin:".$animArray['originx'].'% '.$animArray['originy']."%;";
			}

			return $retString;
		}

		/**
		 *
		 * parse css file and get the classes from there.
		 */
		public function getArrCaptionClasses($contentCSS){
			//parse css captions file
			$parser = new UniteCssParserRev();
			$parser->initContent($contentCSS);
			$arrCaptionClasses = $parser->getArrClasses('','',true);
			
			return($arrCaptionClasses);
		}

		/**
		 *
		 * get all font family types
		 */
		public function getArrFontFamilys($slider){
			//Web Safe Fonts
			$fonts = array(
				//Serif Fonts
				'Georgia, serif',
				'"Palatino Linotype", "Book Antiqua", Palatino, serif',
				'"Times New Roman", Times, serif',

				//Sans-Serif Fonts
				'Arial, Helvetica, sans-serif',
				'"Arial Black", Gadget, sans-serif',
				'"Comic Sans MS", cursive, sans-serif',
				'Impact, Charcoal, sans-serif',
				'"Lucida Sans Unicode", "Lucida Grande", sans-serif',
				'Tahoma, Geneva, sans-serif',
				'"Trebuchet MS", Helvetica, sans-serif',
				'Verdana, Geneva, sans-serif',

				//Monospace Fonts
				'"Courier New", Courier, monospace',
				'"Lucida Console", Monaco, monospace'
			);

			if($slider->getParam("load_googlefont","false") == "true"){
				$font_custom = $slider->getParam("google_font","");
				if(!is_array($font_custom)) $font_custom = array($font_custom); //backwards compability

				if(is_array($font_custom)){
					foreach($font_custom as $key => $curFont){
						$font = $this->cleanFontStyle(stripslashes($curFont));
						if($font != false)
							$font_custom[$key] = $font;
						else
							unset($font_custom[$key]);
					}
					$fonts = array_merge($font_custom, $fonts);
				}
			}

			//add punch fonts here
			$pfonts = new ThemePunch_Fonts();
			$rpfonts = $pfonts->get_all_fonts();
			$punchfonts = array();

			if(!empty($rpfonts)){
				foreach($rpfonts as $rfont){
					$cfont = explode('+', $rfont['url']);
					$cfont = implode(' ', $cfont);
					$cfont = explode(':', $cfont);
					$punchfonts[] = '"'.$cfont[0].'"';
				}
				$fonts = array_merge($punchfonts, $fonts);
			}

			return $fonts;
		}


		/**
		 *
		 * get font name in clean
		 */
		public function cleanFontStyle($font){
			$url = preg_match('/href=["\']?([^"\'>]+)["\']?/', $font, $match);
			if(!isset($match[1])) return false;
			$info = parse_url($match[1]);

			if(isset($info['query'])){
				$font = str_replace(array('family=', '+'), array('', ' '), $info['query']);
				$font = explode(':', $font);
				return (strpos($font['0'], ' ') !== false) ? '"'.$font['0'].'"' : $font['0'];

			}

			return false;
		}

		/**
		 *
		 * get the select classes html for putting in the html by ajax
		 */
		private function getHtmlSelectCaptionClasses($contentCSS){
			$arrCaptions = $this->getArrCaptionClasses($contentCSS);
			$htmlSelect = UniteFunctionsRev::getHTMLSelect($arrCaptions,"","id='layer_caption' name='layer_caption'",true);
			return($htmlSelect);
		}

		/**
		 *
		 * get contents of the css table
		 */
		public function getCaptionsContent(){
			$result = $this->db->fetch(GlobalsRevSlider::$table_css);
			$contentCSS = UniteCssParserRev::parseDbArrayToCss($result);
			return($contentCSS);
		}


		/**
		 *
		 * get contents of the css table
		 */
		public static function getCaptionsContentArray($handle = false){
			$db = new UniteDBRev();
			$result = $db->fetch(GlobalsRevSlider::$table_css);
			$contentCSS = UniteCssParserRev::parseDbArrayToArray($result, $handle);
			return($contentCSS);
		}

		/**
		 *
		 * get contents of the static css file
		 */
		public static function getStaticCss(){
			if ( is_multisite() ){
				if(!get_site_option('revslider-static-css')){
					$contentCSS = @file_get_contents(GlobalsRevSlider::$filepath_static_captions);
					self::updateStaticCss($contentCSS);
				}
				$contentCSS = get_site_option('revslider-static-css', '');
			}else{
				if(!get_option('revslider-static-css')){
					$contentCSS = @file_get_contents(GlobalsRevSlider::$filepath_static_captions);
					self::updateStaticCss($contentCSS);
				}
				$contentCSS = get_option('revslider-static-css', '');
			}

			return($contentCSS);
		}

		/**
		 *
		 * get contents of the static css file
		 */
		public static function updateStaticCss($content){
			$content = str_replace(array("\'", '\"', '\\\\'),array("'", '"', '\\'), trim($content));

			if ( is_multisite() ){
				$c = get_site_option('revslider-static-css', '');
				$c = update_site_option('revslider-static-css', $content);
			}else{
				$c = get_option('revslider-static-css', '');
				$c = update_option('revslider-static-css', $content);
			}

			//UniteFunctionsRev::writeFile($content, GlobalsRevSlider::$filepath_static_captions);
			//$static = self::getStaticCss();

			return $content;
		}

		/**
		 *
		 * get contents of the static css file
		 */
		public function getDynamicCss(){
			$db = new UniteDBRev();

			$styles = $db->fetch(GlobalsRevSlider::$table_css);
			$styles = UniteCssParserRev::parseDbArrayToCss($styles, "\n");
			//$contentCSS = file_get_contents(GlobalsRevSlider::$filepath_dynamic_captions);
			//return($contentCSS);
			return $styles;
		}

		/**
		 *
		 * insert captions css file content
		 * @return new captions html select
		 */
		public function insertCaptionsContentData($content){
			if(isset($content['handle'])) {
				$db = new UniteDBRev();

				$handle = $content['handle'];

				$arrInsert = array();
				$arrInsert["handle"] = '.tp-caption.'.$handle;
				$arrInsert["params"] = stripslashes(json_encode(str_replace("'", '"', $content['params'])));
				$arrInsert["hover"] = stripslashes(json_encode(str_replace("'", '"', @$content['hover'])));
				$arrInsert["settings"] = stripslashes(json_encode(str_replace("'", '"', @$content['settings'])));

				$result = $db->insert(GlobalsRevSlider::$table_css, $arrInsert);
			}

			//$this->updateDynamicCaptions();

			//output captions array
			$operations = new RevOperations();
			$cssContent = $operations->getCaptionsContent();
			$arrCaptions = $operations->getArrCaptionClasses($cssContent);
			return($arrCaptions);
		}

		/**
		 *
		 * update captions css file content
		 * @return new captions html select
		 */
		public function updateCaptionsContentData($content){
			if(isset($content['handle'])) {
				$db = new UniteDBRev();

				$handle = $content['handle'];

				$arrUpdate = array();
				$arrUpdate["params"] = stripslashes(json_encode(str_replace("'", '"', $content['params'])));
				$arrUpdate["hover"] = stripslashes(json_encode(str_replace("'", '"', @$content['hover'])));
				$arrUpdate["settings"] = stripslashes(json_encode(str_replace("'", '"', @$content['settings'])));
				$result = $db->update(GlobalsRevSlider::$table_css, $arrUpdate, array('handle' => '.tp-caption.'.$handle));
			}

			//$this->updateDynamicCaptions();

			//output captions array
			$operations = new RevOperations();
			$cssContent = $operations->getCaptionsContent();
			$arrCaptions = $operations->getArrCaptionClasses($cssContent);
			return($arrCaptions);
		}

		/**
		 *
		 * delete captions css file content
		 * @return new captions html select
		 */
		public function deleteCaptionsContentData($handle){
			$db = new UniteDBRev();

			$db->delete(GlobalsRevSlider::$table_css,"handle='.tp-caption.".$handle."'");

			//$this->updateDynamicCaptions();

			//output captions array
			$operations = new RevOperations();
			$cssContent = $operations->getCaptionsContent();
			$arrCaptions = $operations->getArrCaptionClasses($cssContent);
			return($arrCaptions);
		}

		/**
		 *
		 * update dynamic-captions css file content
		 */
		public static function updateDynamicCaptions($full = false){
			if($full){
				$captions = array();
				$captions = RevOperations::getCaptionsContentArray();

				$styles = UniteCssParserRev::parseArrayToCss($captions, "\n");
				//write styles into dynamic css
				//UniteFunctionsRev::writeFile($styles, GlobalsRevSlider::$filepath_dynamic_captions);
			}else{
				//go through all sliders and check which classes are used, get all classes from DB and write them into the file
				$slider = new RevSlider();
				$arrSliders = $slider->getArrSliders();

				$classes = array();

				//get used classes
				if(!empty($arrSliders)){
					foreach($arrSliders as $slider){
						try{
							$slides = $slider->getSlides();

							if(!empty($slides)){
								foreach($slides as $slide){
									$layers = $slide->getLayers();
									if(!empty($layers)){
										foreach($layers as $layer){
											if(isset($layer['style'])){
												if(!empty($layer['style'])) $classes[$layer['style']] = true;
											}
										}
									}
								}
							}

						}catch(Exception $e){
							$errorMessage = "ERROR: ".$e->getMessage();
						}
					}
				}

				if(!empty($classes)){
					$captions = array();
					foreach($classes as $class => $val){
						$captionCheck = RevOperations::getCaptionsContentArray($class);
						if(!empty($captionCheck)) $captions[] = $captionCheck;
					}

					$styles = UniteCssParserRev::parseArrayToCss($captions, "\n");

					//write styles into dynamic css
					//UniteFunctionsRev::writeFile($styles, GlobalsRevSlider::$filepath_dynamic_captions);
				}
			}
		}


		/**
		 *
		 * get contents of the css file
		 */
		public static function getCaptionsCssContentArray(){
			if(file_exists(GlobalsRevSlider::$filepath_captions))
				$contentCSS = file_get_contents(GlobalsRevSlider::$filepath_captions);
			else if(file_exists(GlobalsRevSlider::$filepath_captions_original))
				$contentCSS = file_get_contents(GlobalsRevSlider::$filepath_captions_original);
			else if(file_exists(GlobalsRevSlider::$filepath_backup.'captions.css'))
				$contentCSS = file_get_contents(GlobalsRevSlider::$filepath_backup.'captions.css');
			else if(file_exists(GlobalsRevSlider::$filepath_backup.'captions-original.css'))
				$contentCSS = file_get_contents(GlobalsRevSlider::$filepath_backup.'captions-original.css');
			else
				UniteFunctionsRev::throwError("No captions.css found! This installation is incorrect, please make sure to reupload the Slider Revolution plugin and try again!");

			$result = UniteCssParserRev::parseCssToArray($contentCSS);

			return($result);
		}

		/**
		 *
		 * import contents of the css file
		 */
		public static function importCaptionsCssContentArray(){
			$db = new UniteDBRev();
			$css = self::getCaptionsCssContentArray();
			$static = array();
			if(is_array($css) && $css !== false && count($css) > 0){
				foreach($css as $class => $styles){
					//check if static style or dynamic style
					$class = trim($class);

					if((strpos($class, ':hover') === false && strpos($class, ':') !== false) || //before, after
					    strpos($class," ") !== false || // .tp-caption.imageclass img or .tp-caption .imageclass or .tp-caption.imageclass .img
					    strpos($class,".tp-caption") === false || // everything that is not tp-caption
						(strpos($class,".") === false || strpos($class,"#") !== false) || // no class -> #ID or img
					    strpos($class,">") !== false){ //.tp-caption>.imageclass or .tp-caption.imageclass>img or .tp-caption.imageclass .img

						$static[$class] = $styles;
						continue;
					}

					//is a dynamic style
					if(strpos($class, ':hover') !== false){
						$class = trim(str_replace(':hover', '', $class));
						$arrInsert = array();
						$arrInsert["hover"] = json_encode($styles);
						$arrInsert["settings"] = json_encode(array('hover' => 'true'));
					}else{
						$arrInsert = array();
						$arrInsert["params"] = json_encode($styles);
					}
					//check if class exists
					$result = $db->fetch(GlobalsRevSlider::$table_css, "handle = '".$class."'");

					if(!empty($result)){ //update
						$db->update(GlobalsRevSlider::$table_css, $arrInsert, array('handle' => $class));
					}else{ //insert
						$arrInsert["handle"] = $class;
						$db->insert(GlobalsRevSlider::$table_css, $arrInsert);
					}
				}
			}

			if(!empty($static)){ //save static into static-captions.css
				$css = UniteCssParserRev::parseStaticArrayToCss($static);
				$static_cur = RevOperations::getStaticCss(); //get the open sans line!
				$css = $static_cur."\n".$css;

				self::updateStaticCss($css);
			}
		}

		/**
		 *
		 * move old captions.css and captions-original.css
		 */
		public static function moveOldCaptionsCss(){
			if(file_exists(GlobalsRevSlider::$filepath_captions_original))
				$success = @rename(GlobalsRevSlider::$filepath_captions_original, GlobalsRevSlider::$filepath_backup.'/captions-original.css');

			if(file_exists(GlobalsRevSlider::$filepath_captions))
				$success = @rename(GlobalsRevSlider::$filepath_captions, GlobalsRevSlider::$filepath_backup.'/captions.css');
		}

		/**
		 *
		 * preview slider output
		 * if output object is null - create object
		 */
		public function previewOutput($sliderID,$output = null){

			if($sliderID == "empty_output"){
				$this->loadingMessageOutput();
				exit();
			}

			if($output == null)
				$output = new RevSliderOutput();

			$slider = new RevSlider();
			$slider->initByID($sliderID);
			$isWpmlExists = UniteWpmlRev::isWpmlExists();
			$useWpml = $slider->getParam("use_wpml","off");
			$wpmlActive = false;
			if($isWpmlExists && $useWpml == "on"){
				$wpmlActive = true;
				$arrLanguages = UniteWpmlRev::getArrLanguages(false);

				//set current lang to output
				$currentLang = UniteFunctionsRev::getPostGetVariable("lang");

				if(empty($currentLang))
					$currentLang = UniteWpmlRev::getCurrentLang();

				if(empty($currentLang))
					$currentLang = $arrLanguages[0];

				$output->setLang($currentLang);

				$selectLangChoose = UniteFunctionsRev::getHTMLSelect($arrLanguages,$currentLang,"id='select_langs'",true);
			}


			$output->setPreviewMode();

			//put the output html
			$urlPlugin = RevSliderAdmin::$url_plugin."rs-plugin/";
			$urlPreviewPattern = UniteBaseClassRev::$url_ajax_actions."&client_action=preview_slider&sliderid=".$sliderID."&lang=[lang]&nonce=[nonce]";
			$nonce = wp_create_nonce("revslider_actions");

			$setBase = (is_ssl()) ? "https://" : "http://";

			$f = new ThemePunch_Fonts();
			$my_fonts = $f->get_all_fonts();
			?>
				<html>
					<head>
						<link rel='stylesheet' href='<?php echo $urlPlugin?>css/settings.css?rev=<?php echo GlobalsRevSlider::SLIDER_REVISION; ?>' type='text/css' media='all' />
						<?php
						$db = new UniteDBRev();

						$styles = $db->fetch(GlobalsRevSlider::$table_css);
						$styles = UniteCssParserRev::parseDbArrayToCss($styles, "\n");
						$styles = UniteCssParserRev::compress_css($styles);

						echo '<style type="text/css">'.$styles.'</style>'; //.$stylesinnerlayers

						$http = (is_ssl()) ? 'https' : 'http';

						if(!empty($my_fonts)){
							foreach($my_fonts as $c_font){
								?>
								<link rel='stylesheet' href="<?php echo $http.'://fonts.googleapis.com/css?family='.strip_tags($c_font['url']); ?>" type='text/css' />
								<?php
							}
						}

						$custom_css = RevOperations::getStaticCss();
						echo '<style type="text/css">'.UniteCssParserRev::compress_css($custom_css).'</style>';
						?>

						<script type='text/javascript' src='<?php echo $setBase; ?>ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>

						<script type='text/javascript' src='<?php echo $urlPlugin?>js/jquery.themepunch.tools.min.js?rev=<?php echo GlobalsRevSlider::SLIDER_REVISION; ?>'></script>
						<script type='text/javascript' src='<?php echo $urlPlugin?>js/jquery.themepunch.revolution.min.js?rev=<?php echo GlobalsRevSlider::SLIDER_REVISION; ?>'></script>
					</head>
					<body style="padding:0px;margin:0px;">
						<?php if($wpmlActive == true):?>
							<div style="margin-bottom:10px;text-align:center;">
							<?php _e("Choose language",REVSLIDER_TEXTDOMAIN)?>: <?php echo $selectLangChoose?>
							</div>

							<script type="text/javascript">
								var g_previewPattern = '<?php echo $urlPreviewPattern?>';
								jQuery("#select_langs").change(function(){
									var lang = this.value;
									var nonce = "<?php echo $nonce; ?>";
									var pattern = g_previewPattern;
									var urlPreview = pattern.replace("[lang]",lang).replace("[nonce]",nonce);
									location.href = urlPreview;
								});
							</script>
						<?php endif?>

						<?php
							$output->putSliderBase($sliderID);
						?>
					</body>
				</html>
			<?php
			exit();
		}

		/*
		 * show only the markup for jQuery version of plugin
		 */
		public function previewOutputMarkup($sliderID,$output = null){

			if($sliderID == "empty_output"){
				$this->loadingMessageOutput();
				exit();
			}

			if($output == null)
				$output = new RevSliderOutput();

			$slider = new RevSlider();
			$slider->initByID($sliderID);
			$isWpmlExists = UniteWpmlRev::isWpmlExists();
			$useWpml = $slider->getParam("use_wpml","off");
			$wpmlActive = false;
			if($isWpmlExists && $useWpml == "on"){
				$wpmlActive = true;
				$arrLanguages = UniteWpmlRev::getArrLanguages(false);

				//set current lang to output
				$currentLang = UniteFunctionsRev::getPostGetVariable("lang");

				if(empty($currentLang))
					$currentLang = UniteWpmlRev::getCurrentLang();

				if(empty($currentLang))
					$currentLang = $arrLanguages[0];

				$output->setLang($currentLang);

				$selectLangChoose = UniteFunctionsRev::getHTMLSelect($arrLanguages,$currentLang,"id='select_langs'",true);
			}


			$output->setPreviewMode();

			//put the output html
			$urlPlugin = "http://yourpluginpath/";
			$urlPreviewPattern = UniteBaseClassRev::$url_ajax_actions."&client_action=preview_slider&only_markup=true&sliderid=".$sliderID."&lang=[lang]&nonce=[nonce]";
			$nonce = wp_create_nonce("revslider_actions");

			$setBase = (is_ssl()) ? "https://" : "http://";

			$f = new ThemePunch_Fonts();
			$my_fonts = $f->get_all_fonts();


			?>
			<html>
			<head>
				<script type='text/javascript' src='<?php echo $setBase; ?>ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
			</head>
			<body style="padding:0px;margin:0px;">
				<?php if($wpmlActive == true):?>
					<div style="margin-bottom:10px;text-align:center;">
					<?php _e("Choose language",REVSLIDER_TEXTDOMAIN)?>: <?php echo $selectLangChoose?>
					</div>

					<script type="text/javascript">
						var g_previewPattern = '<?php echo $urlPreviewPattern?>';
						jQuery("#select_langs").change(function(){
							var lang = this.value;
							var nonce = "<?php echo $nonce; ?>";
							var pattern = g_previewPattern;
							var urlPreview = pattern.replace("[lang]",lang).replace("[nonce]",nonce);
							location.href = urlPreview;
						});

						jQuery('body').on('click', '#rev_replace_images', function(){
							var from = jQuery('input[name="orig_image_path"]').val();
							var to = jQuery('input[name="replace_image_path"]').val();

							jQuery('#rev_script_content').val(jQuery('#rev_script_content').val().replace(from, to));
							jQuery('#rev_the_content').val(jQuery('#rev_the_content').val().replace(from, to));
							jQuery('#rev_style_content').val(jQuery('#rev_style_content').val().replace(from, to));
							jQuery('#rev_head_content').val(jQuery('#rev_head_content').val().replace(from, to));
						});

					</script>
				<?php endif?>
			<?php
			//UniteBaseClassRev::$url_plugin

			ob_start();
			?><link rel='stylesheet' href='<?php echo $urlPlugin?>css/settings.css?rev=<?php echo GlobalsRevSlider::SLIDER_REVISION; ?>' type='text/css' media='all' />
<?php
		$http = (is_ssl()) ? 'https' : 'http';

		if(!empty($my_fonts)){
			foreach($my_fonts as $c_font){
				?><link rel='stylesheet' href="<?php echo $http.'://fonts.googleapis.com/css?family='.strip_tags($c_font['url']); ?>" type='text/css' /><?php
				echo "\n";
			}
		}
		?>
<script type='text/javascript' src='<?php echo $urlPlugin?>js/jquery.themepunch.tools.min.js?rev=<?php echo GlobalsRevSlider::SLIDER_REVISION; ?>'></script>
<script type='text/javascript' src='<?php echo $urlPlugin?>js/jquery.themepunch.revolution.min.js?rev=<?php echo GlobalsRevSlider::SLIDER_REVISION; ?>'></script>
<?php
			$head_content = ob_get_contents();
			ob_clean();
			ob_end_clean();

			ob_start();

			$custom_css = RevOperations::getStaticCss();
			echo $custom_css."\n\n";

			echo '/*****************'."\n";
			echo ' ** '.__('CAPTIONS CSS', REVSLIDER_TEXTDOMAIN)."\n";
			echo ' ****************/'."\n\n";
			$db = new UniteDBRev();
			$styles = $db->fetch(GlobalsRevSlider::$table_css);
			echo UniteCssParserRev::parseDbArrayToCss($styles, "\n");

			$style_content = ob_get_contents();
			ob_clean();
			ob_end_clean();

			ob_start();

			$output->putSliderBase($sliderID);

			$content = ob_get_contents();
			ob_clean();
			ob_end_clean();

			$script_content = substr($content, strpos($content, '<script type="text/javascript">'), strpos($content, '</script>') + 9 - strpos($content, '<script type="text/javascript">'));
			$content = htmlentities(str_replace($script_content, '', $content));
			$script_content = str_replace('				', '', $script_content);
			$script_content = str_replace(array('<script type="text/javascript">', '</script>'), '', $script_content);

			?>
			<style>
				body 	 { font-family:sans-serif; font-size:12px;}
				textarea { background:#f1f1f1; border:#ddd; font-size:10px; line-height:16px; margin-bottom:40px; padding:10px;}
				.rev_cont_title { color:#000; text-decoration:none;font-size:14px; line-height:24px; font-weight:800;background: #D5D5D5;padding: 10px;}
				.rev_cont_title a,
				.rev_cont_title a:visited { margin-left:25px;font-size:12px;line-height:12px;float:right;background-color:#8e44ad; color:#fff; padding:8px 10px;text-decoration:none;}
				.rev_cont_title a:hover	  { background-color:#9b59b6}
			</style>
			<p><?php $dir = wp_upload_dir(); ?>
				<?php _e('Replace image path:', REVSLIDER_TEXTDOMAIN); ?> <?php _e('From:', REVSLIDER_TEXTDOMAIN); ?> <input type="text" name="orig_image_path" value="<?php echo @$dir['baseurl']; ?>" /> <?php _e('To:', REVSLIDER_TEXTDOMAIN); ?> <input type="text" name="replace_image_path" value="" /> <input id="rev_replace_images" type="button" name="replace_images" value="<?php _e('Replace', REVSLIDER_TEXTDOMAIN); ?>" />
			</p>

			<div class="rev_cont_title"><?php _e('Header', REVSLIDER_TEXTDOMAIN); ?> <a class="button-primary revpurple export_slider_standalone copytoclip" data-idt="rev_head_content"  href="javascript:void(0);" original-title=""><?php _e('Mark to Copy', REVSLIDER_TEXTDOMAIN); ?></a><div style="clear:both"></div></div>
			<textarea id="rev_head_content" readonly="true" style="width: 100%; height: 100px; color:#3498db"><?php echo $head_content; ?></textarea>
			<div class="rev_cont_title"><?php _e('CSS', REVSLIDER_TEXTDOMAIN); ?><a class="button-primary revpurple export_slider_standalone copytoclip" data-idt="rev_style_content"  href="javascript:void(0);" original-title=""><?php _e('Mark to Copy', REVSLIDER_TEXTDOMAIN); ?></a></div>
			<textarea id="rev_style_content" readonly="true" style="width: 100%; height: 100px;"><?php echo $style_content; ?></textarea>
			<div class="rev_cont_title"><?php _e('Body', REVSLIDER_TEXTDOMAIN); ?><a class="button-primary revpurple export_slider_standalone copytoclip" data-idt="rev_the_content"  href="javascript:void(0);" original-title=""><?php _e('Mark to Copy', REVSLIDER_TEXTDOMAIN); ?></a></div>
			<textarea id="rev_the_content" readonly="true" style="width: 100%; height: 100px;"><?php echo $content; ?></textarea>
			<div class="rev_cont_title"><?php _e('Script', REVSLIDER_TEXTDOMAIN); ?><a class="button-primary revpurple export_slider_standalone copytoclip" data-idt="rev_script_content"  href="javascript:void(0);" original-title=""><?php _e('Mark to Copy', REVSLIDER_TEXTDOMAIN); ?></a></div>
			<textarea id="rev_script_content" readonly="true" style="width: 100%; height: 100px;"><?php echo $script_content; ?></textarea>

			<script>
				jQuery('body').on('click','.copytoclip',function() {
					jQuery("#"+jQuery(this).data('idt')).select();
				});
			</script>
			</body>
			</html>
			<?php
			exit();
		}

		/**
		 *
		 * output loading message
		 */
		public function loadingMessageOutput(){
			?>
			<div class="message_loading_preview"><?php _e("Loading Preview...",REVSLIDER_TEXTDOMAIN)?></div>
			<?php
		}

		/**
		 *
		 * put slide preview by data
		 */
		public function putSlidePreviewByData($data){

			if($data == "empty_output"){
				$this->loadingMessageOutput();
				exit();
			}

			$data = UniteFunctionsRev::jsonDecodeFromClientSide($data);

			$slideID = $data["slideid"];
			$slide = new RevSlide();
			$slide->initByID($slideID);
			$sliderID = $slide->getSliderID();

			$output = new RevSliderOutput();
			$output->setOneSlideMode($data);

			$this->previewOutput($sliderID,$output);
		}


		/**
		 * update general settings
		 */
		public function updateGeneralSettings($data){

			$strSettings = serialize($data);
			$params = new RevSliderParams();
			$params->updateFieldInDB("general", $strSettings);
		}


		/**
		 *
		 * get general settigns values.
		 */
		static function getGeneralSettingsValues(){

			$params = new RevSliderParams();
			$strSettings = $params->getFieldFromDB("general");

			$arrValues = array();
			if(!empty($strSettings))
				$arrValues = unserialize($strSettings);

			return($arrValues);
		}

		/**
		* update language filter in session
		 */
		public function updateLangFilter($data){
			$lang = UniteFunctionsRev::getVal($data, "lang");
			$sliderID = UniteFunctionsRev::getVal($data, "sliderid");

			if(!isset($_SESSION))
				return(false);
			$_SESSION["revslider_lang_filter"] = $lang;
			return($sliderID);
		}

		/**
		 *
		 * get lang filter value from session
		 */
		public function getLangFilterValue(){

			if(!isset($_SESSION))
				return("all");

			$langFitler = UniteFunctionsRev::getVal($_SESSION, "revslider_lang_filter","all");

			return($langFitler);
		}


		/**
		 *
		 * modify custom slider params. This is instead custom settings difficulties.
		 */
		public function modifyCustomSliderParams($data){

			$settigns = new UniteSettingsRev();

			$arrNames = array("width","height",
							  "responsitive_w1","responsitive_sw1",
							  "responsitive_w2","responsitive_sw2",
							  "responsitive_w3","responsitive_sw3",
							  "responsitive_w4","responsitive_sw4",
							  "responsitive_w5","responsitive_sw5",
							  "responsitive_w6","responsitive_sw6");

			$arrMain = $data["main"];
			foreach($arrNames as $name){
				if(array_key_exists($name, $arrMain)){
					$arrMain[$name] = $settigns->modifyValueByDatatype($arrMain[$name], UniteSettingsRev::DATATYPE_NUMBER);
				}
			}

			$arrMain["fullscreen_offset_container"] = $settigns->modifyValueByDatatype($arrMain["fullscreen_offset_container"], UniteSettingsRev::DATATYPE_STRING);

			//$arrMain["auto_height"] = $settigns->modifyValueByDatatype($arrMain["auto_height"], UniteSettingsRev::DATATYPE_STRING);
			$data["main"] = $arrMain;

			return($data);
		}


		/**
		 *
		 * get post types with categories for client side.
		 */
		public static function getPostTypesWithCatsForClient(){
			$arrPostTypes = UniteFunctionsWPRev::getPostTypesWithCats();

			$globalCounter = 0;

			$arrOutput = array();
			foreach($arrPostTypes as $postType => $arrTaxWithCats){

				$arrCats = array();
				foreach($arrTaxWithCats as $tax){
					$taxName = $tax["name"];
					$taxTitle = $tax["title"];
					$globalCounter++;
					$arrCats["option_disabled_".$globalCounter] = "---- ".$taxTitle." ----";
					foreach($tax["cats"] as $catID=>$catTitle){
						$arrCats[$taxName."_".$catID] = $catTitle;
					}
				}//loop tax

				$arrOutput[$postType] = $arrCats;

			}//loop types

			return($arrOutput);
		}


		/**
		 *
		 * get html font import
		 */
		public static function getCleanFontImport($font){
			$setBase = (is_ssl()) ? "https://" : "http://";

			if(strpos($font, "href=") === false){ //fallback for old versions
				return '<link href="'.$setBase.'fonts.googleapis.com/css?family='.$font.'" rel="stylesheet" type="text/css" media="all" />'; //id="rev-google-font"
			}else{
				$font = str_replace(array('http://', 'https://'), array($setBase, $setBase), $font);
				return stripslashes($font);
			}
		}


		public function checkPurchaseVerification($data){
			global $wp_version;

			$response = wp_remote_post('http://updates.themepunch.com/activate.php', array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'body' => array(
					'name' => urlencode($data['username']),
					'api' => urlencode($data['api_key']),
					'code' => urlencode($data['code']),
					'product' => urlencode('revslider')
				)
			));

			$response_code = wp_remote_retrieve_response_code( $response );
			$version_info = wp_remote_retrieve_body( $response );

			if ( $response_code != 200 || is_wp_error( $version_info ) ) {
				return false;
			}

			if($version_info == 'valid'){
				update_option('revslider-valid', 'true');
				update_option('revslider-api-key', $data['api_key']);
				update_option('revslider-username', $data['username']);
				update_option('revslider-code', $data['code']);

				return true;
			}elseif($version_info == 'exist'){
				UniteFunctionsRev::throwError(__('Purchase Code already registered!', REVSLIDER_TEXTDOMAIN));
			}else{
				return false;
			}

		}

		public function doPurchaseDeactivation($data){
			global $wp_version;

			$key = get_option('revslider-api-key', '');
			$name = get_option('revslider-username', '');
			$code = get_option('revslider-code', '');

			$response = wp_remote_post('http://updates.themepunch.com/deactivate.php', array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'body' => array(
					'name' => urlencode($name),
					'api' => urlencode($key),
					'code' => urlencode($code),
					'product' => urlencode('revslider')
				)
			));

			$response_code = wp_remote_retrieve_response_code( $response );
			$version_info = wp_remote_retrieve_body( $response );

			if ( $response_code != 200 || is_wp_error( $version_info ) ) {
				return false;
			}

			if($version_info == 'valid'){
				//update_option('revslider-api-key', '');
				//update_option('revslider-username', '');
				//update_option('revslider-code', '');
				update_option('revslider-valid', 'false');

				return true;
			}else{
				return false;
			}

		}


	}

?>