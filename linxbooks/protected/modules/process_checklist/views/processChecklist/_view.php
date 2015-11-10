<?php
/* @var $this ProcessChecklistController */
/* @var $data ProcessChecklist */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pc_id), array('view', 'id'=>$data->pc_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subcription_id')); ?>:</b>
	<?php echo CHtml::encode($data->subcription_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_name')); ?>:</b>
	<?php echo CHtml::encode($data->pc_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_create_date')); ?>:</b>
	<?php echo CHtml::encode($data->pc_create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_last_update_by')); ?>:</b>
	<?php echo CHtml::encode($data->pc_last_update_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_last_update')); ?>:</b>
	<?php echo CHtml::encode($data->pc_last_update); ?>
	<br />


</div>