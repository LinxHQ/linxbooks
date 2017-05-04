<?php

	/**
	 * 
	 * get / update params in db
	 *
	 */

	class RevSliderParams extends UniteElementsBaseRev{
		
		
		/**
		 * 
		 * update settign in db
		 */		
		public function updateFieldInDB($name,$value){
			
			$arr = $this->db->fetch(GlobalsRevSlider::$table_settings);
			if(empty($arr)){	//insert to db
				$arrInsert = array();
				$arrInsert["general"] = "";
				$arrInsert["params"] = "";
				$arrInsert[$name] = $value;
				
				$this->db->insert(GlobalsRevSlider::$table_settings,$arrInsert);
			}else{	//update db
				$arrUpdate = array();
				$arrUpdate[$name] = $value;
				
				$id = $arr[0]["id"];
				$this->db->update(GlobalsRevSlider::$table_settings,$arrUpdate,array("id"=>$id));
			}
		}
		
		
		/**
		 * 
		 * get field from db
		 */
		public function getFieldFromDB($name){
			
			$arr = $this->db->fetch(GlobalsRevSlider::$table_settings);
						
			if(empty($arr))
				return("");
				
			
			$arr = $arr[0];
			
			if(array_key_exists($name, $arr) == false)
				UniteFunctionsRev::throwError("The settings db should cotnain field: $name");
			
			$value = $arr[$name];
			return($value);
		}
		
		
	}

?>