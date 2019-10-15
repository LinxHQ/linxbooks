<!-- $employee_id; -->
<?php
	$infoEmployee = LbEmployee::model()->findByPk($employee_id);
 ?>

<div id="lb-container-header">
    <div class="lb-header-right"><h3>Competency Profile</h3></div>
    <div class="lb-header-left lb-header-left-training-profile">
        <a href="<?php echo $this->createUrl('/lbTalent/default/training/id/'.$need_id.''); ?>" class="btn"><i class="icon-arrow-left"></i> Back</a>
    </div>
</div><br>
<div class="accordion" id="accordion1">
<div class="accordion-group">
		<div class="accordion-heading lb_accordion_heading">
			<a class="accordion-toggle lb_accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#form-new-availableSkills-basic-info-collapse">
        		<?php echo YII::t('lang','Infomation'); ?>
	    	</a>
	    </div>
	    <div id="form-new-availableSkills-basic-info-collapse" class="accordion-body collapse in">
  			<div class="accordion-inner">
  				<table>
				    <tbody>
				        <tr>
				            <td>
				                <a href="#" data-toggle="tooltip"><img width="100" data-toggle="tooltip" src="<?php echo Yii::app()->baseUrl ?>/images/lincoln-default-profile-pic.png" class="img-circle"></a>
				            </td>
				            <td>
				            	<p></p>
				                <p>&nbsp;&nbsp; <?php echo $infoEmployee->employee_name ?></p>
				                <p>&nbsp;&nbsp; <?php echo $infoEmployee->employee_email_1 ?></p>
				                <p>&nbsp;&nbsp; <?php echo $infoEmployee->employee_address ?></p>
				            </td>
				        </tr>
				    </tbody>
				</table>
  			</div>
      	</div>
	</div>
</div>
<div class="accordion" id="accordion2">
	<div class="accordion-group">
		<div class="accordion-heading lb_accordion_heading">
			<a class="accordion-toggle lb_accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#form-new-availableCourses-basic-info-collapse">
        		<?php echo YII::t('lang','Available Courses'); ?>
	    	</a>
	    </div>
	    <div id="form-new-availableCourses-basic-info-collapse" class="accordion-body collapse in">
  			<div class="accordion-inner">
  				<table class="table table-hover ">
					<thead>
						<tr>
							<th>Courses</th>
							<th>End Date</th>
							<th>Result</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$available_skill_arr = LbTalentEmployeeCourses::model()->getAvailableSkillsEmlpyee($employee_id, 1);
							foreach ($available_skill_arr as $result_available_skill_arr) {
								$course_id = $result_available_skill_arr['lb_course_id'];
								$course_arr = LbTalentCourses::model()->findAll('lb_record_primary_key IN ('.$course_id.')');
								foreach ($course_arr as $result_course_arr) {
									$skill_level = UserList::model()->getTermName('level_talent', $result_course_arr['lb_level_id']);
									$skill_level_name = "";
									foreach($skill_level as $result_skill_level){
										if($result_skill_level['system_list_item_name'])
											$skill_level_name .= "(".$result_skill_level['system_list_item_name'].")";
									}

									$result_arr = UserList::model()->getItemsListCodeById('result', true);
									$result_name = "";
									foreach ($result_arr as $key => $value) {
										if($result_available_skill_arr['lb_result_course'] == $key){
											$result_name .= $value;
										}
									}
									echo "<tr>
											<td>".$result_course_arr['lb_course_name']." ".$skill_level_name."</td>
											<td>".date("d/m/Y", strtotime($result_available_skill_arr['lb_end_date']))."</td>
											<td>".$result_name."</td>
										</tr>
									";
								}
							}
						?>
					</tbody>
				</table>
  			</div>
      	</div>
	</div>
</div>

<div class="accordion" id="accordion3">

<div class="accordion-group">
		<div class="accordion-heading lb_accordion_heading">
			<a class="accordion-toggle lb_accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#form-new-availableSkills-basic-info-collapse">
        		<?php echo YII::t('lang','Available Skills'); ?>
	    	</a>
	    </div>
	    <div id="form-new-availableSkills-basic-info-collapse" class="accordion-body collapse in">
  			<div class="accordion-inner">
  				<table class="table table-hover ">
					<thead>
						<tr>
							<th>Skills</th>
							<th>End Date</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							// $available_skill_arr = LbTalentEmployeeCourses::model()->getAvailableSkillsEmlpyee($employee_id, 1);
							// foreach ($available_skill_arr as $result_available_skill_arr) {
							// 	$course_id = $result_available_skill_arr['lb_course_id'];
							// 	$skill_name = LbTalentCourseSkills::model()->getSkillIdByCourse($course_id);
							// 	echo "
							// 		<tr>
							// 			<td>".$skill_name."</td>
							// 			<td>".date("d/m/Y", strtotime($result_available_skill_arr['lb_end_date']))."</td>
							// 		</tr>
							// 	";
							// }
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
										echo "
											<tr>
												<td>".$result_get_info_skill['lb_skill_name']." ".$skill_level_name." , </td>
												<td>".date("d/m/Y", strtotime($result_available_skill_arr['lb_end_date']))."</td>
											</tr>
										";
					        		}
					        	}
					        }
						?>
						
					</tbody>
				</table>
  			</div>
      	</div>
	</div>
</div>

<div class="accordion" id="accordion4">

<div class="accordion-group">
		<div class="accordion-heading lb_accordion_heading">
			<a class="accordion-toggle lb_accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#form-new-availableSkills-basic-info-collapse">
        		<?php echo YII::t('lang','Acquiring skills'); ?>
	    	</a>
	    </div>
	    <div id="form-new-availableSkills-basic-info-collapse" class="accordion-body collapse in">
  			<div class="accordion-inner">
  				<table class="table table-hover ">
					<thead>
						<tr>
							<th>Skills</th>
							<th>End Date</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							// $available_skill_arr = LbTalentEmployeeCourses::model()->getAvailableSkillsEmlpyee($employee_id, 0);
							// foreach ($available_skill_arr as $result_available_skill_arr) {
							// 	$course_id = $result_available_skill_arr['lb_course_id'];
							// 	$skill_name = LbTalentCourseSkills::model()->getSkillIdByCourse($course_id);
							// 	echo "
							// 		<tr>
							// 			<td>".$skill_name."</td>
							// 			<td>".date("d/m/Y", strtotime($result_available_skill_arr['lb_end_date']))."</td>
							// 		</tr>
							// 	";
							// }
						$available_skill_arr = LbTalentEmployeeCourses::model()->getAvailableSkillsEmlpyee($employee_id, 0);
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
										echo "
											<tr>
												<td>".$result_get_info_skill['lb_skill_name']." ".$skill_level_name." , </td>
												<td>".date("d/m/Y", strtotime($result_available_skill_arr['lb_end_date']))."</td>
											</tr>
										";
					        		}
					        	}
					        }
						?>
					</tbody>
				</table>
  			</div>
      	</div>
	</div>
</div>

