<?php

/**
 * 
 * unite settings class.
 * @version 1.1
 *
 */

	class UniteSettingsRev{
		
		const COLOR_OUTPUT_FLASH = "flash";
		const COLOR_OUTPUT_HTML = "html";
		
		//------------------------------------------------------------
		
		const RELATED_NONE = "";
		const TYPE_TEXT = "text";
		const TYPE_COLOR = "color";
		const TYPE_DATE = "date";
		const TYPE_SELECT = "list";
		const TYPE_CHECKBOX = "checkbox";
		const TYPE_RADIO = "radio";
		const TYPE_TEXTAREA = "textarea";
		const TYPE_STATIC_TEXT = "statictext";
		const TYPE_HR = "hr";
		const TYPE_CUSTOM = "custom";
		const ID_PREFIX = "";
		const TYPE_CONTROL = "control";
		const TYPE_BUTTON = "button";
		const TYPE_MULTIPLE_TEXT = "multitext";
		const TYPE_IMAGE = "image";
		const TYPE_CHECKLIST = "checklist";
		
		//------------------------------------------------------------
		//set data types  
		const DATATYPE_NUMBER = "number";
		const DATATYPE_NUMBEROREMTY = "number_empty";
		const DATATYPE_STRING = "string";
		const DATATYPE_FREE = "free";
		
		const CONTROL_TYPE_ENABLE = "enable";
		const CONTROL_TYPE_DISABLE = "disable";
		const CONTROL_TYPE_SHOW = "show";
		const CONTROL_TYPE_HIDE = "hide";
		
		//additional parameters that can be added to settings.
		const PARAM_TEXTSTYLE = "textStyle";		
		const PARAM_ADDPARAMS = "addparams";	//additional text after the field
		const PARAM_ADDTEXT = "addtext";	//additional text after the field
		const PARAM_ADDTEXT_BEFORE_ELEMENT = "addtext_before_element";	//additional text after the field
		const PARAM_CELLSTYLE = "cellStyle";	//additional text after the field
		
		//view defaults:
		protected $defaultText = "Enter value";
		protected $sap_size = 5;
		
		//other variables:
		protected $HRIdCounter = 0;	//counter of hr id
		
		protected $arrSettings = array();
		protected $arrSections = array();
		protected $arrIndex = array();	//index of name->index of the settings.
		protected $arrSaps = array();
		
		//controls:
		protected $arrControls = array();		//array of items that controlling others (hide/show or enabled/disabled) 
		protected $arrBulkControl = array();	//bulk cotnrol array. if not empty, every settings will be connected with control.
		 
		//custom functions:
		protected $customFunction_afterSections = null;
		protected $colorOutputType = self::COLOR_OUTPUT_HTML;
		
		//-----------------------------------------------------------------------------------------------
		// constructor
	    public function __construct(){
	    	
	    }
		
		//-----------------------------------------------------------------------------------------------
		// get where query according relatedTo and relatedID. 
		private function getWhereQuery(){
			$where = "relatedTo='".$this->relatedTo."' and relatedID='".$this->relatedID."'";
			return($where);
		}
		
		
		//-----------------------------------------------------------------------------------------------
		//set type of color output
		public function setColorOutputType($type){
			$this->colorOutputType = $type;
		}
		
		//-----------------------------------------------------------------------------------------------
		//set the related to/id for saving/restoring settings.
		public function setRelated($relatedTo,$relatedID){
			$this->relatedTo = $relatedTo;
			$this->relatedID = $relatedID;
		}
		
		
		//-----------------------------------------------------------------------------------------------
		//modify the data before save
		private function modifySettingsData($arrSettings){
			
			foreach($arrSettings as $key=>$content){
				switch(getType($content)){
					case "string":
						//replace the unicode line break (sometimes left after json)
						$content = str_replace("u000a","\n",$content);
						$content = str_replace("u000d","",$content);						
					break;
					case "object":
					case "array":
						$content = UniteFunctionsRev::convertStdClassToArray($content);
					break;					
				}
				
				$arrSettings[$key] = $content;												
			}
			
			return($arrSettings);
		}				
				
		//-----------------------------------------------------------------------------------------------
		// add the section value to the setting
		private function checkAndAddSectionAndSap($setting){
			//add section
			if(!empty($this->arrSections)){
				$sectionKey = count($this->arrSections)-1;
				$setting["section"] = $sectionKey;
				$section = $this->arrSections[$sectionKey];
				$sapKey = count($section["arrSaps"])-1;
				$setting["sap"] = $sapKey;
			}
			else{
				//please impliment add sap normal!!! - without sections
			}
			return($setting);
		}
		
		//-----------------------------------------------------------------------------------------------
		// validate items parameter. throw exception on error
		private function validateParamItems($arrParams){
			if(!isset($arrParams["items"])) throw new Exception("no select items presented");
			if(!is_array($arrParams["items"])) throw new Exception("the items parameter should be array");
			//if(empty($arrParams["items"])) throw new Exception("the items array should not be empty");			
		}
		

		//-----------------------------------------------------------------------------------------------
		//add this setting to index
		private function addSettingToIndex($name){
			$this->arrIndex[$name] = count($this->arrSettings)-1;
		}
		
		//-----------------------------------------------------------------------------------------------
		//get types array from all the settings:
		protected function getArrTypes(){
			$arrTypesAssoc = array();
			$arrTypes = array();
			foreach($this->arrSettings as $setting){	
				$type = $setting["type"];
				if(!isset($arrTypesAssoc[$type])) $arrTypes[] = $type;
				$arrTypesAssoc[$type] = "";				
			}			
			return($arrTypes);
		}
				

		/**
		 * 
		 * modify the values of settings array
		 */
		private function modifySettingsValues(){
			
		}
		
		
		/**
		 * 
		 * get settings array
		 */
		public function getArrSettings(){
			return($this->arrSettings);
		}
		
		
		/**
		 * 
		 * get the keys of the settings
		 */
		public function getArrSettingNames(){
			$arrKeys = array();
			$arrNames = array();
			foreach($this->arrSettings as $setting){
				$name = UniteFunctionsRev::getVal($setting, "name");
				if(!empty($name))
					$arrNames[] = $name;
			}
			
			return($arrNames);
		}

		/**
		 * 
		 * get the keys of the settings
		 */
		public function getArrSettingNamesAndTitles(){
			$arrKeys = array();
			$arrNames = array();
			foreach($this->arrSettings as $setting){
				$name = UniteFunctionsRev::getVal($setting, "name");
				$title = UniteFunctionsRev::getVal($setting, "text");
				if(!empty($name))
					$arrNames[$name] = $title;
			}
			
			return($arrNames);
		}
		
		
		/**
		 * 
		 * get sections
		 */
		public function getArrSections(){
			return($this->arrSections);
		}
		
		
		/**
		 * 
		 * get controls
		 */
		public function getArrControls(){
			return($this->arrControls);
		}

		
		/**
		 * 
		 * set settings array
		 */
		public function setArrSettings($arrSettings){
			$this->arrSettings = $arrSettings;
		}
		
		
		//-----------------------------------------------------------------------------------------------
		//get number of settings
		public function getNumSettings(){
			$counter = 0;
			foreach($this->arrSettings as $setting){
				switch($setting["type"]){
					case self::TYPE_HR:
					case self::TYPE_STATIC_TEXT:
					break;
					default:
						$counter++;
					break;
				}
			}
			return($counter);
		}
		
		//private function 
		//-----------------------------------------------------------------------------------------------
		// add radio group
		public function addRadio($name,$arrItems,$text = "",$defaultItem="",$arrParams = array()){
			$params = array("items"=>$arrItems);
			$params = array_merge($params,$arrParams);
			$this->add($name,$defaultItem,$text,self::TYPE_RADIO,$params);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add text area control
		public function addTextArea($name,$defaultValue,$text,$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_TEXTAREA,$arrParams);
		}

		//-----------------------------------------------------------------------------------------------
		//add button control
		public function addButton($name,$value,$arrParams = array()){
			$this->add($name,$value,"",self::TYPE_BUTTON,$arrParams);
		}
		
		
		//-----------------------------------------------------------------------------------------------
		// add checkbox element
		public function addCheckbox($name,$defaultValue = false,$text = "",$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_CHECKBOX,$arrParams);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add text box element
		public function addTextBox($name,$defaultValue = "",$text = "",$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_TEXT,$arrParams);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add multiple text box element
		public function addMultipleTextBox($name,$defaultValue = "",$text = "",$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_MULTIPLE_TEXT,$arrParams);
		}

		//-----------------------------------------------------------------------------------------------
		//add image selector
		public function addImage($name,$defaultValue = "",$text = "",$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_IMAGE,$arrParams);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add color picker setting
		public function addColorPicker($name,$defaultValue = "",$text = "",$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_COLOR,$arrParams);
		}
		//-----------------------------------------------------------------------------------------------
		//add date picker setting
		public function addDatePicker($name,$defaultValue = "",$text = "",$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_DATE,$arrParams);
		}
		//-----------------------------------------------------------------------------------------------
		//add date picker setting
		public function addCodemirror($name,$defaultValue = "",$text = "",$arrParams = array()){
			$this->add($name,$defaultValue,$text,'codemirror',$arrParams);
		}
		
		/**
		 * 
		 * add custom setting
		 */
		public function addCustom($customType,$name,$defaultValue = "",$text = "",$arrParams = array()){
			$params = array();
			$params["custom_type"] = $customType;
			$params = array_merge($params,$arrParams);
			
			$this->add($name,$defaultValue,$text,self::TYPE_CUSTOM,$params);
		}
		
		
		//-----------------------------------------------------------------------------------------------
		//add horezontal sap
		public function addHr($name="",$params=array()){
			$setting = array();
			$setting["type"] = self::TYPE_HR;
			
			//set item name
			$itemName = "";
			if($name != "") $itemName = $name;
			else{	//generate hr id
			  $this->HRIdCounter++;
			  $itemName = "hr".$this->HRIdCounter;
			}
			
			$setting["id"] = self::ID_PREFIX.$itemName;
			$setting["id_row"] = $setting["id"]."_row";
			
			//addsection and sap keys
			$setting = $this->checkAndAddSectionAndSap($setting);
			
			$this->checkAddBulkControl($itemName);
			
			$setting = array_merge($params,$setting);
			$this->arrSettings[] = $setting;
			
			//add to settings index
			$this->addSettingToIndex($itemName);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add static text
		public function addStaticText($text,$name="",$params=array()){
			$setting = array();
			$setting["type"] = self::TYPE_STATIC_TEXT;
			
			//set item name
			$itemName = "";
			if($name != "") $itemName = $name;
			else{	//generate hr id
			  $this->HRIdCounter++;
			  $itemName = "textitem".$this->HRIdCounter;
			}
			
			$setting["id"] = self::ID_PREFIX.$itemName;
			$setting["id_row"] = $setting["id"]."_row";
			$setting["text"] = $text;
			
			$this->checkAddBulkControl($itemName);
			
			$params = array_merge($params,$setting);
			
			//addsection and sap keys
			$setting = $this->checkAndAddSectionAndSap($setting);
			
			$this->arrSettings[] = $setting;
			
			//add to settings index
			$this->addSettingToIndex($itemName);
		}

		/**
		 * add select setting
		 */
		public function addSelect($name,$arrItems,$text,$defaultItem="",$arrParams=array()){
			$params = array("items"=>$arrItems);
			$params = array_merge($params,$arrParams);
			$this->add($name,$defaultItem,$text,self::TYPE_SELECT,$params);
		}
		
		
		/**
		 * add select setting
		 */
		public function addChecklist($name,$arrItems,$text,$defaultItem="",$arrParams=array()){
			$params = array("items"=>$arrItems);
			$params = array_merge($params,$arrParams);
			$this->add($name,$defaultItem,$text,self::TYPE_CHECKLIST,$params);
		}
		
		
		/**
		 * 
		 * add saporator
		 */
		public function addSap($text, $name="", $opened = false, $icon=""){
			
			if(empty($text))
				UniteFunctionsRev::throwError("sap $name must have a text");
			
			//create sap array
			$sap = array();
			$sap["name"] = $name; 
			$sap["text"] = $text; 
			$sap["icon"] = $icon;
			
			if($opened == true) $sap["opened"] = true;
			
			//add sap to current section
			if(!empty($this->arrSections)){
				$lastSection = end($this->arrSections);
				$section_keys = array_keys($this->arrSections);
				$lastSectionKey = end($section_keys);
				$arrSaps = $lastSection["arrSaps"];
				$arrSaps[] = $sap;
				$this->arrSections[$lastSectionKey]["arrSaps"] = $arrSaps; 				
				$sap_keys = array_keys($arrSaps);
				$sapKey = end($sap_keys);
			}
			else{
				$this->arrSaps[] = $sap;
			}
		}
		
		//-----------------------------------------------------------------------------------------------
		//get sap data:
		public function getSap($sapKey,$sectionKey=-1){
			//get sap without sections:
			if($sectionKey == -1) return($this->arrSaps[$sapKey]);
			if(!isset($this->arrSections[$sectionKey])) throw new Exception("Sap on section:".$sectionKey." doesn't exists");
			$arrSaps = $this->arrSections[$sectionKey]["arrSaps"];
			if(!isset($arrSaps[$sapKey])) throw new Exception("Sap with key:".$sapKey." doesn't exists");
			$sap = $arrSaps[$sapKey];
			return($sap);
		}
		
		//-----------------------------------------------------------------------------------------------
		// add a new section. Every settings from now on will be related to this section
		public function addSection($label,$name=""){
						
			if(!empty($this->arrSettings) && empty($this->arrSections))
				UniteFunctionsRev::throwError("You should add first section before begin to add settings. (section: $text)");
				
			if(empty($label)) 
				UniteFunctionsRev::throwError("You have some section without text");

			$arrSection = array(
				"text"=>$label,
				"arrSaps"=>array(),
				"name"=>$name
			);
			
			$this->arrSections[] = $arrSection;
		}
		
		//-----------------------------------------------------------------------------------------------
		//add setting, may be in different type, of values
		protected function add($name,$defaultValue = "",$text = "",$type = self::TYPE_TEXT,$arrParams = array()){
			
			//validation:
			if(empty($name)) throw new Exception("Every setting should have a name!");
			
			switch($type){
				case self::TYPE_RADIO:
				case self::TYPE_SELECT:
					$this->validateParamItems($arrParams);
				break;
				case self::TYPE_CHECKBOX:
					if(!is_bool($defaultValue)) throw new Exception("The checkbox value should be boolean");
				break;
			}
			
			//validate name:
			if(isset($this->arrIndex[$name])) throw new Exception("Duplicate setting name:".$name);
			
			$this->checkAddBulkControl($name);
						
			//set defaults:
			if($text == "") $text = $this->defaultText;
			
			$setting = array();
			$setting["name"] = $name;
			$setting["id"] = self::ID_PREFIX.$name;
			$setting["id_service"] = $setting["id"]."_service";
			$setting["id_row"] = $setting["id"]."_row";
			$setting["type"] = $type;
			$setting["text"] = $text;
			$setting["value"] = $defaultValue;
						
			
			$setting = array_merge($setting,$arrParams);
			
			//set datatype
			if(!isset($setting["datatype"])){
				$datatype = self::DATATYPE_STRING;
				switch ($type){
					case self::TYPE_TEXTAREA:
						$datatype = self::DATATYPE_FREE;
					break;
					default:
						$datatype = self::DATATYPE_STRING;
					break;
				}
				
				$setting["datatype"] = $datatype;
			}
			
			//addsection and sap keys
			$setting = $this->checkAndAddSectionAndSap($setting);
			
			$this->arrSettings[] = $setting;
			
			//add to settings index
			$this->addSettingToIndex($name);
		}
		
		
		//-----------------------------------------------------------------------------------------------
		//add a item that controlling visibility of enabled/disabled of other.
		public function addControl($control_item_name,$controlled_item_name,$control_type,$value){
			
			UniteFunctionsRev::validateNotEmpty($control_item_name,"control parent");
			UniteFunctionsRev::validateNotEmpty($controlled_item_name,"control child");
			UniteFunctionsRev::validateNotEmpty($control_type,"control type");
			UniteFunctionsRev::validateNotEmpty($value,"control value");
			
			$arrControl = array();
			if(isset($this->arrControls[$control_item_name]))
				 $arrControl = $this->arrControls[$control_item_name];
			$arrControl[] = array("name"=>$controlled_item_name,"type"=>$control_type,"value"=>$value);
			$this->arrControls[$control_item_name] = $arrControl;
		}
		
		//-----------------------------------------------------------------------------------------------
		//start control of all settings that comes after this function (between startBulkControl and endBulkControl)
		public function startBulkControl($control_item_name,$control_type,$value){
			$this->arrBulkControl = array("control_name"=>$control_item_name,"type"=>$control_type,"value"=>$value);
		}	
			
		//-----------------------------------------------------------------------------------------------
		//end bulk control
		public function endBulkControl(){
			$this->arrBulkControl = array();
		}
		
		//-----------------------------------------------------------------------------------------------
		//build name->(array index) of the settings. 
		private function buildArrSettingsIndex(){
			$this->arrIndex = array();
			foreach($this->arrSettings as $key=>$value)
				if(isset($value["name"])) $this->arrIndex[$value["name"]] = $key;
		}
		
		//-----------------------------------------------------------------------------------------------
		// set sattes of the settings (enabled/disabled, visible/invisible) by controls
		public function setSettingsStateByControls(){
			
			foreach($this->arrControls as $control_name => $arrControlled){
				//take the control value
				if(!isset($this->arrIndex[$control_name])) throw new Exception("There is not sutch control setting: '$control_name'");
				$index = $this->arrIndex[$control_name];
				$parentValue = strtolower($this->arrSettings[$index]["value"]);
				
				//set child (controlled) attributes
				foreach($arrControlled as $controlled){
					if(!isset($this->arrIndex[$controlled["name"]])) throw new Exception("There is not sutch controlled setting: '".$controlled["name"]."'");
					$indexChild = $this->arrIndex[$controlled["name"]];
					$child = $this->arrSettings[$indexChild];					
					$value = strtolower($controlled["value"]);
					switch($controlled["type"]){
						case self::CONTROL_TYPE_ENABLE:
							if($value != $parentValue) $child["disabled"] = true;
						break;
						case self::CONTROL_TYPE_DISABLE:
							if($value == $parentValue) $child["disabled"] = true;
						break;
						case self::CONTROL_TYPE_SHOW:
							if($value != $parentValue) $child["hidden"] = true;
						break;
						case self::CONTROL_TYPE_HIDE:
							if($value == $parentValue) $child["hidden"] = true;
						break;
					}
					$this->arrSettings[$indexChild] = $child;					
				}								
			}//end foreach
		}
		
		
		//-----------------------------------------------------------------------------------------------
		//check that bulk control is available , and add some element to it. 
		private function checkAddBulkControl($name){
			//add control
			if(!empty($this->arrBulkControl)) 
				$this->addControl($this->arrBulkControl["control_name"],$name,$this->arrBulkControl["type"],$this->arrBulkControl["value"]);			
		}
		
		//-----------------------------------------------------------------------------------------------
		//set custom function that will be run after sections will be drawen
		public function setCustomDrawFunction_afterSections($func){
			$this->customFunction_afterSections = $func;
		}
		
		
		/**
		 * 
		 * parse options from xml field
		 * @param $field
		 */
		private function getOptionsFromXMLField($field,$fieldName){
			$arrOptions = array();
			
			$arrField = (array)$field;
			$options = UniteFunctionsRev::getVal($arrField, "option");
			
			if(empty($options))
				return($arrOptions);
				
			foreach($options as $option){
				
				if(gettype($option) == "string")
					UniteFunctionsRev::throwError("Wrong options type: ".$option." in field: $fieldName");
				
				$attribs = $option->attributes();
				
				$optionValue = (string)UniteFunctionsRev::getVal($attribs, "value");							
				$optionText = (string)UniteFunctionsRev::getVal($attribs, "text");
				
				//validate options:
				UniteFunctionsRev::validateNotEmpty($optionValue,"option value");
				UniteFunctionsRev::validateNotEmpty($optionText,"option text");
				
				$arrOptions[$optionValue] = $optionText;				 
			}
			
			return($arrOptions);
		}
		
		
		/**
		 * 
		 * load settings from xml file
		 */
		public function loadXMLFile($filepath){
			
			if(!file_exists($filepath))
				UniteFunctionsRev::throwError("File: '$filepath' not exists!!!");
			
			$obj = simplexml_load_file($filepath);
			
			if(empty($obj))
				UniteFunctionsRev::throwError("Wrong xml file format: $filepath");
			
			$fieldsets = $obj->fieldset;
            if(!@count($obj->fieldset)){
                $fieldsets = array($fieldsets);
            }
			
			$this->addSection("Xml Settings");
			
			foreach($fieldsets as $fieldset){
				
				//Add Section
				$attribs = $fieldset->attributes();
				
				$sapName = (string)UniteFunctionsRev::getVal($attribs, "name");
				$sapLabel = (string)UniteFunctionsRev::getVal($attribs, "label");
				$sapIcon = (string)UniteFunctionsRev::getVal($attribs, "icon");				
				
				UniteFunctionsRev::validateNotEmpty($sapName,"sapName");
				UniteFunctionsRev::validateNotEmpty($sapLabel,"sapLabel");
				
				$this->addSap($sapLabel,$sapName,false,$sapIcon);
				
				//--- add fields
				$fieldset = (array)$fieldset;				
				$fields = $fieldset["field"];
								
				if(is_array($fields) == false)
					$fields = array($fields);
				
				foreach($fields as $field){
					$attribs = $field->attributes();
					$fieldType = (string)UniteFunctionsRev::getVal($attribs, "type");
					$fieldName = (string)UniteFunctionsRev::getVal($attribs, "name");
					$fieldLabel = (string)UniteFunctionsRev::getVal($attribs, "label");
					$fieldDefaultValue = (string)UniteFunctionsRev::getVal($attribs, "default");
					
					//all other params will be added to "params array".
					$arrMustParams = array("type","name","label","default"); 
					
					$arrParams = array();
					
					foreach($attribs as $key=>$value){
						$key = (string)$key;
						$value = (string)$value;
						
						//skip must params:
						if(in_array($key, $arrMustParams))
							continue;
							
						$arrParams[$key] = $value;
					}
					
					$options = $this->getOptionsFromXMLField($field,$fieldName);
					
					//validate must fields:
					UniteFunctionsRev::validateNotEmpty($fieldType,"type");
					
					//validate name
					if($fieldType != self::TYPE_HR && $fieldType != self::TYPE_CONTROL &&
						$fieldType != "bulk_control_start" && $fieldType != "bulk_control_end")
						UniteFunctionsRev::validateNotEmpty($fieldName,"name");		
					switch ($fieldType){
						case self::TYPE_CHECKBOX:
							$fieldDefaultValue = UniteFunctionsRev::strToBool($fieldDefaultValue);
							$this->addCheckbox($fieldName,$fieldDefaultValue,$fieldLabel,$arrParams);
						break;
						case self::TYPE_COLOR:
							$this->addColorPicker($fieldName,$fieldDefaultValue,$fieldLabel,$arrParams);
						break;
						case self::TYPE_HR:
							$this->addHr();
						break;
						case self::TYPE_TEXT:
							$this->addTextBox($fieldName,$fieldDefaultValue,$fieldLabel,$arrParams);
						break;
						case self::TYPE_MULTIPLE_TEXT:
							$this->addMultipleTextBox($fieldName,$fieldDefaultValue,$fieldLabel,$arrParams);
						break;
						case self::TYPE_STATIC_TEXT:
							$this->addStaticText($fieldLabel, $fieldName, $arrParams);
						break;
						case self::TYPE_IMAGE:
							$this->addImage($fieldName,$fieldDefaultValue,$fieldLabel,$arrParams);
						break;						
						case self::TYPE_SELECT:	
							$this->addSelect($fieldName, $options, $fieldLabel,$fieldDefaultValue,$arrParams);
						break;
						case self::TYPE_CHECKBOX:
							$this->addChecklist($fieldName, $options, $fieldLabel,$fieldDefaultValue,$arrParams);
						break;
						case self::TYPE_RADIO:
							$this->addRadio($fieldName, $options, $fieldLabel,$fieldDefaultValue,$arrParams);
						break;
						case self::TYPE_TEXTAREA:
							$this->addTextArea($fieldName, $fieldDefaultValue, $fieldLabel, $arrParams);
						break;
						case self::TYPE_CUSTOM:
							$this->add($fieldName, $fieldDefaultValue, $fieldLabel, self::TYPE_CUSTOM, $arrParams);
						break;
						case self::TYPE_BUTTON:
							$this->addButton($fieldName, $fieldDefaultValue, $arrParams);
						break;
						case self::TYPE_CONTROL:
							$parent = UniteFunctionsRev::getVal($arrParams, "parent");
							$child =  UniteFunctionsRev::getVal($arrParams, "child");
							$ctype =  UniteFunctionsRev::getVal($arrParams, "ctype");
							$value =  UniteFunctionsRev::getVal($arrParams, "value");
							$this->addControl($parent, $child, $ctype, $value);
						break;			
						case "bulk_control_start":
							$parent = UniteFunctionsRev::getVal($arrParams, "parent");
							$ctype =  UniteFunctionsRev::getVal($arrParams, "ctype");
							$value =  UniteFunctionsRev::getVal($arrParams, "value");
							
							$this->startBulkControl($parent, $ctype, $value);
						break;
						case "bulk_control_end":
							$this->endBulkControl();
						break;	
						case "codemirror":
							$this->addCodemirror($fieldName,$fieldDefaultValue,$fieldLabel,$arrParams);
						break;		
						default:
							UniteFunctionsRev::throwError("wrong type: $fieldType");
						break;						
					}
					
				}
			}
		}
		
		
		/**
		 * 
		 * get titles and descriptions array
		 */
		public function getArrTextFromAllSettings(){
			$arr = array();
			$arrUnits = array();
			
			//get saps array:
			foreach($this->arrSections as $section){
				$arrSaps = UniteFunctionsRev::getVal($section, "arrSaps");
				if(empty($arrSaps))
					continue;
				foreach($arrSaps as $sap){
					$text = $sap["text"];
					if(!empty($text))
						$arr[] = $text;
				}
			}
			
			foreach($this->arrSettings as $setting){
				
				$text = UniteFunctionsRev::getVal($setting, "text");				
				$desc = UniteFunctionsRev::getVal($setting, "description");
				$unit = UniteFunctionsRev::getVal($setting, "unit");
								
				if(!empty($text))
					$arr[] = $text;
					
				if(!empty($desc))
					$arr[] = $desc;
					
				if(!empty($unit)){
					if(!isset($arrUnits[$unit]))
						$arr[] = $unit;	
					$arrUnits[$unit] = true;
				}

				$items = UniteFunctionsRev::getVal($setting, "items");
				if(!empty($items)){
					foreach($items as $item){
						if(!isset($arrUnits[$item]))
							$arr[] = $item;	
						$arrUnits[$item] = true;
					}
				}				
			}
			
			return($arr);
		}

		
		/**
		 * 
		 * get setting array by name
		 */
		public function getSettingByName($name){
			
			//if index present
			if(!empty($this->arrIndex)){
				if(array_key_exists($name, $this->arrIndex) == false)
					UniteFunctionsRev::throwError("setting $name not found");
				$index = $this->arrIndex[$name];
				$setting = $this->arrSettings[$index];
				return($setting);
			}
			
			//if no index
			foreach($this->arrSettings as $setting){
				$settingName = UniteFunctionsRev::getVal($setting, "name");
				if($settingName == $name)
					return($setting);
			}
			
			UniteFunctionsRev::throwError("Setting with name: $name don't exists");
		}
		
		
		/**
		 * 
		 * get value of some setting
		 * @param $name
		 */
		public function getSettingValue($name,$default=""){
			$setting = $this->getSettingByName($name);
			$value = UniteFunctionsRev::getVal($setting, "value",$default);

			return($value);
		}
		
		
		/**
		 * 
		 * update setting array by name
		 */
		public function updateArrSettingByName($name,$setting){
			
			foreach($this->arrSettings as $key => $settingExisting){
				$settingName = UniteFunctionsRev::getVal($settingExisting,"name");
				if($settingName == $name){
					$this->arrSettings[$key] = $setting;
					return(false);
				}
			}
			
			UniteFunctionsRev::throwError("Setting with name: $name don't exists");
		}
		
		
		/**
		 * 
		 * update default value in the setting
		 */
		public function updateSettingValue($name,$value){
			$setting = $this->getSettingByName($name);
			$setting["value"] = $value;
			
			$this->updateArrSettingByName($name, $setting);
		}
		
		
		/**
		 * 
		 * modify some value by it's datatype
		 */
		public function modifyValueByDatatype($value,$datatype){
			if(is_array($value)){
				foreach($value as $key => $val){
					$value[$key] = $this->modifyValueByDatatypeFunc($val,$datatype);
				}
			}else{
				$value = $this->modifyValueByDatatypeFunc($value,$datatype);
			}
			return($value);
		}
		
		/**
		 * 
		 * modify some value by it's datatype
		 */
		public function modifyValueByDatatypeFunc($value,$datatype){
			switch($datatype){
				case self::DATATYPE_STRING:
					$value = strip_tags($value, '<link>');
				break;
				case self::DATATYPE_NUMBER:
					$value = floatval($value);	//turn every string to float
					if(!is_numeric($value))
						$value = 0;
				break;
				case self::DATATYPE_NUMBEROREMTY:
					$value = trim($value);
					if($value !== "")
						$value = floatval($value);	//turn every string to float
				break;
			}
			
			return $value;
		}
		
		/**
		 * 
		 * set values from array of stored settings elsewhere.
		 */
		public function setStoredValues($arrValues){
			
			foreach($this->arrSettings as $key=>$setting){
				
				$name = UniteFunctionsRev::getVal($setting, "name");
				
				//type consolidation
				$type = UniteFunctionsRev::getVal($setting, "type");
				
				$datatype = UniteFunctionsRev::getVal($setting, "datatype");
				
				//skip custom type
				$customType = UniteFunctionsRev::getVal($setting, "custom_type");
								
				if(!empty($customType))
					continue;
						
				if(array_key_exists($name, $arrValues)){
					$value = $arrValues[$name];
					$value = $this->modifyValueByDatatype($value, $datatype);					
					$this->arrSettings[$key]["value"] = $value;
					$arrValues[$name] = $value;
				}
				
			}//end foreach
			
			return($arrValues);
		}

		
		/**
		 * get setting values. replace from stored ones if given
		 */
		public function getArrValues(){
			
			$arrSettingsOutput = array();
			
			//modify settings by type
			foreach($this->arrSettings as $setting){
				if($setting["type"] == self::TYPE_HR 
				  ||$setting["type"] == self::TYPE_STATIC_TEXT)
					continue;
					
				$value = $setting["value"];
				
				//modify value by type
				switch($setting["type"]){
					case self::TYPE_COLOR:
							$value = strtolower($value);
							//set color output type 
							if($this->colorOutputType == self::COLOR_OUTPUT_FLASH)
								$value = str_replace("#","0x",$value);
					break;
					case self::TYPE_CHECKBOX:
						if($value == true) $value = "true";
						else $value = "false";
					break;
				}
				
				//remove lf
				if(isset($setting["remove_lf"])){
					$value = str_replace("\n","",$value);
					$value = str_replace("\r\n","",$value);
				}
				
				$arrSettingsOutput[$setting["name"]] = $value;
			}
			
			return($arrSettingsOutput);
		}

		
		/**
		* Update values from post meta
		 */
		public function updateValuesFromPostMeta($postID){

			//update setting values array from meta
			$arrNames = $this->getArrSettingNames();
			$arrValues = array();
			$arrMeta = get_post_meta($postID);

			if(!empty($arrMeta) && is_array($arrMeta)){
				foreach($arrNames as $name){
					if(array_key_exists($name, $arrMeta) == false)
						continue;
					
					$value = get_post_meta($postID, $name,true);
					$arrValues[$name] = $value;				
				}
			}
			
			//dmp($postID);dmp($arrValues);exit();
			
			$this->setStoredValues($arrValues);
			
		}
		
		
	}
	
?>