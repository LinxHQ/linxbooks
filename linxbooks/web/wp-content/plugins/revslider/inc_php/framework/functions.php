<?php
	//---------------------------------------------------------------------------------------------------------------------	
	
	if(!function_exists("dmp")){
		function dmp($str){
			echo "<div align='left'>";
			echo "<pre>";
			print_r($str);
			echo "</pre>";
			echo "</div>";
		}
	}
	

	
	
?>