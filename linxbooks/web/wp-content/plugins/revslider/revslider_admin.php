<?php

	class RevSliderAdmin extends UniteBaseAdminClassRev{

		const DEFAULT_VIEW = "sliders";

		const VIEW_SLIDER = "slider";
		const VIEW_SLIDER_TEMPLATE = "slider_template";
		const VIEW_SLIDERS = "sliders";

		const VIEW_SLIDES = "slides";
		const VIEW_SLIDE = "slide";


		/**
		 *
		 * the constructor
		 */
		public function __construct($mainFilepath){

			parent::__construct($mainFilepath,$this,self::DEFAULT_VIEW);

			//set table names
			GlobalsRevSlider::$table_sliders = self::$table_prefix.GlobalsRevSlider::TABLE_SLIDERS_NAME;
			GlobalsRevSlider::$table_slides = self::$table_prefix.GlobalsRevSlider::TABLE_SLIDES_NAME;
			GlobalsRevSlider::$table_static_slides = self::$table_prefix.GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME;
			GlobalsRevSlider::$table_settings = self::$table_prefix.GlobalsRevSlider::TABLE_SETTINGS_NAME;
			GlobalsRevSlider::$table_css = self::$table_prefix.GlobalsRevSlider::TABLE_CSS_NAME;
			GlobalsRevSlider::$table_layer_anims = self::$table_prefix.GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME;

			GlobalsRevSlider::$filepath_backup = self::$path_plugin."backup/";
			GlobalsRevSlider::$filepath_captions = self::$path_plugin."rs-plugin/css/captions.css";
			GlobalsRevSlider::$urlCaptionsCSS = self::$url_plugin."rs-plugin/css/captions.php";
			GlobalsRevSlider::$urlStaticCaptionsCSS = self::$url_plugin."rs-plugin/css/static-captions.css";
			GlobalsRevSlider::$filepath_dynamic_captions = self::$path_plugin."rs-plugin/css/dynamic-captions.css";
			GlobalsRevSlider::$filepath_static_captions = self::$path_plugin."rs-plugin/css/static-captions.css";
			GlobalsRevSlider::$filepath_captions_original = self::$path_plugin."rs-plugin/css/captions-original.css";
			GlobalsRevSlider::$urlExportZip = self::$path_plugin."export.zip";

			$this->init();
		}


		/**
		 *
		 * init all actions
		 */
		private function init(){
			global $revSliderAsTheme;

			//$this->checkCopyCaptionsCSS();

			//self::setDebugMode();

			self::createDBTables();

			//include general settings
			self::requireSettings("general_settings");

			//set role
			$generalSettings = self::getSettings("general");
			$role = $generalSettings->getSettingValue("role",UniteBaseAdminClassRev::ROLE_ADMIN);

			self::setMenuRole($role);

			self::addMenuPage('Revolution Slider', "adminPages");

			$this->addSliderMetaBox();

			//ajax response to save slider options.
			self::addActionAjax("ajax_action", "onAjaxAction");

			//add common scripts there
			//self::addAction(self::ACTION_ADMIN_INIT, "onAdminInit");
			$validated = get_option('revslider-valid', 'false');
			$notice = get_option('revslider-valid-notice', 'true');

			if(!$revSliderAsTheme){
				if($validated === 'false' && $notice === 'true'){
					self::addAction('admin_notices', 'addActivateNotification');
				}

				$upgrade = new UniteUpdateClassRev( GlobalsRevSlider::SLIDER_REVISION );

				if(isset($_GET['checkforupdates']) && $_GET['checkforupdates'] == 'true')
					$upgrade->_retrieve_version_info(true);
				
				if(get_option('revslider-valid', 'false') === 'true') {
					$upgrade->add_update_checks();
				}
			}

			self::addAction('admin_enqueue_scripts', 'enqueue_styles');
			
			
			add_action('wp_ajax_revslider_ajax_call_front', array('RevSliderAdmin', 'onFrontAjaxAction'));
			add_action('wp_ajax_nopriv_revslider_ajax_call_front', array('RevSliderAdmin', 'onFrontAjaxAction')); //for not logged in users
			
		}

		public static function enqueue_styles(){
			$font = new ThemePunch_Fonts();
			$font->register_fonts();
		}


		/**
		 * Include wanted submenu page
		 */
		public function display_plugin_submenu_page_google_fonts() {
			self::display_plugin_submenu('themepunch-google-fonts');
		}

		public static function display_plugin_submenu($subMenu){

			parent::adminPages();

			self::setMasterView("master_view");
			self::requireView($subMenu);
		}


		public function addActivateNotification(){
			$nonce = wp_create_nonce("revslider_actions");
			?>
			<div class="updated below-h2 rs-update-notice-wrap" id="message"><a href="javascript:void(0);" style="float: right;padding-top: 9px;" id="rs-dismiss-notice"><?php _e('(never show this message again)&nbsp;&nbsp;<b>X</b>',REVSLIDER_TEXTDOMAIN); ?></a><p><?php _e('Hi! Would you like to activate your version of Revolution Slider to receive automatic updates & get premium support? This is optional and not needed if the slider came bundled with a theme. ',REVSLIDER_TEXTDOMAIN); ?></p></div>
			<script type="text/javascript">
				jQuery('#rs-dismiss-notice').click(function(){
					var objData = {
									action:"<?php echo self::$dir_plugin; ?>_ajax_action",
									client_action: 'dismiss_notice',
									nonce:'<?php echo $nonce; ?>',
									data:''
									};

					jQuery.ajax({
						type:"post",
						url:ajaxurl,
						dataType: 'json',
						data:objData
					});

					jQuery('.rs-update-notice-wrap').hide();
				});
			</script>
			<?php
		}

		/**
		 *
		 * add wildcards metabox variables to posts
		 */
		private function addSliderMetaBox($postTypes = null){ //null = all, post = only posts
			try{
				$settings = RevOperations::getWildcardsSettings();

				self::addMetaBox("Revolution Slider Options",$settings,array("RevSliderAdmin","customPostFieldsOutput"),$postTypes);
			}catch(Exception $e){

			}
		}


		/**
		 *  custom output function
		 */
		public static function customPostFieldsOutput(UniteSettingsProductSidebarRev $output){

			//$settings = $output->getArrSettingNames();

			?>
				<ul class="revslider_settings">
				<?php
					$output->drawSettingsByNames("slide_template");
				?>
				</ul>
			<?php
		}



		/**
		 * a must function. please don't remove it.
		 * process activate event - install the db (with delta).
		 */
		public static function onActivate(){
			self::createDBTables();
		}

		/**
		 *
		 * create db tables
		 */
		public static function createDBTables(){
			self::createTable(GlobalsRevSlider::TABLE_SLIDERS_NAME);
			self::createTable(GlobalsRevSlider::TABLE_SLIDES_NAME);
			self::createTable(GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME);
			self::createTable(GlobalsRevSlider::TABLE_SETTINGS_NAME);
			self::createTable(GlobalsRevSlider::TABLE_CSS_NAME);
			self::createTable(GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME);
		}


		/**
		 * if caption file don't exists - copy it from the original file.
		 */
		public static function checkCopyCaptionsCSS(){
			if(file_exists(GlobalsRevSlider::$filepath_captions) == false)
				copy(GlobalsRevSlider::$filepath_captions_original,GlobalsRevSlider::$filepath_captions);

			if(!file_exists(GlobalsRevSlider::$filepath_captions) == true){
				self::setStartupError("Can't copy <b>captions-original.css </b> to <b>captions.css</b> in <b> plugins/revslider/rs-plugin/css </b> folder. Please try to copy the file by hand or turn to support.");
			}

		}


		/**
		 *
		 * a must function. adds scripts on the page
		 * add all page scripts and styles here.
		 * pelase don't remove this function
		 * common scripts even if the plugin not load, use this function only if no choise.
		 */
		public static function onAddScripts(){
			global $wp_version;
			
			$style_pre = '';
			$style_post = '';
			if($wp_version < 3.7){
				$style_pre = '<style type="text/css">';
				$style_post = '</style>';
			}
			
			self::addStyle("edit_layers","edit_layers");

			//add google font
			//$urlGoogleFont = "http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700";
			//self::addStyleAbsoluteUrl($urlGoogleFont,"google-font-pt-sans-narrow");
			self::addScriptCommon("edit_layers","unite_layers");
			self::addScriptCommon("css_editor","unite_css_editor");
			self::addScript("rev_admin");

			self::addScript("jquery.themepunch.tools.min","rs-plugin/js",'tp-tools');

			//include all media upload scripts
			self::addMediaUploadIncludes();

			//add rs css:
			self::addStyle("settings","rs-plugin-settings","rs-plugin/css");

			$db = new UniteDBRev();

			$styles = $db->fetch(GlobalsRevSlider::$table_css);
			$styles = UniteCssParserRev::parseDbArrayToCss($styles, "\n");
			$styles = UniteCssParserRev::compress_css($styles);
			wp_add_inline_style( 'rs-plugin-settings', $style_pre.$styles.$style_post );

			$custom_css = RevOperations::getStaticCss();
			$custom_css = UniteCssParserRev::compress_css($custom_css);
			wp_add_inline_style( 'rs-plugin-settings', $style_pre.$custom_css.$style_post );
			//self::addStyle("static-captions","rs-plugin-static","rs-plugin/css");
		}


		/**
		 *
		 * admin main page function.
		 */
		public static function adminPages(){

			parent::adminPages();

			//require styles by view
			switch(self::$view){
				case self::VIEW_SLIDERS:
				case self::VIEW_SLIDER:
				case self::VIEW_SLIDER_TEMPLATE:
					self::requireSettings("slider_settings");
				break;
				case self::VIEW_SLIDES:
				break;
				case self::VIEW_SLIDE:
				break;
			}

			self::setMasterView("master_view");
			self::requireView(self::$view);
		}



		/**
		 *
		 * craete tables
		 */
		public static function createTable($tableName){
			global $wpdb;

			$parseCssToDb = false;

			$checkForTablesOneTime = get_option('revslider_checktables', '0');

			if($checkForTablesOneTime == '0'){
				update_option('revslider_checktables', '1');
				if(UniteFunctionsWPRev::isDBTableExists(self::$table_prefix.GlobalsRevSlider::TABLE_CSS_NAME)){
					//check if database is empty
					$result = $wpdb->get_row("SELECT COUNT( DISTINCT id ) AS NumberOfEntrys FROM ".self::$table_prefix.GlobalsRevSlider::TABLE_CSS_NAME);
					if($result->NumberOfEntrys == 0) $parseCssToDb = true;
				}
			}

			if($parseCssToDb){
				$revOperations = new RevOperations();
				$revOperations->importCaptionsCssContentArray();
				$revOperations->moveOldCaptionsCss();

				//$revOperations->updateDynamicCaptions(true);
			}

			//if table exists - don't create it.
			$tableRealName = self::$table_prefix.$tableName;
			if(UniteFunctionsWPRev::isDBTableExists($tableRealName))
				return(false);

			$charset_collate = '';

			if(method_exists($wpdb, "get_charset_collate"))
				$charset_collate = $wpdb->get_charset_collate();
			else{
				if ( ! empty($wpdb->charset) )
					$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
				if ( ! empty($wpdb->collate) )
					$charset_collate .= " COLLATE $wpdb->collate";
			}

			switch($tableName){
				case GlobalsRevSlider::TABLE_SLIDERS_NAME:
				$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
							  id int(9) NOT NULL AUTO_INCREMENT,
							  title tinytext NOT NULL,
							  alias tinytext,
							  params text NOT NULL,
							  PRIMARY KEY  (id)
							)$charset_collate;";
				break;
				case GlobalsRevSlider::TABLE_SLIDES_NAME:
					$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
								  id int(9) NOT NULL AUTO_INCREMENT,
								  slider_id int(9) NOT NULL,
								  slide_order int not NULL,
								  params text NOT NULL,
								  layers text NOT NULL,
								  PRIMARY KEY  (id)
								)$charset_collate;";
				break;
				case GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME:
					$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
								  id int(9) NOT NULL AUTO_INCREMENT,
								  slider_id int(9) NOT NULL,
								  params text NOT NULL,
								  layers text NOT NULL,
								  PRIMARY KEY  (id)
								)$charset_collate;";
				break;
				case GlobalsRevSlider::TABLE_SETTINGS_NAME:
					$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
								  id int(9) NOT NULL AUTO_INCREMENT,
								  general TEXT NOT NULL,
								  params TEXT NOT NULL,
								  PRIMARY KEY  (id)
								)$charset_collate;";
				break;
				case GlobalsRevSlider::TABLE_CSS_NAME:
					$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
								  id int(9) NOT NULL AUTO_INCREMENT,
								  handle TEXT NOT NULL,
								  settings TEXT,
								  hover TEXT,
								  params TEXT NOT NULL,
								  PRIMARY KEY  (id)
								)$charset_collate;";
					$parseCssToDb = true;
				break;
				case GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME:
					$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
								  id int(9) NOT NULL AUTO_INCREMENT,
								  handle TEXT NOT NULL,
								  params TEXT NOT NULL,
								  PRIMARY KEY  (id)
								)$charset_collate;";
				break;

				default:
					UniteFunctionsRev::throwError("table: $tableName not found");
				break;
			}

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);


			if($parseCssToDb){
				$revOperations = new RevOperations();
				$revOperations->importCaptionsCssContentArray();
				$revOperations->moveOldCaptionsCss();

				//$revOperations->updateDynamicCaptions(true);
			}

		}

		/**
		 *
		 * import slideer handle (not ajax response)
		 */
		private static function importSliderHandle($viewBack = null, $updateAnim = true, $updateStatic = true){

			dmp(__("importing slider setings and data...",REVSLIDER_TEXTDOMAIN));

			$slider = new RevSlider();
			$response = $slider->importSliderFromPost($updateAnim, $updateStatic);
			$sliderID = $response["sliderID"];

			if(empty($viewBack)){
				$viewBack = self::getViewUrl(self::VIEW_SLIDER,"id=".$sliderID);
				if(empty($sliderID))
					$viewBack = self::getViewUrl(self::VIEW_SLIDERS);
			}

			//handle error
			if($response["success"] == false){
				$message = $response["error"];
				dmp("<b>Error: ".$message."</b>");
				echo UniteFunctionsRev::getHtmlLink($viewBack, __("Go Back",REVSLIDER_TEXTDOMAIN));
			}
			else{	//handle success, js redirect.
				dmp(__("Slider Import Success, redirecting...",REVSLIDER_TEXTDOMAIN));
				echo "<script>location.href='$viewBack'</script>";
			}
			exit();
		}

		/**
		 * Get url to secific view.
		 */
		public static function getFontsUrl(){

			$link = admin_url('admin.php?page=themepunch-google-fonts');
			return($link);
		}


		/**
		 *
		 * onAjax action handler
		 */
		public static function onAjaxAction(){

			$slider = new RevSlider();
			$slide = new RevSlide();
			$operations = new RevOperations();

			$action = self::getPostGetVar("client_action");
			$data = self::getPostGetVar("data");
			$nonce = self::getPostGetVar("nonce");

			try{

				//verify the nonce
				$isVerified = wp_verify_nonce($nonce, "revslider_actions");

				if($isVerified == false)
					UniteFunctionsRev::throwError("Wrong request");

				switch($action){
					case 'add_google_fonts':
						$f = new ThemePunch_Fonts();

						$result = $f->add_new_font($data);

						if($result === true){
							self::ajaxResponseSuccess(__("Font successfully created!", REVSLIDER_TEXTDOMAIN), array('data' => $result, 'is_redirect' => true, 'redirect_url' => self::getFontsUrl()));
						}else{
							self::ajaxResponseError($result, false);
						}
					break;
					case 'remove_google_fonts':
						if(!isset($data['handle'])) self::ajaxResponseError(__('Font not found', REVSLIDER_TEXTDOMAIN), false);

						$f = new ThemePunch_Fonts();

						$result = $f->remove_font_by_handle($data['handle']);

						if($result === true){
							self::ajaxResponseSuccess(__("Font successfully removed!", REVSLIDER_TEXTDOMAIN), array('data' => $result));
						}else{
							self::ajaxResponseError($result, false);
						}
					break;
					case 'edit_google_fonts':
						if(!isset($data['handle'])) self::ajaxResponseError(__('No handle given', REVSLIDER_TEXTDOMAIN), false);
						if(!isset($data['url'])) self::ajaxResponseError(__('No parameters given', REVSLIDER_TEXTDOMAIN), false);

						$f = new ThemePunch_Fonts();

						$result = $f->edit_font_by_handle($data);

						if($result === true){
							self::ajaxResponseSuccess(__("Font successfully changed!", REVSLIDER_TEXTDOMAIN), array('data' => $result));
						}else{
							self::ajaxResponseError($result, false);
						}
					break;
					case "export_slider":
						$sliderID = self::getGetVar("sliderid");
						$dummy = self::getGetVar("dummy");
						$slider->initByID($sliderID);
						$slider->exportSlider($dummy);
					break;
					case "import_slider":
						$updateAnim = self::getPostGetVar("update_animations");
						$updateStatic = self::getPostGetVar("update_static_captions");
						self::importSliderHandle(null, $updateAnim, $updateStatic);
					break;
					case "import_slider_slidersview":
						$viewBack = self::getViewUrl(self::VIEW_SLIDERS);
						$updateAnim = self::getPostGetVar("update_animations");
						$updateStatic = self::getPostGetVar("update_static_captions");
						self::importSliderHandle($viewBack, $updateAnim, $updateStatic);
					break;
					case "create_slider":
						self::requireSettings("slider_settings");
						$settingsMain = self::getSettings("slider_main");
						$settingsParams = self::getSettings("slider_params");

						$data = $operations->modifyCustomSliderParams($data);

						$newSliderID = $slider->createSliderFromOptions($data,$settingsMain,$settingsParams);

						self::ajaxResponseSuccessRedirect(
						            __("The slider successfully created",REVSLIDER_TEXTDOMAIN),
									self::getViewUrl("sliders"));

					break;
					case "update_slider":
						self::requireSettings("slider_settings");
						$settingsMain = self::getSettings("slider_main");
						$settingsParams = self::getSettings("slider_params");

						$data = $operations->modifyCustomSliderParams($data);

						$slider->updateSliderFromOptions($data,$settingsMain,$settingsParams);
						self::ajaxResponseSuccess(__("Slider updated",REVSLIDER_TEXTDOMAIN));
					break;

					case "delete_slider":

						$isDeleted = $slider->deleteSliderFromData($data);

						if(is_array($isDeleted)){
							$isDeleted = implode(', ', $isDeleted);
							self::ajaxResponseError("Template can't be deleted, it is still being used by the following Sliders: ".$isDeleted);
						}else{
							self::ajaxResponseSuccessRedirect(
						            __("The slider deleted",REVSLIDER_TEXTDOMAIN),
									self::getViewUrl(self::VIEW_SLIDERS));
						}
					break;
					case "duplicate_slider":

						$slider->duplicateSliderFromData($data);

						self::ajaxResponseSuccessRedirect(
						            __("The duplicate successfully, refreshing page...",REVSLIDER_TEXTDOMAIN),
									self::getViewUrl(self::VIEW_SLIDERS));
					break;
					case "add_slide":
						$numSlides = $slider->createSlideFromData($data);
						$sliderID = $data["sliderid"];

						if($numSlides == 1){
							$responseText = __("Slide Created",REVSLIDER_TEXTDOMAIN);
						}
						else
							$responseText = $numSlides . " ".__("Slides Created",REVSLIDER_TEXTDOMAIN);

						$urlRedirect = self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID");
						self::ajaxResponseSuccessRedirect($responseText,$urlRedirect);

					break;
					case "add_slide_fromslideview":
						$slideID = $slider->createSlideFromData($data,true);
						$urlRedirect = self::getViewUrl(self::VIEW_SLIDE,"id=$slideID");
						$responseText = __("Slide Created, redirecting...",REVSLIDER_TEXTDOMAIN);
						self::ajaxResponseSuccessRedirect($responseText,$urlRedirect);
					break;
					case "update_slide":
						require self::getSettingsFilePath("slide_settings");

						$slide->updateSlideFromData($data,$slideSettings);
						self::ajaxResponseSuccess(__("Slide updated",REVSLIDER_TEXTDOMAIN));
					break;
					case "update_static_slide":
						$slide->updateStaticSlideFromData($data);
						self::ajaxResponseSuccess(__("Static Global Layers updated",REVSLIDER_TEXTDOMAIN));
					break;
					case "delete_slide":
						$isPost = $slide->deleteSlideFromData($data);
						if($isPost)
							$message = __("Post Deleted Successfully",REVSLIDER_TEXTDOMAIN);
						else
							$message = __("Slide Deleted Successfully",REVSLIDER_TEXTDOMAIN);

						$sliderID = UniteFunctionsRev::getVal($data, "sliderID");
						self::ajaxResponseSuccessRedirect($message, self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID"));
					break;
					case "duplicate_slide":
						$sliderID = $slider->duplicateSlideFromData($data);
						self::ajaxResponseSuccessRedirect(
						            __("Slide Duplicated Successfully",REVSLIDER_TEXTDOMAIN),
									self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID"));
					break;
					case "copy_move_slide":
						$sliderID = $slider->copyMoveSlideFromData($data);

						self::ajaxResponseSuccessRedirect(
						            __("The operation successfully, refreshing page...",REVSLIDER_TEXTDOMAIN),
									self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID"));
					break;
					case "get_static_css":
						$contentCSS = $operations->getStaticCss();
						self::ajaxResponseData($contentCSS);
					break;
					case "get_dynamic_css":
						$contentCSS = $operations->getDynamicCss();
						self::ajaxResponseData($contentCSS);
					break;
					case "insert_captions_css":
						$arrCaptions = $operations->insertCaptionsContentData($data);
						self::ajaxResponseSuccess(__("CSS saved succesfully!",REVSLIDER_TEXTDOMAIN),array("arrCaptions"=>$arrCaptions));
					break;
					case "update_captions_css":
						$arrCaptions = $operations->updateCaptionsContentData($data);
						self::ajaxResponseSuccess(__("CSS saved succesfully!",REVSLIDER_TEXTDOMAIN),array("arrCaptions"=>$arrCaptions));
					break;
					case "delete_captions_css":
						$arrCaptions = $operations->deleteCaptionsContentData($data);
						self::ajaxResponseSuccess(__("Style deleted succesfully!",REVSLIDER_TEXTDOMAIN),array("arrCaptions"=>$arrCaptions));
					break;
					case "update_static_css":
						$staticCss = $operations->updateStaticCss($data);
						self::ajaxResponseSuccess(__("CSS saved succesfully!",REVSLIDER_TEXTDOMAIN),array("css"=>$staticCss));
					break;
					case "insert_custom_anim":
						$arrAnims = $operations->insertCustomAnim($data); //$arrCaptions =
						self::ajaxResponseSuccess(__("Animation saved succesfully!",REVSLIDER_TEXTDOMAIN), $arrAnims); //,array("arrCaptions"=>$arrCaptions)
					break;
					case "update_custom_anim":
						$arrAnims = $operations->updateCustomAnim($data);
						self::ajaxResponseSuccess(__("Animation saved succesfully!",REVSLIDER_TEXTDOMAIN), $arrAnims); //,array("arrCaptions"=>$arrCaptions)
					break;
					case "delete_custom_anim":
						$arrAnims = $operations->deleteCustomAnim($data);
						self::ajaxResponseSuccess(__("Animation saved succesfully!",REVSLIDER_TEXTDOMAIN), $arrAnims); //,array("arrCaptions"=>$arrCaptions)
					break;
					case "update_slides_order":
						$slider->updateSlidesOrderFromData($data);
						self::ajaxResponseSuccess(__("Order updated successfully",REVSLIDER_TEXTDOMAIN));
					break;
					case "change_slide_image":
						$slide->updateSlideImageFromData($data);
						$sliderID = UniteFunctionsRev::getVal($data, "slider_id");
						self::ajaxResponseSuccessRedirect(
						            __("Slide Changed Successfully",REVSLIDER_TEXTDOMAIN),
									self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID"));
					break;
					case "preview_slide":
						$operations->putSlidePreviewByData($data);
					break;
					case "preview_slider":
						$sliderID = UniteFunctionsRev::getPostGetVariable("sliderid");
						$do_markup = UniteFunctionsRev::getPostGetVariable("only_markup");

						if($do_markup == 'true')
							$operations->previewOutputMarkup($sliderID);
						else
							$operations->previewOutput($sliderID);
					break;
					case "toggle_slide_state":
						$currentState = $slide->toggleSlideStatFromData($data);
						self::ajaxResponseData(array("state"=>$currentState));
					break;
					case "slide_lang_operation":
						$responseData = $slide->doSlideLangOperation($data);
						self::ajaxResponseData($responseData);
					break;
					case "update_plugin":
						self::updatePlugin(self::DEFAULT_VIEW);
					break;
					case "update_text":
						self::updateSettingsText();
						self::ajaxResponseSuccess(__("All files successfully updated",REVSLIDER_TEXTDOMAIN));
					break;
					case "update_general_settings":
						$operations->updateGeneralSettings($data);
						self::ajaxResponseSuccess(__("General settings updated",REVSLIDER_TEXTDOMAIN));
					break;
					case "update_posts_sortby":
						$slider->updatePostsSortbyFromData($data);
						self::ajaxResponseSuccess(__("Sortby updated",REVSLIDER_TEXTDOMAIN));
					break;
					case "replace_image_urls":
						$slider->replaceImageUrlsFromData($data);
						self::ajaxResponseSuccess(__("Image urls replaced",REVSLIDER_TEXTDOMAIN));
					break;
					case "reset_slide_settings":
						$slider->resetSlideSettings($data);
						self::ajaxResponseSuccess(__("Settings in all Slides changed",REVSLIDER_TEXTDOMAIN));
					break;
					case "activate_purchase_code":

						$result = false;

						if(!empty($data['username']) && !empty($data['api_key']) && !empty($data['code'])){

							$result = $operations->checkPurchaseVerification($data);

						}else{
							UniteFunctionsRev::throwError(__('The API key, the Purchase Code and the Username need to be set!', REVSLIDER_TEXTDOMAIN));
							exit();
						}

						if($result){
							self::ajaxResponseSuccessRedirect(
						            __("Purchase Code Successfully Activated",REVSLIDER_TEXTDOMAIN),
									self::getViewUrl(self::VIEW_SLIDERS));
						}else{
							UniteFunctionsRev::throwError(__('Purchase Code is invalid', REVSLIDER_TEXTDOMAIN));
						}
					break;
					case "deactivate_purchase_code":
						$result = $operations->doPurchaseDeactivation($data);

						if($result){
							self::ajaxResponseSuccessRedirect(
						            __("Successfully removed validation",REVSLIDER_TEXTDOMAIN),
									self::getViewUrl(self::VIEW_SLIDERS));
						}else{
							UniteFunctionsRev::throwError(__('Could not remove Validation!', REVSLIDER_TEXTDOMAIN));
						}
					break;
					case "dismiss_notice":
						update_option('revslider-valid-notice', 'false');
						self::ajaxResponseSuccess(__(".",REVSLIDER_TEXTDOMAIN));
					break;

					default:
						self::ajaxResponseError("wrong ajax action: $action ");
					break;
				}

			}
			catch(Exception $e){

				$message = $e->getMessage();
				if($action == "preview_slide" || $action == "preview_slider"){
					echo $message;
					exit();
				}

				self::ajaxResponseError($message);
			}

			//it's an ajax action, so exit
			self::ajaxResponseError("No response output on <b> $action </b> action. please check with the developer.");
			exit();
		}
		
		/**
		 * Set the option to add a delay to the revslider javascript output
		 */
		public static function rev_set_js_delay($do_delay){
			return '300';
		}
		
		/**
		 * onAjax action handler
		 */
		public static function onFrontAjaxAction(){
			$db = new UniteDBRev();
			$slider = new RevSlider();
			$slide = new RevSlide();
			$operations = new RevOperations();
			
			$token = self::getPostVar("token", false);
			
			//verify the token
			$isVerified = wp_verify_nonce($token, 'RevSlider_Front');
			
			$error = false;
			if($isVerified){
				$data = self::getPostVar('data', false);
				switch(self::getPostVar('client_action', false)){
					case 'get_slider_html':
						$id = intval(self::getPostVar('id', 0));
						if($id > 0){
							$html = '';
							add_filter('revslider_add_js_delay', array('RevSliderAdmin', 'rev_set_js_delay'));
							ob_start();
							$slider_class = RevSliderOutput::putSlider($id);
							$html = ob_get_contents();
							
							//add styling
							$custom_css = RevOperations::getStaticCss();
							$custom_css = UniteCssParserRev::compress_css($custom_css);
							$styles = $db->fetch(GlobalsRevSlider::$table_css);
							$styles = UniteCssParserRev::parseDbArrayToCss($styles, "\n");
							$styles = UniteCssParserRev::compress_css($styles);
							
							$html .= '<style type="text/css">'.$custom_css.'</style>';
							$html .= '<style type="text/css">'.$styles.'</style>';
							
							ob_clean();
							ob_end_clean();
							
							$result = (!empty($slider_class) && $html !== '') ? true : false;
							
							if(!$result){
								$error = __('Slider not found', REVSLIDER_TEXTDOMAIN);
							}else{
								
								if($html !== false){
									self::ajaxResponseData($html);
								}else{
									$error = __('Slider not found', REVSLIDER_TEXTDOMAIN);
								}
							}
						}else{
							$error = __('No Data Received', REVSLIDER_TEXTDOMAIN);
						}
					break;
				}
				
			}else{
				$error = true;
			}
			
			if($error !== false){
				$showError = __('Loading Error', REVSLIDER_TEXTDOMAIN);
				if($error !== true)
					$showError = __('Loading Error: ', REVSLIDER_TEXTDOMAIN).$error;
				
				self::ajaxResponseError($showError, false);
			}
			exit();
		}
		

	}


?>