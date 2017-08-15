<?php
/* @var $this TaskController */
/* @var $data Task */
?>

<div class="view">

	<!--  b><?php //echo CHtml::encode($data->getAttributeLabel('task_id')); ?>:</b>
	<?php //echo CHtml::link(CHtml::encode($data->task_id), array('view', 'id'=>$data->task_id)); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('project_id')); ?>:</b>
	<?php //echo CHtml::encode($data->project_id); ?>
	<br /-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_name')); ?>:</b>
	<?php echo CHtml::encode($data->task_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_start_date')); ?>:</b>
	<?php echo CHtml::encode($data->task_start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->task_end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_owner_id')); ?>:</b>
	<?php echo CHtml::encode($data->task_owner_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->task_created_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('task_public_viewable')); ?>:</b>
	<?php echo CHtml::encode($data->task_public_viewable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_status')); ?>:</b>
	<?php echo CHtml::encode($data->task_status); ?>
	<br />

	*/ ?>

</div>