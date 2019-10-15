<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/select2.min.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/select2.min.js"></script>
<div id="create_training_course">
	<a href="#" onclick="load_div_create();"><?php echo Yii::t('lang','Create Course') ?></a> <br><br>
	<div id="form_create_training_course" hidden>
		<?php $form=$this->beginWidget('CActiveForm', array(
		    'id'=>'form_create_training_course',
		    'enableAjaxValidation'=>false,
		)); ?>
		<table>
			<tbody>
				<tr>
					<td><?php echo $form->labelEx($model,'lb_course_name'); ?></td>
					<td>
						<?php echo $form->textField($model,'lb_course_name',array('size'=>60,'maxlength'=>255)); ?>
                		<?php echo $form->error($model,'lb_course_name'); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model_c_skills,'lb_skill_id'); ?></td>
					<td>
						<?php
							$skill = LbTalentSkills::model()->search();
					        $arr_skill = array();
					        foreach($skill->data as $result_skill){
					            $arr_skill[$result_skill['lb_record_primary_key']] = $result_skill['lb_skill_name'];
					        }
					        echo Select2::multiSelect("lb_skill_id", '', $arr_skill, 
					            array(
					                'required' => 'required',
					                'select2Options' => array(
					                  'placeholder' => 'Select skills',
					                  // 'maximumSelectionSize' => 4,
					                ),
					            )
					        );
						 ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model,'lb_level_id'); ?></td>
					<td>
						<?php 
		                    $level_arr = UserList::model()->getItemsListCodeById('level_talent', true);
		                    echo $form->dropDownList($model,'lb_level_id',$level_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose Level'))); 
		                ?>
		                <?php echo $form->error($model,'lb_level_id'); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
		    LBApplicationUI::submitButton(Yii::t('lang','Save'), array(
		        'htmlOptions'=>array(
		            'onclick'=>'return validation()',
		            'style'=>'margin-left: auto; margin-right: auto; background:#fff,',
		        ),
		    ));
		?>
		<?php $this->endWidget(); ?>
	</div>
</div>
<br><br><br><br>
<?php 
	echo '<div id="show_course" style="margin-top: -50px;">';
	$this->widget('bootstrap.widgets.TbGridView', array(
	    'id' => 'lb_show_course',
	    'itemsCssClass' => 'table-bordered items',
	    'dataProvider' => $model->search(),
	    // 'filter' => $model,
	    'columns'=>array(
	        array(
	           'class' => 'editable.EditableColumn',
	           'name' => 'lb_course_name',
	           'headerHtmlOptions' => array('style' => 'width: 110px'),
	           'editable' => array(    //editable section
                  'url'        => $this->createUrl('default/updateCourse'),
                  'placement'  => 'right',
              )               
	        ),
	        array(
	                'header'=>Yii::t('lang','Skills'),
	                'type'=>'raw',
	                'value'=>function($data,$row) use (&$model_skill){
	                	$skill_course = LbTalentCourseSkills::model()->findAll('lb_talent_course_id IN ('.$data->lb_record_primary_key.')');

	                	foreach($skill_course as $result_skill_course){
					   		$skill_name = LbTalentSkills::model()->getSkillName($result_skill_course['lb_skill_id']);
					   		echo $skill_name->lb_skill_name." , ";
					   		// foreach($skill_name as $result_skill_name){
					   		// 	echo "<pre>";
					   		// 	print_r($result_skill_name);
					   		// 	// echo $result_skill_name->attributes['lb_skill_name'].", ";
					   		// }
					   }
                  	    
			        },
	                'htmlOptions'=>array('width'=>'50'),
	              ),
	        array( 
					'class' => 'editable.EditableColumn',
					'name'  => 'lb_create_date',
					'headerHtmlOptions' => array('style' => 'width: 100px'),
					'editable' => array(
						'type'          => 'date',
						'viewformat'    => 'dd/mm/yyyy',
						'url'           => $this->createUrl('default/updateCourse'),
						'placement'     => 'right',
					)
	         	),
	        array(
                  'header'=>"<a href='#'>".Yii::t('lang','Level')."</a>",
                  'type'=>'raw',
                  'value'=>function($data){
                  		$this->widget('editable.EditableField', array(
					        'type'      => 'select',
					        'model'     => $data,
					        'attribute' => 'lb_level_id',
					        'url'      => $this->createUrl('default/updateCourse'), 
					        'source'   => $this->createUrl('default/getLevel'),
					        'placement' => 'right',
					    ));
                  },
                  'htmlOptions'=>array('width'=>'80','height'=>'30px'),
              ),
	        // array( 
	        //       'class' => 'editable.EditableColumn',
	        //       'name' => 'lb_level_id',
	        //       'headerHtmlOptions' => array('style' => 'width: 100px'),
	        //       'editable' => array(
	        //           'type'     => 'select',
	        //           'url'      => $this->createUrl('default/updateCourse'),
	        //           'source'   => $this->createUrl('default/getLevel'),
	        //           'options'  => array(    //custom display 
	        //              'display' => 'js: function(value, sourceData) {
	        //                   var selected = $.grep(sourceData, function(o){ return value == o.value; }),
	        //                       colors = {1: "green", 2: "blue", 3: "red", 4: "gray"};
	        //                   $(this).text(selected[0].text).css("color", colors[value]);    
	        //               }'
	        //           ),
	        //          'onSave' => 'js: function(e, params) {
	        //               console && console.log("saved value: "+params.newValue);
	        //          }',
	        //       )
	        //  ),
	        array(
	            'header'=>Yii::t('lang',''),
	            'type'=>'raw',
	            'value'=>function($data){
	                $delete = '<a onclick="delete_course('.$data->lb_record_primary_key.');" href="#"><i class="icon-trash"></i></a>';
	                return $delete;
	            },
	            'htmlOptions'=>array('width'=>'20'),
	        ),
	    )
	)); 
	// $this->Widget('bootstrap.widgets.TbGridView',array(
	//             'id'=>'lb_show_course',
	//             // 'type' => TbHtml::GRID_TYPE_BORDERED,
	//             'dataProvider'=>  $model->search(),
	//             'template' => "{items}\n{pager}\n{summary}", 
	//             'columns'=>array(
	//               array(
	//                   'header'=>Yii::t('lang','Course Name'),
	//                   'type'=>'raw',
	//                   'value'=>function($data){
	//                     return $data->lb_course_name;
	//                   },
	//               ),
	//               array(
	//                   'header'=>Yii::t('lang','Skills'),
	//                   'type'=>'raw',
	//                   'value'=>function($data){
	//                     	$skill_id = LbTalentCourseSkills::model()->getSkillIdByCourse($data->lb_record_primary_key);
	//                     	return $skill_id;
	//                   	},
	//               ),
	//               array(
	//                   'header'=>Yii::t('lang','Created Date'),
	//                   'type'=>'raw',
	//                   'value'=>function($data){
	//                     return date("d/m/Y", strtotime($data->lb_create_date));
	//                   },
	//               ),
	//               array(
	//                   'header'=>Yii::t('lang','Level'),
	//                   'type'=>'raw',
	//                   'value'=>function($data){
	//                   	$level_arr = UserList::model()->getItemsListCodeById('level_talent', true);
	//                   	foreach ($level_arr as $key => $value) {
	//                   		if ($key == intval($data->lb_level_id))
 //                                return $value;
	//                   	}
	                    
	//                   },
	//               ),
	//               array(
	//                   'header'=>Yii::t('lang',''),
	//                   'type'=>'raw',
	//                   'value'=>function($data){
	//                     $update = '<a onclick="load_form_edit_course('.$data->lb_record_primary_key.');" href="#"><i class="icon-pencil"></i></a>';
	//                     $delete = '<a onclick="delete_course('.$data->lb_record_primary_key.');" href="#"><i class="icon-trash"></i></a>';
	//                     return $update.'&nbsp;&nbsp;'.$delete;
	//                   },
	//               ),
	//             )
	//         ));
	echo '</div>';
?>
<div id="my-modal-base_course">
	<div id="my-modal-cont_course"></div>
</div>

<script type="text/javascript">
	function load_div_create() {
		$("#form_create_training_course").toggle(500);
	}

	function delete_course(course_id){
		if (confirm('Are you sure to delete this record?')) {
			$.ajax({
		        type:"POST",
		        url:"deleteCourse", 
		        data: {course_id:course_id},
		        success:function(data){
		            window.location.href = "<?php echo Yii::app()->baseUrl ?>/index.php/lbTalent/default/config";
		        }
	        });
		}
	}
</script>