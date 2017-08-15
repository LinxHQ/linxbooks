<?php
/* @var $this LeaveAssignmentController */
/* @var $data LeaveAssignment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('assignment_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->assignment_id), array('view', 'id'=>$data->assignment_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assignment_leave_name')); ?>:</b>
	<?php echo CHtml::encode($data->assignment_leave_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assignment_leave_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->assignment_leave_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assignment_account_id')); ?>:</b>
	<?php echo CHtml::encode($data->assignment_account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assignment_year')); ?>:</b>
	<?php echo CHtml::encode($data->assignment_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assignment_total_days')); ?>:</b>
	<?php echo CHtml::encode($data->assignment_total_days); ?>
	<br />


</div>