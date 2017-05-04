<?php

	class UniteElementsBaseRev{
		
		protected $db;
		
		public function __construct(){
			
			$this->db = new UniteDBRev();
		}
		
	}

?>