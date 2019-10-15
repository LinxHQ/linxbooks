<style type="text/css" media="screen">
	#LbTalentEmployeeCourses_lb_create_date{
		width: 128px !important;
	}
	#LbTalentEmployeeCourses_lb_end_date{
		width: 128px !important;
	}
</style>
<div id="lb-container-header">
	<?php 
		$talent_need_arr = LbTalentNeed::model()->findAll('lb_record_primary_key IN ('.$id_need.')');
	?>
    <div class="lb-header-right">
    	<h3><?php echo $talent_need_arr[0]['lb_talent_name']; ?></h3>
    	
    	
    </div>
    <div class="lb-header-left lb-header-left-traning">
        <a href="<?php echo $this->createUrl('/lbTalent/default/index'); ?>" class="btn"><i class="icon-arrow-left"></i> Back</a>
    </div>
</div>
<br>
<select name="" id="change_status_need" onchange="change_status_need(<?php echo $id_need; ?>);">
	<option value="">Select Status</option>
	<option value="0">In-Progress</option>
	<option value="1">Completed</option>
</select>
Status Need : <?php 
	if($talent_need_arr[0]['lb_talent_status_id'] > 0){
		echo "Completed";
	} else {
		echo "In-Progress";
	}
; ?>

<br>
<table class="table table-hover table-bordered" width="50%">
	<tbody>
		<tr>
			<th>Skills</th>
			<th>#</th>
		</tr>
		<?php
			$skill_ass_talent_need_arr = LbTalentNeedSkills::model()->findAll('lb_talent_need_id IN ('.$id_need.')');
			foreach ($skill_ass_talent_need_arr as $result_skill_ass_talent_need_arr) {
				$skill_id = $result_skill_ass_talent_need_arr['lb_skill_id'];
				$skill_name = LbTalentSkills::model()->getSkillName($skill_id);
				$skill_level = UserList::model()->getTermName('level_talent', $skill_name->lb_level_id);
				$skill_level_name = "";
				foreach($skill_level as $result_skill_level){
					if($result_skill_level['system_list_item_name'])
						$skill_level_name .= "(".$result_skill_level['system_list_item_name'].")";
				}
				echo "
					<tr>
						<td>".$skill_name->lb_skill_name." ".$skill_level_name."</td>
						<td><i onclick='delete_skill_need(".$result_skill_ass_talent_need_arr['lb_record_primary_key'].", ".$id_need.");' style='cursor: pointer;' class='icon-trash'></i></td>
					</tr>
				";
				foreach($skill_name as $result_skill_name){
					
				}
			}
		?>
		<tr>
			<?php $form=$this->beginWidget('CActiveForm', array(
			    'id'=>'ass_skill_training_need',
			    'enableAjaxValidation'=>false,
			)); ?>
			<td>
				<?php 
                    $skill_arr = LbTalentCourses::model()->getSkillsParent();
                    echo $form->dropDownList($model,'lb_skill_name',$skill_arr,array('rows'=>6)); 
                ?>
                <?php echo $form->error($model,'lb_record_primary_key'); ?>
			</td>
			<td>
				<?php
				    LBApplicationUI::submitButton('Save', array(
				        'htmlOptions'=>array(
				            'onclick'=>'return validation()',
				            'style'=>'margin-left: auto; margin-right: auto; background:#fff,',
				        ),
				    ));
				?>
			</td>
			<?php $this->endWidget(); ?>
		</tr>
		
	</tbody>
</table>
<br>
<?php 
	echo '<div id="show_opportunities">';
		$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_show_employee_need',
            'itemsCssClass' => 'table-bordered items',
            'dataProvider'=>  $model_employee_need_search->search($id_need),
            'template' => "{items}\n{pager}\n{summary}", 
            'columns'=>array(
              array(
                  'header'=>Yii::t('lang','Employee'),
                  'type'=>'raw',
                  'value'=>function($data){
                  	$infoEmployee = LbEmployee::model()->findByPk($data->lb_employee_id);
                    return "<a href=".$this->createUrl('/lbTalent/default/profileUser/employee_id/'.$data->lb_employee_id.'/'.'need_id/'.$data->lb_talent_need_id.'').">".$infoEmployee->employee_name."</a>";

                  },
                  'htmlOptions'=>array('width'=>'70','height'=>'30px'),
              ),
              array(
                  'header'=>Yii::t('lang','Available Skills'),
                  'type'=>'raw',
                  'value'=>function($data){
                    $available_skill_arr = LbTalentEmployeeCourses::model()->getAvailableSkillsEmlpyee($data->lb_employee_id, 1);
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
                  },
                  'htmlOptions'=>array('width'=>'160','height'=>'30px'),
              ),
              array(
                  'header'=>Yii::t('lang','Course'),
                  'type'=>'raw',
                  'value'=>function($data){
                  	$course_name = LbTalentCourses::model()->findByPk($data->lb_course_id);
                  	$skill_level = UserList::model()->getTermName('level_talent', $course_name->lb_level_id);
					$skill_level_name = "";
					foreach($skill_level as $result_skill_level){
						if($result_skill_level['system_list_item_name'])
							$skill_level_name .= "(".$result_skill_level['system_list_item_name'].")";
					}
                    return $course_name->lb_course_name." ".$skill_level_name;
                  },
                  'htmlOptions'=>array('width'=>'130','height'=>'30px'),
              ),
              array(
                  'header'=>Yii::t('lang','Start Date'),
                  'type'=>'raw',
                  'value'=>'date("d/m/Y", strtotime($data->lb_create_date))',
                  'htmlOptions'=>array('width'=>'80','height'=>'30px'),
              ),
              array(
                  'header'=>Yii::t('lang','End Date'),
                  'type'=>'raw',
                  'value'=>'date("d/m/Y", strtotime($data->lb_end_date))',
                  'htmlOptions'=>array('width'=>'80','height'=>'30px'),
              ),
              array(
                  'header'=>Yii::t('lang','Result'),
                  'type'=>'raw',
                  'value'=>function($data){
                  		$this->widget('editable.EditableField', array(
					        'type'      => 'select',
					        'model'     => $data,
					        'attribute' => 'lb_result_course',
					        'url'       => $this->createUrl('default/updateResultCourse'), 
					        'source'    => UserList::model()->getItemsListCodeById('result', true),
					        'placement' => 'right',
					    ));
                  },
                  'htmlOptions'=>array('width'=>'80','height'=>'30px'),
              ),
              array(
                  'header'=>Yii::t('lang',''),
                  'type'=>'raw',
                  'value'=>function($data){
                    return '<i onclick="delete_ass_employee_need('.$data->lb_record_primary_key.');" style="cursor: pointer;" class="icon-trash"></i>';
                  },
                  'htmlOptions'=>array('width'=>'10','height'=>'30px'),
              ),
            )
        ));
echo '</div>';
?>
<table class="table table-hover table-bordered">
	<tbody>
		<tr>
			<?php $form=$this->beginWidget('CActiveForm', array(
			    'id'=>'need-assignment-employee',
			    'enableAjaxValidation'=>false,
			)); ?>
			<td>

				<?php 
                    $list_employee = LbEmployee::model()->findAll();
                    $employee_arr = array();
                    foreach($list_employee as $result_list_employee){
                        $employee_arr[$result_list_employee['lb_record_primary_key']] = $result_list_employee['employee_name'];
                    }
                    echo $form->dropDownList($model_employee_need,'lb_employee_id',$employee_arr,array('empty' => Yii::t('lang','Choose Employee'))); 
                ?>
                <?php echo $form->error($model_employee_need,'lb_employee_id'); ?>
			</td>
			<td>
				<div id="load_skill_exists_employee"></div>
			</td>
			<td>
				<?php 
                    $list_course = LbTalentCourses::model()->findAll();
                    $course_arr = array();
                    foreach($list_course as $result_list_course){
                    	$skill_level = UserList::model()->getTermName('level_talent', $result_list_course['lb_level_id']);
						$skill_level_name = "";
						foreach($skill_level as $result_skill_level){
							if($result_skill_level['system_list_item_name'])
								$skill_level_name .= "(".$result_skill_level['system_list_item_name'].")";
						}
                        $course_arr[$result_list_course['lb_record_primary_key']] = $result_list_course['lb_course_name'].$skill_level_name;
                    }
                    echo $form->dropDownList($model_employee_need,'lb_course_id',$course_arr,array()); 
                    // echo $form->dropDownList($model,'lb_record_primary_key',$course_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose Course'))); 
                ?>
                <?php echo $form->error($model_employee_need,'lb_course_id'); ?>
			</td>
			<td>
				
				<?php echo $form->textField($model_employee_need,'lb_create_date',array('value'=>date('d-m-Y'),'size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model_employee_need,'lb_create_date'); ?>
			</td>
			<td>
				<?php echo $form->textField($model_employee_need,'lb_end_date',array('value'=>date('d-m-Y'),'size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model_employee_need,'lb_end_date'); ?>
			</td>
			<td>
				<?php
				    LBApplicationUI::submitButton('Save', array(
				        'htmlOptions'=>array(
				            'onclick'=>'return validation()',
				            'style'=>'width: 78px; margin-left: auto; margin-right: auto; background:#fff,',
				        ),
				    ));
				?>
			</td>
			<?php $this->endWidget(); ?>
		</tr>
	</tbody>
</table>

<script type="text/javascript">
	var start_date = $("#LbTalentEmployeeCourses_lb_create_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        start_date.hide();
    }).data('datepicker');

    var end_date = $("#LbTalentEmployeeCourses_lb_end_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        end_date.hide();
    }).data('datepicker');
    $('#LbTalentEmployeeCourses_lb_employee_id').change(function() {
	     // alert($(this).val()); //will work here
	     var employee_id = $(this).val();
	     $("#load_skill_exists_employee").load("<?php echo $this->createUrl('/lbTalent/default/loadSkillEmployee'); ?>",{employee_id:employee_id});
	});
	function delete_skill_need(skill_need_id, id_need){
		if (confirm('Are you sure to delete this record?')) {
			$.ajax({
		        type:"POST", 
		        url:"<?php echo $this->createUrl('/lbTalent/default/deleteSkillNeed'); ?>",
		        data: {skill_need_id:skill_need_id, id_need:id_need},
		        success:function(data){
		            window.location.href = "<?php echo Yii::app()->baseUrl ?>/index.php/lbTalent/default/training/id/<?php echo $id_need ?>";
		        }
	        });
		}
	}

	function delete_ass_employee_need(talent_employee_course_id){
		if (confirm('Are you sure to delete this record?')) {
			$.ajax({
		        type:"POST", 
		        url:"<?php echo $this->createUrl('/lbTalent/default/deleteAssEmployeeNeed'); ?>",
		        data: {talent_employee_course_id:talent_employee_course_id},
		        success:function(data){
		            window.location.href = "<?php echo Yii::app()->baseUrl ?>/index.php/lbTalent/default/training/id/<?php echo $id_need ?>";
		        }
	        });
		}
	}

	function change_status_need(id_need){
		var change_status_need_id = $("#change_status_need").val();
		$.ajax({
	        type:"POST", 
	        url:"<?php echo $this->createUrl('/lbTalent/default/updateStatusNeed'); ?>",
	        data: {id_need:id_need, change_status_need_id:change_status_need_id},
	        success:function(data){
	            window.location.href = "<?php echo Yii::app()->baseUrl ?>/index.php/lbTalent/default/training/id/<?php echo $id_need ?>";
	        }
        });
	}
</script>
