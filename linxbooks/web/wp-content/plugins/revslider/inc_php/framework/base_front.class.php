<?php

	class UniteBaseFrontClassRev extends UniteBaseClassRev{		
		
		const ACTION_ENQUEUE_SCRIPTS = "wp_enqueue_scripts";
		
		/**
		 * 
		 * main constructor		 
		 */
		public function __construct($mainFile,$t){
			
			parent::__construct($mainFile,$t);
			
			self::addAction(self::ACTION_ENQUEUE_SCRIPTS, "onAddScripts");
		}	
		
	}
?>