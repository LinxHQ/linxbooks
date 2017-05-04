<?php
/* @var $this LbCustomerController */
/* @var $data LbCustomer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_name')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_registration')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_registration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_tax_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_tax_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_website_url')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_website_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_is_own_company')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_is_own_company); ?>
	<br />


</div>