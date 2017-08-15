<?php
/* @var $this LeaveApplicationController */
/* @var $data LeaveApplication */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->leave_id), array('view', 'id'=>$data->leave_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_startdate')); ?>:</b>
	<?php echo CHtml::encode($data->leave_startdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_enddate')); ?>:</b>
	<?php echo CHtml::encode($data->leave_enddate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_reason')); ?>:</b>
	<?php echo CHtml::encode($data->leave_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_approver')); ?>:</b>
	<?php echo CHtml::encode($data->leave_approver); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_ccreceiver')); ?>:</b>
	<?php echo CHtml::encode($data->leave_ccreceiver); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_name')); ?>:</b>
	<?php echo CHtml::encode($data->leave_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_status')); ?>:</b>
	<?php echo CHtml::encode($data->leave_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_type_name')); ?>:</b>
	<?php echo CHtml::encode($data->leave_type_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_date_submit')); ?>:</b>
	<?php echo CHtml::encode($data->leave_date_submit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_name_approvers_by')); ?>:</b>
	<?php echo CHtml::encode($data->leave_name_approvers_by); ?>
	<br />

	 ?>

</div>