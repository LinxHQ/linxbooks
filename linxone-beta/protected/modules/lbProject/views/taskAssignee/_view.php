<?php
/* @var $this TaskAssigneeController */
/* @var $data TaskAssignee */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_assignee_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->task_assignee_id), array('view', 'id'=>$data->task_assignee_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_id')); ?>:</b>
	<?php echo CHtml::encode($data->task_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_assignee_start_date')); ?>:</b>
	<?php echo CHtml::encode($data->task_assignee_start_date); ?>
	<br />


</div>