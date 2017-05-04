<?php
/* @var $this TaskResourcePlanController */
/* @var $data TaskResourcePlan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('trp_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->trp_id), array('view', 'id'=>$data->trp_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_id')); ?>:</b>
	<?php echo CHtml::encode($data->task_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trp_start')); ?>:</b>
	<?php echo CHtml::encode($data->trp_start); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trp_end')); ?>:</b>
	<?php echo CHtml::encode($data->trp_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trp_work_load')); ?>:</b>
	<?php echo CHtml::encode($data->trp_work_load); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trp_effort')); ?>:</b>
	<?php echo CHtml::encode($data->trp_effort); ?>
	<br />


</div>