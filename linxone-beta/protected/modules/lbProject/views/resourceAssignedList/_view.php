<?php
/* @var $this ResourceAssignedListController */
/* @var $data ResourceAssignedList */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_assigned_list_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->resource_assigned_list_id), array('view', 'id'=>$data->resource_assigned_list_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_id')); ?>:</b>
	<?php echo CHtml::encode($data->resource_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_user_list_id')); ?>:</b>
	<?php echo CHtml::encode($data->resource_user_list_id); ?>
	<br />


</div>