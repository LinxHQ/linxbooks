<?php
/* @var $this TaskProgressController */
/* @var $data TaskProgress */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tp_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tp_id), array('view', 'id'=>$data->tp_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_id')); ?>:</b>
	<?php echo CHtml::encode($data->task_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tp_percent_completed')); ?>:</b>
	<?php echo CHtml::encode($data->tp_percent_completed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tp_days_completed')); ?>:</b>
	<?php echo CHtml::encode($data->tp_days_completed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tp_last_update')); ?>:</b>
	<?php echo CHtml::encode($data->tp_last_update); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tp_last_update_by')); ?>:</b>
	<?php echo CHtml::encode($data->tp_last_update_by); ?>
	<br />


</div>