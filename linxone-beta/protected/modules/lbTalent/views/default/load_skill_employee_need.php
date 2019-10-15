<?php 
	if($employee_id != ""){
		$available_skill_arr = LbTalentEmployeeCourses::model()->getAvailableSkillsEmlpyee($employee_id, 1);
        foreach($available_skill_arr as $result_available_skill_arr) {
        	$get_skill_course = LbTalentCourseSkills::model()->findAll('lb_talent_course_id IN ('.$result_available_skill_arr->lb_course_id.')');
        	foreach ($get_skill_course as $result_get_skill_course) {
        		$skill_id = $result_get_skill_course['lb_skill_id'];
        		$get_info_skill = LbTalentSkills::model()->findAll('lb_record_primary_key IN ('.$skill_id.')');
        		foreach($get_info_skill as $result_get_info_skill){
        			$skill_level = UserList::model()->getTermName('level_talent', $result_get_info_skill['lb_level_id']);
        			$skill_level_name = "";
					foreach($skill_level as $result_skill_level){
						if($result_skill_level['system_list_item_name'])
							$skill_level_name .= "(".$result_skill_level['system_list_item_name'].")";
					}
					echo $result_get_info_skill['lb_skill_name']." ".$skill_level_name." , ";
        		}
        	}
        }
	} else {
		echo "";
	}
?>