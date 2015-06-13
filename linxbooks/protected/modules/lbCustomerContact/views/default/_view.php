<?php
/* @var $this LbCustomerContactController */
/* @var $data LbCustomerContact */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_contact_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_customer_contact_id), array('view', 'id'=>$data->lb_customer_contact_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_contact_first_name')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_contact_first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_contact_last_name')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_contact_last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_contact_office_phone')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_contact_office_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_contact_office_fax')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_contact_office_fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_contact_mobile')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_contact_mobile); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_contact_email_1')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_contact_email_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_contact_email_2')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_contact_email_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_contact_note')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_contact_note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_contact_is_active')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_contact_is_active); ?>
	<br />

	*/ ?>

</div>