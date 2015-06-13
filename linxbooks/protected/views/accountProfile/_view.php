<?php
/* @var $this AccountProfileController */
/* @var $data AccountProfile */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_profile_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->account_profile_id), array('view', 'id'=>$data->account_profile_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_profile_surname')); ?>:</b>
	<?php echo CHtml::encode($data->account_profile_surname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_profile_given_name')); ?>:</b>
	<?php echo CHtml::encode($data->account_profile_given_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_profile_preferred_display_name')); ?>:</b>
	<?php echo CHtml::encode($data->account_profile_preferred_display_name); ?>
	<br />


</div>