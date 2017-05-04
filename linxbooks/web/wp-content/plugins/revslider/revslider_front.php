<?php

	class RevSliderFront extends UniteBaseFrontClassRev{
		
		/**
		 * 
		 * the constructor
		 */
		public function __construct($mainFilepath){
			
			parent::__construct($mainFilepath,$this);
			
			//set table names
			GlobalsRevSlider::$table_sliders = self::$table_prefix.GlobalsRevSlider::TABLE_SLIDERS_NAME;
			GlobalsRevSlider::$table_slides = self::$table_prefix.GlobalsRevSlider::TABLE_SLIDES_NAME;
			GlobalsRevSlider::$table_static_slides = self::$table_prefix.GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME;
			GlobalsRevSlider::$table_settings = self::$table_prefix.GlobalsRevSlider::TABLE_SETTINGS_NAME;
			GlobalsRevSlider::$table_css = self::$table_prefix.GlobalsRevSlider::TABLE_CSS_NAME;
			GlobalsRevSlider::$table_layer_anims = self::$table_prefix.GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME;
			
			UniteBaseClassRev::addAction('wp_enqueue_scripts', 'enqueue_styles');
			
		}
		
		
		/**
		 * 
		 * a must function. you can not use it, but the function must stay there!
		 */		
		public static function onAddScripts(){
			global $wp_version;
			
			$style_pre = '';
			$style_post = '';
			if($wp_version < 3.7){
				$style_pre = '<style type="text/css">';
				$style_post = '</style>';
			}
			
			$operations = new RevOperations();
			$arrValues = $operations->getGeneralSettingsValues();
			
			$includesGlobally = UniteFunctionsRev::getVal($arrValues, "includes_globally","on");
			$includesFooter = UniteFunctionsRev::getVal($arrValues, "js_to_footer","off");
			$strPutIn = UniteFunctionsRev::getVal($arrValues, "pages_for_includes");
			$isPutIn = RevSliderOutput::isPutIn($strPutIn,true);
			
			//put the includes only on pages with active widget or shortcode
			// if the put in match, then include them always (ignore this if)			
			if($isPutIn == false && $includesGlobally == "off"){
				$isWidgetActive = is_active_widget( false, false, "rev-slider-widget", true );
				$hasShortcode = UniteFunctionsWPRev::hasShortcode("rev_slider");
				
				if($isWidgetActive == false && $hasShortcode == false)
					return(false);
			}
			
			self::addStyle("settings","rs-plugin-settings","rs-plugin/css");
			
			$custom_css = RevOperations::getStaticCss();
			$custom_css = UniteCssParserRev::compress_css($custom_css);
			wp_add_inline_style( 'rs-plugin-settings', $style_pre.$custom_css.$style_post );
			
			$setBase = (is_ssl()) ? "https://" : "http://";
			
			$url_jquery = $setBase."ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js?app=revolution";
			self::addScriptAbsoluteUrl($url_jquery, "jquery");
			
			
			if($includesFooter == "off"){
				
				$waitfor = array('jquery');
				
				$enable_logs = UniteFunctionsRev::getVal($arrValues, "enable_logs",'off');
				
				if($enable_logs == 'on'){
					self::addScriptWaitFor("jquery.themepunch.enablelog","rs-plugin/js",'enable-logs');
					$waitfor[] = 'enable-logs';
				}
				
				self::addScriptWaitFor("jquery.themepunch.tools.min","rs-plugin/js",'tp-tools', $waitfor);
				self::addScriptWaitFor("jquery.themepunch.revolution.min","rs-plugin/js",'revmin','tp-tools');
				
			}else{
				//put javascript to footer
				UniteBaseClassRev::addAction('wp_footer', 'putJavascript');
			}
			
		}
		
		public function enqueue_styles(){
			
			$font = new ThemePunch_Fonts();
			$font->register_fonts();
			
		}
		
		/**
		 * 
		 * javascript output to footer
		 */
		public function putJavascript(){
			$urlPlugin = UniteBaseClassRev::$url_plugin."rs-plugin/";
			
			$operations = new RevOperations();
			$arrValues = $operations->getGeneralSettingsValues();
			
			?>
			<script type='text/javascript' src='<?php echo $urlPlugin?>js/jquery.themepunch.tools.min.js?rev=<?php echo GlobalsRevSlider::SLIDER_REVISION; ?>'></script>
			<script type='text/javascript' src='<?php echo $urlPlugin?>js/jquery.themepunch.revolution.min.js?rev=<?php echo  GlobalsRevSlider::SLIDER_REVISION; ?>'></script>
			<?php
		}
		
	}
	
?>