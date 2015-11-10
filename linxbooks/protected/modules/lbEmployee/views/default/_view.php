<?php
/* @var $this DefaultControllersController */
/* @var $data LbEmployee */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_name')); ?>:</b>
	<?php echo CHtml::encode($data->employee_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_address')); ?>:</b>
	<?php echo CHtml::encode($data->employee_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_birthday')); ?>:</b>
	<?php echo CHtml::encode($data->employee_birthday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_phone_1')); ?>:</b>
	<?php echo CHtml::encode($data->employee_phone_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_phone_2')); ?>:</b>
	<?php echo CHtml::encode($data->employee_phone_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_email_1')); ?>:</b>
	<?php echo CHtml::encode($data->employee_email_1); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_email_2')); ?>:</b>
	<?php echo CHtml::encode($data->employee_email_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_code')); ?>:</b>
	<?php echo CHtml::encode($data->employee_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_tax')); ?>:</b>
	<?php echo CHtml::encode($data->employee_tax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_bank')); ?>:</b>
	<?php echo CHtml::encode($data->employee_bank); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_note')); ?>:</b>
	<?php echo CHtml::encode($data->employee_note); ?>
	<br />

	*/ ?>

</div>