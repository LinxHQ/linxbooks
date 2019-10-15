<div id="create_training_course">
	<a href="#" onclick="load_div_create_skills();"><?php echo Yii::t('lang','Create Skill') ?></a> <br><br>
	<?php 
		$level_arr = UserList::model()->getItemsListCodeById('level_talent', true);
	 ?>
	<div id="form_create_skil" hidden>
		<?php $form=$this->beginWidget('CActiveForm', array(
		    'id'=>'form_create_skil',
		    'enableAjaxValidation'=>false,
		)); ?>
		<table>
			<tbody>
				<tr>
					<td><?php echo $form->labelEx($model,'lb_skill_name'); ?></td>
					<td>
						<?php echo $form->textField($model,'lb_skill_name',array('size'=>60,'maxlength'=>255)); ?>
                		<?php echo $form->error($model,'lb_skill_name'); ?>
					</td>
				</tr>

				<tr>
					<td><?php echo $form->labelEx($model,'lb_parent_id'); ?></td>
					<td>
						<?php 
		                    $skills_arr = LbTalentSkills::model()->findAll();
		                    $sk_arr = array();
		                    foreach($skills_arr as $result_skills_arr){
		                        $sk_arr[$result_skills_arr['lb_record_primary_key']] = $result_skills_arr['lb_skill_name'];
		                    }
		                    echo $form->dropDownList($model,'lb_parent_id',$sk_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose Parent'))); 
		                ?>
		                <?php echo $form->error($model,'lb_parent_id'); ?>
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
	echo '<div id="show_skills" style="margin-top: -50px;">';
	$this->widget('bootstrap.widgets.TbGridView', array(
	    'id' => 'lb_show_course',
	    'itemsCssClass' => 'table-bordered items',
	    'dataProvider' => $model->search(),
	    'columns'=>array(
	        array(
	           'class' => 'editable.EditableColumn',
	           'name' => 'lb_skill_name',
	           'headerHtmlOptions' => array('style' => 'width: 110px'),
	           'editable' => array(    //editable section
                  'url'        => $this->createUrl('default/updateSkill'),
                  'placement'  => 'right',
              )               
	        ),
	        array( 
					'class' => 'editable.EditableColumn',
					'name'  => 'lb_create_date',
					'headerHtmlOptions' => array('style' => 'width: 100px'),
					'editable' => array(
						'type'          => 'date',
						'viewformat'    => 'dd/mm/yyyy',
						'url'           => $this->createUrl('default/updateSkill'),
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
					        'url'           => $this->createUrl('default/updateSkill'), 
					        'source'   => $this->createUrl('default/getLevel'),
					        'placement' => 'right',
					    ));
                  },
                  'htmlOptions'=>array('width'=>'80','height'=>'30px'),
              ), 
	        array(
	              'header'=>Yii::t('lang',''),
	              'type'=>'raw',
	              'value'=>function($data){
	                $delete = '<a onclick="delete_skill('.$data->lb_record_primary_key.');" href="#"><i class="icon-trash"></i></a>';
	                return $delete;
	              },
	              'htmlOptions'=>array('width'=>'20'),
	        ),
	    )
	)); 
	// $this->Widget('bootstrap.widgets.TbGridView',array(
	//             'id'=>'lb_show_skills',
	//             // 'type' => TbHtml::GRID_TYPE_BORDERED,
	//             'dataProvider'=>  $model->search(),
	//             'template' => "{items}\n{pager}\n{summary}", 
	//             'columns'=>array(
	//               array(
	//                   'header'=>Yii::t('lang','Skill'),
	//                   'type'=>'raw',
	//                   // 'htmlOptions'=>array('style'=>'border: 1px'),
	//                   'value'=>function($data){
	//                     return $data->lb_skill_name;
	//                   },
	//               ),
	//               array(
	//                   'header'=>Yii::t('lang','Create Date'),
	//                   'type'=>'raw',
	//                   'value'=>function($data){
	//                     return $data->lb_create_date;
	//                   },
	//               ),
	//               array(
	//                   'header'=>Yii::t('lang',''),
	//                   'type'=>'raw',
	//                   'value'=>function($data){
	//                     $update = '<a href="#"><i class="icon-pencil"></i></a>';
	//                     $delete = '<a onclick="delete_skill('.$data->lb_record_primary_key.');" href="#"><i class="icon-trash"></i></a>';
	//                     return $update.'&nbsp;&nbsp;'.$delete;
	//                   },
	//               ),
	//             )
	//         ));
	echo '</div>';
 ?>

<script type="text/javascript">
	function load_div_create_skills() {
		$("#form_create_skil").toggle(500);
	}
	function delete_skill(skill_id){
		if (confirm('Are you sure to delete this record?')) {
			$.ajax({
		        type:"POST",
		        url:"deleteSkill", 
		        data: {skill_id:skill_id},
		        success:function(data){
		            window.location.href = "<?php echo Yii::app()->baseUrl ?>/index.php/lbTalent/default/config";
		        }
	        });
		}
	}
</script>