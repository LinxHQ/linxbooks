<?php
/* @var $this LeavePackageItemController */
/* @var $data LeavePackageItem */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->item_id), array('view', 'id'=>$data->item_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_leave_package_id')); ?>:</b>
	<?php echo CHtml::encode($data->item_leave_package_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_leave_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->item_leave_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_total_days')); ?>:</b>
	<?php echo CHtml::encode($data->item_total_days); ?>
	<br />


</div>