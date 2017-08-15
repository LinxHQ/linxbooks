<?php
/* @var $this ProjectController */
/* @var $data Project */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('project_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->project_id), array('view', 'id'=>$data->project_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project_name')); ?>:</b>
	<?php echo CHtml::encode($data->project_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project_owner_id')); ?>:</b>
	<?php echo CHtml::encode($data->project_owner_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project_start_date')); ?>:</b>
	<?php echo CHtml::encode($data->project_start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project_description')); ?>:</b>
	<?php echo CHtml::encode($data->project_description); ?>
	<br />


</div>