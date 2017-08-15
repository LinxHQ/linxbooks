<?php
/* @var $this LbCustomerAddressController */
/* @var $data LbCustomerAddress */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_customer_address_id), array('view', 'id'=>$data->lb_customer_address_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_line_1')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_line_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_line_2')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_line_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_city')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_state')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_country')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_country); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_postal_code')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_postal_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_website_url')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_website_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_phone_1')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_phone_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_phone_2')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_phone_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_fax')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_email')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_note')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_address_is_active')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_address_is_active); ?>
	<br />

	*/ ?>

</div>