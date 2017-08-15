<?php
/* @var $this ResourceUserListController */
/* @var $data ResourceUserList */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_user_list_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->resource_user_list_id), array('view', 'id'=>$data->resource_user_list_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_subscription_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_subscription_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_user_list_name')); ?>:</b>
	<?php echo CHtml::encode($data->resource_user_list_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_user_list_created_by')); ?>:</b>
	<?php echo CHtml::encode($data->resource_user_list_created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resource_user_list_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->resource_user_list_created_date); ?>
	<br />


</div>