<?php

	class RevSliderSettingsProduct extends UniteSettingsRevProductRev{
		
		
		/**
		 * 
		 * set custom values to settings
		 */
		public static function setSettingsCustomValues(UniteSettingsRev $settings, $arrValues, $postTypesWithCats){
			$arrSettings = $settings->getArrSettings();
			
			foreach($arrSettings as $key=>$setting){
				$type = UniteFunctionsRev::getVal($setting, "type");
				if($type != UniteSettingsRev::TYPE_CUSTOM)
					continue;
				$customType = UniteFunctionsRev::getVal($setting, "custom_type");
				
				switch($customType){
					case "slider_size":
						$setting["width"] = UniteFunctionsRev::getVal($arrValues, "width",UniteFunctionsRev::getVal($setting,"width"));
						$setting["height"] = UniteFunctionsRev::getVal($arrValues, "height",UniteFunctionsRev::getVal($setting,"height"));
						$arrSettings[$key] = $setting;
					break;
					case "responsitive_settings":						
						$id = $setting["id"];
						$setting["w1"] = UniteFunctionsRev::getVal($arrValues, $id."_w1",UniteFunctionsRev::getVal($setting,"w1"));
						$setting["w2"] = UniteFunctionsRev::getVal($arrValues, $id."_w2",UniteFunctionsRev::getVal($setting,"w2"));
						$setting["w3"] = UniteFunctionsRev::getVal($arrValues, $id."_w3",UniteFunctionsRev::getVal($setting,"w3"));
						$setting["w4"] = UniteFunctionsRev::getVal($arrValues, $id."_w4",UniteFunctionsRev::getVal($setting,"w4"));
						$setting["w5"] = UniteFunctionsRev::getVal($arrValues, $id."_w5",UniteFunctionsRev::getVal($setting,"w5"));
						$setting["w6"] = UniteFunctionsRev::getVal($arrValues, $id."_w6",UniteFunctionsRev::getVal($setting,"w6"));
						
						$setting["sw1"] = UniteFunctionsRev::getVal($arrValues, $id."_sw1",UniteFunctionsRev::getVal($setting,"sw1"));
						$setting["sw2"] = UniteFunctionsRev::getVal($arrValues, $id."_sw2",UniteFunctionsRev::getVal($setting,"sw2"));
						$setting["sw3"] = UniteFunctionsRev::getVal($arrValues, $id."_sw3",UniteFunctionsRev::getVal($setting,"sw3"));
						$setting["sw4"] = UniteFunctionsRev::getVal($arrValues, $id."_sw4",UniteFunctionsRev::getVal($setting,"sw4"));
						$setting["sw5"] = UniteFunctionsRev::getVal($arrValues, $id."_sw5",UniteFunctionsRev::getVal($setting,"sw5"));
						$setting["sw6"] = UniteFunctionsRev::getVal($arrValues, $id."_sw6",UniteFunctionsRev::getVal($setting,"sw6"));
						$arrSettings[$key] = $setting;				
					break;
				}
			}
			
			$settings->setArrSettings($arrSettings);
			
			//disable settings by slider type:
			$sliderType = $settings->getSettingValue("slider_type");
			
			switch($sliderType){
				case "fixed":
				case "fullwidth":
				case "fullscreen":
					//hide responsive
					$settingRes = $settings->getSettingByName("responsitive");
					$settingRes["disabled"] = true;
					$settings->updateArrSettingByName("responsitive", $settingRes);
				break;
			}
			
			switch($sliderType){
				case "fixed":
				case "responsitive":
				case "fullscreen":
					//hide autoheight
					$settingRes = $settings->getSettingByName("auto_height");
					$settingRes["disabled"] = true;
					$settings->updateArrSettingByName("auto_height", $settingRes);
					
					$settingRes = $settings->getSettingByName("force_full_width");
					$settingRes["disabled"] = true;
					$settings->updateArrSettingByName("force_full_width", $settingRes);
				break;
			}
			//change height to max height
			$settingSize = $settings->getSettingByName("slider_size");
			$settingSize["slider_type"] = $sliderType;
			$settings->updateArrSettingByName("slider_size", $settingSize);

			$settings = self::setCategoryByPostTypes($settings, $arrValues, $postTypesWithCats, "post_types", "post_category","post");
			
			return($settings);
		}
		
		
		
		/**
		 * 
		 * draw responsitive settings value
		 */
		protected function drawResponsitiveSettings($setting){
			$id = $setting["id"];
			
			$w1 = UniteFunctionsRev::getVal($setting, "w1");
			$w2 = UniteFunctionsRev::getVal($setting, "w2");
			$w3 = UniteFunctionsRev::getVal($setting, "w3");
			$w4 = UniteFunctionsRev::getVal($setting, "w4");
			$w5 = UniteFunctionsRev::getVal($setting, "w5");
			$w6 = UniteFunctionsRev::getVal($setting, "w6");
			
			$sw1 = UniteFunctionsRev::getVal($setting, "sw1");
			$sw2 = UniteFunctionsRev::getVal($setting, "sw2");
			$sw3 = UniteFunctionsRev::getVal($setting, "sw3");
			$sw4 = UniteFunctionsRev::getVal($setting, "sw4");
			$sw5 = UniteFunctionsRev::getVal($setting, "sw5");
			$sw6 = UniteFunctionsRev::getVal($setting, "sw6");
			
			$disabled = (UniteFunctionsRev::getVal($setting, "disabled") == true);
			
			$strDisabled = "";
			if($disabled == true)
				$strDisabled = "disabled='disabled'";
			
			?>
			<table>
				<tr>
					<td>
						<?php _e("Screen Width",REVSLIDER_TEXTDOMAIN)?>1:
					</td>
					<td>
						<input id="<?php echo $id?>_w1" name="<?php echo $id?>_w1" type="text" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $w1?>">
					</td>
					<td>
						<?php _e("Slider Width",REVSLIDER_TEXTDOMAIN)?>1: 
					</td>
					<td>
						<input id="<?php echo $id?>_sw1" name="<?php echo $id?>_sw1" type="text" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $sw1?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php _e("Screen Width",REVSLIDER_TEXTDOMAIN)?>2: 
					</td>
					<td>
						<input id="<?php echo $id?>_w2" name="<?php echo $id?>_w2" type="text" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $w2?>">
					</td>
					<td>
						<?php _e("Slider Width",REVSLIDER_TEXTDOMAIN)?>2: 
					</td>
					<td>
						<input id="<?php echo $id?>_sw2" name="<?php echo $id?>_sw2" type="text" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $sw2?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php _e("Screen Width",REVSLIDER_TEXTDOMAIN)?>3: 
					</td>
					<td>
						<input id="<?php echo $id?>_w3" name="<?php echo $id?>_w3" type="text" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $w3?>">
					</td>
					<td>
						<?php _e("Slider Width",REVSLIDER_TEXTDOMAIN)?>3:
					</td>
					<td>
						<input id="<?php echo $id?>_sw3" name="<?php echo $id?>_sw3" type="text" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $sw3?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php _e("Screen Width",REVSLIDER_TEXTDOMAIN)?>4: 
					</td>
					<td>
						<input type="text" id="<?php echo $id?>_w4" name="<?php echo $id?>_w4" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $w4?>">
					</td>
					<td>
						<?php _e("Slider Width",REVSLIDER_TEXTDOMAIN)?>4: 
					</td>
					<td>
						<input type="text" id="<?php echo $id?>_sw4" name="<?php echo $id?>_sw4" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $sw4?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php _e("Screen Width",REVSLIDER_TEXTDOMAIN)?>5:
					</td>
					<td>
						<input type="text" id="<?php echo $id?>_w5" name="<?php echo $id?>_w5" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $w5?>">
					</td>
					<td>
						<?php _e("Slider Width",REVSLIDER_TEXTDOMAIN)?>5:
					</td>
					<td>
						<input type="text" id="<?php echo $id?>_sw5" name="<?php echo $id?>_sw5" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $sw5?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php _e("Screen Width",REVSLIDER_TEXTDOMAIN)?>6:
					</td>
					<td>
						<input type="text" id="<?php echo $id?>_w6" name="<?php echo $id?>_w6" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $w6?>">
					</td>
					<td>
						<?php _e("Slider Width",REVSLIDER_TEXTDOMAIN)?>6:
					</td>
					<td>
						<input type="text" id="<?php echo $id?>_sw6" name="<?php echo $id?>_sw6" class="textbox-small" <?php echo $strDisabled?> value="<?php echo $sw6?>">
					</td>
				</tr>				
								
			</table>
			<?php
		}
		
		
		/**
		 * 
		 * draw slider size
		 */
		protected function drawSliderSize($setting){
			
			$width = UniteFunctionsRev::getVal($setting, "width");
			$height = UniteFunctionsRev::getVal($setting, "height");
			
			$sliderType = UniteFunctionsRev::getVal($setting, "slider_type");
			
			$textNormalW = __("Grid Width:",REVSLIDER_TEXTDOMAIN);
			$textNormalH = __("Grid Height:",REVSLIDER_TEXTDOMAIN);
			
			$textFullWidthW = __("Grid Width:",REVSLIDER_TEXTDOMAIN);
			$textFullWidthH = __("Grid Height:",REVSLIDER_TEXTDOMAIN);
			
			$textFullScreenW = __("Grid Width:",REVSLIDER_TEXTDOMAIN);
			$textFullScreenH = __("Grid Height:",REVSLIDER_TEXTDOMAIN);
			
			//set default text (fixed, responsive) 
			switch($sliderType){
				default:
					$textDefaultW = $textNormalW;
					$textDefaultH = $textNormalH;
				break;
				case "fullwidth":
					$textDefaultW = $textFullWidthW;
					$textDefaultH = $textFullWidthH;
				break;
				case "fullscreen":
					$textDefaultW = $textFullScreenW;
					$textDefaultH = $textFullScreenH;
				break;
			}
			
			?>
			
			<table>
				<tr>
					<td id="cellWidth" data-textnormal="<?php echo $textNormalW?>" data-textfull="<?php echo $textFullWidthW?>" data-textscreen="<?php echo $textFullScreenW?>">
						<?php echo $textDefaultW ?>
					</td>
					<td id="cellWidthInput">
						<input id="width" name="width" type="text" class="textbox-small" value="<?php echo $width?>">
					</td>
					<td id="cellHeight" data-textnormal="<?php echo $textNormalH?>" data-textfull="<?php echo $textFullWidthH?>" data-textscreen="<?php echo $textFullScreenH?>">
						<?php echo $textDefaultH ?> 
					</td>
					<td>
						<input id="height" name="height" type="text" class="textbox-small" value="<?php echo $height?>">
					</td>
				</tr>
			</table>
			
			<?php 
		}
		
		
		/**
		 * 
		 * draw custom inputs for rev slider
		 * @param $setting
		 */
		protected function drawCustomInputs($setting){
			
			$customType = UniteFunctionsRev::getVal($setting, "custom_type");
			switch($customType){
				case "slider_size":
					$this->drawSliderSize($setting);
				break;
				case "responsitive_settings":
					$this->drawResponsitiveSettings($setting);
				break;
				default:
					UniteFunctionsRev::throwError("No handler function for type: $customType");
				break;
			}			
		}
		
		
		/**
		 * 
		 * get first category from categories list
		 */
		private static function getFirstCategory($cats){
						
			foreach($cats as $key=>$value){
				if(strpos($key,"option_disabled") === false)
					return($key);
			}
			return("");
		}		
		
		
		/**
		 * set category by post type, with specific name (can be regular or woocommerce)
		 */
		public static function setCategoryByPostTypes(UniteSettingsRev $settings,$arrValues, $postTypesWithCats,$nameType,$nameCat,$defaultType){
			
			//update the categories list by the post types
			$postTypes = UniteFunctionsRev::getVal($arrValues, $nameType ,$defaultType);
			if(strpos($postTypes, ",") !== false)
				$postTypes = explode(",",$postTypes);
			else
				$postTypes = array($postTypes);
			
			$arrCats = array();
			$globalCounter = 0;	
			
			$arrCats = array();
			$isFirst = true;
			foreach($postTypes as $postType){
				$cats = UniteFunctionsRev::getVal($postTypesWithCats, $postType,array());
				if($isFirst == true){
					$firstValue = self::getFirstCategory($cats);
					$isFirst = false; 
				}
					
				$arrCats = array_merge($arrCats,$cats);
			}
			
			$settingCategory = $settings->getSettingByName($nameCat);
			$settingCategory["items"] = $arrCats;
			$settings->updateArrSettingByName($nameCat, $settingCategory);

			//update value to first category
			$value = $settings->getSettingValue($nameCat);
			if(empty($value)){
				
				$settings->updateSettingValue($nameCat, $firstValue);
			}
			
			return($settings);
		}
		
		
	}

?>