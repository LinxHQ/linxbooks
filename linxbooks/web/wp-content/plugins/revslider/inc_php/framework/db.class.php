<?php
	
	class UniteDBRev{
		
		private $lastRowID;
		
		/**
		 * 
		 * constructor - set database object
		 */
		public function __construct(){
		}
		
		/**
		 * 
		 * throw error
		 */
		private function throwError($message,$code=-1){
			UniteFunctionsRev::throwError($message,$code);
		}
		
		//------------------------------------------------------------
		// validate for errors
		private function checkForErrors($prefix = ""){
			global $wpdb;
			
			if($wpdb->last_error !== ''){
				$query = $wpdb->last_query;
				$message = $wpdb->last_error;
				
				if($prefix) $message = $prefix.' - <b>'.$message.'</b>';
				if($query) $message .=  '<br>---<br> Query: ' . $query;
				
				$this->throwError($message);
			}
		}
		
		
		/**
		 * 
		 * insert variables to some table
		 */
		public function insert($table,$arrItems){
			global $wpdb;
			
			$wpdb->insert($table, $arrItems);
			$this->checkForErrors("Insert query error");
			
			$this->lastRowID = $wpdb->insert_id;
			
			return($this->lastRowID);
		}
		
		/**
		 * 
		 * get last insert id
		 */
		public function getLastInsertID(){
			global $wpdb;
			
			$this->lastRowID = $wpdb->insert_id;
			return($this->lastRowID);			
		}
		
		
		/**
		 * 
		 * delete rows
		 */
		public function delete($table,$where){
			global $wpdb;
			
			UniteFunctionsRev::validateNotEmpty($table,"table name");
			UniteFunctionsRev::validateNotEmpty($where,"where");
			
			$query = "delete from $table where $where";
			
			$wpdb->query($query);
			
			$this->checkForErrors("Delete query error");
		}
		
		
		/**
		 * 
		 * run some sql query
		 */
		public function runSql($query){
			global $wpdb;
			
			$wpdb->query($query);			
			$this->checkForErrors("Regular query error");
		}
		
		
		/**
		 * 
		 * insert variables to some table
		 */
		public function update($table,$arrItems,$where){
			global $wpdb;
			
			$response = $wpdb->update($table, $arrItems, $where);
			//if($response === false)
			//	UniteFunctionsRev::throwError("no update action taken!");
			
			$this->checkForErrors("Update query error");
			
			return($wpdb->num_rows);
		}
		
		
		/**
		 * 
		 * get data array from the database
		 * 
		 */
		public function fetch($tableName,$where="",$orderField="",$groupByField="",$sqlAddon=""){
			global $wpdb;
			
			$query = "select * from $tableName";
			if($where) $query .= " where $where";
			if($orderField) $query .= " order by $orderField";
			if($groupByField) $query .= " group by $groupByField";
			if($sqlAddon) $query .= " ".$sqlAddon;
			
			$response = $wpdb->get_results($query,ARRAY_A);
			
			$this->checkForErrors("fetch");
			
			return($response);
		}
		
		/**
		 * 
		 * fetch only one item. if not found - throw error
		 */
		public function fetchSingle($tableName,$where="",$orderField="",$groupByField="",$sqlAddon=""){
			$response = $this->fetch($tableName, $where, $orderField, $groupByField, $sqlAddon);
			if(empty($response))
				$this->throwError("Record not found");
			$record = $response[0];
			return($record);
		}
		
		/**
		 * 
		 * escape data to avoid sql errors and injections.
		 */
		public function escape($string){
			$string = esc_sql($string);
			return($string);
		}
		
	}
	
?>