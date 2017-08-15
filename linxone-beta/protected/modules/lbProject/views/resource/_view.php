<?php
/* @var $this ResourceController */
/* @var $data Resource */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->resource_id), array('view', 'id'=>$data->resource_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_subscription_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_subscription_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_url')); ?>:</b>
	<?php echo CHtml::encode($data->resource_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_description')); ?>:</b>
	<?php echo CHtml::encode($data->resource_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_created_by')); ?>:</b>
	<?php echo CHtml::encode($data->resource_created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->resource_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_space')); ?>:</b>
	<?php echo CHtml::encode($data->resource_space); ?>
	<br />


</div>