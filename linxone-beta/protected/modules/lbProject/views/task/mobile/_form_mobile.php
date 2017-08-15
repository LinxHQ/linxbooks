<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form CActiveForm */
/* @var project_id project id */

$form = $this->beginWidget('CActiveForm', array(
	'id'=>'task-form',
	'htmlOptions' => array('class'=>'well','onsubmit'=>'return compileData();' ,'data-ajax'=>'false'),
	'enableAjaxValidation'=>false,
	'action' => array('task/create', 'project_id' => $project_id),
));
?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->hiddenField($model,'project_id', array('value' => $project_id)); ?>
	
	<?php echo $form->labelEx($model, 'task_name')?>
	<?php echo $form->textField($model,'task_name'); ?>
	
	<?php echo $form->labelEx($model,'task_description'); ?>
	<?php echo $form->textArea($model, 'task_description'); ?>

	<?php echo $form->labelEx($model,'task_assignees'); ?>
	<?php 
	$project_members = ProjectMember::model()->getProjectMembers($project_id, true);
	foreach ($project_members as $pm)
	{
		echo '<input type="checkbox" 
			id="project_member_'.$pm->account_id.'"
			name="project_member[]" '.(Yii::app()->user->id==$pm->account_id? 'checked="checked" ' : ' ').'"
			onchange="" value="'.$pm->account_id .'"/>';
		echo '<label for="project_member_'.$pm->account_id.'">'.
			AccountProfile::model()->getShortFullName($pm->account_id).'</label>';
	}
	echo $form->hiddenField($model, 'task_assignees');
	?>
	
	<?php 
	echo CHtml::submitButton('Create Task');
	?>
	</div>

<?php $this->endWidget(); ?>
<script language="javascript">
	function compileData()
	{
		// get selected assignees
		var selected_members = '';
		$('input[type=checkbox]').each(function () {
	    	if (this.checked && $(this).attr('name')=='project_member[]') {
	        	//console.log($(this).val()); 
	        	selected_members += $(this).val() + ',';
	        }
		});
		$('#Task_task_assignees').val(selected_members);

		return true;
	}
</script>