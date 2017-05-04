<?php
/* @var $this LbInvoiceController */
/* @var $data LbInvoice */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_group')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_generated_from_quotation_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_generated_from_quotation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_no')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_due_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_due_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_company_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_company_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_company_address_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_company_address_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_customer_address_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_customer_address_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_attention_contact_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_attention_contact_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_subject')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_note')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_invoice_status_code')); ?>:</b>
	<?php echo CHtml::encode($data->lb_invoice_status_code); ?>
	<br />

	*/ ?>

</div>