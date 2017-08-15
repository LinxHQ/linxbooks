<?php
/* @var $this LeaveInLieuController */
/* @var $data LeaveInLieu */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_in_lieu_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->leave_in_lieu_id), array('view', 'id'=>$data->leave_in_lieu_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_in_lieu_name')); ?>:</b>
	<?php echo CHtml::encode($data->leave_in_lieu_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_in_lieu_day')); ?>:</b>
	<?php echo CHtml::encode($data->leave_in_lieu_day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_in_lieu_totaldays')); ?>:</b>
	<?php echo CHtml::encode($data->leave_in_lieu_totaldays); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_create_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_create_id); ?>
	<br />


</div>