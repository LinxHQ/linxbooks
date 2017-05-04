<?php
	class UniteSettingsProductSidebarRev extends UniteSettingsOutputRev{
		
		private $addClass = "";		//add class to the main div
		private $arrButtons = array();
		private $isAccordion = true;
		private $defaultTextClass;
		
		const INPUT_CLASS_SHORT = "text-sidebar";
		const INPUT_CLASS_NORMAL = "text-sidebar-normal";
		const INPUT_CLASS_LONG = "text-sidebar-long";
		const INPUT_CLASS_LINK = "text-sidebar-link";
		

		/**
		 * 
		 * construction
		 */
		public function __construct(){
			$this->defaultTextClass = self::INPUT_CLASS_SHORT;
		}
		
		
		/**
		 * 
		 * set default text class
		 */
		public function setDefaultInputClass($defaultClass){
			$this->defaultTextClass = $defaultClass;
		}
		
		
		/**
		 * 
		 * add buggon
		 */
		public function addButton($title,$id,$class = "button-secondary"){
			
			$button = array(
				"title"=>$title,
				"id"=>$id,
				"class"=>$class
			);
			
			$this->arrButtons[] = $button;			
		}
		
		
		
		/**
		 * 
		 * set add class for the main div
		 */
		public function setAddClass($addClass){
			$this->addClass = $addClass;
		}
		
		
		//-----------------------------------------------------------------------------------------------
		//draw text as input
		protected function drawTextInput($setting) {
			$disabled = "";
			$style="";
			if(isset($setting["style"])) 
				$style = "style='".$setting["style"]."'";
			if(isset($setting["disabled"])) 
				$disabled = 'disabled="disabled"';

			$class = UniteFunctionsRev::getVal($setting, "class",$this->defaultTextClass);
							
			//modify class:
			switch($class){
				case "normal":
				case "regular":
					$class = self::INPUT_CLASS_NORMAL;
				break;
				case "long":
					$class = self::INPUT_CLASS_LONG;
				break;
				case "link":
					$class = self::INPUT_CLASS_LINK;
				break;
			}
			
			if(!empty($class))
				$class = "class='$class'";
			
			$attribs = UniteFunctionsRev::getVal($setting, "attribs");
			
			?>
				<input type="text" <?php echo $attribs?> <?php echo $class?> <?php echo $style?> <?php echo $disabled?> id="<?php echo $setting["id"]?>" name="<?php echo $setting["name"]?>" value="<?php echo $setting["value"]?>" />
			<?php
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw multiple text boxes as input
		protected function drawMultipleText($setting) {
			$disabled = "";
			$style="";
			if(isset($setting["style"])) 
				$style = "style='".$setting["style"]."'";
			if(isset($setting["disabled"])) 
				$disabled = 'disabled="disabled"';

			$class = UniteFunctionsRev::getVal($setting, "class",$this->defaultTextClass);
							
			//modify class:
			switch($class){
				case "normal":
				case "regular":
					$class = self::INPUT_CLASS_NORMAL;
				break;
				case "long":
					$class = self::INPUT_CLASS_LONG;
				break;
				case "link":
					$class = self::INPUT_CLASS_LINK;
				break;
			}
			
			if(!empty($class))
				$class = "class='$class'";
			
			$attribs = UniteFunctionsRev::getVal($setting, "attribs");
			$values = $setting["value"];
			if(!empty($values) && is_array($values)){
				foreach($values as $key => $value){
				?>
					<div class="fontinput_wrapper">
					<input type="text" <?php echo $attribs?> <?php echo $class?> <?php echo $style?> <?php echo $disabled?> id="<?php echo $setting["id"].'_'.$key?>" name="<?php echo $setting["name"]?>[]" value="<?php echo stripslashes($value)?>" /> <a href="javascript:void(0);" data-remove="<?php echo $setting["id"].'_'.$key?>" class="remove_multiple_text"><i class="revicon-trash redicon withhover"></i></a>
					</div>
				<?php
				}
			}else{ //fallback to old version
				$key = 0;
			?>
				<div class="fontinput_wrapper">
				<input type="text" <?php echo $attribs?> <?php echo $class?> <?php echo $style?> <?php echo $disabled?> id="<?php echo $setting["id"].'_'.$key?>" name="<?php echo $setting["name"]?>[]" value="<?php echo stripslashes($setting["value"])?>" /> <a href="javascript:void(0);" data-remove="<?php echo $setting["id"].'_'.$key?>" class="remove_multiple_text"><i class="revicon-trash redicon withhover"></i></a>
				</div>
			<?php
			}
			?>
			
			<div class="<?php echo $setting["id"]?>_TEMPLATE" style="display: none;">
				<div class="fontinput_wrapper">
					<input type="text" <?php echo $attribs?> <?php echo $class?> <?php echo $style?> id="##ID##" name="##NAME##[]" value="" /> <a href="javascript:void(0);" data-remove="##ID##" class="remove_multiple_text"><i class="revicon-trash redicon withhover"></i></a>
				</div>
			</div>
			
			<script type="text/javascript">
				UniteAdminRev.setMultipleTextKey('<?php echo $setting["id"]?>', <?php echo $key?>);
			</script>
			<?php
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw a color picker
		protected function drawColorPickerInput($setting){			
			$bgcolor = $setting["value"];
			$bgcolor = str_replace("0x","#",$bgcolor);			
			// set the forent color (by black and white value)
			$rgb = UniteFunctionsRev::html2rgb($bgcolor);
			$bw = UniteFunctionsRev::yiq($rgb[0],$rgb[1],$rgb[2]);
			$color = "#000000";
			if($bw<128) $color = "#ffffff";
			
			
			$disabled = "";
			if(isset($setting["disabled"])){
				$color = "";
				$disabled = 'disabled="disabled"';
			}
			
			$style="style='background-color:$bgcolor;color:$color'";
			
			?>
				<input type="text" class="inputColorPicker" id="<?php echo $setting["id"]?>" <?php echo $style?> name="<?php echo $setting["name"]?>" value="<?php echo $bgcolor?>" <?php echo $disabled?>></input>
			<?php
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw a color picker
		protected function drawCodeMirror($setting){			
			?>
			<textarea name="<?php echo $setting['name']; ?>" id="<?php echo $setting['id']; ?>"><?php echo $setting["value"]; ?></textarea>
			<script type="text/javascript">
				rev_cm_<?php echo $setting['id']; ?> = null;
				jQuery(document).ready(function(){
					rev_cm_<?php echo $setting['id']; ?> = CodeMirror.fromTextArea(document.getElementById("<?php echo $setting['id']; ?>"), {
						onChange: function(){ },
						lineNumbers: true
					});
					
					jQuery('.postbox.unite-postbox').click(function(){
						rev_cm_<?php echo $setting['id']; ?>.refresh();
					});
				});
			</script>
			<?php
		}
		
		//-----------------------------------------------------------------------------------------------
		// draw setting input by type
		protected function drawInputs($setting){
			switch($setting["type"]){
				case UniteSettingsRev::TYPE_TEXT:
					$this->drawTextInput($setting);
				break;
				case UniteSettingsRev::TYPE_COLOR:
					$this->drawColorPickerInput($setting);
				break;
				case UniteSettingsRev::TYPE_SELECT:
					$this->drawSelectInput($setting);
				break;
				case UniteSettingsRev::TYPE_CHECKBOX:
					$this->drawCheckboxInput($setting);
				break;
				case UniteSettingsRev::TYPE_RADIO:
					$this->drawRadioInput($setting);
				break;
				case UniteSettingsRev::TYPE_TEXTAREA:
					$this->drawTextAreaInput($setting);
				break;
				case UniteSettingsRev::TYPE_CUSTOM:
					$this->drawCustom($setting);
				break;
				case UniteSettingsRev::TYPE_BUTTON:
					$this->drawButtonSetting($setting);
				break;
				case UniteSettingsRev::TYPE_MULTIPLE_TEXT:
					$this->drawMultipleText($setting);
				break;
				case 'codemirror':
					$this->drawCodeMirror($setting);
				break;
				default:
					throw new Exception("wrong setting type - ".$setting["type"]);
				break;
			}			
		}		
		
		//-----------------------------------------------------------------------------------------------
		//draw advanced order box
		protected function drawOrderbox_advanced($setting){
			
			$items = $setting["items"];
			if(!is_array($items))
				$this->throwError("Orderbox error - the items option must be array (items)");
				
			//get arrItems modify items by saved value			
			
			if(!empty($setting["value"]) && 
				getType($setting["value"]) == "array" &&
				count($setting["value"]) == count($items)):
				
				$savedItems = $setting["value"];
				
				//make assoc array by id:
				$arrAssoc = array();
				foreach($items as $item)
					$arrAssoc[$item[0]] = $item[1];
				
				foreach($savedItems as $item){
					$value = $item["id"];
					$text = $value;
					if(isset($arrAssoc[$value]))
						$text = $arrAssoc[$value];
					$arrItems[] = array($value,$text,$item["enabled"]);
				}
			else: 
				$arrItems = $items;
			endif;
			
			?>	
			<ul class="orderbox_advanced" id="<?php echo $setting["id"]?>">
			<?php 
			foreach($arrItems as $arrItem){
				switch(getType($arrItem)){
					case "string":
						$value = $arrItem;
						$text = $arrItem;
						$enabled = true;
					break;
					case "array":
						$value = $arrItem[0];
						$text = (count($arrItem)>1)?$arrItem[1]:$arrItem[0];
						$enabled = (count($arrItem)>2)?$arrItem[2]:true;
					break;
					default:
						$this->throwError("Error in setting:".$setting.". unknown item type.");
					break;
				}
				$checkboxClass = $enabled ? "div_checkbox_on" : "div_checkbox_off";
				
					?>
						<li>
							<div class="div_value"><?php echo $value?></div>
							<div class="div_checkbox <?php echo $checkboxClass?>"></div>
							<div class="div_text"><?php echo $text?></div>
							<div class="div_handle"></div>
						</li>
					<?php 
			}
			
			?>
			</ul>
			<?php 			
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw order box
		protected function drawOrderbox($setting){
						
			$items = $setting["items"];
			
			//get arrItems by saved value
			$arrItems = array();
					
			if(!empty($setting["value"]) && 
				getType($setting["value"]) == "array" &&
				count($setting["value"]) == count($items)){
				
				$savedItems = $setting["value"];
								
				foreach($savedItems as $value){
					$text = $value;
					if(isset($items[$value]))
						$text = $items[$value];
					$arrItems[] = array("value"=>$value,"text"=>$text);	
				}
			}		//get arrItems only from original items
			else{
				foreach($items as $value=>$text)
					$arrItems[] = array("value"=>$value,"text"=>$text);
			}
			
			
			?>
			<ul class="orderbox" id="<?php echo $setting["id"]?>">
			<?php 
				foreach($arrItems as $item){
					$itemKey = $item["value"];
					$itemText = $item["text"];
					
					$value = (getType($itemKey) == "string")?$itemKey:$itemText;
					?>
						<li>
							<div class="div_value"><?php echo $value?></div>
							<div class="div_text"><?php echo $itemText?></div>
						</li>
					<?php 
				} 
			?>
			</ul>
			<?php 
		}
		
		/**
		 * 
		 * draw button
		 */
		function drawButtonSetting($setting){
			//set class
			$class = UniteFunctionsRev::getVal($setting, "class");
			if(!empty($class))
				$class = "class='$class'";
			
			?>
				<input type="button" id="<?php echo $setting["id"]?>" value="<?php echo $setting["value"]?>" <?php echo $class?>>
			<?php 
		}
		
		
		//-----------------------------------------------------------------------------------------------
		// draw text area input
		protected function drawTextAreaInput($setting){
			$disabled = "";
			if (isset($setting["disabled"])) $disabled = 'disabled="disabled"';
			
			//set style
			$style = UniteFunctionsRev::getVal($setting, "style");	
			if(!empty($style)) 
				$style = "style='".$style."'";

			//set class
			$class = UniteFunctionsRev::getVal($setting, "class");
			if(!empty($class))
				$class = "class='$class'";
			
			?>
				<textarea id="<?php echo $setting["id"]?>" <?php echo $class?> name="<?php echo $setting["name"]?>" <?php echo $style?> <?php echo $disabled?>><?php echo $setting["value"]?></textarea>				
			<?php
		}		
		
		//-----------------------------------------------------------------------------------------------
		// draw radio input
		protected function drawRadioInput($setting){
			$items = $setting["items"];
			$counter = 0;
			$id = $setting["id"];
			$isDisabled = UniteFunctionsRev::getVal($setting, "disabled",false); 
			
			?>
			<span id="<?php echo $id?>" class="radio_wrapper">
			<?php 
			foreach($items as $value=>$text):
				$counter++;
				$radioID = $id."_".$counter;
				$checked = "";
				if($value == $setting["value"]) $checked = " checked";

				$disabled = "";
				if($isDisabled == true)
					$disabled = 'disabled="disabled"';
				
				?>
					<div class="radio_inner_wrapper">
						<input type="radio" id="<?php echo $radioID?>" value="<?php echo $value?>" name="<?php echo $setting["name"]?>" <?php echo $disabled?> <?php echo $checked?>/>
						<label for="<?php echo $radioID?>" style="cursor:pointer;"><?php _e($text)?></label>
					</div>
				<?php				
			endforeach;
			?>
			</span>
			<?php 
		}
		
		
		//-----------------------------------------------------------------------------------------------
		// draw checkbox
		protected function drawCheckboxInput($setting){
			$checked = "";
			if($setting["value"] == true) $checked = 'checked="checked"';
			?>
				<input type="checkbox" id="<?php echo $setting["id"]?>" class="inputCheckbox" name="<?php echo $setting["name"]?>" <?php echo $checked?>/>
			<?php
		}		
		
		//-----------------------------------------------------------------------------------------------
		//draw select input
		protected function drawSelectInput($setting){
			
			$className = "";
			if(isset($this->arrControls[$setting["name"]])) $className = "control";
			$class = "";
			if($className != "") $class = "class='".$className."'";
			
			$disabled = "";
			if(isset($setting["disabled"])) 
				$disabled = 'disabled="disabled"';
			
			?>
			<select id="<?php echo $setting["id"]?>" name="<?php echo $setting["name"]?>" <?php echo $disabled?> <?php echo $class?>>
			<?php
			foreach($setting["items"] as $value=>$text):
				$text = __($text,REVSLIDER_TEXTDOMAIN);
				$selected = "";
				if($value == $setting["value"]) $selected = 'selected="selected"';
				?>
					<option value="<?php echo $value?>" <?php echo $selected?>><?php echo $text?></option>
				<?php
			endforeach
			?>
			</select>
			<?php
		}

		/**
		 * 
		 * draw custom setting
		 */
		protected function drawCustom($setting){
			dmp($setting);
			exit();
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw hr row
		protected function drawTextRow($setting){
			
			//set cell style
			$cellStyle = "";
			if(isset($setting["padding"])) 
				$cellStyle .= "padding-left:".$setting["padding"].";";
				
			if(!empty($cellStyle))
				$cellStyle="style='$cellStyle'";
				
			//set style
			$rowStyle = "";					
			if(isset($setting["hidden"]) && $setting["hidden"] == true) 
				$rowStyle .= "display:none;";
				
			if(!empty($rowStyle))
				$rowStyle = "style='$rowStyle'";
			
			?>
				<span class="spanSettingsStaticText"><?php echo __($setting["text"],REVSLIDER_TEXTDOMAIN)?></span>
			<?php 
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw hr row
		protected function drawHrRow($setting){
			//set hidden
			$rowStyle = "";
			if(isset($setting["hidden"]) && $setting["hidden"] == true) $rowStyle = "style='display:none;'";
			
			?>
				<li id="<?php echo $setting["id"]?>_row" class="hrrow">
					<hr />
				</li>
			<?php 
		}
		
		
		//-----------------------------------------------------------------------------------------------
		//draw settings row
		protected function drawSettingRow($setting){
		
			//set cellstyle:
			$cellStyle = "";
			if(isset($setting[UniteSettingsRev::PARAM_CELLSTYLE])){
				$cellStyle .= $setting[UniteSettingsRev::PARAM_CELLSTYLE];
			}
			
			//set text style:
			$textStyle = $cellStyle;
			if(isset($setting[UniteSettingsRev::PARAM_TEXTSTYLE])){
				$textStyle .= $setting[UniteSettingsRev::PARAM_TEXTSTYLE];
			}
			
			if($textStyle != "") $textStyle = "style='".$textStyle."'";
			if($cellStyle != "") $cellStyle = "style='".$cellStyle."'";
			
			//set hidden
			$rowStyle = "";
			if(isset($setting["hidden"]) && $setting["hidden"] == true) $rowStyle = "display:none;";
			if(!empty($rowStyle)) $rowStyle = "style='$rowStyle'";
			
			//set row class:
			$rowClass = "";
			if(isset($setting["disabled"])) $rowClass = "class='disabled'";

			
			//modify text:
			$text = UniteFunctionsRev::getVal($setting,"text","");
			$text = __($text,REVSLIDER_TEXTDOMAIN);
			
			// prevent line break (convert spaces to nbsp)
			$text = str_replace(" ","&nbsp;",$text);
			
			if($setting["type"] == UniteSettingsRev::TYPE_CHECKBOX)
				$text = "<label for='{$setting["id"]}'>{$text}</label>";
			
			//set settings text width:
			$textWidth = "";
			if(isset($setting["textWidth"])) $textWidth = 'width="'.$setting["textWidth"].'"';
			
			$description = UniteFunctionsRev::getVal($setting, "description");
			$description = __($description,REVSLIDER_TEXTDOMAIN);
			
			$unit = UniteFunctionsRev::getVal($setting, "unit");
			$unit = __($unit,REVSLIDER_TEXTDOMAIN);
			
			$required = UniteFunctionsRev::getVal($setting, "required");
			
			$addHtml = UniteFunctionsRev::getVal($setting, UniteSettingsRev::PARAM_ADDTEXT);			
			$addHtmlBefore = UniteFunctionsRev::getVal($setting, UniteSettingsRev::PARAM_ADDTEXT_BEFORE_ELEMENT);			
			
			
			//set if draw text or not.
			$toDrawText = true;
			if($setting["type"] == UniteSettingsRev::TYPE_BUTTON || $setting["type"] == UniteSettingsRev::TYPE_MULTIPLE_TEXT)
				$toDrawText = false;
				
			$settingID = $setting["id"];
			$attribsText = UniteFunctionsRev::getVal($setting, "attrib_text");
			
			$info = ($toDrawText == true && $description !== '') ? ' <div class="setting_info">i</div>' : '';
			
			?>
				<li id="<?php echo $settingID?>_row" <?php echo $rowStyle." ".$rowClass?>>
					
					<?php if($toDrawText == true):?>
						<div id="<?php echo $settingID?>_text" class='setting_text' title="<?php echo $description?>" <?php echo $attribsText?>><?php echo $text.$info ?></div>
					<?php endif?>
					
					<?php if(!empty($addHtmlBefore)):?>
						<div class="settings_addhtmlbefore"><?php echo $addHtmlBefore?></div>
					<?php endif?>
					
					<div class='setting_input'>
						<?php $this->drawInputs($setting);?>
					</div>
					<?php if(!empty($unit)):?>
						<div class='setting_unit'><?php echo $unit?></div>
					<?php endif?>
					<?php if(!empty($required)):?>
						<div class='setting_required'>*</div>
					<?php endif?>
					<?php if(!empty($addHtml)):?>
						<div class="settings_addhtml"><?php echo $addHtml?></div>
					<?php endif?>
					<div class="clear"></div>
				</li>
				<?php
				if($setting['name'] == 'shadow_type'){ //For shadow types, add box with shadow types
					$this->drawShadowTypes($setting['value']);
				}
		}
		
		/**
		 * 
		 * insert settings into saps array
		 */
		private function groupSettingsIntoSaps(){
			$arrSections = $this->settings->getArrSections();
			$arrSaps = $arrSections[0]["arrSaps"];
			$arrSettings = $this->settings->getArrSettings(); 
			
			//group settings by saps
			foreach($arrSettings as $key=>$setting){
				
				$sapID = $setting["sap"];
				
				if(isset($arrSaps[$sapID]["settings"]))
					$arrSaps[$sapID]["settings"][] = $setting;
				else 
					$arrSaps[$sapID]["settings"] = array($setting);
			}
			return($arrSaps);
		}
		
		/**
		 * 
		 * draw buttons that defined earlier
		 */
		private function drawButtons(){
			foreach($this->arrButtons as $key=>$button){
				if($key>0)
				echo "<span class='hor_sap'></span>";
				echo UniteFunctionsRev::getHtmlLink("#", $button["title"],$button["id"],$button["class"]);
			}
		}
		
		/**
		 * 
		 * draw some setting, can be setting array or name
		 */
		public function drawSetting($setting,$state = null){
			if(gettype($setting) == "string")
				$setting = $this->settings->getSettingByName($setting);
			
			$setting = apply_filters('revslider_modify_sidebar_settings', $setting);
			
			switch($state){
				case "hidden":
					$setting["hidden"] = true;
				break;
			}
				
			switch($setting["type"]){
				case UniteSettingsRev::TYPE_HR:
					$this->drawHrRow($setting);
				break;
				case UniteSettingsRev::TYPE_STATIC_TEXT:
					$this->drawTextRow($setting);
				break;
				default:
					$this->drawSettingRow($setting);
				break;
			}
		}
		
		/**
		 * 
		 * draw setting by bulk names
		 */
		public function drawSettingsByNames($arrSettingNames,$state=null){
			if(gettype($arrSettingNames) == "string")
				$arrSettingNames = explode(",",$arrSettingNames);
				
			foreach($arrSettingNames as $name)
				$this->drawSetting($name,$state);
		}
		
		
		/**
		 * 
		 * draw all settings
		 */
		public function drawSettings(){
			$this->prepareToDraw();
			$this->drawHeaderIncludes();
			
			
			$arrSaps = $this->groupSettingsIntoSaps();			
			
			$class = "postbox unite-postbox";
			if(!empty($this->addClass))
				$class .= " ".$this->addClass;
			
			//draw wrapper
			echo "<div class='settings_wrapper'>";
				
			//draw settings - advanced - with sections
			foreach($arrSaps as $key=>$sap):

				//set accordion closed
				$style = "";
				if($this->isAccordion == false){
					$h3Class = "class='no-accordion'";
				}else{
					$h3Class = "";
					if($key>0){
						$style = "style='display:none;'";
						$h3Class = "class='box_closed'";
					}
				}
					
				$text = $sap["text"];
				$icon = $sap["icon"];
				$text = __($text,REVSLIDER_TEXTDOMAIN);
				
				?>
					<div class="<?php echo $class?>">
						<h3 <?php echo $h3Class?>><i style="float:left;margin-top:4px;font-size:14px;" class="<?php echo $icon?>"></i>
						
						<?php if($this->isAccordion == true):?>
							<div class="postbox-arrow"></div>
						<?php endif?>
						
							<span><?php echo $text ?></span>
						</h3>			
												
						<div class="inside" <?php echo $style?> >
							<ul class="list_settings">
						<?php
						
							foreach($sap["settings"] as $setting){
								$this->drawSetting($setting);
							}
							
							?>
							</ul>
							
							<?php 
							if(!empty($this->arrButtons)){
								?>
								<div class="clear"></div>
								<div class="settings_buttons">
								<?php 
									$this->drawButtons();
								?>
								</div>	
								<div class="clear"></div>
								<?php 								
							}								
						?>
						
							<div class="clear"></div>
						</div>
					</div>
				<?php 			
														
			endforeach;
			
			echo "</div>";	//wrapper close
		}
		
		
		//-----------------------------------------------------------------------------------------------
		// draw sections menu
		public function drawSections($activeSection=0){
			if(!empty($this->arrSections)):
				echo "<ul class='listSections' >";
				for($i=0;$i<count($this->arrSections);$i++):
					$class = "";
					if($activeSection == $i) $class="class='selected'";
					$text = $this->arrSections[$i]["text"];
					echo '<li '.$class.'><a onfocus="this.blur()" href="#'.($i+1).'"><div>'.$text.'</div></a></li>';
				endfor;
				echo "</ul>";
			endif;
				
			//call custom draw function:
			if($this->customFunction_afterSections) call_user_func($this->customFunction_afterSections);
		}
		
		/**
		 * 
		 * init accordion
		 */
		private function putAccordionInit(){
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					UniteSettingsRev.initAccordion("<?php echo $this->formID?>");
				});				
			</script>
			<?php 
		}
		
		/**
		 * 
		 * activate the accordion
		 */
		public function isAccordion($activate){
			$this->isAccordion = $activate;
		}
		
		
		/**
		 * 
		 * draw settings function
		 */
		public function draw($formID=null){
			if(empty($formID))
				UniteFunctionsRev::throwError("You must provide formID to side settings.");
			
			$this->formID = $formID;
			
			if(!empty($formID)){
				?>
				<form name="<?php echo $formID?>" id="<?php echo $formID?>">
					<?php $this->drawSettings() ?>
				</form>
				<?php 
			}else
				$this->drawSettings();
			
			if($this->isAccordion == true)
				$this->putAccordionInit();
			
		}
		
		
		/**
		 * 
		 * draw shadow types function
		 */
		public function drawShadowTypes($current){
			?>
			<li  class="shadowTypes shadowType-0"<?php echo ($current == 0) ? ' style="display: none;"' : ''; ?>>
				<img class="shadowTypes shadowType-1" src="<?php echo UniteBaseClassRev::$url_plugin; ?>images/shadow1.png"<?php echo ($current == 1) ? '' : ' style="display: none;"'; ?> width="271" />
				<img class="shadowTypes shadowType-2" src="<?php echo UniteBaseClassRev::$url_plugin; ?>images/shadow2.png"<?php echo ($current == 2) ? '' : ' style="display: none;"'; ?> width="271" />
				<img class="shadowTypes shadowType-3" src="<?php echo UniteBaseClassRev::$url_plugin; ?>images/shadow3.png"<?php echo ($current == 3) ? '' : ' style="display: none;"'; ?> width="271" />
			</li>
			<script type="text/javascript">
				/**
				 * set shadow type
				 */
				jQuery("#shadow_type").change(function() {
					var sel = jQuery(this).val();
					jQuery(".shadowTypes").hide();
					if(sel != '0'){
						jQuery(".shadowType-0").show();
						jQuery(".shadowType-"+sel).show();
					}
				});
			</script>
			<?php
		}
		
		/**
		 * 
		 * draw css editor
		 */
		public function drawCssEditor(){
			?>
			<div id="css_editor_wrap" title="<?php _e("Style Editor",REVSLIDER_TEXTDOMAIN) ?>" style="display:none;">

				<div class="tp-present-wrapper-parent"><div class="tp-present-wrapper"><div class="tp-present-caption"><div id="css_preview" class="">example</div></div></div></div>
				<ul class="list_idlehover">
					<li><a href="javascript:void(0)" id="change-type-idle" class="change-type selected"><span class="nowrap">Idle</span></a></li>
					<li><a href="javascript:void(0)" id="change-type-hover" class="change-type"><span class="nowrap">Hover</span></a></li>					
					<div style="clear:both"></div>
				</ul>
				<div id="css-editor-accordion">
					<h3><?php _e("Simple Editor:",REVSLIDER_TEXTDOMAIN)?></h3>
					<div class="css_editor_novice_wrap">
						<table style="border-spacing:0px">
							<tr class="css-edit-enable"><td colspan="4"><input class="css_edit_novice" type="checkbox" name="css_allow" /> <?php _e("enable ",REVSLIDER_TEXTDOMAIN) ?> <span id="css_editor_allow"></span></td></tr>
							<!--<tr class="css-edit-enable css-edit-title topborder"><td colspan="4"></td></tr>-->
							<tr class="css-edit-title"><td colspan="4">Font</td></tr>
							<tr class="css-edit-title noborder"><td colspan="4"></td></tr>														
							<tr>
								<td><?php _e("Family:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<input class="css_edit_novice" style="width:160px; line-height:17px;margin-top:3px;" id="font_family" type="text" name="css_font-family" value="" />
									<div id="font_family_down" class="ui-state-default ui-corner-all" style="margin-right:0px"><span class="ui-icon ui-icon-arrowthick-1-s"></span></div>
								</td>
								<td><?php _e("Size:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<div id='font-size-slider'></div>
									<input class="css_edit_novice" type="hidden" name="css_font-size" value="" disabled="disabled" />
								</td>
							</tr>
							<tr>
								<td><?php _e("Color:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td><input type="text" name="css_color" data-linkto="color" style="width:160px" class="inputColorPicker css_edit_novice w100" value="" /></td>
								
								<td><?php _e("Line-Height:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<div id='line-height-slider'></div>
									<input class="css_edit_novice" type="hidden" name="css_line-height" value="" disabled="disabled" />
								</td>
							</tr>
							<tr>
								<td><?php _e("Padding:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<div class="sub_main_wrapper">
										<div class="subslider_wrapper"><input class="css_edit_novice pad-input sub-input" type="text" name="css_padding[]" value="" /></div>
										<div class="subslider_wrapper"><input class="css_edit_novice pad-input sub-input" type="text" name="css_padding[]" value="" /></div>
										<div class="subslider_wrapper"><input class="css_edit_novice pad-input sub-input" type="text" name="css_padding[]" value="" /></div>
										<div class="subslider_wrapper"><input class="css_edit_novice pad-input sub-input" type="text" name="css_padding[]" value="" /></div>
										<div style="clear:both"></div>
									</div>
								</td>
								<td><?php _e("Weight:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<div id='font-weight-slider'></div>
									<input class="css_edit_novice" type="hidden" name="css_font-weight" value="" disabled="disabled" />
								</td>
							</tr>
							<tr>
								<td><?php _e("Style:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td><input type="checkbox" name="css_font-style" class="css_edit_novice" /> <?php _e("italic",REVSLIDER_TEXTDOMAIN) ?></td>
								
								<td><?php _e("Decoration:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<select class="css_edit_novice w100" style="cursor:pointer" name="css_text-decoration">
										<option value="none">none</option>
										<option value="underline">underline</option>
										<option value="overline">overline</option>
										<option value="line-through">line-through</option>
									</select>
								</td>
							</tr>
							<tr class="css-edit-title noborder"><td colspan="4"></td></tr>							
							<tr class="css-edit-title"><td colspan="4">Background</td></tr>
							<tr class="css-edit-title noborder"><td colspan="4"></td></tr>														
							<tr>
								<td><?php _e("Color:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<input type="text" name="css_background-color" style="width:160px;float:left" data-linkto="background-color" class="inputColorPicker css_edit_novice" value="" />
									<a href="javascript:void(0);" id="reset-background-color"><i class="revicon-ccw editoricon" style="float:left"></i></a>
								</td>
								<td><?php _e("Transparency:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<div id='background-transparency-slider'></div>
									<input class="css_edit_novice" type="hidden" name="css_background-transparency" value="" disabled="disabled" />
								</td>
							</tr>
							<tr class="css-edit-title noborder"><td colspan="4"></td></tr>							
							<tr class="css-edit-title"><td colspan="4">Border</td></tr>
							<tr class="css-edit-title noborder"><td colspan="4"></td></tr>														
							<tr>
								<td><?php _e("Color:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<input type="text" name="css_border-color-show" data-linkto="border-color" style="width:160px;float:left" class="inputColorPicker css_edit_novice" value="" />
									<input type="hidden" name="css_border-color" class="css_edit_novice" value="" disabled="disabled" />
									<a href="javascript:void(0);" id="reset-border-color"><i class="revicon-ccw editoricon" style="float:left"></i></a>
								</td>
								<td><?php _e("Width:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<div id='border-width-slider'></div>
									<input class="css_edit_novice" type="hidden" name="css_border-width" value="" disabled="disabled" />
								</td>
							</tr>
							<tr>
								<td><?php _e("Style:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<select class="css_edit_novice w100" style="cursor:pointer" name="css_border-style">
										<option value="none">none</option>
										<option value="dotted">dotted</option>
										<option value="dashed">dashed</option>
										<option value="solid">solid</option>
										<option value="double">double</option>
									</select>
								</td>
								<td><?php _e("Radius:",REVSLIDER_TEXTDOMAIN) ?></td>
								<td>
									<div class="sub_main_wrapper">										
										<div class="subslider_wrapper"><input class="css_edit_novice corn-input sub-input" type="text" name="css_border-radius[]" value="" /><div class="subslider"></div></div>
										<div class="subslider_wrapper"><input class="css_edit_novice corn-input sub-input" type="text" name="css_border-radius[]" value="" /><div class="subslider"></div></div>
										<div class="subslider_wrapper"><input class="css_edit_novice corn-input sub-input" type="text" name="css_border-radius[]" value="" /><div class="subslider"></div></div>
										<div class="subslider_wrapper"><input class="css_edit_novice corn-input sub-input" type="text" name="css_border-radius[]" value="" /><div class="subslider"></div></div>
										<div style="clear:both"></div>
									</div>
								</td>
							</tr>
							<tr class="css-edit-title noborder"><td colspan="4"></td></tr>							
						</table>
						<div class="css_editor-disable-inputs">&nbsp;</div>
					</div>
					<h3 class="notopradius" style="margin-top:20px"><?php _e("Advanced Editor:",REVSLIDER_TEXTDOMAIN)?></h3>
					<div>
						<textarea id="textarea_edit_expert" rows="20" cols="81"></textarea>
					</div>
				</div>
			</div>
			
			<div id="dialog-change-css" title="<?php _e("Save Styles",REVSLIDER_TEXTDOMAIN) ?>" style="display:none;">
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 50px 0;"></span><?php
				_e('Overwrite the current selected class ',REVSLIDER_TEXTDOMAIN);
				echo '"<span id="current-class-handle"></span>"';
				_e(' or save the styles as a new class?',REVSLIDER_TEXTDOMAIN)?></p>
			</div>
			
			<div id="dialog-change-css-save-as" title="<?php _e("Save As",REVSLIDER_TEXTDOMAIN) ?>" style="display:none;">
				<p>
					<?php _e('Save as class:',REVSLIDER_TEXTDOMAIN)?><br />
					<input type="text" name="css_save_as" value="" />
				</p>
			</div>
			
			<?php
		}
		
		
		/**
		 * 
		 * draw css editor
		 */
		public function drawGlobalCssEditor(){
			?>
			<div id="css_static_editor_wrap" title="<?php _e("Global Style Editor",REVSLIDER_TEXTDOMAIN) ?>" style="display:none;">
				<div id="css-static-accordion">
					<h3><?php _e("Dynamic Styles (Not Editable):",REVSLIDER_TEXTDOMAIN)?></h3>
					<div class="css_editor_novice_wrap">
						<textarea id="textarea_show_dynamic_styles" rows="20" cols="81"></textarea>
					</div>
					<h3 class="notopradius" style="margin-top:20px"><?php _e("Static Styles:",REVSLIDER_TEXTDOMAIN)?></h3>
					<div>
						<textarea id="textarea_edit_static" rows="20" cols="81"></textarea>
					</div>
				</div>
			</div>
			
			<div id="dialog-change-css-static" title="<?php _e("Save Static Styles",REVSLIDER_TEXTDOMAIN) ?>" style="display:none;">
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 50px 0;"></span><?php _e('Overwrite current static styles?',REVSLIDER_TEXTDOMAIN)?></p>
			</div>
			<?php
		}
	}
?>