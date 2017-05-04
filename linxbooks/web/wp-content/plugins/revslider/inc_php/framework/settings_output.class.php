<?php

	class UniteSettingsOutputRev{
		
		protected $arrSettings = array(); 
		protected $settings;
		protected $formID;
		
		
		/**
		 * 
		 * init the output settings
		 */
		public function init(UniteSettingsRev $settings){
			$this->settings = new UniteSettingsRev();
			$this->settings = $settings;
		}
		
		
		/**
		 * 
		 * draw order box
		 * @param $setting
		 */
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

		/**
		 * 
		 * draw includes of the settings.
		 */
		public function drawHeaderIncludes(){
			
			$arrSections = $this->settings->getArrSections();
			$arrControls = $this->settings->getArrControls();
			
			$formID = $this->formID;
			
			$arrOnReady = array();
			$arrJs = array();
			
			//$arrJs[] = "obj.jsonSettingTypes = '$jsonString'";
			//$arrJs[] = "obj.objSettingTypes = JSON.parse(obj.jsonSettingTypes);";
			
			//put sections vars
			/*
			if(!empty($arrSections)){
				$arrJs[] = "obj.sectionsEnabled = true;";
				$arrJs[] = "obj.numSections = ".count($arrSections).";";
			}
			else 
				$arrJs[] = "obj.sectionsEnabled = false;";
			*/			
			
			//put the settings into form id
			
			$arrJs[] = "g_settingsObj['$formID'] = {}";
			
			//put controls json object:
			if(!empty($arrControls)){
				$strControls = json_encode($arrControls);
				$arrJs[] = "g_settingsObj['$formID'].jsonControls = '".$strControls."'";
				$arrJs[] = "g_settingsObj['$formID'].controls = JSON.parse(g_settingsObj['$formID'].jsonControls);";
			}
						
			/*
			//put types onready function
			$arrTypes = $this->getArrTypes();			
			//put script includes:
			foreach($arrTypes as $type){
				switch($type){
					case UniteSettingsRev::TYPE_ORDERBOX:
						$arrOnReady[] = "$(function() { $( '.orderbox' ).sortable();}); ";
					break;
					case UniteSettingsRev::TYPE_ORDERBOX_ADVANCED:
						$arrOnReady[] = "init_advanced_orderbox();";
					break; 				
				}
			}
			*/		
			//put js vars and onready func.
			
			echo "<script type='text/javascript'>\n";
				
			//put js 
			foreach($arrJs as $line){
				echo $line."\n";
			}
				
			if(!empty($arrOnReady)):
				//put onready
				echo "$(document).ready(function(){\n";
				foreach($arrOnReady as $line){
					echo $line."\n";
				}				
				echo "});";
			endif;
			echo "\n</script>\n";
			
		}
		
		
		//-----------------------------------------------------------------------------------------------
		// draw after body additional settings accesories
		public function drawAfterBody(){
			$arrTypes = $this->settings->getArrTypes();
			foreach($arrTypes as $type){
				switch($type){
					case self::TYPE_COLOR:
						?>
							<div id='divPickerWrapper' style='position:absolute;display:none;'><div id='divColorPicker'></div></div>
						<?php
					break;
				}
			}
		}
				
		
		/**
		 * 
		 * do some operation before drawing the settings.
		 */
		protected function prepareToDraw(){
			
			$this->settings->setSettingsStateByControls();
			
		}
		
		
	}

?>