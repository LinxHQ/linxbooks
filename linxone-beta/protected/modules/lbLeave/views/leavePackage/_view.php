<?php
/* @var $this LeavePackageController */
/* @var $data LeavePackage */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_package_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->leave_package_id), array('view', 'id'=>$data->leave_package_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_package_name')); ?>:</b>
	<?php echo CHtml::encode($data->leave_package_name); ?>
	<br />


</div>